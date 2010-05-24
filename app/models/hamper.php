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

    var $actsAs = array('Containable');

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
}
?>