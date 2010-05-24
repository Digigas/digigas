<?php
/* Showcase Test cases generated on: 2010-03-21 00:03:40 : 1269128140*/
App::import('Model', 'Showcase');

class ShowcaseTestCase extends CakeTestCase {
	var $fixtures = array('app.showcase', 'app.user', 'app.product', 'app.product_category', 'app.basket', 'app.payment', 'app.wallet', 'app.baskets_product', 'app.products_showcase');

	function startTest() {
		$this->Showcase =& ClassRegistry::init('Showcase');
	}

	function endTest() {
		unset($this->Showcase);
		ClassRegistry::flush();
	}

}
?>