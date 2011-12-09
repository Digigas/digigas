<?php if(!empty($userOrder)): ?>
<div class="userorder">
    <h2><?php __('Riepilogo ordine'); ?></h2>

    <?php foreach($userOrder as $order): ?>
    <div class="orderedproduct">
        <div class="number">
            <?php 
			if(substr($order['OrderedProduct']['quantity'], -3) == '.00') {
				echo intval($order['OrderedProduct']['quantity']);
			} else {
				echo rtrim($order['OrderedProduct']['quantity'], '.0');
			}
			?>
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
		if(!empty($order['Product']['option_1'])) {
            echo $order['Product']['option_1']. ": <strong>".$order['OrderedProduct']['option_1']."</strong>";
            }
		if(!empty($order['Product']['option_2'])) {
            echo " | ";
			echo $order['Product']['option_2']. ":  <strong>".$order['OrderedProduct']['option_2']."</strong>";
		}
		if($order['OrderedProduct']['note'])
		{
			echo "<br/>";
			echo '('. $order['OrderedProduct']['note'] .')';
		}
		?>
        </div>
        <div class="value">
            <?php
            __('Costo totale: ');
            echo $this->Number->currency($order['OrderedProduct']['value'], 'EUR');
            
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