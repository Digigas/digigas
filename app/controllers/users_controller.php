<?php

class UsersController extends AppController {

    var $name = 'Users';
	var $paginate = array('order' => array('User.Last_name asc', 'User.first_name Asc'));

    function beforeFilter() {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'users');

        $this->Auth->deny('index', 'edit');
    }

    function login() {

    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }

    function _getUserIdOrLogin() {
        if (!$this->Auth->user()) {
            $this->Session->setFlash(__('Devi fare login per amministrare il tuo profilo', true));
            $this->redirect('/users/login');
            return false;
        }

        $id = $this->Auth->user('id');
        return $id;
    }

    //di fatto questa è la funzione view…
    function index() {
        $id = $this->_getUserIdOrLogin();

        $user = $this->User->find('first', array(
                'conditions' => array('User.id' => $id),
                'contain' => array('Seller', 'Usergroup.name')
            ));

        $this->set(compact('user'));
        $this->set('title_for_layout', __('Il mio profilo', true) . ' - ' . Configure::read('GAS.name'));
    }

    function edit() {
        $id = $this->_getUserIdOrLogin();

        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Utente non valido', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('Profilo salvato', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Si è verificato un errore, riprova', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->User->read(null, $id);
        }

        $this->set('title_for_layout', __('Modifica il profilo', true) . ' - ' . Configure::read('GAS.name'));
    }

    function password_reset($hash = false) {
        if (!$hash) {
            $this->Session->setFlash(__('Spiacente, l\'utente non è stato riconosciuto. Contatta l\'amministratore', true));
            $this->redirect('/');
        }

        $this->User->recursive = -1;
        $user = $this->User->findByHash($hash);

        if (!empty($this->data)) {
            if ($this->data['User']['password'] !== $this->data['User']['password2']) {
                $this->Session->setFlash(__('Le password non coincidono, riprova', true));
                $this->redirect(array('action' => $this->action, $hash));
            } else {
                $this->User->id = $user['User']['id'];
                if ($this->User->saveField('password', $this->Auth->password($this->data['User']['password']))) {
                    $this->Session->setFlash(__('Ok, password salvata, ora puoi fare login!', true));
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Session->setFlash(__('Si è verificato un errore, riprova', true));
                    $this->redirect(array('action' => $this->action, $hash));
                }
            }
        }

        if (empty($user)) {
            $this->Session->setFlash(__('Spiacente, l\'utente non è stato riconosciuto. Contatta l\'amministratore', true));
            $this->redirect('/');
        }

        if ($user['User']['active'] != 1) {
            $this->Session->setFlash(__('Spiacente, l\'utente non è attivo. Contatta l\'amministratore', true));
            $this->redirect('/');
        }

        $this->set('user', $user);
        $this->set('title_for_layout', __('Imposta password', true) . ' - ' . Configure::read('GAS.name'));
    }

    function admin_index($role = null) {
        $this->User->recursive = 0;

        if (!is_null($role) && is_numeric($role)) {
            $this->paginate = am($this->paginate, array('conditions' => array('role' => $role)));
            $this->set('role', Configure::read('roles.' . $role));
        }

        if (isset($this->params['named']['active'])) {
            $this->paginate = am($this->paginate, array('conditions' => array('User.active' => $this->params['named']['active'])));
        }

        if (isset($this->params['named']['family'])) {
            $this->paginate = am($this->paginate, array('conditions' => array(
                'or' => array(
                    'User.id' => $this->params['named']['family'],
                    'User.parent_id' => $this->params['named']['family']
                )),
                'order' => 'User.parent_id asc'));
        }

        $fathers = $this->User->getFathers('list');
        if (isset($this->params['named']['fathers'])) {
            $this->paginate = am($this->paginate, array('conditions' => array('User.id' => array_keys($fathers))));
        }

        $users = $this->paginate();

        $familiesCount = $this->User->find('count', array('conditions' => array('User.parent_id' => null)));

        $this->set(compact('users', 'familiesCount','fathers'));
    }

    function admin_search($key = false) {
        if (!$key && empty($this->data)) {
            $this->Session->setFlash('Nessuna chiave di ricerca specificata');
            $this->redirect($this->referer());
        }

        if (!$key && !empty($this->data)) {
            $key = Inflector::slug($this->data['Search']['key']);
            $this->redirect(array('action' => 'search', $key));
        }

        $key = low(Inflector::humanize($key));
        $users = $this->User->find('all', array(
                'conditions' => array(
                    'or' => array(
                        'first_name LIKE ' => '%' . $key . '%',
                        'last_name LIKE ' => '%' . $key . '%',
                        'username LIKE ' => '%' . $key . '%',
                        'email LIKE ' => '%' . $key . '%',
                    )
                ),
                'recursive' => -1
            ));

        $fathers = $this->User->getFathers('list');

        $this->set(compact('users', 'key', 'fathers'));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->User->create();
            if ($this->User->save($this->data)) {

				//mando una mail di notifica all'utente
				$this->User->recursive = -1;
				$user = $this->User->read(null, $this->User->id);
				$users = array($user);
				$this->_send_users_notification($users);

                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
            }
        }

        $families = $this->User->find('list', array('conditions' => array('User.parent_id' => null), 'order' => 'User.last_name asc'));

        $roles = Configure::read('roles');

        $usergroups = $this->User->Usergroup->generatetreelist(array('Usergroup.active' => 1), '{n}.Usergroup.id', '{n}.Usergroup.name', ' - ');

        $this->set(compact('families', 'roles', 'usergroups'));
    }

    function admin_addseller() {
        if (!empty($this->data)) {
            $this->User->create();
            if ($this->User->save($this->data)) {

				//mando una mail di notifica all'utente
				$this->User->recursive = -1;
				$user = $this->User->read(null, $this->User->id);
				$users = array($user);
				$this->_send_users_notification($users);
				
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
            }
        }

		$families = $this->User->find('list', array('conditions' => array('User.parent_id' => null), 'order' => 'User.last_name asc'));

        $usergroups = $this->User->Usergroup->generatetreelist(array('Usergroup.active' => 1), '{n}.Usergroup.id', '{n}.Usergroup.name', ' - ');

		$sellers = $this->User->Seller->find('list');

        $this->set(compact('families', 'usergroups', 'sellers'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'user'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
            }
        } else {
            $this->data = $this->User->read(null, $id);
        }

        $userChildren = $this->User->find('count', array('conditions' => array('User.parent_id' => $this->data['User']['id'])));
        if($userChildren == 0) {
            //l'utente non è un capofamiglia
            $families = $this->User->find('list', array('conditions' => array('User.parent_id' => null), 'order' => 'User.last_name asc'));
        } else {
            //l'utente è già un capofamiglia e non può essere assegnato a un'altr famiglia
            $families = array();
        }

        $roles = Configure::read('roles');

        $usergroups = $this->User->Usergroup->generatetreelist(array('Usergroup.active' => 1), '{n}.Usergroup.id', '{n}.Usergroup.name', ' - ');

        $this->set(compact('families', 'roles', 'usergroups'));

        if ($this->data['User']['role'] == 2) {
			$sellers = $this->User->Seller->find('list');
			$this->set('sellers', $sellers);

            $this->render('admin_editseller');
        }
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'user'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->User->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s deleted', true), 'User'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'User'));
        $this->redirect(array('action' => 'index'));
    }

    function admin_mail_users_notification($id = false) {
        if (!$id) {
            $users = $this->User->getActiveUsers();
        } else {
            $this->User->recursive = -1;
            $user = $this->User->read(null, $id);
            $users = array($user);
        }

        $this->_send_users_notification($users);

        $this->redirect(array('action' => 'index'));
    }

	function _send_users_notification($users) {
		if(!$users) {
			return false;
		}
		
		foreach ($users as $user) {
            $this->Email->reset();

            $this->Email->to = $user['User']['email'];
            $this->Email->subject = '[' . Configure::read('GAS.name') . '] ' . __('Come attivare il tuo account', true);
            $this->Email->from = Configure::read('email.from');
            $this->Email->sendAs = 'html';
            $this->Email->template = 'admin_mail_users_notification';

            $this->set(compact('user'));

            if (!$this->Email->send()) {
                $this->log($this->name . '->' . $this->action . ' email not sent to: ' . $user['User']['email'], 'users_mail_errors');
                $errors[] = $user;
            }
        }

        if (empty($errors)) {
            $this->Session->setFlash(__('Tutte le email sono state inviate correttamente', true));
        } else {
            $this->Session->setFlash(__('Si sono verificati degli errori nell\'invio delle email', true));
        }
	}

}

?>