<?php
class UsergroupsController extends AppController {

	var $name = 'Usergroups';

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'users');

        $this->Auth->deny($this->methods);
    }

	function admin_index() {
		$this->Usergroup->recursive = 0;
        $this->paginate = array('order' => array('lft asc'));
		$this->set('usergroups', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'usergroup'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('usergroup', $this->Usergroup->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Usergroup->create();
			if ($this->Usergroup->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'usergroup'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'usergroup'));
			}
		}

        $parents = $this->Usergroup->generatetreelist(array(), '{n}.Usergroup.id', '{n}.Usergroup.name', ' - ');
        $this->set(compact('parents'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'usergroup'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Usergroup->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'usergroup'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'usergroup'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Usergroup->read(null, $id);
		}
        
        $parents = $this->Usergroup->generatetreelist(array(
            'not' => array('and' =>array(
                'Usergroup.lft >=' => $this->data['Usergroup']['lft'],
                'Usergroup.rght <=' => $this->data['Usergroup']['rght']
            ))), '{n}.Usergroup.id', '{n}.Usergroup.name', ' - ');
        $this->set(compact('parents'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'usergroup'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Usergroup->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Usergroup'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Usergroup'));
		$this->redirect(array('action' => 'index'));
	}
}
?>