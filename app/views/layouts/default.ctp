<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
        echo $this->Html->css('cake.admin');
        echo $this->Html->css('digigas.print', null, array('media' => 'print'));
        echo $this->Html->css('cake.website');
        echo $this->Html->css('jquery.lightbox');
        echo $this->Html->css('digigas/jquery.treeTable');
        echo $this->Html->css('jquery-ui-1.8.6.custom');

	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->image('digigas.png', array('url' => '/')); ?></h1>
		</div>
        <div id="tools">
            <?php echo $this->element('login_link'); ?>
        </div>
        <div id="navigation">
            <?php
            echo $this->Menu->render(array('levels' => 1));
            ?>
        </div>
		<div id="content">

            <?php 
            if(isset($pageSlug)) {
                echo $this->Html->div('navigation', 
                    $this->Menu->render(array(
                        'startPage' => $pageSlug,
                        'startDepth' => 1
                        )));
            }
            ?>

			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>

            <div class="clear"></div>
		</div>
		<div id="footer">
			<?php echo $this->element('footer'); ?>
		</div>
	</div>

    <?php

        echo $this->Javascript->link('jquery-1.4.3.min');
        echo $this->Javascript->link('jquery.ifixpng');
        echo $this->Javascript->link('jquery-ui-1.8.6.custom.min');
        echo $this->Javascript->link('ckeditor/ckeditor');
        echo $this->Javascript->link('ckeditor/adapters/jquery');
        echo $this->Javascript->link('jquery.lightbox');
        echo $this->Javascript->link('jquery.treeTable.min');
        echo $this->Javascript->link('jquery.asmselect');

		echo $scripts_for_layout;

        $layout->output($js_for_layout);

    ?>

    <script type="text/javascript">
    //<![CDATA[
        $(function(){

            //png fix
            $.ifixpng('<?php echo $this->webroot; ?>img/blank.gif');
            $('img[src$=.png]').ifixpng();

            //CKEditor
            var CKconfig = {
                    filebrowserBrowseUrl : '<?php echo $this->Html->url('/admin/filemanager/ckselect/uploads') ?>',
                    filebrowserImageBrowseUrl : '<?php echo $this->Html->url('/admin/filemanager/ckselect/image') ?>',
                    filebrowserWindowWidth : '100%',
                    filebrowserWindowHeight : '100%'
                };
            $('textarea[class!=plaintext]').ckeditor(CKconfig);

            //calendar
            $('input.calendar').datepicker({
                showOn: "button",
                dateFormat: "yy-mm-dd"
            });

            //tree table
            $('#tree-table').treeTable({
                clickableNodeNames: true,
                expandable: true,
                initialState: "expanded"
                });

            // multiple select
            //$("select[multiple]").asmSelect({highlight: true, animate: true});

            //accordion
            $('.expander:eq(0)').addClass('open');
            $('div.accordion:eq(0)').addClass('open');
            $('div.accordion:gt(0)').hide();
            $('.expander').click(function(){
                $(this).toggleClass('open').next('div.accordion').toggleClass('open').slideToggle();
            })

            //active menu item
            <?php
            if(isset($activemenu_for_layout)) {
                echo '$(".'.$activemenu_for_layout.'").find("a").addClass("active");';
            }
            ?>

            $('#flashMessage').delay('1500').slideUp('slow');

            <?php
            $layout->output($js_on_load_for_layout);
            ?>
        });
    //]]>
    </script>

	<?php echo $this->element('sql_dump'); ?>
</body>
</html>

