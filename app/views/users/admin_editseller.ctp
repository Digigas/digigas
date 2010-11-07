<div class="users form">
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <h2><?php __('Modifica fornitore'); ?></h2>

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
			echo $this->Form->input('User.usergroup_id', array('label' => __('Gruppo', true)));
            echo $this->Form->input('User.role', array('label' => __('Ruolo', true)));
            echo $this->Form->input('User.active', array('label' => 'Attivo'));
            ?>
        </div>

        <h3 class="expander"><?php __('Dati profilo aziendale'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Html->div('note', __('Imposta i dati aziendali che verranno visualizzati sul sito', true));
            echo $this->Form->input('Seller.id');
            echo $this->Form->input('Seller.name');
            echo $this->Form->input('Seller.business_name');
            echo $this->Form->input('Seller.address');
            echo $this->Form->input('Seller.phone');
            echo $this->Form->input('Seller.mobile');
            echo $this->Form->input('Seller.fax');
            echo $this->Form->input('Seller.email');
            echo $this->Form->input('Seller.website');
            echo $this->Form->input('Seller.notes');
            echo $this->Form->input('Seller.active', array('label' => __('Attiva il profio aziendale', true)));
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