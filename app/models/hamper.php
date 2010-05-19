<?php
class Hamper extends AppModel {
	var $name = 'Hamper';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'seller_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    var $hasMany = array('OrderedProduct');

	var $hasAndBelongsToMany = array(
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'products_hampers',
			'foreignKey' => 'hamper_id',
			'associationForeignKey' => 'product_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

    var $validate = array(
        'start_date' => array('rule' => 'notEmpty', 'on' => 'create'),
        'end_date' => array('rule' => 'notEmpty', 'on' => 'create')
    );

}
?>