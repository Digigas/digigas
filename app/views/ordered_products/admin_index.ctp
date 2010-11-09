
<div class="export-tools">
    <div class="openclose">
		<?php echo $this->Html->image('oxygen/16x16/actions/tool2.png'); ?>
    </div>
    <ul class="toolslist">
        <li><?php
		echo $this->Html->image('oxygen/16x16/actions/mail_generic.png');
		echo $this->Html->link(__('email agli utenti', true), array('action' => 'mass_mail_orders_to_users'));
		?></li>
        <li>
			<?php
			echo $this->Html->image('oxygen/16x16/actions/mail_generic.png');
			echo $this->Html->link(__('email ai produttori', true), array('action' => 'mass_mail_orders_to_sellers'));
			?></li>
        <!-- <li><?php
			echo $this->Html->image('oxygen/16x16/mimetypes/application_vnd.ms_excel.png');
			echo $this->Html->link(__('salva in excel', true), array());
			?></li> -->
		</ul>
	</div>

	<div class="orderedProducts index">
		<h2><?php __('Ordini pendenti'); ?></h2>

		<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => __('Pagina %page% di %pages% pagine, %count% ordini totali', true)
			));
		?>	</p>

		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo $this->Paginator->sort(__('Acquirente', true), 'user_id'); ?></th>
				<th><?php echo $this->Paginator->sort(__('Produttore', true), 'seller_id'); ?></th>
				<th><?php echo $this->Paginator->sort(__('Prodotto', true), 'product_id'); ?></th>
				<th><?php echo $this->Paginator->sort(__('Quantità', true), 'quantity'); ?></th>
				<th><?php echo $this->Paginator->sort(__('Totale', true), 'value'); ?></th>
				<th><?php echo $this->Paginator->sort(__('Consegna', true), 'hamper_id'); ?></th>
				<th class="actions"><?php echo $this->Paginator->sort(__('Pagato', true), 'paid'); ?></th>
				<th class="actions"><?php echo $this->Paginator->sort(__('Ritirato', true), 'retired'); ?></th>
				<th class="actions"><?php __('Azioni') ?></th>
			</tr>
		<?php
			$i = 0;
			foreach ($orderedProducts as $orderedProduct):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
		?>
				<tr<?php echo $class; ?>>
					<td>
				<?php echo $this->Html->link($orderedProduct['User']['fullname'], array('action' => 'index_user', $orderedProduct['User']['id'])); ?>
            </td>
            <td>
				<?php echo $this->Html->link($orderedProduct['Seller']['name'], array('action' => 'index_seller', $orderedProduct['Seller']['id'])); ?>
            </td>
            <td>
				<?php
				echo $orderedProduct['Product']['name'];

				$details = '';
				if (!empty($orderedProduct['Product']['option_1'])) {
					$details .= $orderedProduct['Product']['option_1'] . ": <strong>" . $orderedProduct['OrderedProduct']['option_1'] . "</strong>";
				}
				if (!empty($orderedProduct['Product']['option_2'])) {
					$details .= " | ";
					$details .= $orderedProduct['Product']['option_2'] . ":  <strong>" . $orderedProduct['OrderedProduct']['option_2'] . "</strong>";
				}
				if ($orderedProduct['OrderedProduct']['note']) {
					$details .= "<br/>";
					$details .= '(' . $orderedProduct['OrderedProduct']['note'] . ')';
				}
				if (!empty($details)) {
					echo $html->div('product_details', $details);
				}
				?>
            </td>            
            <td>
				<?php echo $orderedProduct['OrderedProduct']['quantity']; ?>
				&nbsp;
				<?php echo $orderedProduct['Product']['units']; ?>
			</td>
            <td><?php echo $orderedProduct['OrderedProduct']['value']; ?>&nbsp;&euro;</td>
            <td>
				<?php
				if (!date_is_empty($orderedProduct['Hamper']['delivery_date_on'])) {
					echo $this->Html->link(date('d/m/Y', strtotime($orderedProduct['Hamper']['delivery_date_on'])), array('action' => 'index_hamper', $orderedProduct['Hamper']['id']), array('title' => __('visualizza gli ordini di questo paniere', true)));
				} else {
					echo $this->Html->link(__('Data non assegnata', true), array('action' => 'index_hamper', $orderedProduct['Hamper']['id']), array('title' => __('visualizza gli ordini di questo paniere', true)));
				}
				?>
            </td>
            <td class="actions"><?php
				if ($orderedProduct['OrderedProduct']['paid']) {
					echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_paid', $orderedProduct['OrderedProduct']['id'])));
				} else {
					echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_paid', $orderedProduct['OrderedProduct']['id'])));
				}
				?></td>
            <td class="actions"><?php
				if ($orderedProduct['OrderedProduct']['retired']) {
					echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_retired', $orderedProduct['OrderedProduct']['id'])));
				} else {
					echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_retired', $orderedProduct['OrderedProduct']['id'])));
				}
				?></td>
            <td>
				<?php echo $this->Html->image('oxygen/16x16/actions/edit.png', array('url' => array('action' => 'edit', $orderedProduct['OrderedProduct']['id']), 'title' => __('modifica', true))); ?>
            </td>
        </tr>
		<?php endforeach; ?>
			</table>


			<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')); ?>
									 | 	<?php echo $this->Paginator->numbers(); ?>
								        |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
			</div>

			<br/>
			<h2><?php __('Ultimi ordini archiviati'); ?></h2>

			<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Acquirente'); ?></th>
					<th><?php __('Produttore'); ?></th>
					<th><?php __('Prodotto'); ?></th>
					<th><?php __('Quantità'); ?></th>
					<th><?php __('Totale'); ?></th>
					<th class="actions"><?php __('Pagato'); ?></th>
					<th class="actions"><?php __('Ritirato'); ?></th>
					<th class="actions"><?php __('Azioni'); ?></th>
				</tr>
		<?php
				$i = 0;
				foreach ($lastModified as $orderedProduct):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
		?>
					<tr<?php echo $class; ?>>
						<td>
				<?php echo $this->Html->link($orderedProduct['User']['fullname'], array('action' => 'index_user', $orderedProduct['User']['id'])); ?>
				</td>
				<td>
				<?php echo $this->Html->link($orderedProduct['Seller']['name'], array('action' => 'index_seller', $orderedProduct['Seller']['id'])); ?>
				</td>
				<td>
				<?php echo $this->Html->link($orderedProduct['Product']['name'], array('controller' => 'products', 'action' => 'view', $orderedProduct['Product']['id'], 'admin' => false)); ?>
				</td>
				<td>
					<?php echo $orderedProduct['OrderedProduct']['quantity']; ?>
					&nbsp;
					<?php echo $orderedProduct['Product']['units']; ?>
				</td>
				<td><?php echo $orderedProduct['OrderedProduct']['value']; ?>&nbsp;&euro;</td>
				<td class="actions"><?php
					if ($orderedProduct['OrderedProduct']['paid']) {
						echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_paid', $orderedProduct['OrderedProduct']['id'])));
					} else {
						echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_paid', $orderedProduct['OrderedProduct']['id'])));
					}
				?></td>
				<td class="actions"><?php
					if ($orderedProduct['OrderedProduct']['retired']) {
						echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_retired', $orderedProduct['OrderedProduct']['id'])));
					} else {
						echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_retired', $orderedProduct['OrderedProduct']['id'])));
					}
				?></td>
				<td>
				<?php echo $this->Html->image('oxygen/16x16/actions/edit.png', array('url' => array('action' => 'edit', $orderedProduct['OrderedProduct']['id']), 'title' => __('modifica', true))); ?>
				</td>
			</tr>
		<?php endforeach; ?>
				</table>

			</div>
			<div class="actions">
				<h3><?php __('Actions'); ?></h3>
				<ul>
					<li class="dropdown"><?php __('Vedi ordini per acquirente'); ?>
						<ul>
				<?php foreach ($users as $id => $user): ?>
						<li><?php echo $this->Html->link($user, array('action' => 'index_user', $id)); ?></li>
				<?php endforeach; ?>
					</ul>
				</li>
				<li class="dropdown"><?php __('Vedi ordini per produttore'); ?>
					<ul>
				<?php foreach ($sellers as $id => $seller): ?>
							<li><?php echo $this->Html->link($seller, array('action' => 'index_seller', $id)); ?></li>
				<?php endforeach; ?>
						</ul>
					</li>
					<li class="dropdown"><?php __('Vedi ordini per paniere'); ?>
						<ul>
				<?php foreach ($hampers as $id => $hamper): ?>
								<li><?php echo $this->Html->link($hamper, array('action' => 'index_hamper', $id)); ?></li>
				<?php endforeach; ?>
							</ul>
						</li>
						<li>
			<?php echo $this->Html->link(__('Fai un ordine per un utente', true), array('controller' => 'ordered_products', 'action' => 'order_for_user')); ?>
							</li>
							<li><?php echo $this->Html->link(__('Comandi rapidi', true), array('action' => 'mass_actions')); ?></li>
    </ul>
</div>