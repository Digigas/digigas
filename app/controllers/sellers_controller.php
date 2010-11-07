<?php
class SellersController extends AppController {

	var $name = 'Sellers';

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'products');

        $this->Auth->deny($this->methods);
    }

	function index() {
		$this->paginate = array('conditions' => array('Seller.active' => 1), 'order' => 'Seller.name asc');
		$this->set('sellers', $this->paginate());
        $this->set('title_for_layout', __('Elenco produttori', true).' - '.Configure::read('GAS.name'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'seller'));
			$this->redirect(array('action' => 'index'));
		}

        $seller = $this->Seller->find('first', array(
            'conditions' => array('Seller.id' => $id),
            'contain' => array('Product')));

		$this->set('seller', $seller);
        $this->set('title_for_layout', $seller['Seller']['name'].' - '.Configure::read('GAS.name'));
	}
    
	function admin_index() {
		$this->Seller->recursive = 0;
		$this->set('sellers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'seller'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('seller', $this->Seller->read(null, $id));
	}

	function admin_add() {

		//nego l'accesso agli utenti non amministratori
		if($this->Auth->user('role') > 1) {
			$this->Session->setFlash(__('Non puoi accedere a questa funzione', true));
			$this->redirect($this->referer());
		}

		if (!empty($this->data)) {
			$this->Seller->create();
			if ($this->Seller->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'seller'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'seller'));
			}
		}

        $users = $this->Seller->User->find('list', array('conditions' => array('role' => 2)));
        $this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'seller'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {

            if ($this->Seller->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'seller'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'seller'));
			}
		}
		if (empty($this->data)) {
            $this->data = $this->Seller->find('first', array(
                'conditions' => array('Seller.id' => $id), 
                'contain' => array('User')));
		}

        $users = $this->Seller->User->find('list', array('conditions' => array('role' => 2)));
        $this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'seller'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Seller->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Seller'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Seller'));
		$this->redirect(array('action' => 'index'));
	}
}
?>