<?php
class AppController extends Controller {

    var $components = array(
    	'Auth',
        'Session',
    	'Cookie');
    var $helpers = array(
        'Session',
        'Html',
        'Form',
        'Javascript',
        'Layout',
        'Image'
    );
    var $layout = 'digigas';
    var $allowedActions = array();

    function beforeFilter() {

        $this->Auth->authorize = 'controller';
        $this->Auth->userScope = array('User.active' => 1);
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false);
        
        if(isset($this->params['admin']) && $this->params['admin']) {
            $this->Auth->deny('*');
        } else {
            $this->Auth->allow($this->allowedActions());
        }
        //$this->Auth->allow('*'); //temporaneo, da disabilitare
        
    }

    function isAuthorized() {
        return true;
    }

    function allowedActions() {
        if(empty($this->Auth->allowedActions)) {
            return '*';
        } else {
            return $this->Auth->allowedActions;
        }
    }

}