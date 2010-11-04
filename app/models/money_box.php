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

    var $actsAs = array('Containable');

    function getTotal($user_id) {
        $this->recursive = -1;
        $inout = $this->query('SELECT SUM(value_in) as valuein, SUM(value_out) as valueout FROM '.$this->useTable.' WHERE user_id = '.$user_id);
        $inout = $inout[0][0];

        $total = $inout['valuein'] - $inout['valueout'];

        return $total;
    }
}
?>