<?php
class ProductsController extends AppController {

	var $name = 'Products';

	function index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product'));
			}
		}
		$productCategories = $this->Product->ProductCategory->find('list');
		$users = $this->Product->User->find('list');
		$hampers = $this->Product->Hamper->find('list');
		$this->set(compact('productCategories', 'users', 'hampers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
		}
		$productCategories = $this->Product->ProductCategory->find('list');
		$users = $this->Product->User->find('list');
		$hampers = $this->Product->Hamper->find('list');
		$this->set(compact('productCategories', 'users', 'hampers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'product'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Product'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Product'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product'));
			}
		}
		$productCategories = $this->Product->ProductCategory->find('list');
		$sellers = $this->Product->Seller->find('list');
		$hampers = $this->Product->Hamper->find('list');
		$this->set(compact('productCategories', 'sellers', 'hampers'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
		}
		$productCategories = $this->Product->ProductCategory->find('list');
		$sellers = $this->Product->Seller->find('list');
		$hampers = $this->Product->Hamper->find('list');
		$this->set(compact('productCategories', 'sellers', 'hampers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'product'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Product'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Product'));
		$this->redirect(array('action' => 'index'));
	}
}
?>