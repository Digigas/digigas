<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';

	var $hasMany = array(
		'SentOrder' => array(
			'className' => 'OrderedProduct',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'RecievedOrder' => array(
			'className' => 'OrderedProduct',
			'foreignKey' => 'seller_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Hamper' => array(
			'className' => 'Hamper',
			'foreignKey' => 'seller_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'MoneyBox' => array(
			'className' => 'MoneyBox',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    var $validate = array(
        'first_name'    => array('rule' => 'notEmpty', 'on' => 'create'),
        'last_name'     => array('rule' => 'notEmpty', 'on' => 'create'),
        'username'      => array('rule' => 'notEmpty', 'on' => 'create'),
        'password'      => array('rule' => 'notEmpty', 'on' => 'create'),
        'email'         => array('rule' => 'notEmpty', 'on' => 'create')
    );

    var $actsAs = array('Containable');

    function beforeSave() {
        if(isset($this->data['User']['password']) && empty($this->data['User']['password'])) {
            unset($this->data['User']['password']);
        }

        return parent::beforeSave();
    }

    function getSellers($options = null) {

        $_options = array(
            'conditions' => array('role' => 2),
            'fields' => array('id', 'first_name', 'last_name', 'username'),
            'contain' => array());

        $options = am($_options, $options);

        $sellers = $this->find('all', $options);

        return $sellers;
    }

}
?>