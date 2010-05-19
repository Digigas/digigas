<?php
class MoneyBox extends AppModel {
	var $name = 'MoneyBox';
	var $displayField = 'created';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'OrderedProduct' => array(
			'className' => 'OrderedProduct',
			'foreignKey' => 'ordered_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>