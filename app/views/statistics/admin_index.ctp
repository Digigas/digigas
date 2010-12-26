<div class="statistics index">
	<h2>Statistiche</h2>

	<?php if(count($years) > 1): ?>
	<ul class="submenu">
		<?php foreach($years as $_year): ?>
		<li><?php echo $this->Html->link($_year, array('action' => $this->action, $_year)); ?></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<h3>Spesa totale per produttore nel <?php echo $year; ?></h3>
	<table>
		<tr>
			<th>Produttore</th>
			<th>Spesa</th>
			<th>N° di ordini</th>
		</tr>
	<?php
	foreach($totalBySellerThisYear as $seller) {
		$return = $this->Html->tag('td', $seller['Seller']['name']);
		$return .= $this->Html->tag('td', $seller['0']['total'] . ' &euro;');
		$return .= $this->Html->tag('td', $seller['0']['orders']);
		echo $this->Html->tag('tr', $return);
	}
	?>
	</table>

	<?php if(!empty($totalBySellerLastYear)): ?>
	<h3>Spesa totale per produttore nel <?php echo date('Y', strtotime($year . ' -1 year')); ?></h3>
	<table>
		<tr>
			<th>Produttore</th>
			<th>Spesa</th>
			<th>N° di ordini</th>
		</tr>
	<?php
	foreach($totalBySellerLastYear as $seller) {
		$return = $this->Html->tag('td', $seller['Seller']['name']);
		$return .= $this->Html->tag('td', $seller['0']['total'] . ' &euro;');
		$return .= $this->Html->tag('td', $seller['0']['orders']);
		echo $this->Html->tag('tr', $return);
	}
	?>
	</table>
	<?php endif; ?>

	<h3>Totale mensile per produttore nel <?php echo $year; ?></h3>
	<?php foreach($monthlyBySeller as $seller): ?>
	<div class="item">
		<h4><?php echo $seller['name'] ?></h4>
		<?php
		if(!empty($seller['months'])):
			foreach($seller['months'] as $month => $value): ?>

			<div class="item-name"><?php echo monthToString($month); ?></div>
			<div class="item-value"><?php echo $value; ?> &euro;</div>
			
		<?php 
			endforeach;
		else:
			echo $this->Html->div('item-name', '&nbsp;');
			echo $this->Html->div('item-value', __('Nessun acquisto', true));
		endif;
		?>
	</div>
	<?php endforeach; ?>

</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Pannello strumenti', true), array('controller' => 'tools')); ?></li>
		<li><?php echo $this->Html->link(__('Statistiche per utente', true), array('controller' => 'statistics', 'action' => 'admin_monthly_by_user')); ?></li>
	</ul>
</div>