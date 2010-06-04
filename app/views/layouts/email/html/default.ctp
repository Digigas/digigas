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
        <title><?php echo $title_for_layout;?></title>

        <style type="text/css">

            body
            {
                margin:0;
                padding:0;
                color:#333;
            }
            h1
            {
                font-size:18px;
            }
            table
            {
                width:100%;
            }
            th 
            {
                border-bottom:2px solid #999;
                padding:5px;
            }
            td
            {
                border-bottom:1px solid #ccc;
                padding:3px;
            }
            .content
            {
                padding:20px;
            }
            .footer
            {
                background:#7CAF00; color:#fff; padding:10px 20px; font-size:10px; text-align:right;
            }
        </style>
    </head>
    <body>
        <div class="content">
        <?php echo $content_for_layout;?>
        </div>
        <div class="footer">Email inviata tramite <?php echo $this->Html->link('digigas3', 'http://'.$_SERVER['HTTP_HOST']); ?></div>
    </body>
</html>