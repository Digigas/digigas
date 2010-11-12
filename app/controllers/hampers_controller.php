<?php
class HampersController extends AppController {

    var $name = 'Hampers';

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

        if(empty($hampers)) {
            $this->set('title_for_layout', __('Nessun paniere disponibile in questo momento', true).' - '.Configure::read('GAS.name'));
            $this->render('index_closed');
        }
    }

    function view($id = null) {
        if (!$id || !$this->Hamper->isActive($id)) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
            $this->redirect(array('action' => 'index'));
        }
        $hamper = $this->Hamper->read(null, $id);
        $this->set('hamper', $hamper);
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
    }

    function admin_copy($id) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
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
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'hamper'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'hamper'));
            }
        }

        $seller = $this->Hamper->Seller->field('name', $seller_id);
        $sellers = $this->Hamper->Seller->find('list', array('conditions' => array('active' => 1)));

        //seleziono i prodotti di questo produttore
        $productCategories = $this->Hamper->Product->getAllFromSellerByCategory($seller_id);

        $this->set(compact('seller', 'seller_id', 'sellers', 'productCategories'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->data = $this->Hamper->formatDates($this->data);
            if ($this->Hamper->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'hamper'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'hamper'));
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
            $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'hamper'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Hamper->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s deleted', true), 'Hamper'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Hamper'));
        $this->redirect(array('action' => 'index'));
    }
}
?>