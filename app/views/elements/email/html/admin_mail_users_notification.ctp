<div class="date">
<?php __('Inviata il'); ?>:
<?php echo digi_date(date('D j M Y, H:i')); ?>
</div>
<h1>
    <?php __('Ciao'); echo $user['User']['fullname']; ?>!
    <?php echo __('Benvenuto in', true).' '.Configure::read('GAS.name'); ?>
</h1>
<p>
Sei stato iscritto al gas <?php echo Configure::read('GAS.name'); ?>, per attivare il tuo account
clicca sul link sottostante e imposta la tua password.<br/>

<strong>
<a href="<?php echo $html->url(array('controller' => 'users', 'action' => 'password_reset', $user['User']['hash'], 'admin' => false), true); ?>"><?php __('Imposta la tua password e attiva il tuo profilo'); ?></a>
</strong>
<br/><br/>
In seguito potrai accedere al software da questo indirizzo:<br/>
<?php echo $this->Html->link($_SERVER['SERVER_NAME'], '/digigas', array('full' => true)); ?>
</p>






