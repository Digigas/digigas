<?php
class CommentableBehavior extends ModelBehavior {

	var $defaults = array(
		//attiva i commenti senz amoderazione dell'amministratore
		'setActive' => 1
	);
	var $settings = array();

	function setup(&$Model, $settings = array()) {
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = $this->defaults;
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array) $settings);

		$this->init($Model);
	}

	function init(&$Model) {
		$Model->bindModel(array('hasMany' => array(
				'Comment' => array(
					'className' => 'Comment',
					'foreignKey' => 'item_id',
					'conditions' => array(
						'Comment.model' => $Model->name,
						'Comment.active' => '1'),
					'order' => 'Comment.created ASC',
					'limit' => '25',
					'dependent' => true
				)
			)));
	}

	function saveComment(&$Model, $data) {
		$data['Comment']['user_id'] = User::get('id');
		if($this->settings[$Model->alias]['setActive'] == 1) {
			$data['Comment']['active'] = 1;
		} else {
			$data['Comment']['active'] = 0;
		}
		return $Model->Comment->save($data);
	}

	function beforeSave(&$Model) {}

}