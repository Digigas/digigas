<div class="hampers index">
    <h2><?php __('Stai ordinando i prodotti per'); ?> <?php echo $user['User']['fullname']; ?></h2>
    <?php
    echo $this->Form->create('OrderedProduct', array('url' => array('action' => 'order_for_user_3')));
    echo $this->Form->hidden('user_id', array('value' => $user_id));
    echo $this->Form->hidden('hamper_id', array('value' => $hamper_id));
    echo $this->Form->hidden('seller_id', array('value' => $hamper['Hamper']['seller_id']));
    $selectOptions = array();
    for($i = 1; $i < 11; $i ++) {
        $selectOptions[$i] = $i;
    }
    ?>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Prodotto'); ?></th>
            <th><?php __('Peso'); ?></th>
            <th><?php __('Pezzi per collo'); ?></th>
            <th><?php __('Prezzo'); ?></th>
            <th><?php __('Ordina quantità'); ?></th>
        </tr>
        <?php
        foreach($hamper['Product'] as $product):
            ?>
        <tr>            
            <td>
                    <?php
                    echo $product['name'];
                    ?>
            </td>
            <td>
                    <?php
                    echo $product['weight'];
                    ?>
            </td>
            <td>
                    <?php
                    echo  $product['number'];
                    ?>
            </td>            
            <td>
                    <?php
                    echo  $product['value'];
                    ?> &euro;
            </td>
            <td class="actions">
                    <?php echo $this->Form->select('Product.'.$product['id'], $selectOptions); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php
    echo $this->Form->end(__('Avanti', true));
    ?>
</div>