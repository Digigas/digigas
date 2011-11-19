<?php

class ForumsController extends AppController {

	var $name = 'Forums';
	var $components = array('UserComment');
	var $helpers = array('Html', 'Form');
	var $uses = array('Forum', 'Comment');

	function beforeFilter() {
		parent::beforeFilter();
		$this->set('activemenu_for_layout', 'tools');
		$this->set('title_for_layout', __('Forum', true));
		
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
		$forums = $this->paginate();

		$forumsId = Set::extract('/Forum/id', $forums);
		$conversationCount = $this->Comment->find('all', array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.item_id' => $forumsId, 'Comment.parent_id' => 0, 'Comment.active' => 1),
			'fields' => array('item_id', 'count(id) as children'),
			'group' => 'item_id',
			'recursive' => -1
		));
		$conversationCount = Set::combine($conversationCount, '{n}.Comment.item_id', '{n}.0.children');

		$messagesCount = $this->Comment->find('all', array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.item_id' => $forumsId, 'Comment.active' => 1),
			'fields' => array('item_id', 'count(id) as children'),
			'group' => 'item_id',
			'recursive' => -1
		));
		$messagesCount = Set::combine($messagesCount, '{n}.Comment.item_id', '{n}.0.children');

		$lastUpdates = $this->Comment->find('all', array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.item_id' => $forumsId, 'Comment.active' => 1),
			'fields' => array('item_id', 'MAX(created) as created'),
			'group' => 'item_id',
			'recursive' => -1
		));
		$lastUpdates = Set::combine($lastUpdates, '{n}.Comment.item_id', '{n}.0.created');

		$lastMessages = $this->Comment->find('all', array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.item_id' => $forumsId, 'Comment.active' => 1),
			'order' => array('Comment.created DESC'),
			'limit' => 10,
			'contain' => array('User.fullname')
		));

		$this->set(compact('forums', 'conversationCount', 'messagesCount', 'lastUpdates', 'lastMessages'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('%s non valido', true), 'Forum'));
			$this->redirect(array('action' => 'index'));
		}
		$forum = $this->Forum->find('first', array(
				'conditions' => array('Forum.id' => $id, 'Forum.active' => 1, 'Forum.access_level >= ' => $this->Auth->user('role')),
				'contain' => array('User.fullname')
			));

		if (empty($forum)) {
			$this->Session->setFlash(__('Non puoi accedere a questo forum', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->paginate = array('Comment' => array(
				'conditions' => array(
					'Comment.model' => 'Forum',
					'Comment.item_id' => $id,
					'Comment.active' => 1,
					'Comment.parent_id' => 0),
				'order' => array('Comment.created DESC'),
				'contain' => array('User.id', 'User.fullname'),
				'limit' => 25
			));
		$comments = $this->paginate($this->Forum->Comment);

		$commentIds = Set::extract('/Comment/id', $comments);
		$commentsChildren = $this->Comment->find('all', array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.parent_id' => $commentIds, 'Comment.active' => 1),
			'fields' => array('Comment.parent_id', 'count(id) as children'),
			'group' => 'parent_id',
			'recursive' => -1
		));
		$commentsChildren = Set::combine($commentsChildren, '{n}.Comment.parent_id', '{n}.0.children');

		$lastUpdates = $this->Comment->find('all', array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.parent_id' => $commentIds, 'Comment.active' => 1),
			'fields' => array('Comment.parent_id', 'MAX(created) as created'),
			'group' => 'parent_id',
			'recursive' => -1
		));
		$lastUpdates = Set::combine($lastUpdates, '{n}.Comment.parent_id', '{n}.0.created');

		$lastMessages = $this->Comment->find('all', array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.item_id' => $id, 'Comment.active' => 1),
			'order' => array('Comment.created DESC'),
			'limit' => 10,
			'contain' => array('User.fullname')
		));

		$this->set(compact('forum', 'comments', 'commentsChildren', 'lastUpdates', 'lastMessages'));
		$this->set('title_for_layout', 'Forum - ' . $forum['Forum']['name']);
	}

	function view_topic($id) {

            $topic = $this->Comment->find('first', array(
                            'conditions' => array('Comment.id' => $id, 'Comment.active' => 1),
                            'contain' => array('User')
                    ));
            
            if (!empty($topic)) {
                $forum = $this->Forum->find('first', array(
                        'conditions' => array('Forum.id' => $topic['Comment']['item_id'], 'Forum.active' => 1, 'Forum.access_level >= ' => $this->Auth->user('role')),
                        'fields' => array('Forum.id', 'Forum.name'),
                        'contain' => array()
                ));

                //forum non attivo o utente non autenticato
                if (empty($forum)) {
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
			$this->Session->setFlash(sprintf(__('%s non valido', true), 'Forum'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('forum', $this->Forum->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Forum->create();
			if ($this->Forum->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Il %s è stato salvato', true), 'forum'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'forum'));
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
				$this->Session->setFlash(sprintf(__('Il %s è stato salvato', true), 'forum'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'forum'));
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
			$this->Session->setFlash(sprintf(__('Id non valido per il %s', true), 'forum'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Forum->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s eliminato', true), 'Forum'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(sprintf(__('Il %s non è stato eliminato', true), 'forum'));
		$this->redirect(array('action' => 'index'));
	}

}

?>