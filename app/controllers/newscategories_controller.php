<?php
class NewscategoriesController extends AppController {

	var $name = 'Newscategories';
	var $helpers = array('Html', 'Form');

    function beforeFilter()
    {
        $this->set('activemenu_for_layout', 'website');
		$this->set('title_for_layout', __('Categorie per le news', true));

        return parent::beforeFilter();
    }

	function admin_index() {
		$this->Newscategory->recursive = 0;
                $this->paginate = array('order' => 'lft asc');
		$this->set('newscategories', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Newscategory->create();
			if ($this->Newscategory->save($this->data)) {
				$this->Session->setFlash(__('La categoria di news è stata salvata', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Non è stato possibile salvare la categoria news. Prova di nuovo.', true));
			}
		}
        $categories = $this->Newscategory->generatetreelist(array(), '{n}.Newscategory.id', '{n}.Newscategory.name', ' - ');
        $this->set(compact('categories'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Categoria news non valida', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Newscategory->save($this->data)) {
				$this->Session->setFlash(__('La categoria di news è stata salvata', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Non è stato possibile salvare la categoria news. Prova di nuovo.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Newscategory->read(null, $id);
		}
        $categories = $this->Newscategory->generatetreelist(array(
            'not' => array('and' =>array(
                    'Newscategory.lft >=' => $this->data['Newscategory']['lft'],
                    'Newscategory.rght <=' => $this->data['Newscategory']['rght']
            ))
        ), '{n}.Newscategory.id', '{n}.Newscategory.name', ' - ');
		$this->set(compact('categories'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Id non valido per la categoria news', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Newscategory->delete($id)) {
			$this->Session->setFlash(__('Categoria news eliminata', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>