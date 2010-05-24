<div class="item_res">
    <div class="item_img">
        <?php echo $this->Html->image('oxygen/128x128/filesystems/folder.png', array('url' => array('controller'=>'filemanager', 'action'=>'index', '/'.$dir.'/'.urlencode($res)))); ?>
    </div>
    <div class="item_name" id="<?php echo $res ?>"><?php echo $res; ?></div>
    <div class="item_details">

    </div>
    <div class="item_actions">
        <?php
        echo $this->Html->image('oxygen/16x16/actions/edit_delete_mail.png', array('url' => array('controller'=>'filemanager', 'action'=>'delete_dir', $dir.'/'.urlencode($res)), array('title'=>'elimina', 'escape' => false), 'Sei sicuro di voler eliminare la cartella '.$res.'?',null,false));
        ?>
    </div>
</div>