<div class="users form">
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <h2><?php __('Nuovo utente'); ?></h2>

        <h3 class="expander">Profilo utente</h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('first_name', array('label' => __('Nome', true)));
            echo $this->Form->input('last_name', array('label' => __('Cognome', true)));
            echo $this->Form->input('username');
            echo $this->Form->input('password', array('value' => ''));
            echo $this->Form->input('email');
            ?>
        </div>

        <h3 class="expander">Altro</h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('parent_id', array('label' => __('Appartiene alla famiglia di', true), 'empty' => 'Nessuno: è capofamiglia', 'options' => $families));
            echo $this->Form->input('usergroup_id', array('label' => __('Gruppo', true)));
            echo $this->Form->input('role', array('label' => __('Ruolo', true), 'value' => 3));
            echo $this->Form->input('active', array('label' => 'Attivo', 'checked' => 'checked'));
            ?>
        </div>
    </fieldset>
    <?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Torna a elenco utenti', true), array('action' => 'index'));?></li>
    </ul>
</div>