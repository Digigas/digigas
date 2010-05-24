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