<div class="actions">
	<ul>
		<li><?php echo $html->link(__('indietro', true), array('action'=>'index'));?></li>
        <li><?php echo $html->link(__('elimina', true), array('action'=>'delete', $form->value('Newscategory.id')), null, sprintf(__('Sei sicuro di voler eliminare la Categoria # %s?', true), $form->value('Newscategory.id'))); ?></li>
	</ul>
</div>

<div class="newscategories form">
    <h2>Modifica la categoria <?php echo $this->data['Newscategory']['name'] ?></h2>
<?php echo $form->create('Newscategory');?>
	<fieldset>
 		
	<?php
		echo $form->input('id');
		echo $form->input('parent_id', array('label'=>'Seleziona la categoria di livello superiore', 'type'=>'select', 'options'=>$categories, 'empty'=>true));
		
		echo $form->input('name', array('label'=>'Nome'));
		echo $form->input('active', array('label'=>'Attiva'));
	?>
	</fieldset>
<?php echo $form->end('Salva');?>
</div>

