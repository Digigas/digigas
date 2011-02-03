<div class="pages index">
    <h2>Strumenti</h2>
    <ul class="tools-list">
        <li><?php
        echo $this->Html->image('oxygen/32x32/filesystems/network.png');
        echo $this->Html->link(__('Pagine del sito web', true), array('controller' => 'pages')); ?>
			<ul>
				<li><?php echo $this->Html->link(__('Nuova pagina', true), array('controller' => 'pages', 'action' => 'add')); ?></li>
			</ul>
		</li>
        <li><?php
        echo $this->Html->image('oxygen/32x32/filesystems/document_multiple.png');
        echo $this->Html->link(__('News', true), array('controller' => 'news')); ?>
			<ul>
				<li><?php echo $this->Html->link(__('Nuova news', true), array('controller' => 'news', 'action' => 'add')); ?></li>
			</ul>
		</li>
		<li><?php
        echo $this->Html->image('oxygen/32x32/filesystems/mail_message.png');
        echo $this->Html->link(__('Newsletter', true), array('controller' => 'newsletter_messages')); ?>
			<ul>
				<li><?php echo $this->Html->link(__('Nuovo messaggio', true), array('controller' => 'newsletter_messages', 'action' => 'add')); ?></li>
			</ul>
		</li>
        <li><?php
        echo $this->Html->image('oxygen/32x32/actions/kontact_notes.png');
        echo $this->Html->link(__('Commenti', true), array('controller' => 'comments')); ?></li>
        <li><?php
        echo $this->Html->image('oxygen/32x32/actions/user_group_new.png');
        echo $this->Html->link(__('Forum', true), array('controller' => 'forums')); ?></li>
        <li><?php
        echo $this->Html->image('oxygen/32x32/filesystems/folder.png');
        echo $this->Html->link(__('Filemanager', true), array('controller' => 'filemanager')); ?></li>
		<li><?php
        echo $this->Html->image('oxygen/32x32/actions/rss.png');
        echo $this->Html->link(__('Rss dei siti amici', true), array('controller' => 'rss_sources')); ?></li>
		<li><?php
        echo $this->Html->image('oxygen/32x32/actions/datashowchart.png');
        echo $this->Html->link(__('Statistiche', true), array('controller' => 'statistics')); ?></li>
		<li><?php
        echo $this->Html->image('oxygen/32x32/actions/configure.png');
        echo $this->Html->link(__('Configurazione generale', true), array('controller' => 'configurator')); ?></li>
    </ul>
</div>