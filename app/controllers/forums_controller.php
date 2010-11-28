<?php
class ForumsController extends AppController {

	var $name = 'Forums';
	var $components = array('UserComment');
	var $helpers = array('Html', 'Form', 'UserComment');
	var $uses = array('Forum', 'Comment');


	function beforeFilter()
    {
		parent::beforeFilter();
        $this->set('activemenu_for_layout', 'tools');
		$this->Auth->deny($this->methods);
    }

	function index() {
		$this->Forum->recursive = 0;
		$this->paginate = array(
			'conditions' => array(
				'Forum.active' => 1,
				'Forum.access_level >= ' => $this->Auth->user('role')
			),
			'order' => array('Forum.weight DESC', 'Forum.created DESC'));
		$this->set('forums', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'forum'));
			$this->redirect(array('action' => 'index'));
		}
		$forum = $this->Forum->find('first', array(
			'conditions' => array('Forum.id' => $id, 'Forum.active' => 1, 'Forum.access_level >= ' => $this->Auth->user('role')),
			'contain' => array('User.fullname')
		));

		if(empty($forum)) {
			$this->Session->setFlash(__('Non puoi accedere a questo forum', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->paginate = array('Comment' => array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.item_id' => $id, 'Comment.active' => 1),
			'order' => array('Comment.created DESC'),
			'contain' => array('User.fullname'),
			'limit' => 25
		));
		$comments = $this->paginate($this->Forum->Comment);

		$this->set(compact('forum', 'comments'));
		$this->set('title_for_layout', 'Forum - ' . $forum['Forum']['name']);
	}

	function view_topic($id) {
		$topic = $this->Comment->find('first', array(
			'conditions' => array('Comment.id' => $id, 'Comment.active' => 1),
			'contain' => array('User')
		));
		if(!empty($topic)) {
			$forum = $this->Forum->find('first', array(
				'conditions' => array('Forum.id' => $topic['Comment']['item_id'], 'Forum.active' => 1, 'Forum.access_level >= ' => $this->Auth->user('role')),
				'fields' => array('Forum.id', 'Forum.name'),
				'contain' => array()
			));

			//forum non attivo o utente non autenticato
			if(empty($forum)) {
				$this->Session->setFlash(__('Non puoi accedere a questa discussione', true));
				$this->redirect(array('action' => 'index'));
			}

			$this->paginate = array('Comment' => array(
				'conditions' => array('Comment.parent_id' => $id, 'Comment.active' => 1),
				'order' => array('Comment.created ASC'),
				'limit' => 25
			));
			$comments = $this->paginate($this->Comment);

			$this->set(compact('forum', 'topic', 'comments'));
		} else {
			//topic non attivo
			$this->Session->setFlash(__('Non puoi accedere a questa discussione', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	function admin_index() {
		$this->Forum->recursive = 0;
		$this->paginate = array('order' => array('Forum.weight DESC', 'Forum.created DESC'));
		$this->set('forums', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'forum'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('forum', $this->Forum->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Forum->create();
			if ($this->Forum->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'forum'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'forum'));
			}
		}
		$users = $this->Forum->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'forum'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Forum->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'forum'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'forum'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Forum->read(null, $id);
		}
		$users = $this->Forum->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'forum'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Forum->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Forum'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Forum'));
		$this->redirect(array('action' => 'index'));
	}
}
?>