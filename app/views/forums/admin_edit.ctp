<div class="forums form">
<?php echo $this->Form->create('Forum');?>
	<fieldset>
 		<h2><?php __('Modifica forum'); ?></h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('weight', array(
			'label' => 'Importanza',
			'after' => ' Determina la posizione nella lista dei forum',
			'options' => array(
				'1 - poco importante', '2', '3', '4', '5 - normale', '6', '7', '8', '9', '10 - molto importante'
			)));
		echo $this->Form->input('name', array('label' => 'Nome del forum'));
		echo $this->Form->input('text', array('label' => 'Descrizione'));
		echo $this->Form->input('access_level', array(
			'label' => 'Livello di accesso',
			'options' => Configure::read('roles'),
			'after' => ' Gli utenti di livello superiore possono accedere al forum'));
		echo $this->Form->input('active', array('label' => 'Attivo'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
	<h3><?php __('Azioni'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Torna all\'elenco dei forum', true), array('action' => 'index'));?></li>
	</ul>
</div>