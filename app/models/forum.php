<?php
class Forum extends AppModel {
	var $name = 'Forum';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'item_id',
			'dependent' => true,
			'conditions' => array(
						'Comment.model' => 'Forum',
						'Comment.active' => '1'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	var $actsAs = array('Containable', 'Commentable');

	function getLastMessages($access_level, $number = false) {
		if(!$number) {
			$number = 10;
		}

		$forums = $this->find('all', array(
			'conditions' => array(
				'Forum.active' => 1,
				'Forum.access_level >= ' => $access_level
			),
			'fields' => 'id',
			'order' => array('Forum.weight DESC', 'Forum.created DESC'),
			'recursive' => -1
		));
		$forumsId = Set::extract('/Forum/id', $forums);

		$lastMessages = $this->Comment->find('all', array(
			'conditions' => array('Comment.model' => 'Forum', 'Comment.item_id' => $forumsId, 'Comment.active' => 1),
			'order' => array('Comment.created DESC'),
			'limit' => $number,
			'contain' => array('User.fullname')
		));

		return $lastMessages;
	}

}
?>