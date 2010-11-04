<?php if(!empty($userOrder)): ?>
<div class="userorder">
    <h2><?php __('Riepilogo ordine'); ?></h2>

    <?php foreach($userOrder as $order): ?>
    <div class="orderedproduct">
        <div class="number">
            <?php echo $order['OrderedProduct']['quantity']; ?>
        </div>
        <div class="name">
            <?php
            echo $order['Product']['name'];
            __(' di ');
            echo $order['Seller']['name'];
            ?>
        </div>
        <div class="value">
        <?php
            if($order['OrderedProduct']['option_1'])
            {
                echo $order['Product']['option_1']. ": <strong>".$order['OrderedProduct']['option_1']."</strong>";
                echo "<br>";
            }
            if($order['OrderedProduct']['option_2'])
            {
                echo $order['Product']['option_2']. ":  <strong>".$order['OrderedProduct']['option_2']."</strong>";
            }
            if($order['OrderedProduct']['note'])
            {
                echo "<br>";
                echo $order['OrderedProduct']['note'];
            }
            ?>
        </div>
        <div class="value">
            <?php
            __('Costo totale: ');
            echo $order['OrderedProduct']['value'];
            echo '&euro;';
            ?>
        </div>
        <div class="delete">
            <?php echo $this->Html->image('oxygen/16x16/actions/editdelete.png', array(
                'url' => array(
                    'controller' => 'ordered_products',
                    'action' => 'delete',
                    $order['OrderedProduct']['id']),
                'title' => __('Elimina', true))); ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>