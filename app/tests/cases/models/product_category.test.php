<?php
/* ProductCategory Test cases generated on: 2010-03-21 00:03:44 : 1269128024*/
App::import('Model', 'ProductCategory');

class ProductCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.product_category', 'app.product');

	function startTest() {
		$this->ProductCategory =& ClassRegistry::init('ProductCategory');
	}

	function endTest() {
		unset($this->ProductCategory);
		ClassRegistry::flush();
	}

}
?>