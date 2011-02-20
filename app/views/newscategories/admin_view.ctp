<div class="newscategories view">
<h2><?php  __('Newscategory');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['parent_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lft'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['lft']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rght'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['rght']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['slug']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newscategory['Newscategory']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Newscategory', true), array('action'=>'edit', $newscategory['Newscategory']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Newscategory', true), array('action'=>'delete', $newscategory['Newscategory']['id']), null, sprintf(__('Sei sicuro di voler eliminare la Categoria # %s?', true), $newscategory['Newscategory']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Newscategories', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Newscategory', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List News', true), array('controller'=> 'news', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New News', true), array('controller'=> 'news', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related News');?></h3>
	<?php if (!empty($newscategory['News'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Newscategory Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Summary'); ?></th>
		<th><?php __('Content'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Date On'); ?></th>
		<th><?php __('Date Off'); ?></th>
		<th><?php __('Slug'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($newscategory['News'] as $news):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $news['id'];?></td>
			<td><?php echo $news['newscategory_id'];?></td>
			<td><?php echo $news['title'];?></td>
			<td><?php echo $news['summary'];?></td>
			<td><?php echo $news['content'];?></td>
			<td><?php echo $news['active'];?></td>
			<td><?php echo $news['date_on'];?></td>
			<td><?php echo $news['date_off'];?></td>
			<td><?php echo $news['slug'];?></td>
			<td><?php echo $news['created'];?></td>
			<td><?php echo $news['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'news', 'action'=>'view', $news['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'news', 'action'=>'edit', $news['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'news', 'action'=>'delete', $news['id']), null, sprintf(__('Sei sicuro di voler eliminare la News # %s?', true), $news['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New News', true), array('controller'=> 'news', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
