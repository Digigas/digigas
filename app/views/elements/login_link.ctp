<?php //l'utente a effettuato il login
if($this->Session->read('Auth.User.active')): ?>
<ul>

    <?php // visibile solo agli amministratori
    if($this->Session->read('Auth.User.role') < 3): ?>
    <li><?php echo $this->Html->link('Admin', '/admin'); ?></li>

    <?php // per gli utenti normali
    else: ?>
    <li><?php echo $this->Html->link('Impostazioni', '/users'); ?></li>
    <?php endif; ?>

    <li><?php echo $this->Html->link('Logout', '/users/logout'); ?></li>

</ul>

<?php // l'utente non è ancora loggato
else: ?>
<ul>
    <li><?php echo $this->Html->link('Login', '/users/login'); ?></li>
</ul>
<?php endif; ?>