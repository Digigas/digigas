<?php
class HampersController extends AppController {

	var $name = 'Hampers';

	function index() {
		$this->Hamper->recursive = 0;
		$this->set('hampers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('hamper', $this->Hamper->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Hamper->create();
			if ($this->Hamper->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'hamper'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'hamper'));
			}
		}
		$users = $this->Hamper->User->find('list');
		$products = $this->Hamper->Product->find('list');
		$this->set(compact('users', 'products'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
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
		$users = $this->Hamper->User->find('list');
		$products = $this->Hamper->Product->find('list');
		$this->set(compact('users', 'products'));
	}

	function delete($id = null) {
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
	function admin_index() {
		$this->Hamper->recursive = 0;
		$this->set('hampers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('hamper', $this->Hamper->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Hamper->create();
			if ($this->Hamper->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'hamper'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'hamper'));
			}
		}
		$users = $this->Hamper->User->find('list');
		$products = $this->Hamper->Product->find('list');
		$this->set(compact('users', 'products'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
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
		$users = $this->Hamper->User->find('list');
		$products = $this->Hamper->Product->find('list');
		$this->set(compact('users', 'products'));
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