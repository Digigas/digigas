<?php
class RssSourcesController extends AppController {

	var $name = 'RssSources';

	function admin_index() {
		$this->RssSource->recursive = 0;
		$this->paginate = array('order' => array('weight ASC', 'id DESC'));
		$this->set('rssSources', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->RssSource->create();
			if ($this->RssSource->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'rss source'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'rss source'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'rss source'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->RssSource->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'rss source'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'rss source'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RssSource->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'rss source'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RssSource->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Rss source'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Rss source'));
		$this->redirect(array('action' => 'index'));
	}
}
?>