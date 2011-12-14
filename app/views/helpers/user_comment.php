<?php
class UserCommentHelper extends Helper {
    var $helpers = array('Html', 'Form', 'Paginator', 'Session');

    /*
     *
     */
    function add($model, $item_id, $parent_id = null, $title = 'Commenta', $show_title = false) {
            $this->View = ClassRegistry::getObject('view');
            if(isset($this->View->viewVars['title_for_layout'])) {
                    $pagetitle = $this->View->viewVars['title_for_layout'];
            } else {
                    $pagetitle = Inflector::humanize($this->View->viewPath);
            }

            $return = '';
            $return .= $this->Html->tag('h3', __($title, true), array('class' => 'expander'));

            $return .= '<div class="accordion">';
            $return .= $this->Form->create('Comment', array('url' => $this->url(null, true)));
            $return .= $this->Form->hidden('Comment.add', array('value' => 1)); //serve nel component
            $return .= $this->Form->hidden('Comment.pagetitle', array('value' => $pagetitle));
            $return .= $this->Form->hidden('Comment.model', array('value' => $model));
            $return .= $this->Form->hidden('Comment.item_id', array('value' => $item_id));
            if(!empty($parent_id)) {
                    $return .= $this->Form->hidden('Comment.parent_id', array('value' => $parent_id));
            }
            if($show_title) {
                    $return .= $this->Form->input('Comment.title', array('type' => 'text', 'label' => 'Titolo'));
            }
            $return .= $this->Form->input('Comment.text', array('type' => 'textarea', 'label' => 'Testo'));
            $return .= $this->Form->end(__('Invia', true));
            $return .= '</div>';

            return $return;
    }

    /*
     *
     */
    function view($data, $element = false, $paginate = false) {
        $this->View = ClassRegistry::getObject('view');
        $return = '';
        
        if(!empty($data)) {
            if($paginate) {
                //paginator
                $return .= $this->Html->div('paging', $this->Html->tag('p', $this->Paginator->counter(array(
                                'format' => __('Pagina %page% di %pages%, %count% commenti inseriti', true)
                                ))));
            }

            $i = $this->params['paging']['Comment']['options']['limit']*($this->params['paging']['Comment']['options']['page']-1);
            $colorIndex=0;
            $userColors = array();
            foreach ($data as $comment) {
                $class = null;
                if ($i++ % 2 == 1) {
                        $class = ' alt';
                }

                $editComment = false;

                if (isset($comment['User'])) {
                        $author = $this->Html->div('comment-author', $comment['User']['fullname']);
                            if($this->user_can_edit($comment['Comment']['user_id'])) {
                                $editComment = true;
                        }
                } else {
                        $author = '';
                }

                if($editComment) {
                        $editComment = $this->Html->tag('div', $this->Html->link(__('modifica', true), array('controller' => 'comments', 'action' => 'edit', $comment['Comment']['id'])), array('class'=>'edit'));
                } else {
                        $editComment = '';
                }
               
//
//                if(isset($userColors[$comment['Comment']['user_id']])) {
//                    $color = $userColors[$comment['Comment']['user_id']];
//                }
//                else {
//                    $color = "user_".++$colorIndex;
//                    $userColors[$comment['Comment']['user_id']] = $color;
//                }

                $color = '';

                $date = $this->Html->div('comment-date', digi_date($comment['Comment']['created']));
                $text = $this->Html->div('comment-body', $comment['Comment']['text']);

                $number = $this->Paginator->link('# '.$i, array('#' => $comment['Comment']['id']));
                $number = $this->Html->div('comment-number', $number);
                $meta =  $this->Html->tag('span', $number.$author.$date, array('class' => 'comment-metadata'));
                $avatar = $this->Html->image('avatars/empty.png', array('class'=>"avatar $color"));
                $comment_topic = $this->Html->div('comment-topic' . $class, $meta.$text.$editComment  );
                $return .= $this->Paginator->link('', '', array( 'name'=> $comment['Comment']['id']));
                $return .= $this->Html->div('comment', $avatar.$comment_topic );
            }

            if($paginate) {
                    //paginator
                    $pages = $this->Paginator->prev('<< '.__('precedente', true), array(), null, array('class'=>'disabled'));
                    $pages .= ' | ';
                    $pages .= $this->Paginator->numbers();
                    $pages .= ' | ';
                    $pages .= $this->Paginator->next(__('successiva', true).' >>', array(), null, array('class'=>'disabled'));
                    $return .= $this->Html->div('paging', $pages);
            }

        } else {
                $return = __('Per ora non ci sono commenti', true);
        }
        $return = $this->Html->div('comments', $return);
        return $return;
    }

    function user_can_edit($comment_user_id) {
            $user = $this->Session->read('Auth.User');
            if(!$user) {
                    return false;
            }

            if($user['id'] == $comment_user_id || $user['role'] < 2) {
                    return true;
            }
            return false;
    }
}