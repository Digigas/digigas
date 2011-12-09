<?php
class ProductsController extends AppController {

	var $name = 'Products';
	var $components = array('UserComment');
	var $helpers = array('Html', 'Form', 'UserComment', 'Number');

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
			$this->Session->setFlash(sprintf(__('%s non valido', true), 'Prodotto'));
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
				$this->Session->setFlash(sprintf(__('Il %s è stato salvato', true), 'prodotto'));
				$this->redirect(array('action' => 'index', 'seller' => $this->data['Product']['seller_id']));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'prodotto'));
			}
		}

		if(isset($this->params['named']['seller'])) {
			$this->data['Product']['seller_id'] = $this->params['named']['seller'];
		}
		$productCategories = $this->Product->ProductCategory->generateTreeList(array(), '{n}.ProductCategory.id', '{n}.ProductCategory.name', ' - ');
		$sellers = $this->Product->Seller->find('list');
		$this->set(compact('productCategories', 'sellers'));
	}

    function admin_import() 
    {
        
//         debug($this->data);
        if($this->data['importable'])
        {
            $imported = 0;
            foreach($this->data['importable'] as $product)
            {
                $product = unserialize($product);
                $seller_id = $product['Product']['seller_id'];
                $product['Product']['id'] = null;
                if(!$product['Product']['text'])
                    $product['Product']['text'] = " ";
                if(!$product['Product']['show_note'])
                    $product['Product']['show_note'] = false;
                
                //debug($product);
                if(!$product['Product']['product_category_id'])
                {   
                    $product_category = $this->Product->ProductCategory->find('first', array('conditions'=> array('name' => $product['ProductCategory']['name']), 'recursive' => -1));
                    $product_category_id = "";
                    if($product_category)
                    {
                        $product['Product']['product_category_id'] = $product_category['ProductCategory']['id'];
                    }
                    else
                    {
                        $this->Product->ProductCategory->save(array('id' => null, 'name' => $product['ProductCategory']['name']));
                        $product['Product']['product_category_id'] = $this->Product->ProductCategory->id;
                    }
                    $this->Product->save($product['Product']);
                }
                if($this->Product->save($product['Product']))
                    $imported++;
            }
            $this->Session->setFlash("Importati correttamente Nr $imported prodotti");
        }

        $this->redirect(array('action' => 'index', 'seller' => $seller_id));
    }
    
    function admin_upload() 
    {
        App::import('Vendor', 'iofactory', array('file' => 'PHPExcel'.DS.'IOFactory.php'));
        if (!empty($this->data)) 
        {
            
            if($this->data['Product']['spreadsheet']['tmp_name'])
            {
                $objPHPExcel = PHPExcel_IOFactory::load($this->data['Product']['spreadsheet']['tmp_name']);
                $objPHPExcel->setActiveSheetIndex(0);
                $counter=2;
                $seller = $this->Product->Seller->find('first', array('conditions'=> array('id' => $this->data['Product']['seller_id']), 'recursive' => -1));

                $products = array();
                while($objPHPExcel->getActiveSheet()->getCell("A$counter")->getValue() && $counter < 100)
                {
                    $product_category = $this->Product->ProductCategory->find('first', array('conditions'=> array('name' => $objPHPExcel->getActiveSheet()->getCell("C$counter")->getValue()), 'recursive' => -1));
                    $product_category_id = "";
                    if($product_category)
                        $product_category_id = $product_category['ProductCategory']['id'];
                    $products[] = array(
                        'Product' => array
                        (
                            'name' =>$objPHPExcel->getActiveSheet()->getCell("A$counter")->getValue(),
                            'code' =>$objPHPExcel->getActiveSheet()->getCell("B$counter")->getValue(),
                            'seller_id' => $this->data['Product']['seller_id'],
                            'product_category_id' => $product_category_id,
                            'weight' =>$objPHPExcel->getActiveSheet()->getCell("D$counter")->getValue(),
                            'text' =>$objPHPExcel->getActiveSheet()->getCell("E$counter")->getValue(),
                            'number' =>$objPHPExcel->getActiveSheet()->getCell("F$counter")->getValue(),
                            'value' =>$objPHPExcel->getActiveSheet()->getCell("G$counter")->getValue(),
                            'units' =>$objPHPExcel->getActiveSheet()->getCell("H$counter")->getValue(),
                            'option_1' =>$objPHPExcel->getActiveSheet()->getCell("I$counter")->getValue(),
                            'option_list_1' =>$objPHPExcel->getActiveSheet()->getCell("J$counter")->getValue(),
                            'option_2' =>$objPHPExcel->getActiveSheet()->getCell("K$counter")->getValue(),
                            'option_list_2' =>$objPHPExcel->getActiveSheet()->getCell("L$counter")->getValue(),
                            'show_note' =>$objPHPExcel->getActiveSheet()->getCell("M$counter")->getValue()
                        ),
                        'Seller' => array
                        (
                            'name' => $seller['Seller']['name']
                        ),
                        'ProductCategory' => array
                        (
                            'name' =>$objPHPExcel->getActiveSheet()->getCell("C$counter")->getValue(),
                            'id' => $product_category_id
                        )
                    );
                    $counter++;
                }
            }
        }
        $productCategories = $this->Product->ProductCategory->generateTreeList(array(), '{n}.ProductCategory.id', '{n}.ProductCategory.name', ' - ');
        $sellers = $this->Product->Seller->find('list');
        $this->set(compact('productCategories', 'sellers', 'products'));
    }

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('%s non valido', true), 'Prodotto'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Il %s è stata salvato', true), 'prodotto'));
				$this->redirect(array('action' => 'index', 'seller' => $this->data['Product']['seller_id']));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'prodotto'));
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
			$this->Session->setFlash(sprintf(__('Id  non valido per il %s', true), 'prodotto'));
			$this->redirect(array('action'=>'index'));
		}
        $seller_id = $this->Product->field('seller_id', array('id' =>$id));
		

		if ($this->Product->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s eliminato', true), 'Prodotto'));
			$this->redirect(array('action'=>'index', 'seller' => $seller_id));
		}
		$this->Session->setFlash(sprintf(__('Il %s non è stato eliminato', true), 'prodotto'));
		$this->redirect(array('action' => 'index', 'seller' => $seller_id));
	}
}
?>