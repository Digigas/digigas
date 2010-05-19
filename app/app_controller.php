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
        'Javascript'
    );
    var $layout = 'digigas';

    function beforeFilter() {
        $this->Auth->allow('*'); //temporaneo, da disabilitare
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false);
        
    }

}