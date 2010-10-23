<?php
class ProductCategory extends AppModel {
	var $name = 'ProductCategory';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_category_id',
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

    var $actsAs = array('Tree', 'Containable');

    function getSubCategories($id) {
        $category = $this->read(null, $id);
        $categories = $this->find('all', array(
            'conditions' => array(
                'lft >= ' => $category['ProductCategory']['lft'],
                'rght <= ' => $category['ProductCategory']['rght']
            ),
            'fields' => array('id'),
            'contain' => array()
        ));

        $categories = Set::extract('/ProductCategory/id', $categories);

        return $categories;
    }
}
?>