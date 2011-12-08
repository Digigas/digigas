<?php
class HampersController extends AppController {

    var $name = 'Hampers';
	var $components = array('UserComment');
	var $helpers = array('Html', 'Form', 'UserComment');

    function beforeFilter() {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'hampers');

        if(!isset($this->params['admin'])) {
            $userOrder = $this->Hamper->OrderedProduct->getUserOrder($this->Auth->user());
            $this->set('userOrder', $userOrder);
        }

        $this->Auth->deny($this->methods);
    }

    function index() {
        $this->paginate = array('conditions' => $this->Hamper->getActiveConditions(), 'order' => array('Hamper.end_date asc'));
        $this->Hamper->recursive = 0;
        $hampers = $this->paginate();
        $this->set('hampers', $hampers);
        $this->set('title_for_layout', __('Tutti i panieri aperti in questo momento', true).' - '.Configure::read('GAS.name'));

		//ultimi messaggi nel forum
		$this->ForumMessages->getLastMessages();
		
        if(empty($hampers)) {
            $this->set('title_for_layout', __('Nessun paniere disponibile in questo momento', true).' - '.Configure::read('GAS.name'));
            $this->render('index_closed');
        }
    }

    function view($id = null) {
        if (!$id || !$this->Hamper->isActive($id)) {
            $this->Session->setFlash(sprintf(__('%s non valido', true), 'Paniere'));
            $this->redirect(array('action' => 'index'));
        }
        $hamper = $this->Hamper->find('first', array(
			'conditions' => array('Hamper.id' => $id),
			'contain' => array(
				'Seller',
				'Product' => array('order' => 'product_category_id asc'),
				'Product.ProductCategory.name')
		));

		$this->paginate = array('Comment' => array(
			'conditions' => array('Comment.model' => 'Hamper', 'Comment.item_id' => $id, 'Comment.active' => 1),
			'order' => array('Comment.created ASC'),
			'contain' => array('User.fullname')
		));
		$comments = $this->paginate($this->Hamper->Comment);
		
        $this->set(compact('hamper', 'comments'));
        $this->set('title_for_layout', __('Paniere', true).' '.$hamper['Hamper']['name'].' - '.Configure::read('GAS.name'));
    }

    function admin_index() {
        $this->Hamper->recursive = 0;
        $this->paginate = array('order' => array('Hamper.id desc'));

        if(isset($this->params['named']['seller'])) {
            $this->paginate = array_merge_recursive($this->paginate, array('conditions' => array('Hamper.seller_id' => $this->params['named']['seller'])));
        }

        if(isset($this->params['named']['actives'])) {
            $this->paginate = array_merge_recursive($this->paginate, array('conditions' => array(
                    'start_date <' => date('Y-m-d H:m:s'),
                    'end_date >' => date('Y-m-d H:m:s')
            )));
        }

        if(isset($this->params['named']['templates'])) {
            $this->paginate = array_merge_recursive($this->paginate, array('conditions' => array('Hamper.is_template' => $this->params['named']['templates'])));
        }

        //query per trovare i sellers (utile per filtrare i panieri)
        $sellers = $this->Hamper->Seller->getSellers();

        $this->set('hampers', $this->paginate());
        $this->set(compact('sellers'));
		$this->set('title_for_layout', __('Panieri', true));
    }

    function admin_view($hamper_id) {
        //dettagli paniere
        $hamper = $this->Hamper->find('first', array(
            'conditions' => array('Hamper.id' => $hamper_id),
            'contain' => array(
                    'Seller.name'
            )
        ));

        //dettagli prodotti ordinati
        $_orderedProducts = $this->Hamper->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
            'order' => array('User.last_name asc', 'User.first_name asc', 'Product.product_category_id'),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Product' => array('fields' => array('id', 'name', 'code', 'option_1', 'option_2', 'units', 'items_in_a_box')),
                'Product.ProductCategory' => array('fields' => array('id', 'name'))
            )
        ));
        
        $orderedProducts = array();
            foreach($_orderedProducts as $orderedProduct) {
                    $product_id = $orderedProduct['Product']['id'].$orderedProduct['OrderedProduct']['option_1'].$orderedProduct['OrderedProduct']['option_2'];
                    $orderedProducts[$product_id]['Product'] = $orderedProduct['Product'];
                    $orderedProducts[$product_id]['Product']['option_1_value'] = $orderedProduct['OrderedProduct']['option_1'];
                    $orderedProducts[$product_id]['Product']['option_2_value'] = $orderedProduct['OrderedProduct']['option_2'];
                    $orderedProducts[$product_id]['OrderedProduct'][] = $orderedProduct;


                    //calcolo il totale per prodotto
                    if(isset($orderedProducts[$product_id]['Total'])) {
                        $orderedProducts[$product_id]['Total'] += $orderedProduct['OrderedProduct']['value'];
                    } else {
                        $orderedProducts[$product_id]['Total'] = $orderedProduct['OrderedProduct']['value'];
                    }
            }
            
		//trovo il totale per ogni prodotto
        $totals = $this->Hamper->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
            'fields' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2', 'OrderedProduct.note', 'Product.items_in_a_box','SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
            'group' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2', 'OrderedProduct.note'),
            'order' => array('hamper_id desc', 'Product.product_category_id'),
            'contain' => array(
                'Product' => array('name', 'code', 'option_1', 'option_2', 'units'), 'Hamper.delivery_date_on',
                'Product.ProductCategory' => array('fields' => array('id', 'name'))
                )
        ));
		// totale
		$total = array_sum(Set::extract('/0/total', $totals));

		//trovo l'elenco degli utenti con ordini attivi
        $users = $this->Hamper->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->Hamper->OrderedProduct->getPendingSellers();

		//trovo l'elenco dei panieri con ordini attivi
        $hampers = $this->Hamper->OrderedProduct->getPendingHampers();

		$this->set(compact('orderedProducts', 'hamper', 'users', 'sellers', 'hampers', 'totals', 'total'));
	}

    function admin_index_templates() {
        $this->Hamper->recursive = 0;
        $this->paginate = array('conditions' => array('is_template' => 1), 'order' => array('Hamper.id desc'));

        if(isset($this->params['named']['seller'])) {
            $this->paginate = array_merge_recursive($this->paginate, array('conditions' => array('Hamper.seller_id' => $this->params['named']['seller'])));
        }

        //query per trovare i sellers (utile per filtrare i panieri)
        $sellers = $this->Hamper->Seller->getSellers();

        $this->set('hampers', $this->paginate());
        $this->set(compact('sellers'));
		$this->set('title_for_layout', __('Panieri - modelli', true));
    }

    function admin_copy($id) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('%s non valido', true), 'paniere'));
            $this->redirect(array('action' => 'index'));
        }

        $newId = $this->Hamper->copy($id);
        if($newId) {
            $this->redirect(array('controller' => 'hampers', 'action' => 'edit', $newId));
        }

    }

    function admin_add($seller_id = null) {
        if(!$seller_id && empty($this->data)) {
            $this->Session->setFlash(__('Devi selezionare un produttore', true));
            $this->redirect(array('action' => 'index'));
        }
        
        if (!empty($this->data)) {
            $this->data = $this->Hamper->formatDates($this->data);
            $this->Hamper->create();
            if ($this->Hamper->save($this->data)) {
                $this->Session->setFlash(sprintf(__('Il %s è stato salvato', true), 'Paniere'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'Paniere'));
            }
        }

        $seller = $this->Hamper->Seller->field('name', array('Seller.id' => $seller_id));
        $sellers = $this->Hamper->Seller->find('list', array('conditions' => array('active' => 1)));

        //seleziono i prodotti di questo produttore
        $productCategories = $this->Hamper->Product->getAllFromSellerByCategory($seller_id);

        $this->set(compact('seller', 'seller_id', 'sellers', 'productCategories'));
		$this->set('title_for_layout', __('Nuovo paniere', true));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('%s non valido', true), 'Paniere'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->data = $this->Hamper->formatDates($this->data);
            if ($this->Hamper->save($this->data)) {
                $this->Session->setFlash(sprintf(__('Il %s è stato salvato', true), 'Paniere'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'hamper'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Hamper->read(null, $id);
        }
        $sellers = $this->Hamper->Seller->find('list', array('conditions' => array('active' => 1)));
        //seleziono i prodotti di questo produttore
        $productCategories = $this->Hamper->Product->getAllFromSellerByCategory($this->data['Seller']['id']);

        $relatedProducts = Set::extract('/Product/id', $this->data);
        $this->set(compact('sellers', 'productCategories', 'relatedProducts'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Id non valido per il %s', true), 'Paniere'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Hamper->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s eliminato', true), 'Eliminato'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(sprintf(__('Il %s non è stato eliminato', true), 'paniere'));
        $this->redirect(array('action' => 'index'));
		$this->set('title_for_layout', __('Modifica paniere', true));
    }

    function admin_print_pdf($hamper_id, $hamper_user_id = null, $save = false) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';

        //dettagli paniere
        $hamper = $this->Hamper->find(
            'first',
            array(
                'conditions' => array('Hamper.id' => $hamper_id),
                'contain' => array(
                    'Seller.name'//,
//                    'OrderedProduct',
//                    'OrderedProduct.Product',
//                    'OrderedProduct.Product.ProductCategory',
//                    'OrderedProduct.User'
                ),

            )
        );


        //dettagli prodotti ordinati per stampa pdf
        $conditions = array(
            'OrderedProduct.hamper_id' => $hamper_id
            );

        if(isset($hamper_user_id)){
            $conditions['OrderedProduct.user_id'] = $hamper_user_id;
//            print_r($conditions); die();
            }
        $_orderedProducts = $this->Hamper->OrderedProduct->find(
            'all',
            array(
                'conditions' => $conditions,
                'order' => array(
                    'Product.product_category_id asc',
                    'User.last_name asc',
                    'User.first_name asc',
                    'Product.name'
            ),
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'id',
                        'fullname',
                        'phone',
                        'mobile',
                        'email'
                        )
                ),
            'Product' => array(
                    'fields' => array(
                        'id',
                        'name',
                        'code',
                        'units',
                        'option_1',
                        'option_2',
                        'product_category_id',
                        'items_in_a_box')
                    ),
                'Product.ProductCategory' => array(
                    'fields' => array(
                        'id',
                        'name')
                    )
                )
            )
        );

        $orderedProducts = array();
        foreach($_orderedProducts as $product) {
            $user_id = $product['User']['id'];
            $orderedProducts[$user_id]['User'] = $product['User'];
            $orderedProducts[$user_id]['Products'][] = $product;

            //calcolo il totale per utente
            if(isset($orderedProducts[$user_id]['Total'])) {
                    $orderedProducts[$user_id]['Total'] += $product['OrderedProduct']['value'];
            } else {
                    $orderedProducts[$user_id]['Total'] = $product['OrderedProduct']['value'];
            }
        }

        //nuova query per ordinata per categoria
        $categoriesProducts = $this->Hamper->OrderedProduct->find(
            'all',
            array(
                'conditions' => $conditions,
                'fields' => array(
                    'hamper_id',
                    'product_id',
                    'option_1',
                    'option_2',
                    'SUM(OrderedProduct.value) as total',
                    'SUM(OrderedProduct.quantity) as quantity'),
                'group' => array(
                    'Product.product_category_id',
                    'product_id',
                    'OrderedProduct.option_1',
                    'OrderedProduct.option_2',
                    'OrderedProduct.note'
                    ),
                'order' => array('product_category_id'),
                'contain' => array(
                    'Product.id',
                    'Product.name',
                    'Product.units',
                    'Product.option_1',
                    'Product.option_2' ,
                    'Product.items_in_a_box' ,
                    'Hamper.delivery_date_on',
                    'Product.ProductCategory.id',
                    'Product.ProductCategory.name',

                    'Product.code'
                    )
                )
            );

        $categories = array();
        foreach($categoriesProducts as $i => $categoryProduct) {
            $categoryId = $categoryProduct['Product']['product_category_id'];
            $categoryData = $categoryProduct['Product']['ProductCategory'];
            $productId = $categoryProduct['Product']['id'];
            $productData = $categoryProduct['Product'];
            $categories[$categoryId]['ProductCategory'] = $categoryData;
            $categories[$categoryId]['Product'][$i]['Product'] = $productData;
            $categories[$categoryId]['Product'][$i]['OrderedProduct'] = $categoryProduct['OrderedProduct'];
            $categories[$categoryId]['Product'][$i]['OrderedProduct']['total'] = $categoryProduct['0']['total'];
            $categories[$categoryId]['Product'][$i]['OrderedProduct']['quantity'] = $categoryProduct['0']['quantity'];
        }

        // totale
        $total = array_sum(Set::extract('/Total', $orderedProducts));

        //trovo l'elenco degli utenti con ordini attivi
        $users = $this->Hamper->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->Hamper->OrderedProduct->getPendingSellers();

        $this->set(compact('categories', 'orderedProducts', 'hamper', 'users', 'sellers',  'total', 'hamper_user_id', 'save'));

        if(!date_is_empty($hamper['Hamper']['delivery_date_on'])) {
                $pageTitle = Inflector::slug(Configure::read('GAS.name').'_'.$hamper['Seller']['name'].'_'.date('d-m-Y', strtotime($hamper['Hamper']['delivery_date_on']))).'.pdf';
        } else {
                $pageTitle = Inflector::slug(Configure::read('GAS.name').'_'.$hamper['Seller']['name']).'.pdf';
        }
        $this->set('pageTitle', $pageTitle);
    }
        
    function admin_mail_to_users($hamper_id) {
        //dettagli paniere
        $hamper = $this->Hamper->find('first', array(
            'conditions' => array('Hamper.id' => $hamper_id),
            'contain' => array(
                    'Seller.name'
            )
        ));

        $this->admin_print_pdf($hamper_id, null, true);
        $this->render('admin_print_pdf', '');

        $orderedProducts = $this->viewVars['orderedProducts'];
//        Configure::write('debug', 2);
//        debug($orderedProducts); die();

        $admins = $this->Hamper->User->find('all', array('conditions'=> array('role'=>1)));
        $failed = false;
        foreach($admins as $admin)
        {
            $this->set('userFullName', $admin['User']['fullname']);
            $this->Email->to = $admin['User']['email'];
            $this->Email->subject = '['.Configure::read('GAS.name').'] '.__('Riepilogo Ordine ', true)
                    .$hamper['Hamper']['name']
                    .' di '.$hamper['Seller']['name'];
            $this->Email->from = Configure::read('email.from');
            $this->Email->sendAs = 'html';
            $this->Email->template = 'admin_mail_pdf_hamper_to_admins';
            $file_name = 'Paniere_'.$hamper['Hamper']['id'];
            $this->Email->attachments = array(
                TMP . $file_name.'.pdf'
            );

            if($this->Email->send()) {
                    //mail ok
            } else {
                    //mail error
                    $failed = true;
            }
        }
        
        foreach($orderedProducts as $userOrder) {
            $this->set('userFullName', $userOrder['User']['fullname']);

            $this->admin_print_pdf($hamper_id, $userOrder['User']['id'], true);
            $this->render('admin_print_pdf', '');

            $this->Email->to = $userOrder['User']['email'];
            $this->Email->subject = '['.Configure::read('GAS.name').'] '.__('Ordine ', true)
                    .$hamper['Hamper']['name']
                    .' di '.$hamper['Seller']['name'];
            $this->Email->from = Configure::read('email.from');
            $this->Email->sendAs = 'html';
            $this->Email->template = 'admin_mail_pdf_hamper_to_users';
            $file_name = 'Paniere_'.$hamper['Hamper']['id'];
            $file_name .= '_'.$userOrder['User']['id'];
            $this->Email->attachments = array(
                TMP . $file_name.'.pdf'
            );

            if($this->Email->send()) {
                    //mail ok
            } else {
                    //mail error
                    $failed = true;
            }
        }
        if($failed) {
                $this->Session->setFlash('Si sono verificati degli errori');
        } else {
                $this->Session->setFlash('Tutte le email sono state inviate correttamente');
        }

        $this->redirect($this->referer());

    }

}
?>