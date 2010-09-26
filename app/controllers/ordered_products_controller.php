<?php
class OrderedProductsController extends AppController {

    var $name = 'OrderedProducts';

    function beforeFilter() {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'orders');

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
        $this->paginate = array('conditions' => array(
                'or' => array(
                    'paid' => 0,
                    'retired' => 0
                )),
            'order' => array('hamper_id desc', 'user_id asc'),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name')),
                'Hamper' => array('fields' => array('id', 'delivery_date_on')))
        );
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

        $this->set(compact('sellers', 'users'));
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

        $this->set(compact('orderedProducts', 'user', 'users', 'sellers', 'total'));
    }

    function admin_index_seller($seller_id) {

        //dettagli ordine
        $this->OrderedProduct->recursive = 0;
        $orderedProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.seller_id' => $seller_id, 'or' => array('paid' => 0, 'retired' => 0)),
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

        //trovo l'elenco degli utenti con ordini attivi
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

        $this->set(compact('orderedProducts', 'seller', 'users', 'sellers', 'totals', 'totalsByHamper'));
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
            'fields' => array('business_name', 'email'),
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
            'fields' => array('product_id', 'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
            'group' => 'product_id',
            'contain' => array('Product.name', 'Hamper.delivery_date_on')
        ));
        $totals = Set::combine($totals, '{n}.Product.name', '{n}');
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
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'ordered product'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->OrderedProduct->read(null, $id);
        }
        $users = $this->OrderedProduct->User->find('list');
        $sellers = $this->OrderedProduct->Seller->find('list');
        $products = $this->OrderedProduct->Product->find('list');
        $hampers = $this->OrderedProduct->Hamper->find('list');
        $this->set(compact('users', 'sellers', 'products', 'hampers'));
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
        $users = $this->OrderedProduct->User->find('list', array('User.active' => 1));
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
        foreach($this->data['Product'] as $product_id => $quantity) {
            if(!empty($quantity)) {
                $dataToValidate = array('OrderedProduct' => array(
                        'product_id' => $product_id,
                        'hamper_id' => $this->data['OrderedProduct']['hamper_id'],
                        'seller_id' => $this->data['OrderedProduct']['seller_id'],
                        'quantity' => $quantity
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
}
?>