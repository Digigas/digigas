<?php
class OrderedProductsController extends AppController {

	var $name = 'OrderedProducts';

	function index() {
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

	function edit($id = null) {
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

	function delete($id = null) {
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