<div class="newsletterMessages form">
    <?php echo $this->Form->create('NewsletterMessage');?>
    <fieldset>
        <h2><?php __('Invia un messaggio newsletter'); ?></h2>
        <h3 class="expander"><?php __('Componi email'); ?></h3>
        <div class="accordion">
        <?php
        echo $this->Form->input('usergroup_id', array('label' => __('Invia a questo gruppo di destinatari', true)));
        echo $this->Form->input('title', array('label' => __('Titolo', true)));
        echo $this->Form->input('text', array('label' => __('Testo', true)));
        ?>
        </div>

        <h3 class="expander"><?php __('Altro'); ?></h3>
        <div class="accordion">
        <?php
        echo $this->Form->input('reply_to', array('label' => __('Indirizzo a cui rispondere', true)));
        ?>
        </div>
    </fieldset>
    <?php echo $this->Form->end(__('Invia', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('<< indietro', true), array('action' => 'index'));?></li>
      </ul>
</div>