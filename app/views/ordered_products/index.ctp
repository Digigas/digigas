<div class="orderedProducts index">
    <h2><?php __('I miei ordini');?></h2>
    <?php if(empty($orderedProducts)): ?>
    <?php __('Nessun ordine in questo momento'); ?>
    <?php
    else:
    foreach ($orderedProducts as $orderedProduct): 
    ?>
    <div class="product">
        <?php echo $this->Image->resize('/documents/image/product/'.$orderedProduct['Product']['image'], '160', '120');?>
        <div class="name">
                <?php echo $orderedProduct['Product']['name'];?>
        </div>
        <div class="seller">
                <?php __('Produttore: '); echo $orderedProduct['Seller']['name']; ?>
        </div>
        <div class="quantity">
                <?php echo $orderedProduct['Product']['units'] . ': ' . rtrim($orderedProduct['OrderedProduct']['quantity'], '.0');?>
        </div>
        <div class="value">
                <?php
                __('Prezzo totale: ');
                echo $this->Number->currency($orderedProduct['OrderedProduct']['value'], 'EUR');
                ?>
        </div>
        <div class="paid">
            <?php
            echo $orderedProduct['OrderedProduct']['paid']?__('Pagato', true):__('Da pagare', true);
            ?>
        </div>
        <div class="retired">
                <?php echo $orderedProduct['OrderedProduct']['retired']?__('Riritato', true):__('Da ritirare', true);?>
        </div>
        <div class="hamperdata">
            <?php
			if(!date_is_empty($orderedProduct['Hamper']['checkout_date'])) {
				__('Questo acquisto deve essere pagato entro ');
				echo  digi_date($orderedProduct['Hamper']['checkout_date']);
			}

			if(!empty($orderedProduct['Hamper']['delivery_position'])) {
				echo '<br/>';
				__('Ritira la merce presso ');
				echo $orderedProduct['Hamper']['delivery_position'];
			}

			if(!date_is_empty($orderedProduct['Hamper']['delivery_date_on'])) {
				__(' da ');
				echo  digi_date($orderedProduct['Hamper']['delivery_date_on']);
				__(' a ');
				echo  digi_date($orderedProduct['Hamper']['delivery_date_off']);
			}
            ?>
        </div>
        <div class="delete">
            <?php 
            echo $this->Html->image('oxygen/16x16/actions/editdelete.png', array(
                'url' => array(
                    'controller' => 'ordered_products',
                    'action' => 'delete',
                    $orderedProduct['OrderedProduct']['id']),
                'title' => __('Elimina', true)));
            ?>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Continua gli acquisti', true), array('controller' => 'hampers', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('Storico dei tuoi ordini', true), array('controller' => 'ordered_products', 'action' => 'past_orders')); ?></li>
        <li><?php echo $this->Html->link(__('Quanto hai speso', true), array('controller' => 'money_boxes', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('Mandami un promemoria', true), array('controller' => 'ordered_products', 'action' => 'send_me_orders_email')); ?></li>
    </ul>
</div>