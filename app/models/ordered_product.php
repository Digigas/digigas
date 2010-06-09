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
        $existing = false;
        if(isset(
        $data['OrderedProduct']['user_id'],
        $data['OrderedProduct']['seller_id'],
        $data['OrderedProduct']['product_id'],
        $data['OrderedProduct']['hamper_id']
        )) {
            $existing = $this->find('first', array('conditions' => array(
                    'OrderedProduct.user_id' => $data['OrderedProduct']['user_id'],
                    'OrderedProduct.seller_id' => $data['OrderedProduct']['seller_id'],
                    'OrderedProduct.product_id' => $data['OrderedProduct']['product_id'],
                    'OrderedProduct.hamper_id' => $data['OrderedProduct']['hamper_id'],
                ),
                'contain' => array()));
        }

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

    function getPendingUsers($full = false) {
        $orderedProducts = $this->getPending(); 

        $user_ids = Set::extract('/OrderedProduct/user_id', $orderedProducts); 
        
        $_users = $this->User->find('all', array(
            'conditions' => array('User.id' => $user_ids),
            'contain' => array()
        ));

        if($full) {
            return $_users;
        }

        $users = Set::combine($_users, '{n}.User.id', '{n}.User.fullname');

        return $users;
    }
    
    function getPendingSellers($full = false) {
        $orderedProducts = $this->getPending();

        $seller_ids = Set::extract('/OrderedProduct/seller_id', $orderedProducts);

        $_sellers = $this->Seller->find('all', array(
            'conditions' => array('Seller.id' => $seller_ids),
            'contain' => array()
        ));

        if($full) {
            return $_sellers;
        }

        $sellers = Set::combine($_sellers, '{n}.Seller.id', '{n}.Seller.name');

        return $sellers;
    }

    function getPending() {
        if(!isset($this->pendingProducts)) {
            $this->pendingProducts = $this->find('all', array(
                'conditions' => array(
                    'or' => array(
                        'paid' => 0,
                        'retired' => 0)),
                'fields' => array('id', 'user_id', 'seller_id', 'hamper_id')
            ));
        }
        return $this->pendingProducts;
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

    function setPaid($id) {
        $data = $this->findById($id);
        if($this->saveField('paid', 1)) {
            $value = $data['OrderedProduct']['value'];
            $user_id = $data['OrderedProduct']['user_id'];
            $ordered_product_id = $data['OrderedProduct']['id'];
            $message = 'Pagamento di '.$data['OrderedProduct']['quantity'].' '.$data['Product']['name'].' verso '.$data['Seller']['name'];
            return $this->updateMoneyBox('out', $value, $user_id, $ordered_product_id, $message);
        } else {
            return false;
        }
    }
    function setNotPaid($id) {
        $data = $this->findById($id);
        if($this->saveField('paid', 0)) {
            $value = $data['OrderedProduct']['value'];
            $user_id = $data['OrderedProduct']['user_id'];
            $ordered_product_id = $data['OrderedProduct']['id'];
            $message = 'Restituzione pagamento per '.$data['OrderedProduct']['quantity'].' '.$data['Product']['name'].' da '.$data['Seller']['name'];
            return $this->updateMoneyBox('in', $value, $user_id, $ordered_product_id, $message);
        } else {
            return false;
        }
    }
    function setRetired($id) {
        $data = $this->findById($id);
        if($this->saveField('retired', 1)) {
            return true;
        } else {
            return false;
        }
    }
    function setNotRetired($id) {
        $data = $this->findById($id);
        if($this->saveField('retired', 0)) {
            return true;
        } else {
            return false;
        }
    }

    function updateMoneyBox($direction, $value, $user_id, $ordered_product_id, $message = 'null') {
        $data = array('MoneyBox' => array(
            'user_id' => $user_id,
            'ordered_product_id' => $ordered_product_id,
            'text' => $message
        ));

        switch($direction) {
            case 'in':
                $data['MoneyBox']['value_in'] = $value;
            break;
            case 'out':
                $data['MoneyBox']['value_out'] = $value;
            break;
        }

        $this->MoneyBox->create();
        return $this->MoneyBox->save($data);
    }
}
?>