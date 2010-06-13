<div class="users view">
    <h2><?php  __('Pannello di controllo di');?> <?php echo $user['User']['fullname']; ?></h2>

    <h3 class="expander"><?php __('Dati account'); ?></h3>
    <div class="accordion">
        <dl><?php $i = 0;
$class = ' class="altrow"';?>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome per login'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                <?php echo $user['User']['username']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tipo di account'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                <?php                
                echo configure::read('roles.'.$user['User']['role']);
                ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gruppo'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['User']['usergroup_id']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registrato il'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo digi_date($user['User']['created']); ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Attivo'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php $user['User']['active']?__('si'):__('no'); ?>
                &nbsp;
            </dd>
        </dl>
    </div>

    <h3 class="expander"><?php __('Dati personali'); ?></h3>
    <div class="accordion">
        <dl><?php $i = 0;
$class = ' class="altrow"';?>
          
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['User']['first_name']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cognome'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['User']['last_name']; ?>
                &nbsp;
            </dd>
            
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['User']['email']; ?>
                &nbsp;
            </dd>
            
        </dl>
    </div>


    <?php if(!empty($user['Seller']['id'])): ?>
    <h3 class="expander"><?php __('Dati aziendali'); ?></h3>
    <div class="accordion">
        <dl><?php $i = 0;
$class = ' class="altrow"';?>

            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Attivo'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php $user['Seller']['active']?__('si'):__('no'); ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome azienda'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['Seller']['name']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ragione sociale'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['Seller']['business_name']; ?>
                &nbsp;
            </dd>

            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Indirizzo'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['Seller']['address']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Telefono'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['Seller']['phone']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cellulare'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['Seller']['mobile']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fax'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['Seller']['fax']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['Seller']['email']; ?>
                &nbsp;
            </dd>
            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sito web'); ?></dt>
            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
<?php echo $user['Seller']['website']; ?>
                &nbsp;
            </dd>

        </dl>
    </div>
    <?php endif; ?>

</div>
<div class="actions">
    <h3><?php __('Azioni'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Modifica profilo', true), array('action' => 'edit')); ?> </li>
        <li><?php echo $this->Html->link(__('Torna a digigas', true), '/digigas'); ?> </li>
    </ul>
</div>
