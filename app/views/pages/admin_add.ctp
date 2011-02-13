<div class="pages form">
	<h2>Nuova pagina</h2>
<?php echo $this->Form->create('Page', array('enctype'=>'multipart/form-data'));?>

<h3 class="expander">Contenuto</h3>
<div class="accordion">
	<?php 		
		echo $this->Form->input('parent_id', array('label'=>'Seleziona la pagina di livello superiore', 'type'=>'select', 'options'=>$pages, 'empty'=>true));
	?>
	<?php echo $this->Form->input('menu', array('label'=>'Testo del menu'));?>
	<?php echo $this->Form->input('title', array('label'=>'Titolo'));?>
	<?php echo $this->Form->input('text', array('label'=>'Contenuto'));?>
</div>
	
<h3 class="expander">Altre opzioni</h3>
<div class="accordion">
		
    <?php echo $this->Form->input('active', array('label'=>'Attiva', 'checked'=>'checked'));?>
    <?php echo $this->Form->input('private', array('label'=>'Privata'));?>
    <?php echo $this->Html->div('note', __('Una pagina privata è visibile solo ai partecipanti del GAS', true)); ?>
    <?php echo $this->Form->input('date_on', array('label'=>'Data di pubblicazione', 'class'=>'calendar', 'type'=>'text'));?>
    <?php echo $this->Form->input('date_off', array('label'=>'Data di scadenza', 'class'=>'calendar', 'type'=>'text'));?>

    <?php echo $this->Form->input('menuable', array('label'=>'Mostra nel menu', 'checked'=>'checked'));?>
    <?php echo $this->Form->input('skip_to_first_child', array('label' => 'Salta direttamente alla prima sottopagina'));?>
    <?php echo $this->Form->input('link_to_front', array('label'=>'Link a un altro contenuto'));?>
</div>

<h3 class="expander">Opzioni per i motori di ricerca</h3>
<div class="accordion">
    <p class="info">In questa sezione puoi inserire alcune informazioni utili per i motori di ricerca, i meta tags.<br/>
    &middot; &nbsp;Le meta keywords sono le parole chiave per questa pagina.<br/>
    &middot; &nbsp;La meta description è un brevissimo testo che riassume il contenuto della pagina.
    Il motore di ricerca visualizza questo testo nella sua pagina di risultati.</p>
    <?php
    echo $this->Form->input('meta_keywords', array('type'=>'textarea', 'class'=>'plaintext'));
    echo $this->Form->input('meta_description', array('type'=>'textarea', 'class'=>'plaintext'));
    ?>
</div>

<?php
echo $this->Form->submit('Salva e continua', array('name'=>'action_edit'));
echo $this->Form->end('Salva');
?>
</div>


<div class="actions">
	<ul>
		<li><?php echo $this->Html->link('Torna alla struttura del sito', array('action'=>'index'));?></li>
	</ul>
</div>