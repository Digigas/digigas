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
        echo $this->Html->css('jquery.lightbox');
        echo $this->Html->css('digigas/jquery.treeTable');
        echo $this->Html->css('jquery-ui-themeroller');

	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->image('digigas.png', array('url' => '/')); ?></h1>
            <div id="today-date"><?php echo digi_date('now'); ?></div>
		</div>
        <div id="tools">
            <?php echo $this->element('login_link'); ?>
        </div>
        <div id="navigation">
            <ul>
                <li class="products"><?php echo $this->Html->link('Produttori e prodotti', array('controller' => 'sellers', 'action' => 'index')); ?></li>
                <li class="hampers"><?php echo $this->Html->link('Panieri', array('controller' => 'hampers', 'action' => 'index')); ?></li>
                <li class="orders"><?php echo $this->Html->link('Ordini', array('controller' => 'ordered_products', 'action' => 'index')); ?></li>
                <li class="users"><?php echo $this->Html->link('Utenti', array('controller' => 'users', 'action' => 'index')); ?></li>
                <li class="tools"><?php echo $this->Html->link('Strumenti', array('controller' => 'tools', 'action' => 'index')); ?></li>
            </ul>
        </div>
		<div id="content">

			<?php echo $this->Session->flash();?>
			<?php echo $content_for_layout; ?>
            <?php echo $this->Session->flash('email'); //debug emails in debig mode ?>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>

    <?php

        echo $this->Javascript->link('jquery-1.4.2.min');
        echo $this->Javascript->link('jquery.ui');
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

            //menu a tendina
            $('.dropdown').children().hide()
                .end()
                .css({cursor: 'pointer'})
                .click(function(){
                    $(this).toggleClass('open').children().slideToggle();
                });

            //strumenti ausiliari
            $('.export-tools .toolslist').hide();
            $('.export-tools .openclose').css({cursor: 'pointer'}).click(function(){
                $('.export-tools .toolslist').toggle('slow');
            })

            //active menu item
            <?php
            if(isset($activemenu_for_layout)) {
                echo '$(".'.$activemenu_for_layout.'").find("a").addClass("active");';
            }
            ?>
            <?php
            $layout->output($js_on_load_for_layout);
            ?>

            $('#flashMessage').delay('1500').slideUp('slow');
        });
    //]]>
    </script>

	<?php echo $this->element('sql_dump'); ?>
</body>
</html>

