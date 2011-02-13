<?php
/* Payment Fixture generated on: 2010-03-21 00:03:22 : 1269128002 */
class PaymentFixture extends CakeTestFixture {
	var $name = 'Payment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'value' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '10,2'),
		'wallet_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'basket_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'value' => 1,
			'wallet_id' => 1,
			'basket_id' => 1,
			'created' => '2010-03-21 00:33:22'
		),
	);
}
?>