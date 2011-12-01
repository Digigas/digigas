<div class="orderedProducts form">

	<h2><?php __('Modifica ordine'); ?>
		(<?php echo $this->data['Product']['name'] . ' ' . __('di', true) . ' ' . $this->data['User']['fullname'] . ' ' . __('in consegna entro', true) . ' ' . digi_date($this->data['Hamper']['delivery_date_off']) ?>)</h2>

	<?php echo $this->Form->create('OrderedProduct'); ?>
	<fieldset>
        <dl>
            <dt class="altrow"><?php __('Utente'); ?></dt>
            <dd class="altrow">
				<?php echo $this->data['User']['fullname']; ?>
                &nbsp;
            </dd>

            <dt><?php __('Paniere'); ?></dt>
            <dd>
				<?php echo $this->data['Hamper']['name']; ?>
                &nbsp;
            </dd>

            <dt class="altrow"><?php __('Termine consegna'); ?></dt>
            <dd class="altrow">
				<?php echo digi_date($this->data['Hamper']['delivery_date_off']); ?>
                &nbsp;
            </dd>

            <dt><?php __('Produttore'); ?></dt>
            <dd>
				<?php echo $this->data['Seller']['name']; ?>
                &nbsp;
            </dd>

            <dt class="altrow"><?php __('Prodotto'); ?></dt>
            <dd class="altrow">
				<?php echo $this->data['Product']['name']; ?>
                &nbsp;
            </dd>           

        </dl>
		<?php
				echo $this->Form->hidden('Referer.', array('value' => $referer));
				echo $this->Form->input('id');
				echo $this->Form->input('quantity', array('label' => __('Quantità', true) . ' ' . $this->data['Product']['units']));

				if ($this->data['Product']['option_list_1']) {
					$options = array();
					foreach (explode(';', $this->data['Product']['option_list_1']) as $opt) {
						$options[$opt] = $opt;
					}

					echo $this->Form->input('option_1', array('label' => $this->data['Product']['option_1'], 'options' => $options, 'type' => 'select'));
				}

				if ($this->data['Product']['option_list_2']) {
					$options = array();
					foreach (explode(';', $this->data['Product']['option_list_2']) as $opt) {
						$options[$opt] = $opt;
					}
					echo $this->Form->input('option_2', array('type' => 'select', 'options' => $options, 'label' => $this->data['Product']['option_2']));
				}

				echo $this->Form->input('value', array('label' => __('Costo totale', true)));
                                echo $this->Form->checkbox('do_not_recalculate', array('label' => __('Forza valore')));
				echo $this->Form->input('paid', array('label' => __('Pagato', true)));
				echo $this->Form->input('retired', array('label' => __('Ritirato', true)));

				if ($this->data['Product']['show_note']) {
					echo $this->Form->input('note', array('label' => __('Note', true)));
				}
		?>
			</fieldset>
	<?php echo $this->Form->end(__('Salva', true)); ?>
			</div>
			<div class="actions">
				<h3><?php __('Azioni'); ?></h3>
				<ul>
					<li><?php echo $this->Html->link(__('<< indietro', true), $referer); ?></li>
			        <li><?php echo $this->Html->link(__('Elimina questo ordine', true), array('action' => 'delete', $this->Form->value('OrderedProduct.id')), null, __('Sei sicuro di eliminare l\'ordine?', true)); ?></li>
    </ul>
</div>