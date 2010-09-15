<div class="hampers index">
	<h2><?php __('Nessun paniere disponibile');?></h2>
    <?php __('Spiacente, in questo momento non c\'è nessun paniere disponibile.'); ?>
</div>

<div class="actions">
    <?php echo $this->element('user_order', array('userOrder' => $userOrder)); ?>
    <ul>
        <li><?php echo $this->Html->link(__('Vai alla tua pagina ordini', true), array('controller' => 'ordered_products', 'action' => 'index')); ?></li>
    </ul>
</div>