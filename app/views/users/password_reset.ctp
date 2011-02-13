<div class="users view">
    <h2>
        <?php __('Benvenuto'); echo $user['User']['fullname']; ?>!
        <?php __('Imposta la tua password'); ?>
    </h2>

    <?php echo $this->Form->create('User', array('url' => array('action' => 'password_reset', $user['User']['hash']))); ?>
    <?php echo $this->Form->input('password', array('label' => __('Nuova password', true))); ?>
    <?php echo $this->Form->input('password2', array('label' => __('Ripeti la password', true), 'type' => 'password')); ?>
    <?php echo $this->Form->end('Invia'); ?>
</div>