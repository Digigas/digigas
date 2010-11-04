<div class="news-list view">
    <div class="news">

        <div class="news-category">
            <?php echo $html->link($news['Newscategory']['name'], array('controller'=>'news', 'action'=>'category', $news['Newscategory']['slug'])) ?>
        </div>

        <div class="news-date">
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

        <h2><?php echo $news['News']['title'] ?></h2>        

        <div class="news-content">
            <?php echo $news['News']['summary'] ?>

            <?php
            echo $news['News']['text'];
            ?>
        </div>

    </div>
</div>