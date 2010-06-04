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
    }
    
    function past_orders() {
        $user = $this->Auth->user();
        $this->paginate = array('conditions' => array(
            'user_id' => $user['User']['id']
        ));
        $this->OrderedProduct->recursive = 0;
        $this->set('orderedProducts', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'ordered product'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('orderedProduct', $this->OrderedProduct->read(null, $id));
    }

    function add() {

        $this->data = $this->OrderedProduct->buildOrder($this->data, $this->Auth->user());

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

    function admin_index() {
        $this->paginate = array('conditions' => array(
            'or' => array(
                'paid' => 0,
                'retired' => 0
            )),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name')))
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
        $this->paginate = array(
            'conditions' => array('user_id' => $user_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name')))
        );
        $this->OrderedProduct->recursive = 0;
        $orderedProducts = $this->paginate();

        $user = $this->OrderedProduct->User->findById($user_id);

        //trovo l'elenco degli utenti con ordini attivi
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

        $this->set(compact('orderedProducts', 'user', 'users', 'sellers'));
    }

    function admin_index_seller($seller_id) {
        $this->paginate = array(
            'conditions' => array('OrderedProduct.seller_id' => $seller_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name')))
        );
        $this->OrderedProduct->recursive = 0;
        $orderedProducts = $this->paginate();

        //trovo il totale per ogni prodotto
        $totals = $this->OrderedProduct->find('all', array(
            'conditions' => array('OrderedProduct.seller_id' => $seller_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'fields' => array('product_id', 'SUM(OrderedProduct.value) as total', 'SUM(OrderedProduct.quantity) as quantity'),
            'group' => 'product_id',
            'contain' => array('Product.name')
        ));
        $totals = Set::combine($totals, '{n}.Product.name', '{n}.0');

        $seller = $this->OrderedProduct->User->findById($seller_id);

        //trovo l'elenco degli utenti con ordini attivi
        $users = $this->OrderedProduct->getPendingUsers();

        //trovo l'elenco dei produttori con ordini attivi
        $sellers = $this->OrderedProduct->getPendingSellers();

        $this->set(compact('orderedProducts', 'seller', 'users', 'sellers', 'totals'));
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

        //dati dell'ordine
        $orderedProducts = $this->OrderedProduct->find('all', array(
            'conditions' => array('user_id' => $user_id, 'or' => array('paid' => 0, 'retired' => 0)),
            'contain' => array(
                'User' => array('fields' => array('id', 'fullname')),
                'Seller' => array('fields' => array('id', 'name')),
                'Product' => array('fields' => array('id', 'name')))
        ));
        $this->set(compact('user', 'orderedProducts'));

        //compongo il messaggio nella view che si trova nella cartella email
        /*
         * da rifare -> invia seguendo le istruzioni e spostando la view in un element :-(
         * rifatto ma… controllare, non sono sicuro che funzioni…
         */
        //invio l'email
        //$this->Email->delivery = 'debug';
        $this->Email->to = $user['User']['email'];
        $this->Email->subject = __('Riepilogo ordini', true);
        $this->Email->from = Configure::read('email.from');
        $this->Email->sendAs = 'html';
        $this->Email->template = 'admin_mail_orders_to_user';

        if($this->Email->send()) {
            //mail ok
            $this->Session->setFlash(__('Email inviata correttamente', true));
        } else {
            //mail error
            $this->Session->setFlash(__('ERRORE durante l\'invio della mail', true));
        }
        $this->redirect($this->referer());
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

    function admin_index_() {
        $this->OrderedProduct->recursive = 0;
        $this->set('orderedProducts', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'ordered product'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('orderedProduct', $this->OrderedProduct->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->OrderedProduct->create();
            if ($this->OrderedProduct->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'ordered product'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'ordered product'));
            }
        }
        $users = $this->OrderedProduct->User->find('list');
        $sellers = $this->OrderedProduct->Seller->find('list');
        $products = $this->OrderedProduct->Product->find('list');
        $hampers = $this->OrderedProduct->Hamper->find('list');
        $this->set(compact('users', 'sellers', 'products', 'hampers'));
    }

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
}
?>