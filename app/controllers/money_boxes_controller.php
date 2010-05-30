<?php
class MoneyBoxesController extends AppController {

    var $name = 'MoneyBoxes';

    function beforeFilter() {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'users');

        $this->Auth->deny($this->methods);
    }

    function index() {
        $this->MoneyBox->recursive = 0;
        $this->paginate = array(
            'conditions' => array('MoneyBox.user_id' => $this->Auth->user('id')),
            'order' => 'MoneyBox.created desc');
        $this->set('moneyBoxes', $this->paginate());

        $total = $this->MoneyBox->getTotal($this->Auth->user('id'));
        $this->set('total', $total);
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'money box'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('moneyBox', $this->MoneyBox->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->MoneyBox->create();
            if ($this->MoneyBox->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'money box'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'money box'));
            }
        }
        $users = $this->MoneyBox->User->find('list');
        $orderedProducts = $this->MoneyBox->OrderedProduct->find('list');
        $this->set(compact('users', 'orderedProducts'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'money box'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->MoneyBox->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'money box'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'money box'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->MoneyBox->read(null, $id);
        }
        $users = $this->MoneyBox->User->find('list');
        $orderedProducts = $this->MoneyBox->OrderedProduct->find('list');
        $this->set(compact('users', 'orderedProducts'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'money box'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->MoneyBox->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s deleted', true), 'Money box'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Money box'));
        $this->redirect(array('action' => 'index'));
    }
    function admin_index() {
        $this->MoneyBox->recursive = 0;
        $this->set('moneyBoxes', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'money box'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('moneyBox', $this->MoneyBox->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->MoneyBox->create();
            if ($this->MoneyBox->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'money box'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'money box'));
            }
        }
        $users = $this->MoneyBox->User->find('list');
        $orderedProducts = $this->MoneyBox->OrderedProduct->find('list');
        $this->set(compact('users', 'orderedProducts'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'money box'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->MoneyBox->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'money box'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'money box'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->MoneyBox->read(null, $id);
        }
        $users = $this->MoneyBox->User->find('list');
        $orderedProducts = $this->MoneyBox->OrderedProduct->find('list');
        $this->set(compact('users', 'orderedProducts'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'money box'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->MoneyBox->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s deleted', true), 'Money box'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Money box'));
        $this->redirect(array('action' => 'index'));
    }
}
?>