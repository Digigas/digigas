<div class="pages index">
    <h2>Strumenti</h2>
    <ul class="tools-list">
        <li><?php
        echo $this->Html->image('oxygen/32x32/filesystems/network.png');
        echo $this->Html->link(__('Gestisci il sito web', true), array('controller' => 'pages')); ?>
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
        echo $this->Html->image('oxygen/32x32/actions/color_line.png');
        echo $this->Html->link(__('Gestione commenti', true), array('controller' => 'comments')); ?></li>
        <li><?php
        echo $this->Html->image('oxygen/32x32/filesystems/folder.png');
        echo $this->Html->link(__('Filemanager', true), array('controller' => 'filemanager')); ?></li>
    </ul>
</div>