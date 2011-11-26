<div class="forums view">
	<h2><?php echo $forumName; ?></h2>
	<div class="description">
		<?php //echo $forum['Forum']['text']; ?>
	</div>
        
	<?php if (!empty($threads)): ?>

	<table cellpadding="0" cellspacing="0">
        <tr>
            <th></th>
            <th><?php echo $this->Paginator->sort(__('Oggetto', true), 'name');?></th>
            <th><?php echo $this->Paginator->sort(__('Aperta da', true), 'user_id');?></th>
            <th><?php echo $this->Paginator->sort(__('Risposte', true), 'comments_count');?></th>
            <th><?php echo $this->Paginator->sort(__('Ultimo commento', true), 'LastComment.created');?></th>
        </tr>
        <?php
        
        $i = 0;
        
        foreach ($threads as $thread):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
//            $children = 0;
//            $lastUpdatesView = '';
//            if (isset($commentsChildren[$comment[$model]['id']]))
//            {
//                $children =  $commentsChildren[$comment[$model]['id']] ;
//                $lastUpdatesView =  $this->Time->relativeTime($lastUpdates[$comment[$model]['id']]);
//            }


    ?>
        <tr<?php echo $class;?>>
            <td>
            </td>
            <td class='discussion_title'><?php echo $this->Html->link($thread[$model]['name'], array('controller' => Inflector::pluralize($model), 'page' => 'last', '#' => $thread[$model]['last_comment_id'],  'action' => 'view', $thread[$model]['id']), array('class' => 'read')); ?></td>
            <td class='discussion_author'><?php echo $this->Html->div('comment-author', $thread['User']['fullname']);?> </td>
            <td class='discussion_answers'><?php echo $thread[$model]['comments_count'];?> </td>
            <td>
                <?php
            
            if(isset($thread['LastComment']['created'] ))
            {
                $lastUpdatesView =  $this->Time->relativeTime($thread['LastComment']['created']);
                echo $lastUpdatesView."<br>da<strong> ".$thread['LastUser']['fullname']."</strong>";
            }
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