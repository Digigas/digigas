<div class="news view">

    <h1><?php echo $news['News']['title'] ?></h1>

    <div class="date">
        <?php
        if($news['News']['date_on'] != '0000-00-00 00:00:00') {
            if(date('Y-m-d') == date('Y-m-d', strtotime($news['News']['date_on'])))
                echo __('Oggi', true).' '.date('H:i', strtotime($news['News']['date_on']));
            else
                echo date('D d M Y', strtotime($news['News']['date_on']));
        }
        else {
            if(date('Y-m-d') == date('Y-m-d', strtotime($news['News']['created'])))
                echo __('Oggi', true).' '.date('H:i', strtotime($news['News']['created']));
            else
                echo date('D d M Y', strtotime($news['News']['created']));
        }
        ?>
    </div>

    <div class="newscategory">
        <?php echo $html->link($news['Newscategory']['name'], array('controller'=>'news', 'action'=>'category', $news['Newscategory']['slug'])) ?>
    </div>

    <div class="summary">
        <?php echo $news['News']['summary'] ?>
    </div>

    <div class="body">
        <?php
        echo $news['News']['text'];
        ?>
    </div>

</div>