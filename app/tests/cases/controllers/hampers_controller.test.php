<?php
/* Hampers Test cases generated on: 2010-05-15 23:05:30 : 1273957410*/
App::import('Controller', 'Hampers');

class TestHampersController extends HampersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class HampersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.hamper', 'app.user', 'app.wallet', 'app.payment', 'app.ordered_product', 'app.product', 'app.product_category', 'app.products_hamper');

	function startTest() {
		$this->Hampers =& new TestHampersController();
		$this->Hampers->constructClasses();
	}

	function endTest() {
		unset($this->Hampers);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>