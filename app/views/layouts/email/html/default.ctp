<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts.email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head>
        <title><?php echo $title_for_layout; ?></title>
    </head>
    <body style="margin:0; padding:0;">
		<div style="margin:0;
                padding:0;
                color:#333;
				font-family: Arial, sans-serif;
				font-size: 12px;">
			<div class="header" style="background:#7CAF00; color:#fff; padding:10px 20px; font-size:20px; text-align:left;">
				<?php
				echo Configure::read('GAS.name');
				?>
			</div>
			<div class="content" style="padding:20px;">
				<?php echo $content_for_layout; ?>
			</div>
			<div class="footer" style="background:#7CAF00; color:#fff; padding:10px 20px; font-size:10px; text-align:right;">
				Email inviata tramite <?php echo $this->Html->link('digigas3', 'http://' . $_SERVER['HTTP_HOST']); ?>
			</div>
		</div>
	</body>
</html>