<div class="news-list index">
    <h2><?php __('News');?></h2>
    <p>
        <?php
        echo $paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        $paginator->options(array('url' => $this->passedArgs));
        ?></p>
    <div class="paging">
        <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
        | 	<?php echo $paginator->numbers();?>
        <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
    </div>
    <?php
    foreach ($news as $one_news):
        ?>
    <div class="news">
        <div class="news-category"><?php echo $one_news['Newscategory']['name']; ?></div>
        <div class="news-date"><?php echo digi_date($one_news['News']['date_on']); ?></div>
        <h2><?php echo $this->Html->link($one_news['News']['title'], array('action'=>'view', $one_news['News']['id'])); ?></h2>
        <div class="summary"><?php echo $one_news['News']['summary']; ?>
            <div class="comments-number">
                <?php
                    $comment_number = $one_news['Comment']['count'];
                    if($comment_number)
                    {
                        if($comment_number == 1)
                            echo $comment_number." ".__('commento', true); 
                        else
                            echo $comment_number." ".__('commenti', true); 
                    }
                ?>
            </div>
            <span class="news-more">
                    <?php echo $html->link(__('Leggi tutto…', true), array('action'=>'view', $one_news['News']['id'])); ?>
            </span>
        </div>
    </div>
    <?php endforeach; ?>
    
</div>
<div class="actions">
    
        <ul>
            <li><?php echo $this->Html->link(__('Inserisci una news', true), array('controller' => 'news', 'action' => 'add')); ?></li>
        </ul>
    </div>