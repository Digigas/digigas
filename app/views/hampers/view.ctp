<?php
$this->Layout->blockStart('js_on_load');

echo <<<JS
$('.product .options form', '.products').hide();
$('.product .options h4', '.products').css({cursor: 'pointer'}).click(function(){
    $(this).next('form').slideToggle();
});
JS;

$this->Layout->blockEnd();
?>

<div class="hampers view">
    <h2><?php  __('Riepilogo di');?> <?php echo $hamper['Hamper']['name']; ?></h2>

    <div class="report">
        <?php
        __('Questo paniere è prodotto da ');
        echo $this->Html->link($hamper['Seller']['name'], array('controller' => 'sellers', 'action' => 'view', $hamper['Seller']['id']));

        echo '<br/>';
        __('Puoi acquistare questi prodotti da ');
        echo digi_date($hamper['Hamper']['start_date']);
        __(' fino a ');
        echo  digi_date($hamper['Hamper']['end_date']);

        echo '<br/>';
        __('Questo acquisto deve essere pagato entro ');
        echo  digi_date($hamper['Hamper']['checkout_date']);

        echo '<br/>';
        __('Ritira la merce presso ');
        echo $hamper['Hamper']['delivery_position'];
        __(' da ');
        echo  digi_date($hamper['Hamper']['delivery_date_on']);
        __(' a ');
        echo  digi_date($hamper['Hamper']['delivery_date_off']);
        ?>
    </div>

    <div class="related products">
        <h2><?php __('Prodotti in questo paniere');?></h2>
        <?php if (!empty($hamper['Product'])):?>
            <?php foreach ($hamper['Product'] as $product): ?>
        <div class="product">
                    <?php echo $this->Image->resize('/documents/image/product/'.$product['image'], '150', '120');?>
            <div class="name"><?php echo $product['name'];?></div>

                    <?php if(!empty($product['text'])): ?>
            <div class="text"><?php echo $product['text'];?></div>
                    <?php endif; ?>

                    <?php if(!empty($product['packing'])): ?>
            <div class="pack">
                            <?php
                            __('Confezione: ');
                            echo $product['packing'];
                            ?>
            </div>
                    <?php endif; ?>

                    <?php if(!empty($product['weight'])): ?>
            <div class="weight">
                            <?php
                            __('Peso: ');
                            echo $product['weight'];
                            ?>
            </div>
                    <?php endif; ?>

                    <?php if(!empty($product['number'])): ?>
            <div class="number">
                            <?php
                            __('Pezzi per collo: ');
                            echo $product['number'];
                            ?>
            </div>
                    <?php endif; ?>

                    <?php if(!empty($product['value'])): ?>
            <div class="value">
                            <?php
                            __('Prezzo: ');
                            echo $product['value'];
                            ?>&euro;
            </div>
                    <?php endif; ?>

            <div class="options">
                <h4><?php __('Ordina'); ?></h4>
                <?php
                echo $this->Form->create('OrderedProduct', array('action' => 'add'));
                echo $this->Form->hidden('product_id', array('value' => $product['id']));
                echo $this->Form->hidden('hamper_id', array('value' => $hamper['Hamper']['id']));
                echo $this->Form->hidden('seller_id', array('value' => $hamper['Seller']['id']));
                $selectOptions = array();
                for($i = 1; $i < 11; $i ++) {
                    $selectOptions[$i] = $i;
                }
                echo $this->Form->input('quantity', array('options' => $selectOptions, 'label' => __('Quantità', true)));
                echo $this->Form->end('Acquista');
                ?>
            </div>

        </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('<< Ritorna ai panieri', true), array('action' => 'index')); ?></li>
    </ul>
    
    <?php echo $this->element('user_order', array('userOrder' => $userOrder)); ?>

    <ul>
        <li><?php echo $this->Html->link(__('Vai alla tua pagina ordini', true), array('controller' => 'ordered_products', 'action' => 'index')); ?></li>
    </ul>
</div>