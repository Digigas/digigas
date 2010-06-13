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

        $this->set('roles', $roles);
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
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
            if($this->data['User']['role'] == 2) {
                $this->render('admin_editseller');
            }
		}

        $roles = Configure::read('roles');
        $this->set('roles', $roles);
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
}
?>