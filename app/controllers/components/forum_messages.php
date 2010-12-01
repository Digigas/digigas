<?php
class ForumMessagesComponent extends Object {

	var $components = array('Auth');

	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
	}

	// ultimi messaggi nel forum
	function getLastMessages($number = false, $role = false) {

		if(!$number) {
			$number = 5;
		}

		if(!$role) {
			$role = $this->Auth->user('role');
		}

		$this->Forum = ClassRegistry::init('Forum');
		$lastMessages = $this->Forum->getLastMessages($role, $number);
		$this->controller->set('lastMessages', $lastMessages);
	}
}