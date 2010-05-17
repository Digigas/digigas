<?php
/* Order Test cases generated on: 2010-03-21 18:03:49 : 1269193969*/
App::import('Model', 'Order');

class OrderTestCase extends CakeTestCase {
	var $fixtures = array('app.order', 'app.user', 'app.usergroup', 'app.showcase', 'app.product', 'app.product_category', 'app.orders_product', 'app.products_showcase', 'app.wallet', 'app.payment');

	function startTest() {
		$this->Order =& ClassRegistry::init('Order');
	}

	function endTest() {
		unset($this->Order);
		ClassRegistry::flush();
	}

}
?>