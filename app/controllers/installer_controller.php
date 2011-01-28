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

	function index($step = '1') {
		if($step == '1') {
			if (!empty($this->data)) {
				if ($this->Installer->step1($this->data['Installer'])) {
					$this->Session->write('data', $this->data);
					$this->redirect(array('controller' => 'installer', 'action' => 'index', '2'));
				} else {
					$this->Session->setFlash('Si è verificato un errore, riprova oppure contattaci :-(');
				}
			}
		} else if($step == '2') {
			if (!$this->Session->read('data')) {
				$this->redirect('/');
			}
			$this->data = $this->Session->read('data');
			if ($this->Installer->step2($this->data['Installer'])) {
				$this->Session->setFlash('Congratulazioni! L\'installazione è riuscita correttamente,
							ora puoi accedere come amminstratore tramite il link in alto a destra.');
				$this->redirect('/');
			} else {
				$this->Session->setFlash('Si è verificato un errore, riprova oppure contattaci :-(');
			}
		}
	}

	function _digigas_is_installed() {
		if (file_exists(APP . 'config' . DS . 'installed.txt')) {
			return true;
		}
		return false;
	}

}