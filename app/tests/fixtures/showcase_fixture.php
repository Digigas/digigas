<?php
/* Showcase Fixture generated on: 2010-03-21 00:03:40 : 1269128140 */
class ShowcaseFixture extends CakeTestFixture {
	var $name = 'Showcase';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'start_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'end_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'checkout_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'delivery_date_on' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'delivery_date_off' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'delivery_position' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'user_id' => 1,
			'start_date' => '2010-03-21 00:35:40',
			'end_date' => '2010-03-21 00:35:40',
			'checkout_date' => '2010-03-21 00:35:40',
			'delivery_date_on' => '2010-03-21 00:35:40',
			'delivery_date_off' => '2010-03-21 00:35:40',
			'delivery_position' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2010-03-21',
			'modified' => '2010-03-21'
		),
	);
}
?>