<?php
class SellersController extends AppController {

	var $name = 'Sellers';

    function beforeFilter()
    {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'products');
		$this->set('title_for_layout', __('Produttori', true));

        $this->Auth->deny($this->methods);
    }

	function index() {
		$this->paginate = array('conditions' => array('Seller.active' => 1), 'order' => 'Seller.name asc');
		$this->set('sellers', $this->paginate());
        $this->set('title_for_layout', __('Elenco produttori', true).' - '.Configure::read('GAS.name'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('%s non valido', true), 'Fornitore'));
			$this->redirect(array('action' => 'index'));
		}

        $seller = $this->Seller->find('first', array(
            'conditions' => array('Seller.id' => $id),
            'contain' => array('Product')));

		$this->set('seller', $seller);
        $this->set('title_for_layout', $seller['Seller']['name'].' - '.Configure::read('GAS.name'));
	}
    
	function admin_index() {
		$this->Seller->recursive = 0;
		$this->set('sellers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('$s non valido', true), 'fornitore'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('seller', $this->Seller->read(null, $id));
	}

	function admin_add() {

		//nego l'accesso agli utenti non amministratori
		if($this->Auth->user('role') > 1) {
			$this->Session->setFlash(__('Non puoi accedere a questa funzione', true));
			$this->redirect($this->referer());
		}

		if (!empty($this->data)) {
			$this->Seller->create();
			if ($this->Seller->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Il %s è stata salvato', true), 'venditore'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'venditore'));
			}
		}

        $users = $this->Seller->User->find('list', array('conditions' => array('role' => 2)));
        $this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('%s non valido', true), 'fornitore'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {

            if ($this->Seller->save($this->data)) {
				$this->Session->setFlash(sprintf(__('Il %s è stata salvato', true), 'fornitore'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('Non è stato possibile salvare il %s. Prova di nuovo.', true), 'fornitore'));
			}
		}
		if (empty($this->data)) {
            $this->data = $this->Seller->find('first', array(
                'conditions' => array('Seller.id' => $id), 
                'contain' => array('User')));
		}

        $users = $this->Seller->User->find('list', array('conditions' => array('role' => 2)));
        $this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Id non valido per il %s', true), 'fornitore'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Seller->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s eliminato', true), 'Fornitore'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('Il %s  non è stato eliminato', true), 'Fornitore'));
		$this->redirect(array('action' => 'index'));
	}
}
?>