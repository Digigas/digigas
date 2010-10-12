
<div class="export-tools">
    <div class="openclose">
        <?php echo $this->Html->image('oxygen/16x16/actions/tool2.png'); ?>
    </div>
    <ul class="toolslist">
        <li><a href="" onclick = "window.print(); return false;">
                <?php echo $this->Html->image('oxygen/16x16/devices/printer.png'); ?>
                <?php __('Stampa'); ?>
            </a></li>
		<li><a href="<?php echo $this->Html->url(array('controller' => 'ordered_products', 'action' => 'print_pdf_hamper', $hamper['Hamper']['id'])); ?>">
                <?php echo $this->Html->image('oxygen/16x16/mimetypes/pdf.png'); ?>
                <?php __('Salva in PDF'); ?>
            </a></li>
    </ul>
</div>

<div class="orderedProducts index">
    <h2>
        <?php
        __('Ordini per il paniere ');
        echo $hamper['Hamper']['name'];
		__(' di ');
		echo $hamper['Seller']['name'];
		__(' in consegna ');
		echo digi_date($hamper['Hamper']['delivery_date_on']);
        ?>
    </h2>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Prodotto'); ?></th>
            <th><?php __('Quantità'); ?></th>
            <th><?php __('Totale'); ?></th>
        </tr>
        <?php foreach($totals as $product): ?>
        <tr class="total">
            <td class="name"><?php echo $product['Product']['name']; ?></td>
            <td class="quantity"><?php echo $product['0']['quantity']; ?></td>
            <td class="value"><?php echo $product['0']['total']; ?> &euro;</td>
        </tr>
        <?php endforeach; ?>
		<tr>
			<td colspan="2">
				<strong><?php __('Totale') ?></strong>
			</td>
			<td>
				<strong><?php echo $total; ?> &euro;</strong>
			</td>
		</tr>
    </table>

    <h2>
        <?php
        __('Dettaglio per utente');
        ?>
    </h2>

	<?php foreach($orderedProducts as $products): ?>
	<h3>
		<?php
		echo $products['User']['fullname'];
		?>
	</h3>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Prodotto');?></th>
            <th class="small-w"><?php __('Quantità');?></th>
            <th class="small-w"><?php __('Totale');?></th>
            <th class="actions small-w"><?php __('Pagato');?></th>
            <th class="actions small-w"><?php __('Ritirato');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($products['Products'] as $product):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
        <tr<?php echo $class;?>>
            <td>
                    <?php echo $product['Product']['name']; ?>
            </td>
            <td><?php echo $product['OrderedProduct']['quantity']; ?>&nbsp;</td>
            <td><?php echo $product['OrderedProduct']['value']; ?>&nbsp;&euro;</td>
            <td class="actions"><?php
                    if($product['OrderedProduct']['paid']) {
                        echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_paid', $product['OrderedProduct']['id'])));
                    } else {
                        echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_paid', $product['OrderedProduct']['id'])));
                    }
                    ?></td>
            <td class="actions"><?php
                    if($product['OrderedProduct']['retired']) {
                        echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_retired', $product['OrderedProduct']['id'])));
                    } else {
                        echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_retired', $product['OrderedProduct']['id'])));
                    }
                    ?></td>
        </tr>
        <?php endforeach; ?>
		<tr>
			<td colspan="2">
				<strong><?php __('Totale'); ?></strong>
			</td>
			<td>
				<strong><?php echo $products['Total']; ?> &euro;</strong>
			</td>
			<td colspan="2"></td>
		</tr>
    </table>
	<?php endforeach; ?>

</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
		<li><?php echo $this->Html->link('<< '.__('indietro', true), $referer); ?></li>
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