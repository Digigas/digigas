
<div class="export-tools">
    <div class="openclose">
        <?php echo $this->Html->image('oxygen/16x16/actions/tool2.png'); ?>
    </div>
    <ul class="toolslist">
        <li><?php
        echo $this->Html->image('oxygen/16x16/actions/mail_generic.png');
        echo $this->Html->link(__('email al fornitore', true), array('action' => 'mail_orders_to_seller', $seller['Seller']['id'])); ?></li>
        <li><a href="" onclick = "window.print(); return false;">
            <?php echo $this->Html->image('oxygen/16x16/devices/printer.png'); ?>
            <?php __('Stampa'); ?>
            </a></li>
    </ul>
</div>

<div class="orderedProducts index">
	<h2>
    <?php
    __('Ordini pendenti per ');
    echo $seller['Seller']['name'];
    ?>
    </h2>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Prodotto'); ?></th>
            <th><?php __('Quantità'); ?></th>
            <th><?php __('Totale'); ?></th>
            <th><?php __('Data di consegna'); ?></th>
        </tr>
    <?php foreach($totals as $product): ?>
        <tr class="total">
            <td class="name"><?php echo $product['Product']['name']; ?></td>
            <td class="quantity"><?php echo $product['0']['quantity']; ?></td>
            <td class="value"><?php echo $product['0']['total']; ?> &euro;</td>
            <td class="date"><?php echo digi_date($product['Hamper']['delivery_date_on']); ?></td>
        </tr>
    <?php endforeach; ?>
    </table>

    <h2>
    <?php
    __('Totali per consegna');
    ?>
    </h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Data di consegna'); ?></th>
            <th><?php __('Totale'); ?></th>
        </tr>
    <?php foreach($totalsByHamper as $date => $total): ?>
        <tr class="total">
            <td class="date"><?php echo digi_date($date); ?></td>
            <td class="value"><?php echo $total; ?> &euro;</td>
        </tr>
    <?php endforeach; ?>
    </table>

    <h2>
    <?php
    __('Dettaglio');
    ?>
    </h2>
    
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('Acquirente');?></th>
			<th><?php __('Prodotto');?></th>
			<th><?php __('Quantità');?></th>
			<th><?php __('Totale');?></th>
			<th class="actions"><?php __('Pagato');?></th>
			<th class="actions"><?php __('Ritirato');?></th>
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
			<?php echo $this->Html->link($orderedProduct['User']['fullname'], array('action' => 'index_user', $orderedProduct['User']['id'])); ?>
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