<div class="date">
<?php __('Inviata il'); ?>:
<?php echo digi_date(date('D j M Y, H:i')); ?>
</div>
<?php echo $this->Html->tag('h1', $title); ?>
<?php echo $text; ?>