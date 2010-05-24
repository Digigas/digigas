<div class="hampers index">
	<h2><?php __('Panieri aperti');?></h2>

    <div class="filters">
        <h3><?php __('Ordina per'); ?></h3>
			<span><?php echo $this->Paginator->sort(__('Ordine alfabetico', true), 'name');?></span>
			<span><?php echo $this->Paginator->sort(__('Produttore', true), 'seller_id');?></span>
			<span><?php echo $this->Paginator->sort(__('Data di chiusura', true), 'end_date');?></span>
			<span><?php echo $this->Paginator->sort(__('Data di consegna', true), 'delivery_date_on');?></span>
            <div class="clear"></div>
	</div>

    <div id="hampers">
	<?php
	foreach ($hampers as $hamper):
	?>
    <div class="hamper">
		<div class="name">
        <?php
        if(!empty($hamper['Hamper']['name'])) {
            echo $hamper['Hamper']['name'];
        }
        ?>
        </div>
		<div class="seller">
			<?php
            __('Prodotto da ');
            echo $this->Html->link($hamper['Seller']['name'], array('controller' => 'sellers', 'action' => 'view', $hamper['Seller']['id']));
            ?>
		</div>
		<div class="enddate">
            <?php
            __('Puoi effettuare l\'ordine fino a ');
            echo  digi_date($hamper['Hamper']['end_date']);
            ?>
        </div>
		<div class="delivery">
            <?php
            __('In consegna presso ');
            echo $hamper['Hamper']['delivery_position'];
            __(' da ');
            echo  digi_date($hamper['Hamper']['delivery_date_on']);
            __(' a ');
            echo  digi_date($hamper['Hamper']['delivery_date_off']);
            ?>
        </div>
		<div class="options">
			<?php echo $this->Html->link(__('Visualizza e ordina', true), array('action' => 'view', $hamper['Hamper']['id'])); ?>
		</div>
	</div>
<?php endforeach; ?>
	</div>

    <div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
    | 	<?php echo $this->Paginator->numbers();?>
    |   <?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>

</div>

<div class="actions">
    <?php echo $this->element('user_order', array('userOrder' => $userOrder)); ?>
    <ul>
        <li><?php echo $this->Html->link(__('Vai alla tua pagina ordini', true), array('controller' => 'ordered_products', 'action' => 'index')); ?></li>
    </ul>
</div>
