<?php
class ConfiguratorController extends AppController {
	var $name = 'Configurator';
	var $uses = array('Configurator');
	var $components = array('Files');

	function beforeFilter() {
		$this->logo_dir_path = WWW_ROOT . 'img'.DS.'logo'.DS;
		$this->logo_dir = '/img'.DS.'logo'.DS;

		$this->set('title_for_layout', __('Configurazione', true));

		return parent::beforeFilter();
	}

	function admin_index() {
		if(!empty($this->data)) {
			$this->data = $this->data['Configurator'];
			if($this->data['GAS']['image']['error'] == 0) {
				if($this->Files->saveAs($this->data['GAS']['image'], null, $this->logo_dir_path, false)) {
					$this->data['GAS']['image'] = $this->logo_dir . $this->data['GAS']['image']['name'];
				}				
			} else {
				unset($this->data['GAS']['image']);
			}
			$this->data = $this->_flatArray($this->data);
			if($this->Configurator->saveConfigs($this->data)) {
				$this->Session->setFlash(__('Configurazione salvata!', true));
				$this->redirect(array('controller' => 'configurator', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('Si è verificato un errore', true));
			}
		}
	}

	function admin_clear_cache() {
		if(Cache::clear()) {
			$this->Session->setFlash(__('Configurazione ripristinata', true));
		} else {
			$this->Session->setFlash(__('Errore, non riesco a svuotare la cache', true));
		}
		$this->redirect(array('controller' => 'configurator', 'action' => 'index'));
	}

	function admin_empty() {
		$this->Configurator->deleteAll(array('1' => '1'));
		Cache::clear();
		$this->Session->setFlash(__('La configurazione è stata completamente rimossa', true));
		$this->redirect(array('controller' => 'configurator', 'action' => 'index'));
	}

	function _flatArray($data, $prefix = false) {
		$return = array();
		foreach($data as $key => $value) {
			if(is_array($value)) {
				$_return = $this->_flatArray($value, $key);
				$return = array_merge($return, $_return);
			} else {
				if($prefix) {
					$key = $prefix . '.' . $key;
				}
				$return[$key] = $value;
			}
		}
		return $return;
	}
}