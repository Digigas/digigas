<div class="orderedProducts index">
    <h2><?php __('Comandi rapidi');?></h2>
    <p>Le funzioni di questa pagina permettono di impostare come pagati e consegnati tutti gli ordini di un paniere con solo un click.</p>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Produttore'); ?></th>
            <th><?php __('Paniere'); ?></th>
            <th><?php __('Data di consegna'); ?></th>
            <th colspan="2"><?php __('Imposta gli ordini come'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($pendingHampers as $hamper):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
        <tr<?php echo $class;?>>
            <td><?php echo $hamper['Seller']['name']; ?></td>
            <td><?php echo $hamper['Hamper']['name']; ?></td>
            <td><?php echo digi_date($hamper['Hamper']['delivery_date_on']); ?></td>
            <td><?php echo $this->Html->link(__('tutti pagati', true), array('action' => 'mass_actions', 'paid', $hamper['Hamper']['id'])); ?></td>
            <td><?php echo $this->Html->link(__('tutti consegnati', true), array('action' => 'mass_actions', 'retired', $hamper['Hamper']['id'])); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Tutti gli ordini pendenti', true), array('action' => 'index')); ?></li>
        <li class="dropdown"><?php __('Vedi ordini per acquirente'); ?>
            <ul>
                <?php foreach($users as $id => $user): ?>
                <li><?php echo $this->Html->link($user, array('action' => 'index_user', $id)); ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="dropdown"><?php __('Vedi ordini per produttore'); ?>
            <ul>
                <?php foreach($sellers as $id => $seller): ?>
                <li><?php echo $this->Html->link($seller, array('action' => 'index_seller', $id)); ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li>
            <?php echo $this->Html->link(__('Fai un ordine per un utente', true), array('controller' => 'ordered_products', 'action' => 'order_for_user')); ?>
        </li>
    </ul>
</div>