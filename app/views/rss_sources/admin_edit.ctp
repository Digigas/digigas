<div class="rssSources form">
<?php echo $this->Form->create('RssSource');?>
	<fieldset>
 		<h2><?php __('Modifica collegamento a un feed RSS') ?></h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('label' => 'Titolo', 'after' => 'Compare online'));
		echo $this->Form->input('website_name', array('label' => 'Nome del sito'));
		echo $this->Form->input('url', array('label' => 'URL del feed'));
		echo $this->Form->input('weight', array(
			'label' => 'Livello di importanza',
			'after' => ' (Determina l\'ordine di pubblicazione)',
			'options' => array('1 - molto importante','2','3','4','5 - normale','6','7','8','9','10 - poco importante')));
		echo $this->Form->input('active', array('label' => 'Pubblicato'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('indietro', true), array('action' => 'index'));?></li>
	</ul>
</div>