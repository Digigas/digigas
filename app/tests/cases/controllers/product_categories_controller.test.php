<?php
/* ProductCategories Test cases generated on: 2010-03-21 00:03:43 : 1269128983*/
App::import('Controller', 'ProductCategories');

class TestProductCategoriesController extends ProductCategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ProductCategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.product_category', 'app.product', 'app.basket', 'app.user', 'app.usergroup', 'app.showcase', 'app.products_showcase', 'app.wallet', 'app.payment', 'app.baskets_product');

	function startTest() {
		$this->ProductCategories =& new TestProductCategoriesController();
		$this->ProductCategories->constructClasses();
	}

	function endTest() {
		unset($this->ProductCategories);
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