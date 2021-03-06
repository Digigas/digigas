<div class="sellers form">
    <?php echo $this->Form->create('Seller');?>
    <fieldset>
        <h2><?php __('Modifica profilo azienda produttrice'); ?></h2>

        <h3 class="expander"><?php __('Dati del profilo'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('id');
            echo $this->Form->input('name', array('label' => 'Nome'));
            echo $this->Form->input('business_name', array('label' => 'Ragione sociale'));
            echo $this->Form->input('address', array('label' => 'Indirizzo'));
            echo $this->Form->input('phone', array('label' => 'Telefono'));
            echo $this->Form->input('mobile', array('label' => 'Cellulare'));
            echo $this->Form->input('fax', array('label' => 'Fax'));
            echo $this->Form->input('email', array('label' => 'e-mail'));
            echo $this->Form->input('website', array('label' => 'Sito web'));
            echo $this->Form->input('notes', array('label' => 'Note'));
			echo $this->Form->input('active', array('label' => __('Attivo', true)));
            ?>
        </div>

        <h3 class="expander"><?php __('Dati privati'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('private_notes', array('label' => 'Note private', 'between' => __('Il contenuto di questo campo non verrà pubblicato sul sito', true)));
			?>
        </div>

        <h3 class="expander"><?php __('Referenti per questa azienda'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('User', array('multiple' => 'checkbox', 'label' => __('Utenti abilitati a gestire gli ordini', true)));
            ?>
        </div>

    </fieldset>
    <?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Gestisci i produttori', true), array('action' => 'index'));?></li>
    </ul>
</div>