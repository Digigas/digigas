<?php
class NewsletterMessage extends AppModel {
	var $name = 'NewsletterMessage';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Usergroup' => array(
			'className' => 'Usergroup',
			'foreignKey' => 'usergroup_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    function saveSentData($id) {
        $this->id = $id;
        return $this->saveField('sent_date', date('Y-m-d H:i:s', strtotime('now')));
    }
}
?>