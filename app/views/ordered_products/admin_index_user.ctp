<div class="orderedProducts index">
	<h2>
    <?php
    __('Ordini pendenti per l\'acquirente ');
    echo $user['User']['fullname'];
    echo '&nbsp;';
    echo $this->Html->image('oxygen/32x32/actions/mail_mark_unread.png', array(
        'url' => array('action' => 'mail_orders_to_user', $user['User']['id']),
        'title' => __('Invia per email all\'utente', true)));
    ?>
    </h2>

    <p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>
    
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort(__('Produttore', true), 'seller_id');?></th>
			<th><?php echo $this->Paginator->sort(__('Prodotto', true), 'product_id');?></th>
			<th><?php echo $this->Paginator->sort(__('Quantità', true), 'quantity');?></th>
			<th><?php echo $this->Paginator->sort(__('Totale', true), 'value');?></th>
			<th class="actions"><?php echo $this->Paginator->sort(__('Pagato', true), 'paid');?></th>
			<th class="actions"><?php echo $this->Paginator->sort(__('Ritirato', true), 'retired');?></th>
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
			<?php echo $this->Html->link($orderedProduct['Seller']['name'], array('controller' => 'users', 'action' => 'view', $orderedProduct['Seller']['id'], 'admin' => false)); ?>
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
	</table>


	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>

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