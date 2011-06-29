<?php
class UsergroupsController extends AppController {

	var $name = 'Usergroups';

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'users');
		$this->set('title_for_layout', __('Gruppi di utenti', true));

        $this->Auth->deny($this->methods);
    }

	function admin_index() {
		$this->Usergroup->recursive = 0;
        $this->paginate = array('order' => array('lft asc'));
		$this->set('usergroups', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('%s', true), 'Gruppo utenti'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('usergroup', $this->Usergroup->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Usergroup->create();
			if ($this->Usergroup->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Il %s è stata salvato', true), 'gruppo utenti'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'gruppo utenti'));
			}
		}

        $parents = $this->Usergroup->generatetreelist(array(), '{n}.Usergroup.id', '{n}.Usergroup.name', ' - ');
        $this->set(compact('parents'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('%s non valido', true), 'Gruppo utenti'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Usergroup->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Il %s è stata salvato', true), 'gruppo utenti'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'gruppo utenti'));
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
			$this->Session->setFlash(sprintf(__('Id non valido per il %s', true), 'gruppo utenti'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Usergroup->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s eliminato', true), 'Gruppo utenti'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('Il %s non è stato eliminato', true), 'gruppo utenti'));
		$this->redirect(array('action' => 'index'));
	}
}
?>