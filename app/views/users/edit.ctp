<div class="users form">
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <h2><?php __('Modifica il mio profilo'); ?></h2>

        <h3 class="expander">Profilo utente</h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('id');
            echo $this->Form->input('first_name', array('label' => __('Nome', true)));
            echo $this->Form->input('last_name', array('label' => __('Cognome', true)));
            echo $this->Form->input('username', array('label' => __('Nome per il login', true)));
            echo $this->Form->input('password', array('value' => '', 'label' => __('Password: se non vuoi modificarla, lascia bianco', true)));
            echo $this->Form->input('email');
            echo $this->Form->input('address', array('label' => __('Indirizzo', true)));
            echo $this->Form->input('phone', array('label' => __('Telefono', true)));
            echo $this->Form->input('mobile', array('label' => __('Cellulare', true)));
            ?>
        </div>
    </fieldset>
    <?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Torna al mio profilo', true), array('action' => 'index'));?></li>
    </ul>
</div>