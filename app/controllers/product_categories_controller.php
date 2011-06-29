<?php
class ProductCategoriesController extends AppController {

	var $name = 'ProductCategories';
    var $paginate = array('order' => 'lft asc');

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'products');
		$this->set('title_for_layout', __('Categorie di prodotti', true));
    }
	
	function admin_index() {
		$this->ProductCategory->recursive = 0;
		$this->set('productCategories', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ProductCategory->create();
			if ($this->ProductCategory->save($this->data)) {
				$this->Session->setFlash(sprintf(__('La %s è stata salvata', true), 'Categoria prodotto'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare la %s. Prova di nuovo.', true), 'categoria prodotto'));
			}
		}

        $parents = $this->ProductCategory->generatetreelist(array(), '{n}.ProductCategory.id', '{n}.ProductCategory.name', ' - ');

        $this->set('parents', $parents);
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('%s non valida', true), 'Categoria prodotto'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductCategory->save($this->data)) {
				$this->Session->setFlash(sprintf(__('La %s è stata salvata', true), 'categoria prodotto'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare la %s. Prova di nuovo.', true), 'categoria prodotto'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductCategory->read(null, $id);
		}

        $parents = $this->ProductCategory->generatetreelist(array(), '{n}.ProductCategory.id', '{n}.ProductCategory.name', ' - ');

        $this->set('parents', $parents);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Id non valido per la %s', true), 'categoria prodotto'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductCategory->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s eliminata', true), 'Categoria prodotto'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('La %s non è stata eliminata', true), 'categoria prodotto'));
		$this->redirect(array('action' => 'index'));
	}
}
?>