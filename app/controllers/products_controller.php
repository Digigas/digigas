<?php
class ProductsController extends AppController {

	var $name = 'Products';
	var $components = array('UserComment');
	var $helpers = array('Html', 'Form', 'UserComment');

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'products');
		$this->set('title_for_layout', __('Prodotti', true));
    }

    //rimando a un'altra pagina, bah…
	function index($seller_id = false) {
        if(!$seller_id) {
            $this->redirect(array('controller' => 'hampers', 'action' => 'index'));
        } else {
            $this->redirect(array('controller' => 'sellers', 'action' => 'view', $seller_id));
        }
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}

        $product = $this->Product->find('first', array(
			'conditions' => array('Product.id' => $id),
			'contain' => array('ProductCategory', 'Seller')
		));

		$this->paginate = array('Comment' => array(
			'conditions' => array('Comment.model' => 'Product', 'Comment.item_id' => $id, 'Comment.active' => 1),
			'order' => array('Comment.created ASC'),
			'contain' => array('User.fullname')
		));
		$comments = $this->paginate($this->Product->Comment);

		$this->set(compact('product', 'comments'));
        $this->set('title_for_layout', $product['Seller']['name'].' - '.$product['Product']['name'].' - '.Configure::read('GAS.name'));

	}

	function admin_index() {
		$this->Product->recursive = 0;
		$this->paginate = array('limit' => 50);

        //aggiungo filtro per categoria
        if(isset($this->params['named']['category'])) {
            //seleziono anche le sottocategorie
            $categories = $this->Product->ProductCategory->getSubCategories($this->params['named']['category']);
            $this->paginate = am($this->paginate, array('conditions' => array('product_category_id' => $categories)));
            $categoryName = $this->Product->ProductCategory->field('name', array('id' => $this->params['named']['category']));
            $this->set('categoryName', $categoryName);
        }
        
        //aggiungo filtro per produttore
        if(isset($this->params['named']['seller'])) {
            $this->paginate = am($this->paginate, array('conditions' => array('seller_id' => $this->params['named']['seller'])));
            $sellerName = $this->Product->Seller->field('name',  array('id' => $this->params['named']['seller']));
            $this->set('sellerName', $sellerName);
        }

		$this->set('products', $this->paginate());

        $productCategories = $this->Product->ProductCategory->generateTreeList(array(), '{n}.ProductCategory.id', '{n}.ProductCategory.name', ' - ');
        
		$sellers = $this->Product->Seller->find('list');

		$this->set(compact('productCategories', 'sellers'));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product'));
				$this->redirect(array('action' => 'index', 'seller' => $this->data['Product']['seller_id']));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product'));
			}
		}

		if(isset($this->params['named']['seller'])) {
			$this->data['Product']['seller_id'] = $this->params['named']['seller'];
		}
		$productCategories = $this->Product->ProductCategory->generateTreeList(array(), '{n}.ProductCategory.id', '{n}.ProductCategory.name', ' - ');
		$sellers = $this->Product->Seller->find('list');
		$this->set(compact('productCategories', 'sellers'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product'));
				$this->redirect(array('action' => 'index', 'seller' => $this->data['Product']['seller_id']));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
		}
		$productCategories = $this->Product->ProductCategory->generateTreeList(array(), '{n}.ProductCategory.id', '{n}.ProductCategory.name', ' - ');
		$sellers = $this->Product->Seller->find('list');
		$this->set(compact('productCategories', 'sellers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'product'));
			$this->redirect(array('action'=>'index'));
		}

		$seller_id = $this->Product->field('seller_id', $id);
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Product'));
			$this->redirect(array('action'=>'index', 'seller' => $seller_id));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Product'));
		$this->redirect(array('action' => 'index', 'seller' => $seller_id));
	}
}
?>