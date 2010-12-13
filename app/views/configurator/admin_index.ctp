<?php
$this->Javascript->link('jquery.colorInput.min', false);
$this->Layout->blockStart('js_on_load');
echo <<<JS
	$('input.color').colorInput({hideInput : false, hueWidth: '27'});
JS;
$this->Layout->blockEnd();
?>


<div class="index">
	<h2>Configurazione</h2>

	<?php echo $this->Form->create('Configurator', array('type' => 'file', 'url' => array('controller' => 'configurator', 'action' => 'index'))); ?>
	<h3 class="expander">Dati generali</h3>
	<div class="accordion">
		<?php
		echo $this->Form->input('Configurator.GAS.name', array('label' => 'Nome del GAS', 'value' => Configure::read('GAS.name')));
		?>
	</div>

	<h3 class="expander">Aspetto</h3>
	<div class="accordion">
		<?php
		echo $this->Form->input('Configurator.GAS.image', array('label' => 'Logo del GAS', 'type' => 'file'));
		echo $this->Form->input('Configurator.colors.body_background', array('label' => 'Colore di sfondo della pagina', 'class' => 'color', 'value' => Configure::read('colors.body_background')));
		echo $this->Form->input('Configurator.colors.content_background', array('label' => 'Colore di sfondo dei contenuti', 'class' => 'color', 'value' => Configure::read('colors.content_background')));
		echo $this->Form->input('Configurator.colors.h2', array('label' => 'Colore dei titoli', 'class' => 'color', 'value' => Configure::read('colors.text_1')));
		//echo $this->Form->input('Configurator.colors.text_2', array('label' => 'Testo 2', 'class' => 'color', 'value' => Configure::read('colors.text_2')));
		//echo $this->Form->input('Configurator.colors.text_3', array('label' => 'Testo 3', 'class' => 'color', 'value' => Configure::read('colors.text_3')));
		?>
	</div>

	<h3 class="expander">Email</h3>
	<div class="accordion">
		<?php
		echo $this->Form->input('Configurator.email.from', array('label' => 'E-mail principale', 'value' => Configure::read('email.from')));
		?>
		<h3 class="expander">Parametri SMTP (facoltativi)</h3>
		<div class="accordion">
			<?php
			echo $this->Form->input('Configurator.email.SMTPoptions.host', array('label' => 'Nome host', 'value' => Configure::read('email.SMTPoptions.host')));
			echo $this->Form->input('Configurator.email.SMTPoptions.username', array('label' => 'Username', 'value' => Configure::read('email.SMTPoptions.username')));
			echo $this->Form->input('Configurator.email.SMTPoptions.password', array('label' => 'Password'));
			?>
		</div>
	</div>

	<?php
	echo $this->Form->end('Salva configurazione');
	?>

</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Torna al pannello strumenti', true), array('controller' => 'tools')); ?></li>
		<li><?php echo $this->Html->link(__('Aggiorna', true), array('action' => 'clear_cache')); ?></li>
		<li><?php echo $this->Html->link(__('Azzera la configurazione', true), array('action' => 'empty'), null, 'Sei sicuro? Tutti i dati di configurazione verranno azzerati.'); ?></li>
	</ul>
</div>