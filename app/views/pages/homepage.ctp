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

    </div>
</div>