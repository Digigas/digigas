<div class="orderedProducts form">

 		<h2><?php __('Modifica ordine'); ?>
            (<?php echo $this->data['Product']['name'].' '. __('di', true).' '.$this->data['User']['fullname'].' '.__('in consegna entro', true).' '.digi_date($this->data['Hamper']['delivery_date_off']) ?>)</h2>
        
<?php echo $this->Form->create('OrderedProduct');?>
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
		echo $this->Form->input('id');
		echo $this->Form->input('quantity', array('label' => __('Quantità', true)));
		echo $this->Form->input('value', array('label' => __('Costo totale', true)));
		echo $this->Form->input('paid', array('label' => __('Pagato', true)));
		echo $this->Form->input('retired', array('label' => __('Ritirato', true)));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
	<h3><?php __('Azioni'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('<< Torna agli ordini', true), array('action' => 'index'));?></li>
        <li><?php echo $this->Html->link(__('Elimina questo ordine', true), array('action' => 'delete', $this->Form->value('OrderedProduct.id')), null, __('Sei sicuro di eliminare l\'ordine?', true)); ?></li>
    </ul>
</div>