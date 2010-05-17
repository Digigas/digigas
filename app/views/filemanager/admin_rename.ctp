<?php
switch($type)
{
    case 'file':
        echo $this->element('admin/filemanager_file', array('res'=>$new_file));
        break;
    case 'folder':
        echo $this->element('admin/filemanager_folder', array('res'=>$new_file));
        break;
}
?>