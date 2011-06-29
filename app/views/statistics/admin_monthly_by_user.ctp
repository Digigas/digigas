<div class="statistics index">
	<h2>Statistiche</h2>

	<?php if(count($years) > 1): ?>
	<ul class="submenu">
		<?php foreach($years as $_year): ?>
		<li><?php echo $this->Html->link($_year, array('action' => $this->action, $_year)); ?></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<h3>Spesa totale per utente nel <?php echo $year; ?></h3>
	<table>
		<tr>
			<th>Utente</th>
			<th>Spesa</th>
			<th>N° di acquisti</th>
		</tr>
	<?php
	foreach($totalByUserThisYear as $user) {
		$return = $this->Html->tag('td', $user['User']['first_name'] . ' ' . $user['User']['last_name']);
		$return .= $this->Html->tag('td', $user['0']['total'] . ' &euro;');
		$return .= $this->Html->tag('td', $user['0']['orders']);
		echo $this->Html->tag('tr', $return);
	}
	?>
	</table>

	<?php if(!empty($totalByUserLastYear)): ?>
	<h3>Spesa totale per utente nel <?php echo date('Y', strtotime($year . ' -1 year')); ?></h3>
	<table>
		<tr>
			<th>Utente</th>
			<th>Spesa</th>
			<th>N° di acquisti</th>
		</tr>
	<?php
	foreach($totalByUserLastYear as $user) {
		$return = $this->Html->tag('td', $user['User']['first_name'] . ' ' . $user['User']['last_name']);
		$return .= $this->Html->tag('td', $user['0']['total'] . ' &euro;');
		$return .= $this->Html->tag('td', $user['0']['orders']);
		echo $this->Html->tag('tr', $return);
	}
	?>
	</table>
	<?php endif; ?>

	<h3>Totale mensile per utente nel <?php echo $year; ?></h3>
	<?php foreach($monthlyByUser as $user): ?>
	<div class="item">
		<h4><?php echo $user['name']; ?></h4>
		<div class="item-name">
			Numero di ordini
		</div>
		<div class="item-value">
			<?php echo $user['orders']; ?>
		</div>
		<?php
		if(!empty($user['months'])):
			foreach($user['months'] as $month => $value): ?>

			<div class="item-name"><?php echo monthToString($month); ?></div>
			<div class="item-value"><?php echo $value; ?> &euro;</div>

		<?php
			endforeach;
		endif;
		?>
	</div>
	<?php endforeach; ?>

</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Statistiche generali', true), array('controller' => 'statistics', 'action' => 'index')); ?></li>
	</ul>
</div>