<?php
class Newscategory extends AppModel {

	var $name = 'Newscategory';
    
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'News' => array('className' => 'News',
								'foreignKey' => 'newscategory_id',
								'dependent' => true,
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
    var $actsAs = array('Tree', 'Sluggable'=>array('label'=>array('name'), 'overwrite' => true), 'Containable');

    var $validate = array(
        'parent_id'=>array(
            'rule' => 'validateParentId'));
}
?>