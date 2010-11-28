<?php
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form', 'Text');

	function beforeFilter()
    {
		parent::beforeFilter();
        $this->set('activemenu_for_layout', 'tools');
		$this->Auth->deny($this->methods);
    }
	
	function admin_index() {
		$this->paginate = array('order' => 'Comment.created DESC');

		if(isset($this->params['named']['user'])) {
			if(!isset($this->paginate['conditions'])) {
				$this->paginate['conditions'] = array();
			}
			$this->paginate['conditions'] = array_merge($this->paginate['conditions'], array('user_id' => $this->params['named']['user']));
		}

		$this->set('comments', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'comment'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Comment->create();
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'comment'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'comment'));
			}
		}
		$users = $this->Comment->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'comment'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'comment'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'comment'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Comment->read(null, $id);
		}
		$users = $this->Comment->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'comment'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Comment->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Comment'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Comment'));
		$this->redirect(array('action' => 'index'));
	}

	function admin_toggle_active($id)
    {
        if (!$id)
        {
            $this->Session->setFlash(__('Invalid Comment.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Comment->toggle_active($id);
        $this->redirect(array('action'=>'index'));
    }
}
?>