<?php 
$layout->blockStart('metatags');
echo $this->element('metatags', array('metatags'=>array('keywords'=>$page['Page']['meta_keywords'], 'description'=>$page['Page']['meta_description'])));
$layout->blockEnd()
    ?>

<!-- contenuto -->
<div id="cont">
    <div class="view">

        <h1><?php echo $page['Page']['title']; ?></h1>
        <div class="content">
            <?php echo $page['Page']['text']; ?>
        </div>

        <div class="news-list">
            <h1><?php __('Ultime news'); ?></h1>
            <?php foreach($lastNews as $news): ?>
            <div class="news">
                <div class="news-category"><?php echo $news['Newscategory']['name']; ?></div>
                <div class="news-date">
                    <?php echo digi_date($news['News']['date_on']); ?>
                </div>
                <h2><?php echo $this->Html->link($news['News']['title'], array('controller' => 'news', 'action' => 'view', $news['News']['id'])); ?></h2>
                <div class="news-content">
                    <?php echo $news['News']['summary']; ?>
                </div>
                <div class="news-more">
                    <?php echo $this->Html->link(__('Leggi tutto', true), array('controller' => 'news', 'action' => 'view', $news['News']['id'])); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<div class="actions">
	<?php echo $this->element('forum/last_messages'); ?>
</div>