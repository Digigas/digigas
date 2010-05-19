<?php
echo $html->css('admin/filemanager.css');
echo $javascript->link('jquery.jeditable');
echo $javascript->link('swfupload/swfupload_fp10/swfupload');
echo $javascript->link('swfupload/jquery.swfupload');
?>

<script type="text/javascript">
    //<![CDATA[
    $(function(){
        $('#filemanager_actions .filemanager_form').hide();
        $('#_newfolder').click(function(){
            open_action('newfolder');
            return false;
        });
        $('#_newfile').click(function(){
            open_action('newfile');
            return false;
        });
        $('#_newfile_swfupload').click(function(){
            open_action('newfile_swfupload');
            return false;
        });


        //avvio jeditable
        jeditable_init();
    });

    function jeditable_init()
    {

        $('.item_name').editable('<?php echo $html->url(array('controller'=>'filemanager', 'action'=>'rename', $dir)) ?>', {
            indicator : 'Saving...',
            tooltip   : 'Click to edit',
            callback : function(value, settings) {
                var content = $(this).html();
                $(this).parents('.item_box').empty().html(content);
                jeditable_init();
            }
        });

        //lightbox -> richiamo lightbox per gli elementi caricati in ajax
        $('a.lightbox').lightBox({
            overlayBgColor: 		'#000',
            overlayOpacity:			0.9,
            imageLoading:			'<?php echo $this->webroot;?>img/lightbox-ico-loading.gif',		// (string) Path and the name of the loading icon
            imageBtnPrev:			'<?php echo $this->webroot;?>img/lightbox-btn-prev.gif',			// (string) Path and the name of the prev button image
            imageBtnNext:			'<?php echo $this->webroot;?>img/lightbox-btn-next.gif',			// (string) Path and the name of the next button image
            imageBtnClose:			'<?php echo $this->webroot;?>img/lightbox-btn-close.gif',		// (string) Path and the name of the close btn
            imageBlank:				'<?php echo $this->webroot;?>img/lightbox-blank.gif'
        });
    }

    function open_action(actionId)
    {
        var active_action = $('#filemanager_actions .active').attr('id');
        if(active_action == actionId && active_action)
        {
            $('#'+actionId).slideUp().removeClass('active');
        }
        else
        {
            $('#filemanager_actions .active').slideUp().removeClass('active');
            $('#'+actionId).slideDown().addClass('active');
        }
    }

    $(function(){
    //swfupload
    $('#swfupload').swfupload({
        // Backend Settings
        upload_url: "<?php echo $html->url(array('controller'=>'filemanager', 'action'=>'swfupload', 'session'=>$session->id(), $dir)); ?>",    // Relative to the SWF file (or you can use absolute paths)

        // File Upload Settings
        file_size_limit : "102400", // 100MB
        file_types : "*.*",
        file_types_description : "All Files",
        file_upload_limit : "100",
        file_queue_limit : "0",

        // Button Settings
        button_image_url : "<?php echo $html->url('/js/swfupload/swfupload_fp10/') ?>button.png", // Relative to the SWF file
        button_placeholder_id : "swfbutton",
        button_width: 61,
        button_height: 22,

        // Flash Settings
        flash_url : "<?php echo $html->url('/js/swfupload/swfupload_fp10/') ?>swfupload.swf"

    });
    // assign our event handlers
    $('#swfupload')
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#log').html('<li>File dialog complete</li>');
			$(this).swfupload('startUpload');
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			$('#log').html('<li>Upload progress - '+bytesLoaded+'</li>');
		})
		.bind('uploadComplete', function(event, file){
			$('#log').html('<li>Upload complete - '+file.name+'</li>');

            //if queue is complete, reload the page
            var stats = $.swfupload.getInstance(this).getStats();
            //console.debug(stats);
            if (stats.files_queued == 0) {
                window.location.reload();
            }

			// upload has completed, lets try the next one in the queue
			$(this).swfupload('startUpload');
		})
		.bind('uploadError', function(event, file, errorCode, message){
			$('#log').html('<li>Upload error - '+message+'</li>');
		});

    });

    //]]>
</script>

<div class="filemanager index">
    <h2>File manager</h2>

    <div id="filemanager_content">
        <?php

        if(!empty($dir))
        {
            $crumbs_array = explode('/', $dir);
            $crumbs = $html->link('Cartella iniziale', array('controller'=>'filemanager', 'action'=>'index'));
            $path = '';
            foreach($crumbs_array as $crumb)
            {
                $path .= '/'.urlencode($crumb);
                $crumbs .= $html->link(' > '.$crumb, array('controller'=>'filemanager', 'action'=>'index', $path));
            }
            echo $html->div('breadcrumbs', 'Sei in: &nbsp;' . $crumbs);
        }
        ?>

        <div id="filemanager_actions">
            <ul>
                <li><?php echo $html->link('Nuova cartella', array(), array('id'=>'_newfolder'))?></li>
                <li><?php echo $html->link('Carica un file', array(), array('id'=>'_newfile'))?></li>
                <li><?php echo $html->link('Carica una serie di files', array(), array('id'=>'_newfile_swfupload'))?></li>
            </ul>
            <div class="clear"></div>

            <div id="newfolder" class="filemanager_form">
                <h2>Crea una nuova cartella all'interno della cartella attuale</h2>
                <?php
                echo $form->create('Filemanager', array('url'=>'create'));
                echo $form->hidden('path', array('value'=>$dir));
                echo $form->input('name', array('label'=>'Nome della cartella'));
                echo $form->end('Crea cartella');
                ?>
            </div>

            <div id="newfile" class="filemanager_form">
                <h2>Carica un nuovo file dal tuo computer</h2>
                <?php
                echo $form->create('Filemanager', array('url'=>'upload', 'type'=>'file'));
                echo $form->hidden('path', array('value'=>$dir));
                echo $form->input('file', array('label'=>'Seleziona il file sul tuo computer', 'type'=>'file'));
                echo $form->end('Carica il file sul server');
                ?>
            </div>

            <div id="newfile_swfupload" class="filemanager_form">
                <h2>Carica una serie di files dal tuo computer</h2>
                <?php
                echo $form->create('Filemanager', array('url'=>'swfupload', 'type'=>'file'));
                echo $form->hidden('path', array('value'=>$dir, 'id'=>null));
                //echo $form->input('file', array('label'=>'Seleziona i files sul tuo computer', 'type'=>'file', 'id'=>'swfupload'));
                echo $html->div('input', $html->tag('div', $html->tag('div', '', array('id'=>'swfbutton')), array('id'=>'swfupload')));
                echo $form->end();
                echo $html->tag('div', '', array('id'=>'log'));
                ?>
            </div>
        </div>
        <div class="clear"></div>

        <?php
        $folders = $resources[0];
        $files = $resources[1];
        foreach($folders as $res)
        {
            echo $html->div('item_box', $this->element('admin/filemanager_folder', array('res'=>$res)));
        }
        ?>
        <?php
        foreach($files as $res)
        {
            echo  $html->div('item_box', $this->element('admin/filemanager_file', array('res'=>$res)));
        }
        ?>
        <div class="clear"></div>


    </div>
</div>