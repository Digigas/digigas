<?php
class Hamper extends AppModel {
	var $name = 'Hamper';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Seller' => array(
			'className' => 'Seller',
			'foreignKey' => 'seller_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)

	);

    var $hasMany = array(
		'OrderedProduct' => array(
                        'dependent'=> true
		));

	var $hasAndBelongsToMany = array(
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'hampers_products',
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

    var $actsAs = array('Containable', 'Commentable' => array('forumName' => 'Panieri'));

	function beforeFind($queryData) {
		if(Configure::read('ReferentUser.allowed_sellers')) {
			$queryData = array_merge_recursive(
				array(
					'conditions' => array('Hamper.seller_id' => Configure::read('ReferentUser.allowed_sellers'))
				),
				$queryData);
		}
		return $queryData;
	}

    function formatDates($data) {
        $dateTimeFields = array();
        foreach($this->_schema as $field => $type) {
            if($type['type'] == 'datetime') {
                $dateTimeFields[] = $field;
            }
        }

        foreach($dateTimeFields as $field) {
            if(isset($data[$this->alias][$field])
                && isset($data[$this->alias][$field]['date']))
            {
                $year = date('Y', strtotime($data[$this->alias][$field]['date']));
                $month = date('m', strtotime($data[$this->alias][$field]['date']));
                $day = date('d', strtotime($data[$this->alias][$field]['date']));

                $data[$this->alias][$field]['year'] = $year;
                $data[$this->alias][$field]['month'] = $month;
                $data[$this->alias][$field]['day'] = $day;
                
                //unset($data[$this->alias][$field]['date']);
            }
        }

        return $data;
    }

    function getActiveConditions() {
        $now = date('Y:m:d H:i');
        $conditions = array(
            'Hamper.start_date < ' => $now,
            'Hamper.end_date > ' => $now);
        return $conditions;
    }
    
    //dayana 12/06/2012 aggiunta funzione per ottenere gli ordini attivi di un produttore
    function getActiveConditionsForSeller($id) {
        $now = date('Y:m:d H:i');
        $conditions = array(
            'Hamper.start_date < ' => $now,
            'Hamper.seller_id = ' => $id,
            'Hamper.end_date > ' => $now);
        return $conditions;
    }

    function isActive($id) {
        if($id != $this->id) {
            $this->id = $id;
        }

        $data = $this->find('first', array('conditions' => array('id' => $id), 'recursive' => -1));
        $now = date('Y-m-d H:m:s');

        $return = true;

        switch($data['Hamper']['start_date']) {
            case '0000-00-00 00:00:00':
                $return = false;
                break;
            case ($data['Hamper']['start_date'] > $now):
                $return = false; 
                break;
        }

        switch($data['Hamper']['end_date']) {
            case '0000-00-00 00:00:00':
                $return = false;
                break;
            case ($data['Hamper']['end_date'] < $now):
                $return = false; 
                break;
        }

        $sellerIsActive = $this->Seller->field('active', array('id' => $data['Hamper']['seller_id']));
        if(!$sellerIsActive) {
            $return = false;
        } 

        return $return;
    }

    function copy($id) {
        $template = $this->find('first', array(
            'conditions' => array('Hamper.id' => $id),
            'fields' => array(
                'name',
                'seller_id',
                'delivery_position',
				'notes'),
            'contain' => array(
                'Product.id'
            )
            ));

        if(!empty($template)) {

            //rimuovo id
            unset($template['Hamper']['id']);
            
            //imposto il formato corretto per i prodotti correlati
            $products = Set::extract('/Product/id', $template);
            unset($template['Product']);
            $template['Product'] = $products;
        } else {
            return false;
        }

        //imposto tutte le date a oggi
        $template['Hamper']['start_date'] = date('Y-m-d H:i:s');
        $template['Hamper']['end_date'] = date('Y-m-d H:i:s');
        $template['Hamper']['checkout_date'] = date('Y-m-d H:i:s');
        $template['Hamper']['delivery_date_on'] = date('Y-m-d H:i:s');
        $template['Hamper']['delivery_date_off'] = date('Y-m-d H:i:s');

        $this->create();
        if($this->save($template)) {
            return $this->id;
        } else {
            return false;
        }
    }

}
?>