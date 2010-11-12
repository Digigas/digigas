<div class="actions">
	<ul>
		<li><?php echo $html->link(__('indietro', true), array('action'=>'index'));?></li>
	</ul>
</div>

<div class="newscategories form">
<h2>Nuova categoria di news</h2>
<?php echo $form->create('Newscategory');?>
	<fieldset>
 		
	<?php
		echo $form->input('parent_id', array('label'=>'Seleziona la categoria di livello superiore', 'type'=>'select', 'options'=>$categories, 'empty'=>true));
		
		echo $form->input('name', array('label'=>'Nome'));
		echo $form->input('active', array('label'=>'Attiva'));
		
	?>
	</fieldset>
<?php echo $form->end('Salva');?>
</div>
