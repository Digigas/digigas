<?php
/* Sellers Test cases generated on: 2010-05-20 17:05:41 : 1274369621*/
App::import('Controller', 'Sellers');

class TestSellersController extends SellersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SellersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.seller', 'app.hamper', 'app.user', 'app.ordered_product', 'app.product', 'app.product_category', 'app.products_hamper', 'app.money_box');

	function startTest() {
		$this->Sellers =& new TestSellersController();
		$this->Sellers->constructClasses();
	}

	function endTest() {
		unset($this->Sellers);
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