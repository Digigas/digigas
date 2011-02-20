<div class="newscategories index">
<h2><?php __('Newscategories');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Pagina %page% di %pages%, riga da %start% a %end% di %count%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('lft');?></th>
	<th><?php echo $paginator->sort('rght');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('active');?></th>
	<th><?php echo $paginator->sort('slug');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($newscategories as $newscategory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $newscategory['Newscategory']['id']; ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['parent_id']; ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['lft']; ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['rght']; ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['name']; ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['active']; ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['slug']; ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['created']; ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $newscategory['Newscategory']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $newscategory['Newscategory']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $newscategory['Newscategory']['id']), null, sprintf(__('Sei sicuro di voler eliminare la Categoria # %s?', true), $newscategory['Newscategory']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('successiva', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('precedente', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Newscategory', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List News', true), array('controller'=> 'news', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New News', true), array('controller'=> 'news', 'action'=>'add')); ?> </li>
	</ul>
</div>
