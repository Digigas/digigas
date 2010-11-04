<?php

class InstallerController extends Controller {

	var $name = 'Installer';
	var $uses = array('Installer');
	var $layout = 'install';

	var $components = array(
        'Session',
    	'Cookie'
    );
    var $helpers = array(
        'Session',
        'Html',
        'Form',
        'Javascript',
        'Layout'
    );

	function beforeFilter() {
		if ($this->_digigas_is_installed()) {
			exit;
		}
	}

	function beforeRender() {}
	function afterFilter() {}

	function index() {
		if (!empty($this->data)) {
			if ($this->Installer->step1($this->data['Installer'])) {
				$this->Session->write('data', $this->data);
				$this->redirect(array('controller' => 'installer', 'action' => 'step2'));
			} else {
				$this->Session->setFlash('Si è verificato un errore, riprova oppure contattaci :-(');
			}
		}
	}

	function step2() {
		if (!$this->Session->read('data')) {
			$this->redirect('/');
		}
		$this->data = $this->Session->read('data');
		if ($this->Installer->step2($this->data['Installer'])) {
			$this->Session->setFlash('Congratulazioni! L\'installazione è riuscita correttamente,
						ora puoi accedere come amminstratore tramite il link in alto a destra.');
		} else {
			$this->Session->setFlash('Si è verificato un errore, riprova oppure contattaci :-(');
		}

		$this->redirect('/');
	}

	function _digigas_is_installed() {
		if (file_exists(APP . 'config' . DS . 'installed.txt')) {
			return true;
		}
		return false;
	}

}