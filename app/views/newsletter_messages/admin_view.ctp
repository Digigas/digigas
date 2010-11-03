<div class="newsletterMessages view">
<h2>
<?php  __('Messaggio');?>:
<?php echo $newsletterMessage['NewsletterMessage']['title']; ?>
</h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mittente'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($newsletterMessage['User']['fullname'], array('controller' => 'users', 'action' => 'view', $newsletterMessage['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Destinatari'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newsletterMessage['Usergroup']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rispondi a'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newsletterMessage['NewsletterMessage']['reply_to']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data di invio'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newsletterMessage['NewsletterMessage']['sent_date']; ?>
			&nbsp;
		</dd>
	</dl>

    <br/> <br/>
    <?php echo $newsletterMessage['NewsletterMessage']['text']; ?>

</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('<< indietro', true), array('action' => 'index')); ?> </li>
    </ul>
</div>
