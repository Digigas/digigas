<?php
/* Order Fixture generated on: 2010-03-21 18:03:49 : 1269193969 */
class OrderFixture extends CakeTestFixture {
	var $name = 'Order';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'value' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '10,2'),
		'paid' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'retired' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'value' => 1,
			'paid' => 1,
			'retired' => 1,
			'created' => '2010-03-21',
			'modified' => '2010-03-21'
		),
	);
}
?>