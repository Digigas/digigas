
<div class="export-tools">
    <div class="openclose">
        <?php echo $this->Html->image('oxygen/16x16/actions/tool2.png'); ?>
    </div>
    <ul class="toolslist">
        <li><?php
        echo $this->Html->image('oxygen/16x16/actions/mail_generic.png');
        echo $this->Html->link(__('email notifica iscrizione', true),
            array(
                'action' => 'mail_users_notification'),
            array(
                'title' => __('invia agli utenti una email con le istruzioni per accedere al sito', true)
            ));
        ?></li>
    </ul>
</div>

<div class="users index">
	<h2><?php __('Ricerca utenti'); echo ': '.$key; ?></h2>

    <div class="search">
        <?php
        echo $this->Form->create('Search', array('url' => array('controller' => 'users', 'action' => 'search')));
        echo $this->Form->text('key');
        echo $this->Form->end(__('Cerca', true));
        ?>
    </div>
    
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('Congome');?></th>
			<th><?php __('Nome');?></th>
			<th><?php __('Username');?></th>
			<th><?php __('e-mail');?></th>
			<th><?php __('Tipo');?></th>
			<th><?php __('Attivo');?></th>
            <th><?php __('Famiglia'); ?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $user['User']['last_name']; ?>&nbsp;</td>
		<td><?php echo $user['User']['first_name']; ?>&nbsp;</td>
		<td><?php echo $user['User']['username']; ?>&nbsp;</td>
		<td><?php echo $this->Html->link($user['User']['email'], 'mailto:'.$user['User']['email']); ?>&nbsp;</td>
		<td><?php echo Configure::read('roles.'.$user['User']['role']); ?>&nbsp;</td>
		<td class="align-center"><?php echo $user['User']['active']?'si':'no'; ?>&nbsp;</td>
		<td class="align-center">
                <?php
                if(isset($fathers[$user['User']['id']])) {
                    echo $this->Html->image('oxygen/family.png', array('title' => __('Visualizza famiglia', true), 'url' => array('action' => 'index', 'family' => $user['User']['id'])));
                } else if(empty($user['User']['parent_id'])) {
                    echo $this->Html->image('oxygen/single.png', array('title' => __('Partecipante single', true)));
                } else {
                    echo $this->Html->image('oxygen/child.png', array('title' => __('Appartiene a una famiglia', true)));
                }
                ?>
        </td>
        <td class="actions">
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
        <li>Filtra
            <ul>
                <li><?php echo $this->Html->link(__('Tutti gli utenti', true), array('action' => 'index')); ?></li>
                <li><?php echo $this->Html->link(__('Solo attivi', true), array('active' => 1)); ?></li>
                <li><?php echo $this->Html->link(__('Solo disattivati', true), array('active' => 0)); ?></li>
                <?php foreach(Configure::read('roles') as $n => $_role): ?>
                <li><?php echo $this->Html->link(__('Solo ', true).$_role, array('action' => 'index', $n)); ?></li>
                <?php endforeach; ?>                
            </ul>
        </li>
		<li><?php echo $this->Html->link(sprintf(__('Nuovo %s', true), __('utente', true)), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(sprintf(__('Nuovo %s', true), __('fornitore', true)), array('action' => 'addseller')); ?></li>
        <li><?php echo $this->Html->link(__('Gestisci i gruppi', true), array('controller' => 'usergroups', 'action' => 'index')); ?></li>
    </ul>
</div>