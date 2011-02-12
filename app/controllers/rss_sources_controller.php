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
				$this->Session->setFlash(sprintf(__('La %s è stata salvata', true), 'fonte rss'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare la %s. Prova di nuovo.', true), 'fonte rss'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('%s non valida', true), 'Fonte rss'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->RssSource->save($this->data)) {
				$this->Session->setFlash(sprintf(__('La %s è stata salvata', true), 'fonte rss'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare la %s. Prova di nuovo.', true), 'fonte rss'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RssSource->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Id non valido per la %s', true), 'fonte rss'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RssSource->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s eliminata', true), 'Fonte rss'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('La %s non è stata eliminata', true), 'Fonte rss'));
		$this->redirect(array('action' => 'index'));
	}
}
?>