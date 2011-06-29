<?php
class ToolsController extends AppController {
    var $name = 'Tools';
    var $uses = array();

    function beforeFilter()
	{
        $this->set('activemenu_for_layout', 'tools');
		$this->set('title_for_layout', __('Strumenti', true));

        parent::beforeFilter();
    }

    function admin_index() {
        
    }
}