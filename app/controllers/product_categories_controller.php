<?php
class ProductCategoriesController extends AppController {

	var $name = 'ProductCategories';

	function index() {
		$this->ProductCategory->recursive = 0;
		$this->set('productCategories', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product category'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('productCategory', $this->ProductCategory->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ProductCategory->create();
			if ($this->ProductCategory->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product category'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product category'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product category'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductCategory->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product category'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product category'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductCategory->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'product category'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductCategory->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Product category'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Product category'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->ProductCategory->recursive = 0;
		$this->set('productCategories', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product category'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('productCategory', $this->ProductCategory->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ProductCategory->create();
			if ($this->ProductCategory->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product category'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product category'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'product category'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductCategory->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'product category'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'product category'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductCategory->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'product category'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductCategory->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Product category'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Product category'));
		$this->redirect(array('action' => 'index'));
	}
}
?>