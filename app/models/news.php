<?php
class News extends AppModel {

	var $name = 'News';
    
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Newscategory' => array('className' => 'Newscategory',
								'foreignKey' => 'newscategory_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
            'User'
	);
	var $actsAs = array(
        'Sluggable'=>array('label'=>array('title'), 'overwrite' => true),
        'Containable',
		'Commentable' => array ('forumName' => 'News', 'displayField' => 'title')
        );

	function beforeSave() {
		$this->data['News']['user_id'] =  User::get('id');
		return parent::beforeSave();
	}

	function toggle_active($id)
	{
		$value = $this->field('active', array('id'=>$id));
		switch($value)
		{
			case 1:
				$value = 0;
				break;
			case 0:
				$value = 1;
				break;
		}
		$this->create(array('id'=>$id));
		$this->saveField('active', $value);
	}

}
?>