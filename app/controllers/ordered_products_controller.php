<?php
class OrderedProductsController extends AppController {

    var $name = 'OrderedProducts';

    function beforeFilter() {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'orders');
		$this->set('title_for_layout', __('Ordini', true));

        $this->Auth->deny($this->methods);
    }

    function index() {
        $orderedProducts = $this->OrderedProduct->getUserOrder($this->Auth->User());
        $this->set(compact('orderedProducts'));
        $this->set('title_for_layout', __('I miei ordini', true).' - '.Configure::read('GAS.name'));
    }

    function past_orders() {
        $user = $this->Auth->user();
        $this->paginate = array(
            'conditions' => array(
                'user_id' => $user['User']['id']),
            'order' => array(
                'OrderedProduct.created desc'
            ));
        $this->OrderedProduct->recursive = 0;
        $this->set('orderedProducts', $this->paginate());
        $this->set('title_for_layout', __('Storico degli ordini', true).' - '.Configure::read('GAS.name'));
    }

    function add() {

        $user = $this->Auth->user();
        if(empty($user)) {
            $this->Session->setFlash(__('Devi fare login per ordinare', true));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        $this->data = $this->OrderedProduct->buildOrder($this->data, $user);

        if (!empty($this->data)) {
            $this->OrderedProduct->create();
            if ($this->OrderedProduct->save($this->data)) {
                $this->Session->setFlash(__('L\'Ordine è stato registrato correttamente, grazie!', true));
            } else {
                $this->Session->setFlash(__('L\'ordine non può essere registrato, riprova', true));
            }

        } else {
            $this->Session->setFlash(__('L\'ordine non è corretto', true));
        }
        $this->redirect($this->referer());
    }

    function delete($id) {
        $user = $this->Auth->user();

        if($this->OrderedProduct->verify($id, $user)) {
            if($this->OrderedProduct->delete($id)) {
                $this->Session->setFlash(__('Ordine annullato', true));
            } else {
                $this->Session->setFlash(__('Si è verificato un errore durante l\'annullamento. Riprova', true));
            }
        } else {
            $this->Session->setFlash(__('L\'ordine non può essere annullato', true));
        }

        $this->redirect($this->referer());
    }

    function send_me_orders_email() {
        $user = $this->Auth->user();
        if($this->_mail_orders_to_user($user['User']['id'], $user['User']['email'])) {
            $this->Session->setFlash(__('Ti è statainviata una email con il riepilogo dei tuoi ordini', true));
        } else {
            $this->Session->setFlash(__('Si è verificato un errore, riprova o contatta l\'amministratore', true));
        }
        $this->redirect($this->referer());
    }

    function admin_index() {
        $this->paginate = array_merge_recursive($this->paginate, array('conditions' => array(
                'or' => array(
                    'paid' => 0,
                    'retired' => 0
                )),
            'order' => array('hamper_id desc', 'user_id asc'),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name', 'code', 'option_1', 'option_2', 'units')),
                'Hamper' => array('fields' => array('id', 'delivery_date_on')))
        ));
        $this->OrderedProduct->recursive = 0;
        $orderedProducts = $this->paginate();
        $this->set('orderedProducts', $orderedProducts);

        $lastModified = $this->OrderedProduct->find('all', array(
            'conditions' => array(
                'paid' => 1,
                'retired' => 1,
                'OrderedProduct.modified > ' => date('Y-m-d H:i:s', strtotime('now - 24 hours'))),
            'order' => 'OrderedProduct.modified desc',
            'limit' => '20'
        ));
        $this->set('lastModified', $lastModified);

        //trovo l'elenco degli utenti con ordini attivi
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

		//trovo l'elenco dei panieri con ordini attivi
        $hampers = $this->OrderedProduct->getPendingHampers();

        $this->set(compact('users', 'sellers', 'hampers'));
    }

    function admin_index_user($user_id) {
//        $this->paginate = array(
//            'conditions' => array('user_id' => $user_id, 'or' => array('paid' => 0, 'retired' => 0)),
//            'contain' => array(
//                'User' => array('fields' => array('id', 'fullname')),
//                'Seller' => array('fields' => array('id', 'name')),
//                'Product' => array('fields' => array('id', 'name')))
//        );
//        $this->OrderedProduct->recursive = 0;
//        $orderedProducts = $this->paginate();

        $orderedProducts = $this->OrderedProduct->getPendingForUser($user_id);

        $toPay = Set::extract('/OrderedProduct/value', $orderedProducts);
        $total = array_sum($toPay);

        $user = $this->OrderedProduct->User->findById($user_id);

        //trovo l'elenco degli utenti con ordini attivi
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

		//trovo l'elenco dei panieri con ordini attivi
        $hampers = $this->OrderedProduct->getPendingHampers();

        $this->set(compact('orderedProducts', 'user', 'users', 'sellers', 'hampers', 'total'));
    }

	function admin_index_hamper($hamper_id) {
		//dettagli paniere
		$hamper = $this->OrderedProduct->Hamper->find('first', array(
			'conditions' => array('Hamper.id' => $hamper_id),
			'contain' => array(
				'Seller.name'
			)
		));

		//dettagli prodotti ordinati
		$_orderedProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
			'order' => array('User.last_name asc', 'User.first_name asc', 'Product.product_category_id'),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Product' => array('fields' => array('id', 'name', 'code', 'option_1', 'option_2', 'units')),
                'Product.ProductCategory' => array('fields' => array('id', 'name'))
                )
        ));
        $orderedProducts = array();
		foreach($_orderedProducts as $product) {
			$user_id = $product['User']['id'];
			$orderedProducts[$user_id]['User']['fullname'] = $product['User']['fullname'];
			$orderedProducts[$user_id]['Products'][] = $product;

			//calcolo il totale per utente
			if(isset($orderedProducts[$user_id]['Total'])) {
				$orderedProducts[$user_id]['Total'] += $product['OrderedProduct']['value'];
			} else {
				$orderedProducts[$user_id]['Total'] = $product['OrderedProduct']['value'];
			}
		}

		//trovo il totale per ogni prodotto
        $totals = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
            'fields' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2', 'OrderedProduct.note', 'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
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
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

		//trovo l'elenco dei panieri con ordini attivi
        $hampers = $this->OrderedProduct->getPendingHampers();

		$this->set(compact('orderedProducts', 'hamper', 'users', 'sellers', 'hampers', 'totals', 'total'));
	}

    function admin_index_seller($seller_id) {

        //dettagli ordine
        $this->OrderedProduct->recursive = 0;
        $orderedProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.seller_id' => $seller_id, 'or' => array('paid' => 0, 'retired' => 0)),
			'order' => array('OrderedProduct.user_id'),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name', 'code', 'option_1', 'option_2', 'units')))
        ));

        //trovo il totale per ogni prodotto
        $totals = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.seller_id' => $seller_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'fields' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2', 'OrderedProduct.note', 'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
            'group' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2', 'OrderedProduct.note'),
            'order' => array('hamper_id desc'),
            'contain' => array('Product' => array('name', 'code', 'option_1', 'option_2', 'units'), 'Hamper.delivery_date_on')
        ));

        $totalsByHamper = array();
        foreach($totals as $tot) {
			$totalsByHamper[$tot['Hamper']['id']]['date'] = $tot['Hamper']['delivery_date_on'];
            if(isset($totalsByHamper[$tot['Hamper']['id']]['total'])) {
                $totalsByHamper[$tot['Hamper']['id']]['total'] += $tot['0']['total'];
            } else {
                $totalsByHamper[$tot['Hamper']['id']]['total'] = $tot['0']['total'];
            }
        }

        $seller = $this->OrderedProduct->Seller->findById($seller_id);

        //trovo l'elenco degli utenti con ordini attivi
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

		//trovo l'elenco dei panieri con ordini attivi
        $hampers = $this->OrderedProduct->getPendingHampers();

        $this->set(compact('orderedProducts', 'seller', 'users', 'sellers', 'hampers', 'totals', 'totalsByHamper'));
    }

    function admin_mass_actions($action = false, $hamper_id = false) {

        //piccolo controllo
        if(!in_array($action, array('paid', 'retired', false))) {
            $this->Session->setFlash(__('Ehi, non cercare di fregarmi!', true));
            $this->redirect(array('action' => 'mass_actions'));
        }

        if($action && $hamper_id) {

            //SALVO
            $this->OrderedProduct->massUpdate($action, $hamper_id);

            $this->Session->setFlash(__('Ok, operazione eseguita', true));
            $this->redirect(array('action' => 'mass_actions'));
        }

        $pendingOrders = $this->OrderedProduct->find('all', array(
            'conditions' => array('or' => array('paid' => 0, 'retired' => 0)),
            'fields' => array('OrderedProduct.hamper_id'),
            'group' => array('OrderedProduct.seller_id', 'OrderedProduct.hamper_id'),
            'recursive' => -1
        ));
        $pendingHampersIds = Set::extract('/OrderedProduct/hamper_id', $pendingOrders);
        $pendingHampers = $this->OrderedProduct->Hamper->find('all', array(
            'conditions' => array('Hamper.id' => $pendingHampersIds),
            'fields' => array('Hamper.id', 'Hamper.name', 'Hamper.delivery_date_on'),
            'contain' => array('Seller.name')
        ));

        if(empty($pendingHampers)) {
            $this->Session->setFlash(__('Non c\'è nessun ordine pendente in questo momento', true));
            $this->redirect(array('action' => 'index'));
        }

        //trovo l'elenco degli utenti con ordini attivi
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

        $this->set(compact('users', 'sellers', 'pendingHampers'));
    }

    function admin_mail_orders_to_user($user_id) {
        //dati dell'utente
        $user = $this->OrderedProduct->User->find('first', array(
            'conditions' => array('User.id' => $user_id, 'User.active' => 1),
            'fields' => array('fullname', 'email'),
            'recursive' => -1));

        if(empty($user)) {
            $this->Session->setFlash(__('Utente inesistente o disattivato', true));
            $this->redirect($this->referer());
        }

        //invio la mail
        $mail_ok = $this->_mail_orders_to_user($user_id, $user['User']['email']);

        if($mail_ok) {
            $this->Session->setFlash(__('Email inviata correttamente', true));
        } else {
            $this->Session->setFlash(__('ERRORE durante l\'invio della mail', true));
        }
        $this->redirect($this->referer());
    }

	function admin_mail_hamper_to_users($hamper_id) {
        //dettagli paniere
		$hamper = $this->OrderedProduct->Hamper->find('first', array(
			'conditions' => array('Hamper.id' => $hamper_id),
			'contain' => array(
				'Seller.name'
			)
		));

		//dettagli prodotti ordinati
		$_orderedProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
			'order' => array('User.id asc'),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname', 'email')),
                'Product' => array('fields' => array('id', 'name', 'option_1', 'option_2')))
        ));
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

		$failed = false;
		foreach($orderedProducts as $userOrder) {
			$products = $userOrder['Products'];
			$total = $userOrder['Total'];
			$this->set(compact('products', 'hamper', 'total'));

			//compongo il messaggio nella view che si trova nella cartella email
			//invio l'email
			//$this->Email->delivery = 'debug';
			$this->Email->to = $userOrder['User']['email'];
			$this->Email->subject = '['.Configure::read('GAS.name').'] '.__('Ordine ', true)
				.$hamper['Hamper']['name']
				.' di '.$hamper['Seller']['name'];
			$this->Email->from = Configure::read('email.from');
			$this->Email->sendAs = 'html';
			$this->Email->template = 'admin_mail_hamper_to_users';

			if($this->Email->send()) {
				//mail ok
			} else {
				//mail error
				$failed = true;
			}

			if($failed) {
				$this->Session->setFlash('Si sono verificati degli errori');
			} else {
				$this->Session->setFlash('Tutte le email sono state inviate correttamente');
			}

			$this->redirect($this->referer());
		}
    }

    function admin_mass_mail_orders_to_users() {
        //utenti con ordini pendenti
        $users = $this->OrderedProduct->getPendingUsers(true);

        $failed = array();
        foreach($users as $user) {
            if(!$this->_mail_orders_to_user($user['User']['id'], $user['User']['email'])) {
                $failed[] = $user;
            }
        }

        if(empty($failed)) {
            $this->Session->setFlash(__('Tutte le email sono state spedite correttamente', true));
        } else {
            $this->Session->setFlash(__('Si sono verificati degli errori durante la spedizione delle email', true));
        }
        $this->redirect($this->referer());
    }

    function admin_mail_orders_to_seller($seller_id) {
        //dati dell'utente
        $seller = $this->OrderedProduct->Seller->find('first', array(
            'conditions' => array('Seller.id' => $seller_id, 'Seller.active' => 1),
            'fields' => array('name', 'business_name', 'email'),
            'recursive' => -1));

        if(empty($seller)) {
            $this->Session->setFlash(__('Fornitore inesistente o disattivato', true));
            $this->redirect($this->referer());
        }

        $mail_ok = $this->_mail_orders_to_seller($seller_id, $seller['Seller']['name']);

        if($mail_ok) {
            $this->Session->setFlash(__('Email inviata correttamente', true));
        } else {
            $this->Session->setFlash(__('ERRORE durante l\'invio della mail', true));
        }
        $this->redirect($this->referer());
    }

    function admin_mass_mail_orders_to_sellers() {
        //utenti con ordini pendenti
        $sellers = $this->OrderedProduct->getPendingSellers(true);

        $failed = array();
        foreach($sellers as $seller) {
            if(!$this->_mail_orders_to_seller($seller['Seller']['id'], $seller['Seller']['email'])) {
                $failed[] = $seller;
            }
        }

        if(empty($failed)) {
            $this->Session->setFlash(__('Tutte le email sono state spedite correttamente', true));
        } else {
            $this->Session->setFlash(__('Si sono verificati degli errori durante la spedizione delle email', true));
        }
        $this->redirect($this->referer());
    }

    function _mail_orders_to_user($user_id, $user_email) {
        $this->Email->reset();

        //dati dell'ordine
        $orderedProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('user_id' => $user_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name')),
                'Hamper' => array('fields' => array('delivery_date_on')))
        ));
        $this->set(compact('user', 'orderedProducts'));

        //compongo il messaggio nella view che si trova nella cartella email
        //invio l'email
        //$this->Email->delivery = 'debug';
        $this->Email->to = $user_email;
        $this->Email->subject = '['.Configure::read('GAS.name').'] '.__('Riepilogo ordini', true);
        $this->Email->from = Configure::read('email.from');
        $this->Email->sendAs = 'html';
        $this->Email->template = 'admin_mail_orders_to_user';

        if($this->Email->send()) {
            //mail ok
            return true;
        } else {
            //mail error
            return false;
        }
    }

    function _mail_orders_to_seller($seller_id, $seller_email) {
        $this->Email->reset();

        //dati dell'ordine
        //trovo il totale per ogni prodotto
        $totals = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.seller_id' => $seller_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'fields' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2', 'OrderedProduct.note', 'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
            'group' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2', 'OrderedProduct.note'),
            'contain' => array('Product.id', 'Product.name', 'Hamper.delivery_date_on')
        ));
        $totals = Set::combine($totals, '{n}.Product.id', '{n}');
        $this->set(compact('seller', 'totals'));

        $relatedUsers = $this->OrderedProduct->Seller->getUserEmails($seller_id);

        $adminUsers = $this->OrderedProduct->User->getAdminEmails();

        //compongo il messaggio nella view che si trova nella cartella email
        //invio l'email
        //$this->Email->delivery = 'debug';
        $this->Email->to = $seller_email;
        $this->Email->cc = $relatedUsers;
        $this->Email->bcc = $adminUsers;
        $this->Email->subject = '['.Configure::read('GAS.name').'] '.__('Riepilogo ordini per produttori', true);
        $this->Email->from = Configure::read('email.from');
        $this->Email->sendAs = 'html';
        $this->Email->template = 'admin_mail_orders_to_seller';

        if($this->Email->send()) {
            //mail ok
            return true;
        } else {
            //mail error
            return false;
        }
    }

    function admin_set_paid($id) {
        if($this->OrderedProduct->setPaid($id)) {
            $this->Session->setFlash(__('Ok, pagato!', true));
            $this->redirect($this->referer());
        }
    }

    function admin_set_not_paid($id) {
        if($this->OrderedProduct->setNotPaid($id)) {
            $this->Session->setFlash(__('Ordine ripristinato come pendente', true));
            $this->redirect($this->referer());
        }
    }

    function admin_set_retired($id) {
        if($this->OrderedProduct->setRetired($id)) {
            $this->Session->setFlash(__('Ok, ritirato!', true));
            $this->redirect($this->referer());
        }
    }

    function admin_set_not_retired($id) {
        if($this->OrderedProduct->setNotRetired($id)) {
            $this->Session->setFlash(__('Ordine ripristinato come pendente', true));
            $this->redirect($this->referer());
        }
    }

//    function admin_add() {
//        if (!empty($this->data)) {
//            $this->OrderedProduct->create();
//            if ($this->OrderedProduct->save($this->data)) {
//                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'ordered product'));
//                $this->redirect(array('action' => 'index'));
//            } else {
//                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'ordered product'));
//            }
//        }
//        $users = $this->OrderedProduct->User->find('list');
//        $sellers = $this->OrderedProduct->Seller->find('list');
//        $products = $this->OrderedProduct->Product->find('list');
//        $hampers = $this->OrderedProduct->Hamper->find('list');
//        $this->set(compact('users', 'sellers', 'products', 'hampers'));
//    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'ordered product'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->OrderedProduct->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'ordered product'));
                if(isset($this->data['Referer'])) {
					$this->redirect($this->data['Referer']);
				} else {
					$this->redirect(array('action' => 'index'));
				}
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'ordered product'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->OrderedProduct->read(null, $id);
        }
        //$users = $this->OrderedProduct->User->find('list');
        //$sellers = $this->OrderedProduct->Seller->find('list');
        //$products = $this->OrderedProduct->Product->find('list');
        //$hampers = $this->OrderedProduct->Hamper->find('list');
        //$this->set(compact('users', 'sellers', 'products', 'hampers'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'ordered product'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->OrderedProduct->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s deleted', true), 'Ordered product'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Ordered product'));
        $this->redirect(array('action' => 'index'));
    }

    function admin_order_for_user() {
        $users = $this->OrderedProduct->User->find('list', array(
			'conditions' => array('User.active' => 1),
			'order' => array('User.Last_name asc', 'User.First_name asc')));
        $hampers = $this->OrderedProduct->Hamper->find('all', array(
            'conditions' => $this->OrderedProduct->Hamper->getActiveConditions(),
            'contain' => array('Seller.name')
        ));
        $this->set(compact('users', 'hampers'));

        if(empty($hampers)) {
            $this->Session->setFlash(__('Non ci sono panieri aperti in questo momento', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    function admin_order_for_user_2() {
        if(empty($this->data) || empty($this->data['OrderedProduct']['hamper_id'])) {
            $this->Session->setFlash(__('Devi prima compilare questa pagina', true));
            $this->redirect(array('action' => 'admin_order_for_user'));
        }

        $user_id = $this->data['OrderedProduct']['user_id'];
        $user = $this->OrderedProduct->User->read(null, $user_id);
        $hamper_id = $this->data['OrderedProduct']['hamper_id'];
        $hamper = $this->OrderedProduct->Hamper->read(null, $hamper_id);

        $this->set(compact('user_id', 'user', 'hamper_id', 'hamper'));
    }

    function admin_order_for_user_3() {
        if(empty($this->data)) {
            $this->Session->setFlash(__('Devi prima compilare questa pagina', true));
            $this->redirect(array('action' => 'admin_order_for_user'));
        }

        $user = $this->OrderedProduct->User->read(null, $this->data['OrderedProduct']['user_id']);

        $errors = false;
        foreach($this->data['Product'] as $product_id => $data) {
            if(!empty($data['quantity'])) {
                $dataToValidate = array('OrderedProduct' => array(
                        'product_id' => $product_id,
                        'hamper_id' => $this->data['OrderedProduct']['hamper_id'],
                        'seller_id' => $this->data['OrderedProduct']['seller_id'],
						'option_1' => $data['option_1'],
						'option_2' => $data['option_2'],
						'note' => $data['note'],
                        'quantity' => $data['quantity']
                ));
                //debug($dataToValidate);
                $dataToSave = $this->OrderedProduct->buildOrder($dataToValidate, $user);
                //debug($dataToSave);
                if(!empty($dataToSave)) {
                    $this->OrderedProduct->create();
                    if(!$this->OrderedProduct->save($dataToSave)) {
                        $errors = true;
                    }
                } else {
                    $errors = true;
                }
            }
        }

        if(!$errors) {
            $this->Session->setFlash(__('L\'Ordine è stato registrato correttamente!', true));
        } else {
            $this->Session->setFlash(__('Si sono verificati degli errori, verifica', true));
        }
        $this->redirect(array('controller' => 'ordered_products', 'action' => 'index'));

    }

    function admin_print_pdf_seller($seller_id) {
        Configure::write('debug', 0);
        $this->layout = 'pdf';

        //dettagli ordine
        $this->OrderedProduct->recursive = 0;
        $orderedProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.seller_id' => $seller_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'order' => array('OrderedProduct.user_id'),
			'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name')))
        )); 

        //trovo il totale per ogni prodotto
        $totals = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.seller_id' => $seller_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'fields' => array('hamper_id', 'product_id', 'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
            'group' => array('hamper_id', 'product_id'),
            'order' => array('hamper_id desc'),
            'contain' => array('Product.name', 'Hamper.delivery_date_on')
        )); 
        
        $totalsByHamper = array();
        foreach($totals as $tot) {
            if(isset($totalsByHamper[$tot['Hamper']['delivery_date_on']])) {
                $totalsByHamper[$tot['Hamper']['delivery_date_on']] += $tot['0']['total'];
            } else {
                $totalsByHamper[$tot['Hamper']['delivery_date_on']] = $tot['0']['total'];
            }
        } 

        $seller = $this->OrderedProduct->Seller->findById($seller_id);

        $this->set(compact('orderedProducts', 'seller', 'totals', 'totalsByHamper'));
        
        $pageTitle = Inflector::slug(Configure::read('GAS.name').'_'.__('ordini pendenti', true).'_'.$seller['Seller']['name']).'.pdf';
        $this->set('pageTitle', $pageTitle);
    }

	function admin_print_pdf_hamper($hamper_id) {
		Configure::write('debug', 0);
        $this->layout = 'pdf';

		//dettagli paniere
		$hamper = $this->OrderedProduct->Hamper->find('first', array(
			'conditions' => array('Hamper.id' => $hamper_id),
			'contain' => array(
				'Seller.name'
			)
		));

		//dettagli prodotti ordinati per stampa pdf
		$_orderedProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
			'order' => array('Product.product_category_id asc', 'User.last_name asc', 'User.first_name asc', 'Product.name'),
			'contain' => array(
                'User' => array('fields' => array('id', 'fullname', 'phone', 'mobile')),
                'Product' => array('fields' => array('id', 'name', 'code', 'units',   'option_1', 'option_2', 'product_category_id')),
				'Product.ProductCategory' => array('fields' => array('id', 'name')))
        ));

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
        $categoriesProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
            'fields' => array('hamper_id', 'product_id', 'option_1', 'option_2',
				'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
            'group' => array('Product.product_category_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2', 'OrderedProduct.note'),
            'order' => array('product_category_id'),
            'contain' => array(
				'Product.id', 'Product.name', 'Product.units', 'Product.option_1', 'Product.option_2' ,
				'Hamper.delivery_date_on',
				'Product.ProductCategory.id', 'Product.ProductCategory.name', 'Product.code')
        ));

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
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

		$this->set(compact('categories', 'orderedProducts', 'hamper', 'users', 'sellers',  'total'));

		if(!date_is_empty($hamper['Hamper']['delivery_date_on'])) {
			$pageTitle = Inflector::slug(Configure::read('GAS.name').'_'.$hamper['Seller']['name'].'_'.date('d-m-Y', strtotime($hamper['Hamper']['delivery_date_on']))).'.pdf';
		} else {
			$pageTitle = Inflector::slug(Configure::read('GAS.name').'_'.$hamper['Seller']['name']).'.pdf';
		}
		$this->set('pageTitle', $pageTitle);
	}
	
	function admin_print_excel_hamper($hamper_id)
	{
//         Configure::write('debug', 2);
        $this->layout = 'excel';
        $hamper = $this->OrderedProduct->Hamper->find('first', array(
            'conditions' => array('Hamper.id' => $hamper_id),
            'contain' => array(
                'Seller.name'
            )
        ));
        
        $users = $this->OrderedProduct->find
        (
            'all', array
            (
                'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
                'fields' => array('user_id', 'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
                'group' => array('user_id'),
                'order' => array('User.id'),
                'contain' => array
                (
                    'User' => array('fields' => array('id', 'first_name', 'last_name'))
                )
            )
        );
        
        $totals = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.hamper_id' => $hamper_id),
            'fields' => array('hamper_id', 'product_id', 'option_1', 'option_2', 'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
            'group' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2'),
            'order' => array('hamper_id desc', 'Product.name'),
            'contain' => array('Product.name','Product.option_1', 'Product.option_2', 'Product.units', 'Product.value' ,'Hamper.delivery_date_on')
        ));
        
        foreach($totals as $key => $product)
        {
            foreach($users as $user)
            {
                $partial = $this->OrderedProduct->find('all', array(
                'conditions' => array
                (
                    'OrderedProduct.hamper_id' => $hamper_id, 
                    'user_id' => $user['User']['id'],
                    'OrderedProduct.product_id' => $product['Product']['id'], 
                    'OrderedProduct.option_1' => $product['OrderedProduct']['option_1'],
                    'OrderedProduct.option_2' => $product['OrderedProduct']['option_2']
                ),
                'fields' => array('SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
                'group' => array('hamper_id', 'product_id', 'OrderedProduct.option_1', 'OrderedProduct.option_2'),
                'order' => array('hamper_id desc', 'Product.name'),
                'contain' => array('Product.name','Product.option_1' ,'Product.option_2' ,'Hamper.delivery_date_on')
                ));
                if(!isset($partial[0]))
                    $partial[0] = '';
                $totals[$key]['Users'][$user['User']['id']] = $partial[0];
                    
            }
        }
        $this->set(compact('hamper', 'totals', 'users'));

		if(!date_is_empty($hamper['Hamper']['delivery_date_on'])) {
			$pageTitle = Inflector::slug(Configure::read('GAS.name').'_'.$hamper['Seller']['name'].'_'.date('d-m-Y', strtotime($hamper['Hamper']['delivery_date_on'])));
		} else {
			$pageTitle = Inflector::slug(Configure::read('GAS.name').'_'.$hamper['Seller']['name']);
		}
		$this->set('title_for_layout', $pageTitle);
    }

}

