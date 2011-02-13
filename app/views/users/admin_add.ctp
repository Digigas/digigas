<div class="users form">
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <h2><?php __('Nuovo utente'); ?></h2>

		<div class="info">
			Per creare un nuovo utente devi compilare il form qui sotto. I campi fondamentali sono: nome, cognome, username e email.
			Ti consiglio di impostare una password temporanea (digita solo qualche lettera a caso, non è necessario che te la ricordi).
			L'utente riceve automaticamente una email con le istruzioni per accedere e impostare la propria password.
		</div>

        <h3 class="expander">Profilo utente</h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('first_name', array('label' => __('Nome', true)));
            echo $this->Form->input('last_name', array('label' => __('Cognome', true)));
            echo $this->Form->input('username');
            echo $this->Form->input('password', array('value' => ''));
            echo $this->Form->input('email');

			echo $this->Form->input('address', array('label' => __('Indirizzo', true)));
			echo $this->Form->input('phone', array('label' => __('Telefono', true)));
			echo $this->Form->input('mobile', array('label' => __('Cellulare', true)));
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