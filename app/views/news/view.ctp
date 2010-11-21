<div class="news-list view">
    <div class="news">

        <div class="news-category">
            <?php echo $html->link($news['Newscategory']['name'], array('controller'=>'news', 'action'=>'category', $news['Newscategory']['slug'])) ?>
        </div>

        <div class="news-date">
            <?php
//             debug($news);
            if($news['News']['user_id']);
                echo "Inserita da <strong>".$news['User']['first_name']." ".$news['User']['last_name']."</strong> ";
            /*if($news['News']['date_on'] != '0000-00-00 00:00:00') {
                if(date('Y-m-d') == date('Y-m-d', strtotime($news['News']['date_on'])))
                    echo __('Oggi', true).' '.date('H:i', strtotime($news['News']['date_on']));
                else
                    echo date('D d M Y', strtotime($news['News']['date_on']));
            }
            else*/ {
                if(date('Y-m-d') == date('Y-m-d', strtotime($news['News']['created'])))
                    echo __('Oggi alle', true).' '.date('H:i', strtotime($news['News']['created']));
                else
                    echo date('D d M Y', strtotime($news['News']['created']));
            }
            ?>
        </div>

        <h2><?php echo $news['News']['title'] ?></h2>        

        <div class="news-content">
            <strong><?php echo $news['News']['summary'] ?></strong>
            
            <?php
            echo $news['News']['text'];
            ?>
        </div>
    </div>
<?php      
if($this->Session->read('Auth.User.id')):
echo $form->create('News', array('action' => 'add_as_comment'));
echo $form->input('parent_id', array('type'=>'hidden', 'value' => $news['News']['id']));
echo $form->label('Commento').$form->textarea('text', array('label' => 'Commento', 'cols' => 60, 'rows' => 4));
echo $form->end(array('label' => 'Invia commento'));



$i=0;
foreach ($news['Comment'] as $comments):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' altnews';
    }
?>
    <div class="news<?php echo $class ?>">
        <div class="news-date">
            <?php
            
            if($comments['user_id']);
                echo "Inserita da <strong>".$comments['User']['first_name']." ".$comments['User']['last_name']."</strong> ";
            /*if($news['News']['date_on'] != '0000-00-00 00:00:00') {
                if(date('Y-m-d') == date('Y-m-d', strtotime($news['News']['date_on'])))
                    echo __('Oggi', true).' '.date('H:i', strtotime($news['News']['date_on']));
                else
                    echo date('D d M Y', strtotime($news['News']['date_on']));
            }
            else*/ {
                if(date('Y-m-d') == date('Y-m-d', strtotime($comments['created'])))
                    echo __('Oggi alle', true).' '.date('H:i', strtotime($comments['created']));
                else
                    echo date('D d M Y', strtotime($comments['created']));
            }
            ?>
        </div>
        
        <a name = <?php  echo '"comment_'.$comments['id'].'" href="#comment_'.$comments['id'].'"' ?> >
        <h2>
        <?php echo __('Commento #', true).$i ?> 
        </h2>        
        </a>

        <div class="news-content">
            <strong><?php echo $comments['summary'] ?></strong>
            
            <?php
            echo $comments['text'];
            ?>
        </div>
    </div>
<?php endforeach; 
endif;
?>

</div>