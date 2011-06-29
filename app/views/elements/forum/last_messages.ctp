<?php
if(isset($this->viewVars['lastMessages'])):
	if(!empty($this->viewVars['lastMessages'])):
?>
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
<?php 
	endif;
endif;
?>