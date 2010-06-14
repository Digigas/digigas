<?php
class ToolsController extends AppController {
    var $name = 'Tools';
    var $uses = array();

    function beforeFilter()
	{
        $this->set('activemenu_for_layout', 'tools');
        parent::beforeFilter();
    }

    function admin_index() {
        
    }
}