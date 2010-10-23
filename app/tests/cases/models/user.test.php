<?php
/* User Test cases generated on: 2010-03-21 00:03:40 : 1269128200*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $fixtures = array('app.user', 'app.usergroup', 'app.basket', 'app.payment', 'app.wallet', 'app.product', 'app.product_category', 'app.baskets_product', 'app.showcase', 'app.products_showcase');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

}
?>