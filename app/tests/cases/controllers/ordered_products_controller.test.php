<?php
/* OrderedProducts Test cases generated on: 2010-05-15 11:05:01 : 1273916641*/
App::import('Controller', 'OrderedProducts');

class TestOrderedProductsController extends OrderedProductsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class OrderedProductsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.ordered_product', 'app.user', 'app.hamper', 'app.product', 'app.product_category', 'app.products_hamper', 'app.wallet', 'app.payment');

	function startTest() {
		$this->OrderedProducts =& new TestOrderedProductsController();
		$this->OrderedProducts->constructClasses();
	}

	function endTest() {
		unset($this->OrderedProducts);
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