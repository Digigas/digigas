<?php
$this->Layout->blockStart('js_on_load');

echo <<<JS

$('.forum')
	.css({cursor: 'pointer'})
	.hover(
		function() { $(this).addClass('hover'); },
		function() { $(this).removeClass('hover'); })
	.click(function(){
		var url = $(this).find('h3.forum-title a').attr('href');
		window.location = url;
	});

JS;

$this->Layout->blockEnd();
?>

<div class="forums index">
	<h2><?php __('Forum');?></h2>

	<?php
	$i = 0;
	foreach ($forums as $forum):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' altrow';
		}
	?>
	<div class="forum <?php echo $class;?>">

		<?php if(isset($messagesCount[$forum['Forum']['id']])): ?>
			<div class="forum-messages">
				<?php echo $messagesCount[$forum['Forum']['id']]; ?> <?php __('messaggi in'); ?>
				<?php echo $conversationCount[$forum['Forum']['id']]; ?> <?php __('conversazioni'); ?>
			</div>
			<div class="forum-lastupdate">
				<?php __('Aggiornato a'); ?> <?php echo $this->Time->relativeTime($lastUpdates[$forum['Forum']['id']]); ?>
			</div>
		<?php endif; ?>
		
		<h3 class="forum-title"><?php echo $this->Html->link($forum['Forum']['name'], array('controller' => 'forums', 'action' => 'view', $forum['Forum']['id'])); ?>&nbsp;</h3>
		<div class="description"><?php echo $forum['Forum']['text']; ?></div>
	</div>
<?php endforeach; ?>
	
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('precedente', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('successiva', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>

<div class="actions">
	<h2>Ultimi messaggi nel forum</h2>
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