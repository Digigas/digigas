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

	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link('Digigas3', '/'); ?></h1>
		</div>
        <div id="tools">
            <ul>
                <li><?php echo $this->Html->link('Logout', '/users/logout'); ?></li>
            </ul>
        </div>
        <div id="navigation">
            <ul>
                <li><?php echo $this->Html->link('Prodotti', '/'); ?></li>
                <li><?php echo $this->Html->link('Panieri', '/'); ?></li>
                <li><?php echo $this->Html->link('Ordini', '/'); ?></li>
                <li><?php echo $this->Html->link('Utenti', '/'); ?></li>
            </ul>
        </div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>

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
        echo $this->Javascript->link('ckeditor/ckeditor');
        echo $this->Javascript->link('ckeditor/adapters/jquery');

		echo $scripts_for_layout;

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
        });
    //]]>
    </script>

	<?php echo $this->element('sql_dump'); ?>
</body>
</html>

