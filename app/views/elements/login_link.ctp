<?php if($this->Session->read('Auth.User.active')): ?>
<ul>
    <li><?php echo $this->Html->link('Logout', '/users/logout'); ?></li>
</ul>
<?php else: ?>
<ul>
    <li><?php echo $this->Html->link('Login', '/users/login'); ?></li>
</ul>
<?php endif; ?>