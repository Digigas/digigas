
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

		<li><a href="<?php echo $this->Html->url(array('controller' => 'ordered_products', 'action' => 'print_excel_hamper', $hamper['Hamper']['id'])); ?>">
				<?php echo $this->Html->image('oxygen/16x16/mimetypes/application_vnd.ms_excel.png'); ?>
				<?php __('Salva in Excel'); ?>
		<li><?php
				echo $this->Html->image('oxygen/16x16/actions/mail_generic.png');
				echo $this->Html->link(__('email agli utenti', true), array('action' => 'admin_mail_hamper_to_users', $hamper['Hamper']['id'])); ?></li>
                <li><?php
				echo $this->Html->image('oxygen/16x16/actions/mail_generic.png');
				echo $this->Html->link(__('PDF agli utenti', true), array('controller' => 'hampers',  'action' => 'admin_mail_to_users', $hamper['Hamper']['id'])); ?></li>
		</ul>
	</div>

	<div class="orderedProducts index">
		<h2>
		<?php
				__('Ordini per il paniere ');
				echo $hamper['Hamper']['name'];
				__(' di ');
				echo $hamper['Seller']['name'];
				if (!date_is_empty($hamper['Hamper']['delivery_date_on'])) {
					__(' in consegna ');
					echo digi_date($hamper['Hamper']['delivery_date_on']);
				}
		?>
			</h2>

			<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Prodotto'); ?></th>
					<th><?php __('Codice'); ?></th>
					<th><?php __('Categoria'); ?></th>
					<th><?php __('Quantità'); ?></th>
                                        <th><?php __('Colli'); ?></th>
					<th><?php __('Totale'); ?></th>
				</tr>

		<?php foreach ($totals as $product): ?>
					<tr class="total">
						<td class="name">
				<?php
					echo $product['Product']['name'];

					$details = '';
					if (!empty($product['OrderedProduct']['option_1'])) {
						$details .= $product['Product']['option_1'] . ': ' . $product['OrderedProduct']['option_1'];
					}
					if (!empty($product['OrderedProduct']['option_2'])) {
						$details .= ' | ' . $product['Product']['option_2'] . ': ' . $product['OrderedProduct']['option_2'];
					}
					if (!empty($product['OrderedProduct']['note'])) {
						$details .= '<br/>' . $product['OrderedProduct']['note'];
					}
					if (!empty($details)) {
						echo $html->div('product_details', $details);
					}
				?>
				</td>
				<td>
				<?php echo $product['Product']['code']; ?>&nbsp;
				</td>
				<td class="product_category">
				<?php echo $product['Product']['ProductCategory']['name']; ?>
				</td>
				<td class="quantity">
				<?php echo clean_number($product['0']['quantity']); ?>
					&nbsp;
				<?php echo $product['Product']['units']; ?>
				</td>
				
                                <?php
                                $items_in_a_box = $product['Product']['items_in_a_box'];
                                $boxes='';
                                $class = '';
                                if($items_in_a_box)
                                {
                                    $modulus = ($product['0']['quantity'])%($items_in_a_box);
                                    $boxes = ($product['0']['quantity']-$modulus)/($items_in_a_box);
                                    if($modulus) {
                                        $boxes .= " + ".$modulus;
                                        $class = 'style= "color: red"';
                                    }
                                }

                                ?>
                                <td class="quantity" <?php echo $class; ?>><?php echo $boxes; ?> </td>
                                <td class="value"><?php echo $product['0']['total']; ?> &euro;</td>
			</tr>
		<?php endforeach; ?>
					<tr>
						<td colspan="4">
							<strong><?php __('Totale') ?></strong>
						</td>
						<td></td>
						<td>
							<strong><?php echo $total; ?> &euro;</strong>
						</td>
					</tr>
				</table>

				<h2>
		<?php
					__('Dettaglio per prodotto');
		?>
				</h2>

	<?php  foreach ($orderedProducts as $products): ?>
						<h3>
		<?php

						echo $products['Product']['name'];
                                                $details = '';
                                                if (!empty($products['Product']['option_1'])) {
                                                        $details .= $products['Product']['option_1'] . ': ' . $products['Product']['option_1_value'];
                                                }
                                                if (!empty($products['Product']['option_2'])) {
                                                        $details .= ' | ' . $products['Product']['option_2'] . ': ' . $products['Product']['option_2_value'];
                                                }
                                                if (!empty($details)) {
                                                        echo $html->div('product_details', $details);
                                                }
		?>
					</h3>
					<table cellpadding="0" cellspacing="0">
						<tr>
							<th><?php __('Utente'); ?></th>
							<th class="small-w"><?php __('Quantità'); ?></th>
							<th class="small-w"><?php __('Totale'); ?></th>
							<th class="actions small-w"><?php __('Pagato'); ?></th>
							<th class="actions small-w"><?php __('Ritirato'); ?></th>
							<th class="actions"><?php __('Azioni') ?></th>
						</tr>
		<?php
                    				$i = 0;
                                                
						foreach ($products['OrderedProduct'] as $product):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
		?>
							<tr<?php echo $class; ?>>
								<td>
				<?php
							echo $product['User']['fullname'];

							
				?>

						</td>
						
						<td>
				<?php echo clean_number($product['OrderedProduct']['quantity']); ?>&nbsp;
				<?php echo $product['Product']['units']; ?>
						</td>
						<td><?php echo $product['OrderedProduct']['value']; ?>&nbsp;&euro;</td>
						<td class="actions"><?php
							if ($product['OrderedProduct']['paid']) {
								echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_paid', $product['OrderedProduct']['id'])));
							} else {
								echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_paid', $product['OrderedProduct']['id'])));
							}
				?></td>
						<td class="actions"><?php
							if ($product['OrderedProduct']['retired']) {
								echo $this->Html->image('oxygen/16x16/actions/apply.png', array('url' => array('action' => 'set_not_retired', $product['OrderedProduct']['id'])));
							} else {
								echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('url' => array('action' => 'set_retired', $product['OrderedProduct']['id'])));
							}
				?></td>
						<td class="actions">
				<?php echo $this->Html->image('oxygen/16x16/actions/edit.png', array('url' => array('controller'=>'orderedProducts',  'action' => 'edit', $product['OrderedProduct']['id']), 'title' => __('modifica', true))); ?>
			            </td>
					</tr>
		<?php endforeach; ?>
							<tr>
								<td colspan="1">
									<strong><?php __('Totale'); ?></strong>
								</td>
								<td></td>
								<td>
									<strong><?php echo $products['Total']; ?> &euro;</strong>
								</td>
								<td colspan="3"></td>
							</tr>
						</table>
	<?php endforeach; ?>

						</div>
						<div class="actions">
							<h3><?php __('Actions'); ?></h3>
							<ul>
								<li><?php echo $this->Html->link('<< ' . __('indietro', true), $referer); ?></li>
								<li><?php echo $this->Html->link(__('Tutti gli ordini pendenti', true), array('action' => 'index')); ?></li>
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
    </ul>
</div>
