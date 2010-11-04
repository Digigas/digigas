<div class="hampers index">
    <h2><?php __('Fai un ordine per un utente'); ?></h2>
    <?php
    echo $this->Form->create('OrderedProduct', array('url' => array('action' => 'order_for_user_2')));
    echo $this->Form->input('user_id', array('label' => __('Ordina per questo utente', true)));
    ?>

    <h2><?php __('Seleziona il paniere'); ?></h2>

    <input name="data[OrderedProduct][hamper_id]" value="" type="hidden">

    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Seleziona'); ?></th>
            <th><?php __('Nome del paniere'); ?></th>
            <th><?php __('Produttore'); ?></th>
            <th><?php __('Data di chiusura'); ?></th>
            <th><?php __('Data di consegna'); ?></th>
        </tr>
        <?php
        foreach($hampers as $hamper):
            ?>
        <tr>
            <td class="actions">
                    <input name="data[OrderedProduct][hamper_id]" value="<?php echo $hamper['Hamper']['id'] ?>" type="radio">
            </td>
            <td>
                    <?php
                    echo $hamper['Hamper']['name'];
                    ?>
            </td>
            <td>
                    <?php
                    echo $hamper['Seller']['name'];
                    ?>
            </td>
            <td>
                    <?php
                    echo  digi_date($hamper['Hamper']['end_date']);
                    ?>
            </td>            
            <td>
                    <?php
                    echo  digi_date($hamper['Hamper']['delivery_date_on']);
                    ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php
    echo $this->Form->end(__('Avanti', true));
    ?>
</div>