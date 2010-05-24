<div class="news view">

<h1><?php echo $news['News']['title'] ?></h1>

<div class="date">
    <?php
        if($news['News']['date_on'] != '0000-00-00 00:00:00')
        {
            if(date('Y-m-d') == date('Y-m-d', strtotime($news['News']['date_on'])))
                echo 'Oggi '.date_it('H:i', strtotime($news['News']['date_on']));
            else
                echo date_it('D d M Y', strtotime($news['News']['date_on']));
        }
        else
        {
            if(date('Y-m-d') == date('Y-m-d', strtotime($news['News']['created'])))
                echo 'Oggi '.date_it('H:i', strtotime($news['News']['created']));
            else
                echo date_it('D d M Y', strtotime($news['News']['created']));
        }
    ?>
</div>

<div class="newscategory">
    <?php echo $html->link($news['Newscategory']['name'], array('controller'=>'news', 'action'=>'category', $news['Newscategory']['slug'])) ?>
</div>

<?php if(count($news['Tag']) > 0):?>
<div class="tags">
    <ul>
    <?php
    foreach($news['Tag'] as $tag):
    ?>
        <li>
        <?php echo $html->link($tag['name'], array('controller'=>'tags', 'action'=>'view', $tag['id'])) ?>
        </li>
    <?php endforeach ?>
    </ul>
    <div class="clear"></div>
</div>
<?php endif ?>


<?php echo $news['News']['summary'] ?>

<?php
//carico un'immagine a caso nella cartella
    $slideshow_for_layout = array();//$news['Image']; // disabilitato per il momento
    if(count($slideshow_for_layout) > 1)
    {
        //debug($slideshow_for_layout);
        foreach($slideshow_for_layout as $n=>$_image)
        {
            $slideshow_for_layout[$n] = 'quad.'.$_image['file'];
        }
        $images = $slideshow_for_layout;


        echo '<ul class="slideshow">';

        $images_tmp = $images;
        $i = 0;
        while($i<count($slideshow_for_layout))
        {
            $i++;
            $randnum = rand(0, count($images_tmp)-1);
            $_image = $images_tmp[$randnum];
            // tolgo le immagini dall'array per evitare che si ripetano
            if(count($images_tmp)>1)
            {
                unset($images_tmp[$randnum]);
                $images_tmp = array_values($images_tmp);
            }
            // ripopolo l'array quando si svuota
            else
            $images_tmp = $images;

            //echo '<li><img src="'.$this->webroot.'documents/image/'.$image.'" alt=""/></li>';
            echo '<li>'.$image->resize('/documents/image/'.$_image, 630, 400).'</li>';
        }
        echo '</ul>';
    }
    elseif(count($slideshow_for_layout) == 1)
    {
        echo $image->resize('/documents/image/'.'quad.'.$slideshow_for_layout['0']['file'], 610, 400);
    }
?>
<?php 
	echo $news['News']['text'];

    echo $bookmark->getBookMarks($news['News']['title']);
 ?>

</div>