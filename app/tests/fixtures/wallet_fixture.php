<?php
/* Wallet Fixture generated on: 2010-03-21 00:03:08 : 1269128228 */
class WalletFixture extends CakeTestFixture {
	var $name = 'Wallet';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'value_in' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '10,2'),
		'value_out' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '10,2'),
		'created' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'value_in' => 1,
			'value_out' => 1,
			'created' => '2010-03-21',
			'modified' => '2010-03-21'
		),
	);
}
?>