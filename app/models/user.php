<?php

class User extends AppModel {

	var $name = 'User';
	var $displayField = 'fullname';
	var $virtualFields = array('fullname' => "CONCAT(User.first_name, ' ', User.last_name)");
	var $hasMany = array(
		'OrderedProduct' => array(
			'className' => 'OrderedProduct',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MoneyBox' => array(
			'className' => 'MoneyBox',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ReadedThread' => array(
			'className' => 'ReadedThread',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	var $belongsTo = array('Usergroup');
	var $hasAndBelongsToMany = array('Seller');
	var $validate = array(
		'first_name' => array('rule' => 'notEmpty', 'on' => 'create'),
		'last_name' => array('rule' => 'notEmpty', 'on' => 'create'),
		'username' => array(
			'notEmpty' => array('rule' => 'notEmpty', 'on' => 'create'),
			'unique' => array('rule' => 'isUnique', 'on' => 'create', 'message' => 'Questo username è già utilizzato per un altro utente')),
		'password' => array('rule' => 'notEmpty', 'on' => 'create'),
		'email' => array('rule' => 'notEmpty', 'on' => 'create')
	);
	var $actsAs = array('Containable');

	function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])
			&& $this->data['User']['password'] == Security::hash('', null, true)) {
			unset($this->data['User']['password']);
		}
//
//        // salvo il nuovo profilo azienda
//        if(isset($this->data['Seller']) && $this->data['User']['role'] == 2) {
//            if($this->Seller->save($this->data)) {
//                $this->data['User'] = am(
//                    $this->data['User'],
//                    array(
//                    'seller_id' => $this->Seller->id
//                    )
//                );
//            }
//        }
		//modificao il campo hash
		$this->data['User']['hash'] = $this->randomString();

		return parent::beforeSave($options);
	}

	function getFathers($findType = 'list') {
		$fathersId = $this->find('all', array('conditions' => array(
					'User.parent_id != ' => NULL
				),
				'fields' => array('parent_id'),
				'group' => 'parent_id',
				'recursive' => -1
			));
		$fathersId = Set::extract('/User/parent_id', $fathersId);
		$fathers = $this->find($findType, array('conditions' => array('User.id' => $fathersId), 'order' => 'last_name asc'));
		return $fathers;
	}

	function getAdminEmails() {
		$users = $this->find('all', array(
				'conditions' => array(
					'User.active' => 1,
					'User.role < ' => 2),
				'fields' => array('email'),
				'recursive' => -1
			));
		$emails = Set::extract('/User/email', $users);
		return $emails;
	}

	function getActiveUsers() {
		$users = $this->find('all', array(
				'conditions' => array('User.active' => 1),
				'recursive' => -1
			));
		return $users;
	}

	function getActiveEmails() {
		$users = $this->find('all', array(
				'conditions' => array('User.active' => 1),
				'fields' => array('email'),
				'recursive' => -1
			));
		$emails = Set::extract('/User/email', $users);
		return $emails;
	}

	function randomString($lenght = false) {
		if (!$lenght) {
			$lenght = 30;
		}
		$base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz0123456789';
		$max = strlen($base) - 1;
		$return = '';
		mt_srand((double) microtime() * 1000000);
		while (strlen($return) < $lenght + 1)
			$return.=$base{mt_rand(0, $max)

				};

		return $return;
	}

	/*
		 * Funzioni per accedere a $controller->Auth->user() anche nei modelli
		 *	in AppController::beforeFilter:
			App::import('Model', 'User');
			User::store($this->Auth->user());
		 */

		function &getInstance($user=null) {
			static $instance = array();
			if ($user) {
				$instance[0] = & $user;
			}

			if (!$instance) {
				trigger_error(__("User not set.", true), E_USER_WARNING);
				return false;
			}

			return $instance[0];
		}

		function store($user) {
			if (empty($user)) {
				return false;
			}

			User::getInstance($user);
		}

		function get($path) {
			$_user = & User::getInstance();

			$path = str_replace('.', '/', $path);
			if (strpos($path, 'User') !== 0) {
				$path = sprintf('User/%s', $path);
			}

			if (strpos($path, '/') !== 0) {
				$path = sprintf('/%s', $path);
			}

			$value = Set::extract($path, $_user);

			if (!$value) {
				return false;
			}

			return $value[0];
		}
}