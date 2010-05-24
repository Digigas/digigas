<?php
class HampersController extends AppController {

	var $name = 'Hampers';
    
    function beforeFilter()
    {
        $this->set('activemenu_for_layout', 'hampers');
        return parent::beforeFilter();
    }

	function index() {
		$this->Hamper->recursive = 0;
		$this->set('hampers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('hamper', $this->Hamper->read(null, $id));
	}

	function admin_index() {
		$this->Hamper->recursive = 0;

        if(isset($this->params['named']['seller'])) {
            $this->paginate = array_merge_recursive($this->paginate, array('conditions' => array('Hamper.seller_id' => $this->params['named']['seller'])));
        }

        if(isset($this->params['named']['actives'])) {
            $this->paginate = array_merge_recursive($this->paginate, array('conditions' => array(
                'start_date <' => date('Y-m-d H:m:s'),
                'end_date >' => date('Y-m-d H:m:s')
                )));
        }

        if(isset($this->params['named']['templates'])) {
            $this->paginate = array_merge_recursive($this->paginate, array('conditions' => array('Hamper.is_template' => $this->params['named']['templates'])));
        }

        //query per trovare i sellers (utile per filtrare i panieri)
        $sellers = $this->Hamper->User->getSellers();

		$this->set('hampers', $this->paginate());
        $this->set(compact('sellers'));
	}

	function admin_add() {
		if (!empty($this->data)) {
            $this->data = $this->Hamper->formatDates($this->data);
            $this->Hamper->create();
			if ($this->Hamper->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'hamper'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'hamper'));
			}
		}

		$sellers = $this->Hamper->User->find('list', array('conditions' => array('role' => 2)));
        $productCategories = $this->Hamper->Product->ProductCategory->find('all', array(
            'order' => 'ProductCategory.lft asc',
            'fields' => array(
                'id', 'name', 'parent_id', 'lft', 'rght'
            ),
            'contain' => array(
                'Product.id', 'Product.name', 'Product.image'
            )
        ));
		$this->set(compact('sellers', 'productCategories'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'hamper'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->data = $this->Hamper->formatDates($this->data);
			if ($this->Hamper->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'hamper'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'hamper'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Hamper->read(null, $id);
		}
		$sellers = $this->Hamper->User->find('list', array('conditions' => array('role' => 2)));
		$productCategories = $this->Hamper->Product->ProductCategory->find('all', array(
            'order' => 'ProductCategory.lft asc',
            'fields' => array(
                'id', 'name', 'parent_id', 'lft', 'rght'
            ),
            'contain' => array(
                'Product.id', 'Product.name', 'Product.image'
            )
        ));
        $relatedProducts = Set::extract('/Product/id', $this->data);
		$this->set(compact('sellers', 'productCategories', 'relatedProducts'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'hamper'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Hamper->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Hamper'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Hamper'));
		$this->redirect(array('action' => 'index'));
	}
}
?>