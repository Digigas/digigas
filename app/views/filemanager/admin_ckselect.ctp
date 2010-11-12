<div class="filemanager index">
<h2>File manager</h2>

<div id="filemanager_content">
<?php

if(!empty($dir))
{
    $crumbs_array = explode('/', $dir);
    $crumbs = $this->Html->link('Cartella iniziale', array('controller'=>'filemanager', 'action'=>'ckselect', $getstring));
    $path = '';
    foreach($crumbs_array as $crumb)
    {
        $path .= '/'.urlencode($crumb);
        $crumbs .= $this->Html->link(' > '.$crumb, array('controller'=>'filemanager', 'action'=>'ckselect', $path, $getstring));
    }
    echo $this->Html->div('breadcrumbs', 'Sei in: &nbsp;' . $crumbs);
}
?>

    <div id="filemanager_actions">
        <ul>
            <li><?php echo $this->Html->link('Navigazione rapida', array(), array('id'=>'_tree'))?></li>
            <li><?php echo $this->Html->link('Nuova cartella', array(), array('id'=>'_newfolder'))?></li>
            <li><?php echo $this->Html->link('Carica un file', array(), array('id'=>'_newfile'))?></li>
        </ul>
        <div class="clear"></div>

        <div id="tree" class="filemanager_form">
            <h2>Navigazione rapida tra tutte le cartelle</h2>
            <ul>
            <?php
            foreach($dir_tree as $node)
            {
                //il nodo della cartella principale è vuoto
                if($node == '')
                {
                    echo '<li>'.$this->Html->link('Cartella iniziale', array('controller'=>'filemanager', 'action'=>'ckselect', '/', $getstring)).'</li>';
                }
                else
                {
                    echo '<li>'.$this->Html->link($node, array('controller'=>'filemanager', 'action'=>'ckselect', $node, $getstring)).'</li>';
                }
            }
            ?>
            </ul>
        </div>

        <div id="newfolder" class="filemanager_form">
            <h2>Crea una nuova cartella all'interno della cartella attuale</h2>
            <?php
            echo $this->Form->create('Filemanager', array('url'=>'create'));
            echo $this->Form->hidden('path', array('value'=>$dir));
            echo $this->Form->input('name', array('label'=>'Nome della cartella'));
            echo $this->Form->end('Crea cartella');
            ?>
        </div>

        <div id="newfile" class="filemanager_form">
            <h2>Carica un nuovo file dal tuo computer</h2>
            <?php
            echo $this->Form->create('Filemanager', array('url'=>'upload', 'type'=>'file'));
            echo $this->Form->hidden('path', array('value'=>$dir));
            echo $this->Form->input('file', array('label'=>'Seleziona il file sul tuo computer', 'type'=>'file'));
            echo $this->Form->end('Carica il file sul server');
            ?>
        </div>
    </div>
    <div class="clear"></div>

<?php
$folders = $resources[0];
$files = $resources[1];
foreach($folders as $res):
?>
<div class="item_res">
    <div class="item_img">
        <?php echo $this->Html->image('oxygen/128x128/filesystems/folder.png', array('url' => array('controller'=>'filemanager', 'action'=>'ckselect', '/'.$dir.'/'.urlencode($res).$getstring))); ?>
    </div>
    <div class="item_name" id="<?php echo $res ?>"><?php echo $res; ?></div>
    <div class="item_details">

    </div>
    <div class="item_actions">
        <?php
        // echo $this->Html->link($this->Html->image('oxygen/16x16/actions/edit_delete_mail.png'), array('controller'=>'filemanager', 'action'=>'delete_dir', $dir.'/'.urlencode($res)), array('title'=>'elimina'), 'Sei sicuro di voler eliminare la cartella '.$res.'?',null,false);
        ?>
    </div>
</div>
<?php endforeach ?>
<?php
foreach($files as $res)
{
   echo  $this->Html->div('item_box', $this->element('admin/filemanager_file', array('res'=>$res)));
}
?>
<div class="clear"></div>


</div>
</div>