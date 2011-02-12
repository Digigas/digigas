<div class="moneyBoxes index">
	<h2><?php __('Dettaglio delle spese');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort(__('Data', true), 'created');?></th>
			<th><?php __('Causale'); ?></th>
			<th><?php __('Importo');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($moneyBoxes as $moneyBox):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
        <td><?php echo digi_date($moneyBox['MoneyBox']['created']); ?>&nbsp;</td>
		<td>
			<?php echo $moneyBox['MoneyBox']['text']; ?>
		</td>
		<td><?php 
        if($moneyBox['MoneyBox']['value_in'] != '0.00') {
            echo $this->Html->div('money-in', '+ '.$moneyBox['MoneyBox']['value_in'].' &euro;');
        } else {
            echo $this->Html->div('money-out', '- '.$moneyBox['MoneyBox']['value_out'].' &euro;');
        }
        ?>
        </td>
	</tr>
<?php endforeach; ?>
    <tr>
        <td colspan="2"><strong><?php __('Totale'); ?></strong></td>
        <td><strong><?php echo $total; ?> &euro;</strong></td>
    </tr>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%, riga da %start% a %end% di %count%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('precedente', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('successiva', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Continua gli acquisti', true), array('controller' => 'hampers', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('I tuoi ordini attuali', true), array('controller' => 'ordered_products', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('Storico dei tuoi ordini', true), array('controller' => 'ordered_products', 'action' => 'past_orders')); ?></li>
    </ul>
</div>