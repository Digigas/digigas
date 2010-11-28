<div class="forums view">
	<h2><?php echo $forum['Forum']['name']; ?></h2>
	<div class="description">
		<?php echo $forum['Forum']['text']; ?>
	</div>

	<?php 
		if (!empty($comments)) {
			$i = 0;
			foreach ($comments as $comment) {
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' alt';
				}

				if (isset($comment['User'])) {
					$author = $this->Html->div('comment-author', $comment['User']['fullname']);
				} else {
					$author = '';
				}
				$date = $this->Html->div('comment-date', digi_date($comment['Comment']['created']));
				$text = $this->Html->div('comment-text', $comment['Comment']['text']);
				$readlink = $this->Html->link(__('Partecipa alla conversazione', true), array('action' => 'view_topic', $comment['Comment']['id']), array('class' => 'read'));
				echo $this->Html->div('comment comment-topic' . $class, $author . $date . $text . $readlink . $this->Html->div('clear', '&nbsp;'));
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
		echo $this->UserComment->add('Forum', $forum['Forum']['id'], null, 'Inizia una nuova discussione');
	}
	?>
	</div>
	<div class="actions">
		<h3><?php __('Actions'); ?></h3>
		<ul>
			<li><?php echo $this->Html->link(__('Torna a elenco forum', true), array('action' => 'index')); ?> </li>

	</ul>
</div>