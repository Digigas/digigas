<?php
/* Showcases Test cases generated on: 2010-03-21 01:03:20 : 1269130220*/
App::import('Controller', 'Showcases');

class TestShowcasesController extends ShowcasesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ShowcasesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.showcase', 'app.user', 'app.usergroup', 'app.basket', 'app.payment', 'app.wallet', 'app.product', 'app.product_category', 'app.baskets_product', 'app.products_showcase');

	function startTest() {
		$this->Showcases =& new TestShowcasesController();
		$this->Showcases->constructClasses();
	}

	function endTest() {
		unset($this->Showcases);
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

	function testSellerIndex() {

	}

	function testSellerView() {

	}

	function testSellerAdd() {

	}

	function testSellerEdit() {

	}

	function testSellerDelete() {

	}

}
?>