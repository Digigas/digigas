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
/*
 * COMMENTI
 */
//visualizzo i commenti solo per gli utenti registrati
if($this->Session->read('Auth.User.id')) {

	//elenco dei commenti
	echo $this->Html->tag('h3', __('Commenti', true));
	echo $this->UserComment->view($news['Comment']);


	//form di inserimento commenti
	echo $this->UserComment->add('News', $news['News']['id']);

}
?>

</div>

<div class="actions">
    <ul>
        <li><?php echo $this->Html->link('<< '.__('indietro', true), $referer); ?></li>
		<li><?php echo $this->Html->link(__('Homepage', true), '/'); ?></li>
    </ul>
</div>
