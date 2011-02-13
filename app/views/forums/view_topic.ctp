<div class="forums view">
	<h2>
	<?php
	if(!empty($topic['Comment']['title'])) {
		echo $topic['Comment']['title'];
		echo ' - ';
	}
	?>
	<?php echo $forum['Forum']['name']; ?>
	</h2>
	
	<div class="comment topic">
		<div class="comment-author"><?php echo $topic['User']['fullname']; ?></div>
		<div class="comment-date"><?php echo digi_date($topic['Comment']['created']); ?></div>
		<div class="comment-text"><?php echo $topic['Comment']['text']; ?></div>
	</div>

	<?php
		if (!empty($comments)) {
			$i = 0;
			foreach ($comments as $comment) {
				$class = null;
				if ($i++ % 2 == 1) {
					$class = ' alt';
				}

				$editComment = false;

				if (isset($comment['User'])) {
					$author = $this->Html->div('comment-author', $comment['User']['fullname']);
					if($this->UserComment->user_can_edit($comment['User']['id'])) {
						$editComment = true;
					}
				} else {
					$author = '';
				}

				if($editComment) {
					$editComment = $this->Html->div('edit', $this->Html->link(__('modifica', true), array('controller' => 'comments', 'action' => 'edit', $comment['Comment']['id'])));
				} else {
					$editComment = '';
				}

				$date = $this->Html->div('comment-date', digi_date($comment['Comment']['created']));
				$text = $this->Html->div('comment-text', $comment['Comment']['text']);
				echo $this->Html->div('comment comment-topic' . $class, $author . $date . $text . $editComment . $this->Html->div('clear', '&nbsp;'));
			}
		}		
	?>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('precedente', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('prossima', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<br/>

	<?php
	if ($this->Session->read('Auth.User.id')) {
		//form di inserimento commenti
		echo $this->UserComment->add('Forum', $forum['Forum']['id'], $topic['Comment']['id'], 'Rispondi');
	}
	?>
	
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Torna a tutti i forum', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Torna a', true) . ' ' . $forum['Forum']['name'], array('action' => 'view', $forum['Forum']['id'])); ?></li>
	</ul>
</div>