<div class="sellers form">
    <?php echo $this->Form->create('Seller');?>
    <fieldset>
        <h2><?php __('Nuovo profilo di azienda produttrice'); ?></h2>

        <h3 class="expander"><?php __('Dati profilo aziendale'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('name');
            echo $this->Form->input('business_name');
            echo $this->Form->input('address');
            echo $this->Form->input('phone');
            echo $this->Form->input('mobile');
            echo $this->Form->input('fax');
            echo $this->Form->input('email');
            echo $this->Form->input('website');
            echo $this->Form->input('notes');
            echo $this->Form->input('active', array('label' => __('Attiva il profio aziendale', true), 'checked' => 'checked'));
            ?>
        </div>

        <h3 class="expander"><?php __('Profili fornitore che gestiranno questa azienda'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('User', array('multiple' => 'checkbox', 'label' => 'Fornitori'));
            ?>
        </div>
        
    </fieldset>
    <?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Torna a produttori', true), array('action' => 'index'));?></li>
    </ul>
</div>