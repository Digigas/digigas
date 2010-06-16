<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link('<< '.__('indietro', true), $referer); ?> </li>
        <li><?php echo $this->Html->link(__('Continua gli acquisti', true), array('controller' => 'hampers', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('Tutti i produttori', true), array('action' => 'index')); ?> </li>
    </ul>
</div>

<div class="sellers view">
    <h2>
        <?php
        __('Scheda del produttore');
        echo  ' '.$seller['Seller']['name'];
        ?>
    </h2>
    <dl><?php $i = 0;
        $class = ' class="altrow"';?>

        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ragione sociale'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $seller['Seller']['business_name']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Indirizzo'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $seller['Seller']['address']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Telefono'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $seller['Seller']['phone']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cellulare'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $seller['Seller']['mobile']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fax'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $seller['Seller']['fax']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $seller['Seller']['email']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Website'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $seller['Seller']['website']; ?>
            &nbsp;
        </dd>
    </dl>

    <?php echo $seller['Seller']['notes']; ?>


    <div class="related products">
        <h2><?php __('Prodotti');?></h2>
        <?php if (!empty($seller['Product'])):?>

            <?php foreach ($seller['Product'] as $product): ?>
        <div class="product-detail">
            <div class="detail-1">
                        <?php echo $this->Image->resize('/documents/image/product/'.$product['image'], '150', '120');?>
                <div class="name"><?php echo $product['name'];?></div>

                <div class="weight"><?php __('Peso: ');
                            echo $product['weight'];?></div>
                <div class="number"><?php __('Pezzi per collo: ');
                            echo $product['number'];?></div>
                <div class="value"><?php __('Prezzo: ');
                            echo $product['value'];?></div>
            </div>
            <div class="detail-2">
                        <?php if(!empty($product['text'])): ?>
                <div class="text"><?php echo $product['text'];?></div>
                        <?php endif; ?>
                <div class="pack"><?php __('Confezione: ');
                            echo $product['packing'];?></div>
            </div>
            <div class="clear"></div>
        </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
