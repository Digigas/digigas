<div class="sellers form">
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <h2><?php __('Nuovo referente'); ?></h2>

        <h3 class="expander"><?php __('Dati profilo utente'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Html->div('note', __('Imposta i dati personali per accedere al sistema', true));
            echo $this->Form->input('User.first_name', array('label' => __('Nome', true)));
            echo $this->Form->input('User.last_name', array('label' => __('Cognome', true)));
            echo $this->Form->input('User.username');
            echo $this->Form->input('User.password', array('value' => ''));
            echo $this->Form->input('User.email', array('label' => __('email personale', true)));
            echo $this->Form->input('User.address', array('label' => __('Indirizzo', true)));
            echo $this->Form->input('User.phone', array('label' => __('Telefono', true)));
            echo $this->Form->input('User.mobile', array('label' => __('Cellulare', true)));
            ?>
        </div>

        <h3 class="expander"><?php __('Altro'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('Seller', array('label' => __('Aziende di cui è referente', true), 'multiple' => 'checkbox'));
            echo $this->Form->input('User.parent_id', array('label' => __('Appartiene alla famiglia di', true), 'empty' => 'Nessuno: è capofamiglia', 'options' => $families));
            echo $this->Form->input('User.usergroup_id', array('label' => __('Gruppo', true)));
            echo $this->Form->hidden('User.role', array('value' => 2));
            echo $this->Form->input('User.active', array('label' => 'Attivo', 'checked' => 'checked'));
            ?>
        </div>
    </fieldset>
    <?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Torna a elenco utenti', true), array('controller' => 'users', 'action' => 'index'));?></li>
    </ul>
</div>