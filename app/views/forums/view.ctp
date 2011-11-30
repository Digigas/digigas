<div class="forums view">
	<h2><?php echo $forum['Forum']['name']; ?></h2>
	<div class="description">
		<?php echo $forum['Forum']['text']; ?>
	</div>

	<?php if (!empty($comments)): ?>
	
	<table cellpadding="0" cellspacing="0">
        <tr>
            <th></th>
            <th><?php echo $this->Paginator->sort(__('Oggetto', true), 'title');?></th>
            <th><?php echo $this->Paginator->sort(__('Aperta da', true), 'user_id');?></th>
            <th><?php echo $this->Paginator->sort(__('Risposte', true), '');?></th>
            <th><?php echo $this->Paginator->sort(__('Ultimo commento', true), 'created');?></th>
        </tr>
        <?php
        $i = 0;
        
        foreach ($comments as $comment):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            $children = 0;
            $lastUpdatesView = '';
            if (isset($commentsChildren[$comment['Comment']['id']])) 
            {
                $children =  $commentsChildren[$comment['Comment']['id']] ;
                $lastUpdatesView =  $this->Time->relativeTime($lastUpdates[$comment['Comment']['id']]);
            } 
            
    
    ?>
        <tr<?php echo $class;?>>
            <td>
                <?php echo $this->Html->image('oxygen/16x16/actions/'.$comment['Comment']['status'].'.png'); // $thread[$model]['status'];?>
            </td>
            <td class='discussion_title'><?php echo $this->Html->link($comment['Comment']['title'], array('action' => 'view_topic', $comment['Comment']['id']), array('class' => 'read')); ?></td>
            <td class='discussion_author'><?php echo $this->Html->div('comment-author', $comment['User']['fullname']);?> </td>
            <td class='discussion_answers'><?php echo $children;?> </td>
            <td><?php if(isset($lastAuthor[$comment['Comment']['id']] )) 
                echo $lastUpdatesView."<br>da<strong> ".$lastAuthor[$comment['Comment']['id']]."</strong>";
            else
                echo $this->Time->relativeTime($comment['Comment']['created'])."<br>da<strong> ".$comment['User']['fullname']."</strong>";
                ?> </td>
            
        </tr>
<?php endforeach; 
endif;
?>
    </table>
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
			echo $this->UserComment->add('Forum', $forum['Forum']['id'], null, 'Inizia una nuova discussione', true);
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