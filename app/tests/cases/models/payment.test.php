<?php
/* Payment Test cases generated on: 2010-03-21 00:03:22 : 1269128002*/
App::import('Model', 'Payment');

class PaymentTestCase extends CakeTestCase {
	var $fixtures = array('app.payment', 'app.wallet', 'app.basket', 'app.user', 'app.product', 'app.baskets_product');

	function startTest() {
		$this->Payment =& ClassRegistry::init('Payment');
	}

	function endTest() {
		unset($this->Payment);
		ClassRegistry::flush();
	}

}
?>