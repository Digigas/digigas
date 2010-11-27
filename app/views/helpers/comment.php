<?php
class CommentHelper extends Helper {
	var $helpers = array('Html', 'Form');

	/*
	 * 
	 */
	function add($model, $item_id) {

		$return = '';
		$return .= $this->Html->tag('h3', __('Commenta', true), array('class' => 'expander'));

		$return .= '<div class="accordion">';
		$return .= $this->Form->create('Comment', array('url' => $this->url()));
		$return .= $this->Form->hidden('Comment.add', array('value' => 1)); //serve nel component
		$return .= $this->Form->hidden('Comment.model', array('value' => $model));
		$return .= $this->Form->hidden('Comment.item_id', array('value' => $item_id));
		$return .= $this->Form->input('Comment.text', array('type' => 'textarea', 'label' => __('Scrivi qui il tuo commento', true)));
		$return .= $this->Form->end(__('Invia il commento', true));
		$return .= '</div>';

		return $return;
	}

	/*
	 * 
	 */
	function view($data, $element = false) {
		$this->View = ClassRegistry::getObject('view');
		$return = '';

		if(!empty($data)) {
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
			return $return;
		} else {
			return __('Per ora non ci sono commenti', true);
		}
	}
}