<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php //$firecake->view($this); ?>

<title>admin - <?php echo $title_for_layout; ?></title>
<?php echo $this->Html->charset(); ?>
<link rel="icon" href="<?php echo $this->webroot . 'favicon.ico'; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $this->webroot . 'favicon.ico'; ?>" type="image/x-icon" />

<?php echo $this->Html->css('cake.generic'); ?>
<?php echo $this->Html->css('cake.admin'); ?>
<?php echo $this->Html->css('digigas/filemanager.css'); ?>

<?php echo $this->Javascript->link('jquery-1.4.3.min'); ?>
<?php echo $this->Javascript->link('jquery.ifixpng'); ?>

<?php echo $this->Javascript->link('ckeditor/ckeditor.js'); ?>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // apply png fix to all images
    $.ifixpng('<?php echo $this->webroot; ?>img/blank.gif');
    $('img[src$=.png]').ifixpng();

    $('#flashMessage').click(function(){$(this).hide()}).delay(1200).fadeOut(800);

    $('#filemanager_actions .filemanager_form').hide();
    $('#_newfolder').click(function(){
        open_action('newfolder');
        return false;
    });
    $('#_newfile').click(function(){
        open_action('newfile');
        return false;
    });
    $('#_tree').click(function(){
        open_action('tree');
        return false;
    });

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

    $('.file_resource a').click(function()
    {
        var href = $(this).attr('href');

        window.opener.CKEDITOR.tools.callFunction(<?php echo $ckeditorfuncnum ?>, href);

        window.close();
        return false;
    });

});
//]]>
</script>
<?php echo $scripts_for_layout ?>

</head>
<body>
    <div id="container">
        <div id="header">
            <h1>Digigas</h1>
        </div>

        <div id="topmenu">

        </div>

        <div id="contentwrapper"><div id="content">
            <?php
            if ($this->Session->check('Message.flash'))
            {
                echo '<div class="flashMessage">';
                $this->Session->flash();
                echo '</div>';
            }
            echo $content_for_layout;
            ?>
        </div></div>
        <div id="footer">
            <span><?php //echo $html->link('&copy; IDEAEDI ', 'http://www.ideaedi.it', array('target'=>'_blank'),false,false ); ?></span>
        </div>
    </div>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>