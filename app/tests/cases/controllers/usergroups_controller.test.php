<?php
/* Usergroups Test cases generated on: 2010-03-29 23:03:44 : 1269896744*/
App::import('Controller', 'Usergroups');

class TestUsergroupsController extends UsergroupsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UsergroupsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.usergroup', 'app.user', 'app.order', 'app.payment', 'app.wallet', 'app.product', 'app.product_category', 'app.orders_product', 'app.showcase', 'app.products_showcase');

	function startTest() {
		$this->Usergroups =& new TestUsergroupsController();
		$this->Usergroups->constructClasses();
	}

	function endTest() {
		unset($this->Usergroups);
		ClassRegistry::flush();
	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
?>