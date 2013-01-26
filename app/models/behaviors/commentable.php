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

        
        
	function setup(&$Model, $settings = array()) {
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = $this->defaults;
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array) $settings);

		$this->init($Model);
	}

	function init(&$Model) {
                $modelName = $Model->name == 'Comment'? 'Forum' : $Model->name;
		$Model->bindModel(array(
                    'hasMany' => array(
				'Comment' => array(
					'className' => 'Comment',
					'foreignKey' => 'item_id',
					'conditions' => array(
						'Comment.model' => $modelName,
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
						'LastComment.model' => $modelName,
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
//                        die('prova');

            $last_comment_id = $Model->Comment->getLastInsertId();
            
            $thread_id = null;
            $tempModel = $Model;
            $field = 'Comment.item_id';
            if($Model->name == 'Forum')
            {
                if(isset($data['Comment']['parent_id']))
                {
                    $thread_id =  $data['Comment']['parent_id'];
                # Aggiorno il Modello con i dati sull'ultimo commento
                
                    $Model->Comment->save(
                        array('Comment' => array (
                            'id' => $data['Comment']['parent_id'],
                            'last_comment_user_id' => $data['Comment']['user_id'],
                            'comments_count' => $Model->Comment->find(
                                'count', array(
                                    'conditions' => array(
                                        'Comment.parent_id' => $thread_id,
                                        'Comment.model' => $Model->name
                                    ))),
                            'last_comment_id' => $last_comment_id
                            )
                        )
                    );
                }
            }
            else
            {
                $thread_id = $data['Comment']['item_id'];
                # Aggiorno il Modello con i dati sull'ultimo commento
                $Model->save(
                    array($Model->name => array (
                        'id' => $data['Comment']['item_id'],
                        'last_comment_user_id' => $data['Comment']['user_id'],
                        'comments_count' => $Model->Comment->find('count', array(
                            'conditions' => array(
                                'Comment.item_id' => $thread_id,
                                'Comment.model' => $Model->name
                                ))),
                        'last_comment_id' => $last_comment_id))
                    );
            }
            


            $Model->User->ReadedThread->updateAll(
                array('unreaded_comments' => 'unreaded_comments + 1'),
                array(
                    'ReadedThread.user_id !=' => User::get('id'),
                    'ReadedThread.model' => $Model->name,
                    'ReadedThread.thread_id' => $thread_id
                ));
            $userToEmail = $Model->User->ReadedThread->find('all', array(
                'fields' => 'DISTINCT user_id',
                'conditions' => array(
                    'ReadedThread.model' => $Model->name,
                    'ReadedThread.thread_id' => $thread_id,
                    'ReadedThread.unreaded_comments =' => 1
                )
            ));

            return $ret;
	}


        function userHasReaded(&$Model, $thread_id) {
            
             $rs = $Model->User->ReadedThread->find('all', array(
                    'fields' => 'unreaded_comments',
                    'conditions' => array(
                        'ReadedThread.model' => $Model->name,
                        'ReadedThread.thread_id' => $thread_id,
                        'ReadedThread.user_id' => User::get('id')
                    )
                ));
             if(empty($rs) || $rs[0]['ReadedThread']['unreaded_comments'] > 0)
                 return false;
             else
                 return true;
        }

        function userHasAnswered(&$Model, $thread_id) {
            # ToDo: nei forum non tiene in considerazone l'autore del post di apertura
            
            if($Model->name == 'Forum') {
                $condition = 'Comment.parent_id';
            }
            else{
                $condition = 'Comment.item_id';
            }

            $answers = $Model->Comment->find('count', array(
                'conditions' => array(
                    'Comment.model' => $Model->name,
                    $condition => $thread_id,
                    'Comment.user_id' => User::get('id')
                )
            ));
            
             if($answers)
                 return true;
             else
                 return false;
        }

        function getThreadStatus(&$Model, $thread_id) {
            $s = "";
            if($this->userHasReaded($Model, $thread_id))
                $s = 'mail_mark_read';
            else
                $s = 'mail_mark_unread';
            $s .= "";
            if($this->userHasAnswered($Model, $thread_id))
                $s .= '_new';
            else
                $s .= '';
            return $s;
        }

        function getDisplayField(&$Model) {
            $r = 'name';
            if(isset($this->settings[$Model->name]['displayField']))
                    $r = $this->settings[$Model->name]['displayField'];
            return $r;

        }

        function commentsReaded(&$Model, $id)
        {
            if(isset($_SESSION['Auth']['User']))
            {
                $user_id = User::get('id');
                $isReaded = $Model->User->ReadedThread->find('all', array(
                    'conditions' =>  array(
                        'ReadedThread.user_id' => $user_id,
                        'ReadedThread.model' => $Model->name,
                        'ReadedThread.thread_id' => $id
                        )
                    )
                 );
//                debug($isReaded); die();
                if(empty($isReaded)) {
                    $readed_thread_id = null;
                }
                else
                {
                    $readed_thread_id = $isReaded[0]['ReadedThread']['id'];
                }
                $Model->User->ReadedThread->save( array('ReadedThread' => array(
                    'id' =>  $readed_thread_id,
                    'user_id' => $user_id,
                    'model' => $Model->name,
                    'thread_id' => $id,
                    'unreaded_comments' => 0
                    )));
//                }
            }
        }
        
	function beforeSave(&$Model) {
            if(!isset($Model->data[$Model->name]['id']))
                    $Model->data[$Model->name]['user_id'] = User::get('id');
        }

}