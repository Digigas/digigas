<?php
    $layout->blockStart('metatags');
    echo $this->element('metatags', array('metatags'=>array('keywords'=>$page['Page']['meta_keywords'], 'description'=>$page['Page']['meta_description'])));
    $layout->blockEnd()
?>

<?php
    $layout->blockStart('foto');
    echo $imagesList->show(array('images_array' => $page['Image']));
    $layout->blockEnd();
?>

<!-- contenuto -->
<div id="cont">

<div class="page_content">
    <h1><?php echo $page['Page']['title']; ?></h1>
    <div class="content">
    <?php
    //tag substitution
    echo $tag2element->replace($page['Page']['summary']);
    ?>
    </div>
    <div class="content">
    <?php
    //tag substitution
    echo $tag2element->replace($page['Page']['text']);
    ?>
    </div>
</div>

</div>