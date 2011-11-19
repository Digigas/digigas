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
	
	
	<?php
    $date = $this->Html->div('comment-date', digi_date($topic['Comment']['created']));
                    $text = $this->Html->div('comment-body', $topic['Comment']['text']);
                    $author = $this->Html->div('comment-author', $topic['User']['fullname']);
                    $meta =  $this->Html->tag('span', $author.$date, array('class' => 'comment-metadata'));
                    $avatar = $this->Html->image('avatars/empty.png', array('class'=>'avatar'));
                    $comment_topic = $this->Html->div('comment-topic first' , $meta.$text  );
                    $st = $this->Html->div('comment', $avatar.$comment_topic );

                    echo $st;
                    echo "<br/>";
                    echo $this->UserComment->view($comments, false , true);
		
	?>	
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