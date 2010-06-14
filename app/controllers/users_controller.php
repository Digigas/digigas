<?php
class UsersController extends AppController {

	var $name = 'Users';

    function beforeFilter()
    {
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
            'contain' => array('Seller')
        ));
        
		$this->set(compact('user'));
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

	}

    function password_reset($hash = false) {
        if(!$hash) {
            $this->Session->setFlash(__('Spiacente, l\'utente non è stato riconosciuto. Contatta l\'amministratore', true));
            $this->redirect('/');
        }

        $this->User->recursive = -1;
        $user = $this->User->findByHash($hash);

        if(!empty($this->data)) {
            if($this->data['User']['password'] !== $this->data['User']['password2']) {
                $this->Session->setFlash(__('Le password non coincidono, riprova', true));
                $this->redirect(array('action' => $this->action, $hash));
            } else {
                $this->User->id = $user['User']['id'];
                if($this->User->saveField('password', $this->Auth->password($this->data['User']['password']))) {
                    $this->Session->setFlash(__('Ok, password salvata, ora puoi fare login!', true));
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Session->setFlash(__('Si è verificato un errore, riprova', true));
                    $this->redirect(array('action' => $this->action, $hash));
                }
            }
        }

        if(empty($user)) {
            $this->Session->setFlash(__('Spiacente, l\'utente non è stato riconosciuto. Contatta l\'amministratore', true));
            $this->redirect('/');
        }

        if($user['User']['active'] != 1) {
            $this->Session->setFlash(__('Spiacente, l\'utente non è attivo. Contatta l\'amministratore', true));
            $this->redirect('/');
        }

        $this->set('user', $user);
    }
    
	function admin_index($role = null) {
		$this->User->recursive = 0;

        if(!is_null($role) && is_numeric($role)) {
            $this->paginate = array('conditions' => array('role' => $role));
            $this->set('role', Configure::read('roles.'.$role));
        }

        if(isset($this->params['named']['active'])) {
            $this->paginate = am($this->paginate, array('conditions' => array('User.active' => $this->params['named']['active'])));
        }

		$this->set('users', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
                $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
			}
		}

        $roles = Configure::read('roles');

        $usergroups = $this->User->Usergroup->find('list', array('conditions' => array('Usergroup.active' => 1)));

        $this->set(compact('roles', 'usergroups'));
	}

    function admin_addseller() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'user'));
                $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'user'));
			}
		}

        $usergroups = $this->User->Usergroup->find('list', array('conditions' => array('Usergroup.active' => 1)));


        $this->set(compact('usergroups'));
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
		}	

        $roles = Configure::read('roles');

        $usergroups = $this->User->Usergroup->find('list', array('conditions' => array('Usergroup.active' => 1)));

        $this->set(compact('roles', 'usergroups'));

        if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
            if($this->data['User']['role'] == 2) {
                $this->render('admin_editseller');
            }
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'user'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'User'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'User'));
		$this->redirect(array('action' => 'index'));
	}

    function admin_mail_users_notification($id = false) {
        if(!$id) {
            $users = $this->User->getActiveUsers();
        } else {
            $this->User->recursive = -1;
            $user = $this->User->read(null, $id);
            $users = array($user);
        }

        foreach($users as $user) {
            $this->Email->reset();

            $this->Email->to = $user['User']['email'];
            $this->Email->subject = '['.Configure::read('GAS.name').'] '.__('Come attivare il tuo account', true);
            $this->Email->from = Configure::read('email.from');
            $this->Email->sendAs = 'html';
            $this->Email->template = 'admin_mail_users_notification';

            $this->set(compact('user'));

            if(!$this->Email->send()) {
                $this->log($this->name.'->'.$this->action.' email not sent to: '.$user['User']['email'], 'users_mail_errors');
                $errors[] = $user;
            }
        }

        if(empty($errors)) {
            $this->Session->setFlash(__('Tutte le email sono state inviate correttamente', true));
        } else {
            $this->Session->setFlash(__('Si sono verificati degli errori nell\'invio delle email', true));
        }
        $this->redirect(array('action' => 'index'));
    }
}
?>