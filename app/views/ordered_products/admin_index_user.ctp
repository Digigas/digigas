
<div class="export-tools">
    <div class="openclose">
        <?php echo $this->Html->image('oxygen/16x16/actions/tool2.png'); ?>
    </div>
    <ul class="toolslist">
        <li><?php
        echo $this->Html->image('oxygen/16x16/actions/mail_generic.png');
        echo $this->Html->link(__('email all\' utente', true), array('action' => 'mail_orders_to_user', $user['User']['id'])); ?></li>        
    </ul>
</div>

<div class="orderedProducts index">
	<h2>
    <?php
    __('Ordini pendenti per l\'acquirente ');
    echo $user['User']['fullname'];
    ?>
    </h2>
    
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('Produttore', true);?></th>
			<th><?php __('Prodotto', true);?></th>
			<th><?php __('Quantità', true);?></th>
			<th><?php __('Totale', true);?></th>
			<th class="actions"><?php __('Pagato', true);?></th>
			<th class="actions"><?php __('Ritirato', true);?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orderedProducts as $orderedProduct):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($orderedProduct['Seller']['name'], array('action' => 'index_seller', $orderedProduct['Seller']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderedProduct['Product']['name'], array('controller' => 'products', 'action' => 'view', $orderedProduct['Product']['id'], 'admin' => false)); ?>
		</td>
		<td><?php echo $orderedProduct['OrderedProduct']['quantity']; ?>&nbsp;</td>
		<td><?php echo $orderedProduct['OrderedProduct']['value']; ?>&nbsp;&euro;</td>
		<td class="actions"><?php
        if($orderedProduct['OrderedProduct']['paid']) {
            echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_paid', $orderedProduct['OrderedProduct']['id'])));
        } else {
            echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_paid', $orderedProduct['OrderedProduct']['id'])));
        }
        ?></td>
		<td class="actions"><?php
        if($orderedProduct['OrderedProduct']['retired']) {
            echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_retired', $orderedProduct['OrderedProduct']['id'])));
        } else {
            echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_retired', $orderedProduct['OrderedProduct']['id'])));
        }
        ?></td>
	</tr>
<?php endforeach; ?>
    <tr>
        <td colspan="3">&nbsp;</td>
        <td class="total">
            <strong>
            <?php
            __('Totale');
            echo ': ';
            echo $total;
            echo '&euro;';
            ?>
            </strong>
        </td>
        <td colspan="2">&nbsp;</td>
    </tr>
	</table>

</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
        <li><?php echo $this->Html->link(__('Tutti gli ordini pendenti', true), array('action' => 'index')); ?></li>
        <li class="dropdown"><?php __('Vedi ordini per acquirente'); ?>
            <ul>
                <?php foreach($users as $id => $user): ?>
                <li><?php echo $this->Html->link($user, array('action' => 'index_user', $id)); ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="dropdown"><?php __('Vedi ordini per produttore'); ?>
            <ul>
                <?php foreach($sellers as $id => $seller): ?>
                <li><?php echo $this->Html->link($seller, array('action' => 'index_seller', $id)); ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
	</ul>
</div>