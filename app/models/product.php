<?php
class Product extends AppModel {
    var $name = 'Product';
    var $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'ProductCategory' => array(
                'className' => 'ProductCategory',
                'foreignKey' => 'product_category_id',
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
        )
    );

    var $hasMany = array('OrderedProduct');

    var $hasAndBelongsToMany = array(
        'Hamper' => array(
                'className' => 'Hamper',
                'joinTable' => 'products_hampers',
                'foreignKey' => 'product_id',
                'associationForeignKey' => 'hamper_id',
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
        'name' => array('rule' => 'notEmpty', 'on' => 'create'),
        'value' => array('rule' => 'notEmpty', 'on' => 'create')
    );

    var $actsAs = array('MultipleUpload' =>
                            array(
                                'image' => array(
                                    'field' => 'image',
                                    'dir' => "documents{DS}image{DS}product", //markers: '{APP}', '{DS}', '{IMAGES}', '{WWW_ROOT}', '{FILES}'
                                    'deleteMainFile' => false,
									'randomFilenames' => false,
                                    'thumbsizes' => array()
                                )
                            )
                        );

}
?>