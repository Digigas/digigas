<?php
/* Product Test cases generated on: 2010-03-21 00:03:14 : 1269128054*/
App::import('Model', 'Product');

class ProductTestCase extends CakeTestCase {
	var $fixtures = array('app.product', 'app.product_category', 'app.basket', 'app.user', 'app.payment', 'app.wallet', 'app.baskets_product', 'app.showcase', 'app.products_showcase');

	function startTest() {
		$this->Product =& ClassRegistry::init('Product');
	}

	function endTest() {
		unset($this->Product);
		ClassRegistry::flush();
	}

}
?>