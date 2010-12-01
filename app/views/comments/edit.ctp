<div class="comments form">
<?php echo $this->Form->create('Comment');?>
	<fieldset>
 		<h2><?php __('Modifica commento') ?></h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('text', array('label' => 'Testo'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
	<h3><?php __('Azioni'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('<< indietro', true), $referer);?></li>
	</ul>
</div>