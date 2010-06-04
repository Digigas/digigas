<?php
class AppController extends Controller {

    var $components = array(
    	'Auth',
        'Session',
    	'Cookie',
        'Email'
    );
    var $helpers = array(
        'Session',
        'Html',
        'Form',
        'Javascript',
        'Layout',
        'Image',
        'Menu'
    );
    var $allowedActions = array();

    function beforeFilter() {

        $this->Auth->authorize = 'controller';
        $this->Auth->userScope = array('User.active' => 1);
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false);
        
        if(isset($this->params['admin']) && $this->params['admin']) {
            $this->layout = 'digigas';
        } else {
            $this->Auth->allow('*');
        }
        //$this->Auth->allow('*'); //temporaneo, da disabilitare
        
    }

    function beforeRender() {
        $this->set('referer', $this->referer());
    }

    function isAuthorized() {
        //solo gli utenti root, admin e seller possono accedere all'area admin
        if(isset($this->params['admin']) && $this->Auth->user('role') > 2) {
            return false;
        }
        return true;
    }

    function _emailSetUp() {
        $this->Email->delivery = 'mail';
    }
}