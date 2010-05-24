<div class="sellers index">
    <h2><?php __('Tutti i produttori');?></h2>

    <?php
    foreach ($sellers as $seller):
        ?>
    <div class="seller">
        <h2>
            <?php echo $this->Html->link($seller['Seller']['name'], array('action' => 'view', $seller['Seller']['id'])); ?>
        </h2>
        <div class="businessname">
                <?php echo $this->Html->link($seller['Seller']['business_name'], array('action' => 'view', $seller['Seller']['id'])); ?>
        </div>
    </div>
    <?php endforeach; ?>

<div class="paging">
    <?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
    |
    <?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Vedi i panieri disponibili', true), array('controller' => 'hampers', 'action' => 'index')); ?> </li>
    </ul>
</div>