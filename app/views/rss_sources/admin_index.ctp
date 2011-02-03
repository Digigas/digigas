<div class="rssSources index">
	<h2><?php __('RSS connessi');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Titolo', 'title');?></th>
			<th><?php echo $this->Paginator->sort('Sito', 'website_name');?></th>
			<th><?php echo $this->Paginator->sort('Pubblicato', 'active');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($rssSources as $rssSource):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $rssSource['RssSource']['title']; ?>&nbsp;</td>
		<td><?php echo $rssSource['RssSource']['website_name']; ?>&nbsp;</td>
		<td><?php echo $rssSource['RssSource']['active'] ? 'si' : 'no'; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $rssSource['RssSource']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $rssSource['RssSource']['id']), null, sprintf(__('Sicuro di voler eliminare # %s?', true), $rssSource['RssSource']['title'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('precedente', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('prossima', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Azioni'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nuovo collegamento RSS', true), array('action' => 'add')); ?></li>
	</ul>
</div>