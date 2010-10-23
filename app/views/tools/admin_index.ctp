<div class="pages index">
    <h2>Strumenti</h2>
    <ul class="tools-list">
        <li><?php
        echo $this->Html->image('oxygen/64x64/filesystems/network.png');
        echo $this->Html->link(__('Gestisci il sito web', true), array('controller' => 'pages')); ?></li>
        <li><?php
        echo $this->Html->image('oxygen/64x64/filesystems/document_multiple.png');
        echo $this->Html->link(__('News', true), array('controller' => 'news')); ?></li>
        <li><?php
        echo $this->Html->image('oxygen/64x64/filesystems/mail_message.png');
        echo $this->Html->link(__('Newsletter', true), array('controller' => 'newsletter_messages')); ?></li>
        <li><?php
        echo $this->Html->image('oxygen/64x64/filesystems/folder.png');
        echo $this->Html->link(__('Filemanager', true), array('controller' => 'filemanager')); ?></li>
    </ul>
</div>