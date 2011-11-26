<?php
class CommentableBehavior extends ModelBehavior {

	var $defaults = array(
		//attiva i commenti senz amoderazione dell'amministratore
		'setActive' => 1
	);
	var $settings = array();

        function getForumName(&$Model) {
            $r = $Model->name;
            if(isset($this->settings[$Model->name]['forumName']))
                    $r = $this->settings[$Model->name]['forumName'];
            return $r;

        }

        function commentsReaded(&$Model, $id)
        {
            $user_id = User::get('id');
            if($Model->name == 'Forum')
            {
                $Model->Comment->updateAll(
                    array('unreaded_comments' => 0),
                    array(
                        'Comment.user_id =' => User::get('id'),
                        'Comment.model' => $Model->name,
                        'Comment.parent_id' => $id
                    ));
            }
            else {
            $Model->Comment->updateAll(
                array('unreaded_comments' => 0),
                array(
                    'Comment.user_id =' => User::get('id'),
                    'Comment.model' => $Model->name,
                    'Comment.item_id' => $id
                ));
            }
        }
        
	function setup(&$Model, $settings = array()) {
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = $this->defaults;
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array) $settings);

		$this->init($Model);
	}

	function init(&$Model) {
		$Model->bindModel(array(
                    'hasMany' => array(
				'Comment' => array(
					'className' => 'Comment',
					'foreignKey' => 'item_id',
					'conditions' => array(
						'Comment.model' => $Model->name,
						'Comment.active' => '1'),
					'order' => 'Comment.created ASC',
					'limit' => '25',
					'dependent' => true
				)),
                    'belongsTo' => array(
				'LastComment' => array(
					'className' => 'Comment',
					'foreignKey' => 'last_comment_id',
					'conditions' => array(
						'LastComment.model' => $Model->name,
						'LastComment.active' => '1'),
					'dependent' => true
				),
                                'LastUser' => array(
					'className' => 'User',
					'foreignKey' => 'last_comment_user_id',
					'dependent' => true
                                        
				),
                                'User'  
			)
                     ), false);
                

	}

	function saveComment(&$Model, $data) {
            	$data['Comment']['user_id'] = User::get('id');
		if($this->settings[$Model->alias]['setActive'] == 1) {
			$data['Comment']['active'] = 1;
		} else {
			$data['Comment']['active'] = 0;
		}

		$ret =  $Model->Comment->save($data);
                
                #ToDo verificare se viene invocato solo all'inserimento di un nuovo commento o per caso anche all'update
                if($Model->name == 'Forum')
                {
                    $Model->Comment->save(
                            array('Comment' => array (
                                'id' => $data['Comment']['parent_id'],
                                'last_comment_user_id' => $data['Comment']['user_id'],
                                'comments_count' => $Model->Comment->find('count', array(
                                    'conditions' => array(
                                        'Comment.parent_id' => $data['Comment']['parent_id'],
                                        'model' => 'Forum'
                                        ))),
                                'last_comment_id' => $Model->Comment->getLastInsertId()))
                            );
                    $Model->Comment->updateAll(
                        array('unreaded_comments' => 'unreaded_comments + 1'),
                        array(
                            'Comment.user_id !=' => User::get('id'),
                            'Comment.model' => $Model->name,
                            'Comment.parent_id' => $data['Comment']['parent_id']
                        ));

                    $userToEmail = $Model->Comment->find('all', array(
                        'fields' => 'DISTINCT user_id',
                        'conditions' => array(
                            'model' => $Model->name,
                            'Comment.parent_id' => $data['Comment']['parent_id'],
                            'unreaded_comments =' => 1
                        )
                    ));

                }
                else
                {
                    # Aggiorno il Modello con i dati sull'ultimo commento
                    $Model->save(
                            array($Model->name => array (
                                'id' => $data['Comment']['item_id'],
                                'last_comment_user_id' => $data['Comment']['user_id'],
                                'comments_count' => $Model->Comment->find('count', array(
                                    'conditions' => array(
                                        'item_id' => $data['Comment']['item_id'],
                                        'model' => $Model->name
                                        ))),
                                'last_comment_id' => $Model->Comment->getLastInsertId()))
                            );

                    # Aggiorno i commenti con i commenti non letti

                    $Model->Comment->updateAll(
                        array('unreaded_comments' => 'unreaded_comments + 1'),
                        array(
                            'user_id !=' => User::get('id'),
                            'model' => $Model->name,
                            'item_id' => $data['Comment']['item_id']
                        ));

                    # Cerco gli Id Utenti a cui mandare email

                    $userToEmail = $Model->Comment->find('all', array(
                        'fields' => 'DISTINCT user_id',
                        'conditions' => array(
                            'model' => $Model->name,
                            'item_id' => $data['Comment']['item_id'],
                            'unreaded_comments >' => 1
                        )
                    ));
                }
                return $ret;
	}

	function beforeSave(&$Model) {
            if(!isset($Model->data[$Model->name]['id']))
                    $Model->data[$Model->name]['user_id'] = User::get('id');
//            debug($Model); 

        }

}