<div class="news index">
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
    <div class="news-item">
        <h1><?php echo $one_news['News']['title']; ?></h1>
        <div class="newscategory"><?php echo $one_news['Newscategory']['name']; ?></div>
        <div class="date"><?php echo $one_news['News']['date_on'] ?></div>
        <div class="summary"><?php echo $one_news['News']['summary']; ?>
            <span class="more">
                    <?php echo $html->link(__('more…', true), array('action'=>'view', $one_news['News']['id'])); ?>
            </span>
        </div>
    </div>
    <?php endforeach; ?>
</div>