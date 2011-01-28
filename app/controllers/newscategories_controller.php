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
    
	function index() {
		$this->Newscategory->recursive = 0;
                $this->paginate = array('order' => 'lft asc');
		$this->set('newscategories', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Newscategory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('newscategory', $this->Newscategory->read(null, $id));
	}

	function admin_index() {
		$this->Newscategory->recursive = 0;
                $this->paginate = array('order' => 'lft asc');
		$this->set('newscategories', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Newscategory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('newscategory', $this->Newscategory->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Newscategory->create();
			if ($this->Newscategory->save($this->data)) {
				$this->Session->setFlash(__('The Newscategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Newscategory could not be saved. Please, try again.', true));
			}
		}
        $categories = $this->Newscategory->generatetreelist(array(), '{n}.Newscategory.id', '{n}.Newscategory.name', ' - ');
        $this->set(compact('categories'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Newscategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Newscategory->save($this->data)) {
				$this->Session->setFlash(__('The Newscategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Newscategory could not be saved. Please, try again.', true));
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
			$this->Session->setFlash(__('Invalid id for Newscategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Newscategory->delete($id)) {
			$this->Session->setFlash(__('Newscategory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>