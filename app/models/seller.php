<?php
class Seller extends AppModel {
	var $name = 'Seller';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
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
		'OrderedProduct' => array(
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
		'Product' => array(
			'className' => 'Product',
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
		'User' => array(
			'className' => 'User',
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
		)
	);

    var $actsAs = array('Containable');

    function afterSave($created) {
        if(isset($this->data['Seller']['User'])) {
            $this->User->updateAll(array('seller_id' => 0), array('User.seller_id' => $this->id));
            $this->User->updateAll(array('seller_id' => $this->id), array('User.id' => $this->data['Seller']['User']));
        }
        return parent::afterSave($created);
    }

    function getSellers($options = null) {

        $_options = array(
            'conditions' => array('active' => 1),
            'fields' => array('id', 'name'),
            'contain' => array());

        $options = am($_options, $options);

        $sellers = $this->find('all', $options);

        return $sellers;
    }

}
?>