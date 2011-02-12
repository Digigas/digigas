<div class="newscategories index">
<h2>Categorie di news</h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('PPagina %page% di %pages%, riga da %start% a %end% di %count%', true)
));
?></p>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('precedente', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('successiva', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>Nome</th>
	<th>Attiva</th>
	<th class="actions" colspan='2'><?php __('Actions');?></th>
</tr>
<?php
//L'array $elements = array ('id elemento' => 'profondita')
$elements = Array('0'=>'0');
$i = 0;
foreach ($newscategories as $newscategory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
    $elements[$newscategory['Newscategory']['id']] = $elements[$newscategory['Newscategory']['parent_id']]+1;
	$profondita = $elements[$newscategory['Newscategory']['parent_id']]+1;
?>
	<tr<?php echo $class;?>>
		<td>
			<?php
            echo str_repeat('&middot; &nbsp;&nbsp;', $profondita).$newscategory['Newscategory']['name'];
            ?>
		</td>
		<td>
			<?php echo $newscategory['Newscategory']['active']?'si':'no'; ?>
		</td>
		<td class="actions">
            <?php echo $html->link(__('Modifica', true), array('action'=>'edit', $newscategory['Newscategory']['id'])); ?>
        </td>
		<td class="actions">
            <?php echo $html->link(__('Elimina', true), array('action'=>'delete', $newscategory['Newscategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $newscategory['Newscategory']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>


<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Nuova categoria', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('Gestisci le news', true), array('controller'=> 'news', 'action'=>'index')); ?> </li>
	</ul>
</div>
