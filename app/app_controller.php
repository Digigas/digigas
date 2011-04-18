<?php

class AppController extends Controller {

	var $components = array(
		'Auth' => array(
			'loginError' => 'L\'autenticazione è fallita: username o password sbagliate',
			'authError' => 'Non hai il permesso di accedere a questa pagina. Registrati'
		),
		'Session',
		'Cookie',
		'Email',
		'ForumMessages'
	);
	var $helpers = array(
		'Session',
		'Html',
		'Form',
		'Javascript',
		'Layout',
		'Image',
		'Menu',
		'Number',
		'UserComment',
		'Text',
		'Time',
		'DynamicCss'
	);
	var $allowedActions = array();

	function beforeFilter() {

		//Salvo i dati dell'utente corrente nel modello User per accedervi da altri modelli
			App::import('Model', 'User');
			User::store($this->Auth->user());
		// --- ---

		$this->Auth->authorize = 'controller';
		$this->Auth->userScope = array('User.active' => 1);
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false);

		if (isset($this->params['admin']) && $this->params['admin']) {
			$this->layout = 'digigas';
		} else {
			$this->Auth->allow('*');
		}
		//$this->Auth->allow('*'); //temporaneo, da disabilitare

		$this->_emailSetUp();

		$this->_loadConfig();
	}

	function beforeRender() {
		$this->set('referer', $this->referer());
	}

	function isAuthorized() {
		//solo gli utenti root, admin e seller possono accedere all'area admin
		if (isset($this->params['admin']) && $this->Auth->user('role') > 2) {
			return false;
		}

		//restringo i permessi di accesso per i referenti (role == 2)
		if (isset($this->params['admin']) && $this->Auth->user('role') == 2) {
			if (!in_array($this->name, Configure::read('ReferentUser.allowed_controllers'))) {
				$this->Session->setFlash(__('Non puoi accedere a questa funzione', true));
				return false;
			}

			//estraggo l'array dei seller abilitati e li metto in Session
			if (!$this->Session->read('Auth.User.allowed_sellers')) {
				$this->User = $this->Auth->getModel();
				$allowed_sellers = $this->User->find('all', array(
						'conditions' => array('User.id' => $this->Auth->User('id')),
						'fields' => 'id',
						'contain' => 'Seller.id'
					));
				$allowed_sellers = Set::extract('/Seller/id', $allowed_sellers);
				$this->Session->write('Auth.User.allowed_sellers', $allowed_sellers);
			}
			Configure::write('ReferentUser.allowed_sellers', $this->Session->read('Auth.User.allowed_sellers'));
		}

		return true;
	}

	function _emailSetUp() {
		$SMTPoptions = Configure::read('email.SMTPoptions');
		if (!empty($SMTPoptions)) {
			$this->Email->smtpOptions = $SMTPoptions;
			$this->Email->delivery = 'smtp';
		} else {
			$this->Email->delivery = 'mail';
		}
	}

	function afterFilter() {

		//log degli errori smtp
		if (!empty($this->Email->smtpError)) {
			$this->log($this->Email->smtpError, 'smtp-errors');
		}

		return parent::afterFilter();
	}

	function _loadConfig() {
		$config = Cache::read('Config');
		if(empty($config)) {
			$this->Configurator = ClassRegistry::init('Configurator');
			$config = $this->Configurator->config();
		}
		Configure::write($config);
	}

}