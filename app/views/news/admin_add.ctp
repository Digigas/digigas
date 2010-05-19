<div class="news form">
<h2>Nuova news</h2>
<?php echo $form->create('News', array('enctype'=>'multipart/form-data'));?>
	<fieldset>
	<h3 class="expander">Contenuto</h3>
	<div class="accordion">
	<?php
		echo $form->input('newscategory_id', array('label'=>'Categoria'));
		echo $form->input('title', array('label'=>'Titolo'));
		echo $form->input('summary', array('label'=>'Abstract'));
		echo $form->input('text', array('label'=>'Testo'));
	?>
	</div>

<h3 class="expander">Altro</h3>	
<div class="accordion">
<?php
		echo $form->input('active', array('label'=>'Attiva', 'checked'=>'checked'));

		echo $form->input('date_on', array('type'=>'text', 'class'=>'calendar', 'label'=>'Data di pubblicazione', 'value'=>date('Y-m-d')));
		echo $form->input('date_off', array('type'=>'text', 'class'=>'calendar', 'label'=>'Data di scadenza'));
?>
</div>

	</fieldset>
<?php
echo $form->submit('Salva e continua', array('name'=>'action_edit'));
echo $form->end('Salva');
?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Torna alle news', true), array('action'=>'index'));?></li>
	</ul>
</div>
