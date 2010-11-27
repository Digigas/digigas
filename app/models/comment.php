<?php
class Comment extends AppModel {
	var $name = 'Comment';

	var $belongsTo = array('User');

	var $actsAs = array('Containable');

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