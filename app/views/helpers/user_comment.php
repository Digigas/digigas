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
				$return .= $this->Html->tag('p', $this->Paginator->counter(array(
						'format' => __('Pagina %page% di %pages%, %count% commenti inseriti', true)
						)));
			}

			$i=0;
			foreach ($data as $comment) {
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' alt';
				}

				if($element) {
					//render element
					$return .= $this->View->element($element, array('data' => $comment));
				} else {
					//default view
					if(!isset($comment['Comment'])) {
						$comment['Comment'] = $comment;
					}
					if(isset($comment['User'])) {
						$author = $this->Html->div('comment-author', $comment['User']['fullname']);
					} else {
						$author = '';
					}
					$date = $this->Html->div('comment-date', digi_date($comment['Comment']['created']));
					$text = $this->Html->div('comment-text', $comment['Comment']['text']);
					$return .= $this->Html->div('comment'.$class, $author.$date.$text);
				}
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

			return $return;
		} else {
			return __('Per ora non ci sono commenti', true);
		}
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