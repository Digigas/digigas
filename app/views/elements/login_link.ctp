<?php if($this->Session->read('Auth.User.active')): ?>
<ul>
    <?php if($this->Session->read('Auth.User.role') < 3): ?>
    <li><?php echo $this->Html->link('Admin', '/admin'); ?></li>
    <?php endif; ?>
    <li><?php echo $this->Html->link('Logout', '/users/logout'); ?></li>
</ul>
<?php else: ?>
<ul>
    <li><?php echo $this->Html->link('Login', '/users/login'); ?></li>
</ul>
<?php endif; ?>