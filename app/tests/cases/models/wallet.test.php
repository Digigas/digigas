<?php
/* Wallet Test cases generated on: 2010-03-21 00:03:08 : 1269128228*/
App::import('Model', 'Wallet');

class WalletTestCase extends CakeTestCase {
	var $fixtures = array('app.wallet', 'app.user', 'app.usergroup', 'app.basket', 'app.payment', 'app.product', 'app.product_category', 'app.baskets_product', 'app.showcase', 'app.products_showcase');

	function startTest() {
		$this->Wallet =& ClassRegistry::init('Wallet');
	}

	function endTest() {
		unset($this->Wallet);
		ClassRegistry::flush();
	}

}
?>