<div class="date" style="background:#7CAF00;
                color:#fff;
                padding:5px 8px;
                width:auto;
                float:right;">
<?php __('Inviata il'); ?>:
<?php echo digi_date(date('D j M Y, H:i')); ?>
</div>

<?php echo $this->Html->tag('h1', $title, array('style' => 'font-size:18px;')); ?>
<?php echo $this->Absolutize->links($this->Absolutize->images($text)); ?>