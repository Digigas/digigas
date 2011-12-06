<div class="users form">
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <h2><?php __('Modifica referente'); ?></h2>

        <h3 class="expander"><?php __('Dati profilo utente'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('User.id');
            echo $this->Form->input('User.first_name', array('label' => __('Nome', true)));
            echo $this->Form->input('User.last_name', array('label' => __('Cognome', true)));
            echo $this->Form->input('User.username');
            echo $this->Form->input('User.password', array('value' => ''));
            echo $this->Form->input('User.email');
			echo $this->Form->input('User.address', array('label' => __('Indirizzo', true)));
			echo $this->Form->input('User.phone', array('label' => __('Telefono', true)));
			echo $this->Form->input('User.mobile', array('label' => __('Cellulare', true)));
            ?>
        </div>

        <h3 class="expander"><?php __('Altro'); ?></h3>
        <div class="accordion">
            <?php
			echo $this->Form->input('User.role', array('label' => __('Ruolo', true)));
			echo $this->Form->input('Seller', array('label' => __('Aziende di cui è referente', true), 'multiple' => 'checkbox'));
            echo $this->Form->input('User.parent_id', array('label' => __('Appartiene alla famiglia di', true), 'empty' => 'Nessuno: è capofamiglia', 'options' => $families));
            echo $this->Form->input('User.usergroup_id', array('empty' => true,'label' => __('Gruppo', true)));
            echo $this->Form->input('User.active', array('label' => 'Attivo', 'checked' => 'checked'));
            ?>
        </div>

    </fieldset>
    <?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Torna a elenco utenti', true), array('action' => 'index'));?></li>
        <li><?php echo $this->Html->link(__('Invia email con i dati di connessione', true), array('action' => 'admin_mail_users_notification', $this->data['User']['id']));?></li>
    </ul>
</div>