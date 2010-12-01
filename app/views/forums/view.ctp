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

				$editComment = false;
				if (isset($comment['User'])) {
					$author = $this->Html->div('comment-author', $comment['User']['fullname']);
					if($this->UserComment->user_can_edit($comment['User']['id'])) {
						$editComment = true;
					}
				} else {
					$author = '';
				}
				$date = $this->Html->div('comment-date', digi_date($comment['Comment']['created']));

				if($editComment) {
					$editComment = $this->Html->div('edit', $this->Html->link(__('modifica', true), array('controller' => 'comments', 'action' => 'edit', $comment['Comment']['id'])));
				} else {
					$editComment = '';
				}

				//quanti commenti ci sono dentro e a quando risalgono
				if (isset($commentsChildren[$comment['Comment']['id']])) {
					$children = $this->Html->div('comment-children', $commentsChildren[$comment['Comment']['id']] . ' ' . __('messaggi', true));
					$lastUpdates = $this->Html->div('comment-lastupdates', __('L\'ultimo è di ', true) . $this->Time->relativeTime($lastUpdates[$comment['Comment']['id']]));
				} else {
					$children = $this->Html->div('comment-children', __('Nessun messaggio', true));
					$lastUpdates = '';
				}

				$content = $this->Html->div('comment-text', $comment['Comment']['text']);
				$readlink = $this->Html->link(__('Partecipa alla conversazione', true), array('action' => 'view_topic', $comment['Comment']['id']), array('class' => 'read'));
				echo $this->Html->div('comment comment-topic' . $class, $author . $date . $children . $lastUpdates . $content . $editComment . $readlink . $this->Html->div('clear', '&nbsp;'));
			}
		}
	?>
		<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('precedente', true), array(), null, array('class' => 'disabled')); ?>
	 | 	<?php echo $this->Paginator->numbers(); ?>
		|
		<?php echo $this->Paginator->next(__('prossima', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
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
			<li><?php echo $this->Html->link(__('Torna all\'elenco dei forum', true), array('action' => 'index')); ?> </li>
		</ul>

		<br/>
		<h2>Ultimi aggiornamenti</h2>
	<?php
	$i=0;
	foreach ($lastMessages as $comment) {
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' alt';
		}

		if(isset($comment['User'])) {
			$author = $this->Html->div('comment-author', $comment['User']['fullname']);
		} else {
			$author = '';
		}
		$date = $this->Html->div('comment-date', $this->Time->relativeTime($comment['Comment']['created']));
		$content = $this->Html->div('comment-text', $this->Text->truncate(strip_tags($comment['Comment']['text'])));
		$more = $this->Html->link(__('Leggi', true), '/' . $comment['Comment']['url'], array('class' => 'more'));
		echo $this->Html->div('comment'.$class, $author.$date.$content.$more);
	}
	?>
</div>