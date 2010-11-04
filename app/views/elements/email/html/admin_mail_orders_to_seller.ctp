<div class="date">
<?php __('Inviata il'); ?>:
<?php echo digi_date(date('D j M Y, H:i')); ?>
</div>
<?php echo $this->Html->tag('h1', __('Invio riepilogo ordini', true)); ?>

<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php __('Prodotto'); ?></th>
        <th><?php __('Consegna'); ?></th>
        <th><?php __('Quantità'); ?></th>
        <th><?php __('Totale'); ?></th>
    </tr>
    <?php foreach($totals as $product => $values): ?>
    <tr class="total">
        <td class="name"><?php echo $product; ?></td>
        <td class="date"><?php echo digi_date($values['Hamper']['delivery_date_on']); ?></td>
        <td class="quantity"><?php echo $values['0']['quantity']; ?></td>
        <td class="value"><?php echo $values['0']['total']; ?> &euro;</td>
    </tr>
    <?php endforeach; ?>
</table>