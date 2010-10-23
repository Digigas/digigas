<?php
/* Usergroup Test cases generated on: 2010-03-21 00:03:52 : 1269128152*/
App::import('Model', 'Usergroup');

class UsergroupTestCase extends CakeTestCase {
	var $fixtures = array('app.usergroup', 'app.user');

	function startTest() {
		$this->Usergroup =& ClassRegistry::init('Usergroup');
	}

	function endTest() {
		unset($this->Usergroup);
		ClassRegistry::flush();
	}

}
?>