<?php
class OrderedProduct extends AppModel {
	var $name = 'OrderedProduct';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Seller' => array(
			'className' => 'Seller',
			'foreignKey' => 'seller_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Hamper' => array(
			'className' => 'Hamper',
			'foreignKey' => 'hamper_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'MoneyBox' => array(
			'className' => 'MoneyBox',
			'foreignKey' => 'ordered_product_id',
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

    function save($data = null, $validate = true, $fieldList = array()) {
        // se esiste un altro ordine uguale, sommo all'ordine precedente
        $existing = $this->find('first', array('conditions' => array(
            'OrderedProduct.user_id' => $data['OrderedProduct']['user_id'],
            'OrderedProduct.seller_id' => $data['OrderedProduct']['seller_id'],
            'OrderedProduct.product_id' => $data['OrderedProduct']['product_id'],
            'OrderedProduct.hamper_id' => $data['OrderedProduct']['hamper_id'],
            ),
            'contain' => array()));

        if(!empty($existing)) {
            $data['OrderedProduct']['id'] = $existing['OrderedProduct']['id'];
            $data['OrderedProduct']['quantity'] = $data['OrderedProduct']['quantity'] + $existing['OrderedProduct']['quantity'];
            $data['OrderedProduct']['value'] = $data['OrderedProduct']['value'] + $existing['OrderedProduct']['value'];
        }

        return parent::save($data, $validate, $fieldList);
    }

    function buildOrder($data, $user) {

        $this->Product->recursive = -1;
        $product = $this->Product->read(null, $data['OrderedProduct']['product_id']);

        if(!$this->Hamper->isActive($data['OrderedProduct']['hamper_id'])) {
            return false;
        }

        if($data['OrderedProduct']['seller_id'] != $product['Product']['seller_id']) {
            return false;
        }

        //imposto il modello
        $data['OrderedProduct']['user_id'] = $user['User']['id'];

        $data['OrderedProduct']['value'] = $product['Product']['value'] * $data['OrderedProduct']['quantity'];

        $data['OrderedProduct']['paid'] = 0;
        $data['OrderedProduct']['retired'] = 0;
        
        return $data;
    }

    function getUserOrder($user) {
        $userOrder = $this->find('all', array(
            'conditions' => array('retired' => '0', 'user_id' => $user['User']['id']),
            'contain' => array(
                'Product',
                'Seller'=> array('fields' => array('name')),
                'Hamper' => array('fields' => array('name', 'start_date', 'end_date', 'checkout_date', 'delivery_date_on', 'delivery_date_off', 'delivery_position')))
        ));
        return $userOrder;
    }

    function verify($id, $user) {
        $orderedProduct = $this->findById($id);

        if(empty($orderedProduct)) {
            return false;
        }

        if(!$this->Hamper->isActive($orderedProduct['OrderedProduct']['hamper_id'])) {
            return false;
        }

        if($orderedProduct['OrderedProduct']['user_id'] != $user['User']['id']) {
            return false;
        }

        return true;
    }
}
?>