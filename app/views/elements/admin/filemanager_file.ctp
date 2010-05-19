<div class="item_res">
    <div class="item_img file_resource">
        <?php
            $parts = explode('.', $res);
            $extension = array_pop($parts);
            $is_image = false;
            switch(low($extension))
            {
                case 'jpg':
                case 'jpeg':
                case 'gif':
                case 'png':
                case 'bmp':
                    //$image = 'oxygen/64x64/mimetypes/image.png';
                    $_image = '/'.$docs_dir.'/'.$dir.'/'.$res;
                    $is_image = true;
                    break;
                case 'pdf':
                    $_image = 'oxygen/128x128/mimetypes/application_pdf.png';
                    break;
                case 'doc':
                case 'odt':
                case 'swt':
                    $_image = 'oxygen/128x128/mimetypes/application_vnd.ms_word.png';
                    break;
                case 'php':
                    $_image = 'oxygen/128x128/mimetypes/application_x_php.png';
                    break;
                case 'ctp':
                case 'html':
                case 'htm':
                case 'xhtml':
                    $_image = 'oxygen/128x128/mimetypes/application_xhtml+xml.png';
                    break;

                case '':
                default:
                    $_image = 'oxygen/128x128/mimetypes/txt.png';
                    break;
            }

            if($is_image)
            {
                echo '<a href="'.$this->webroot.$docs_dir.'/'.$dir.'/'.$res.'" class="lightbox">'.$this->Image->resize($_image, '128', '128').'</a>';
            }
            else
            {
                echo '<a href="'.$this->webroot.$docs_dir.'/'.$dir.'/'.$res.'">'.$this->Html->image($_image).'</a>';
            }
        ?>
    </div>
    <div class="item_name" id="<?php echo $res ?>"><?php echo $res ?></div>
    <div class="item_details">

    </div>
    <div class="item_actions">
        <?php
        echo $this->Html->link($this->Html->image('oxygen/16x16/actions/rotate_cw.png'), array('controller'=>'filemanager', 'action'=>'rotate_ccw', $dir.'/'.urlencode($res)), array('title'=>'ruota antiorario', 'escape' => false));
        echo $this->Html->link($this->Html->image('oxygen/16x16/actions/rotate_ccw.png'), array('controller'=>'filemanager', 'action'=>'rotate_cw', $dir.'/'.urlencode($res)), array('title'=>'ruota orario', 'escape' => false));
        echo $this->Html->link($this->Html->image('oxygen/16x16/actions/edit_delete_mail.png'), array('controller'=>'filemanager', 'action'=>'delete', $dir.'/'.urlencode($res)), array('title'=>'elimina', 'escape' => false),'Sei sicuro di voler eliminare il file '.$res.'?');
        ?>
    </div>
</div>