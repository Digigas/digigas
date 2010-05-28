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
                'joinTable' => 'hampers_products',
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

    var $actsAs = array('Containable', 'MultipleUpload' =>
                            array(
                                'image' => array(
                                    'field' => 'image',
                                    'dir' => "documents{DS}image{DS}product", //markers: '{APP}', '{DS}', '{IMAGES}', '{WWW_ROOT}', '{FILES}'
                                    'deleteMainFile' => false,
									'randomFilenames' => true,
                                    'thumbsizes' => array()
                                )
                            )
                        );

    function getAllFromSellerByCategory($seller_id) {
        $products = $this->find('all', array(
            'conditions' => array('seller_id' => $seller_id),
            'fields' => array('id', 'name', 'image'),
            'contain' => array(
                'ProductCategory' => array(
                    'order' => 'ProductCategory.lft asc',
                    'fields' => array('id', 'name', 'parent_id', 'lft', 'rght')
                )
            )
        ));
        //formatto l'elenco in modo utile per il frontend
        $productCategories = array();
        foreach($products as $product) {
            $productCategories[$product['ProductCategory']['id']]['ProductCategory'] = $product['ProductCategory'];
            $productCategories[$product['ProductCategory']['id']]['Product'][] = $product['Product'];
        }
        return $productCategories;
    }

}
?>