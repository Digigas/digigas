<div class="usergroups form">
<?php echo $this->Form->create('Usergroup');?>
	<fieldset>
 		<h2><?php __('Nuovo gruppo'); ?></h2>
	<?php
        echo $this->Form->input('parent_id', array('label' => __('Inserisci all\'interno del gruppo', true), 'empty' => true));
		echo $this->Form->input('name', array('label' => __('Nome del gruppo', true)));
		echo $this->Form->input('text', array('label' => __('Breve descrizione', true)));
		echo $this->Form->input('active', array('label' => __('Attivo', true)));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Torna a gruppi', true), array('action' => 'index'));?></li>
	</ul>
</div>