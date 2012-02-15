<div class="products view">
    <h2><?php  echo $product['Product']['name']; ?></h2>
    <div class="code">
        <?php echo  $product['Product']['code']; ?>
    </div>

    
    <div class="image">
        <?php echo $this->Image->resize('/documents/image/product/' . $product['Product']['image'], 230, 230); ?>
    </div>

    <div class="category detail">
        <?php echo $product['ProductCategory']['name']; ?>
    </div>

    <div class="seller detail">
        <?php echo $this->Html->link($product['Seller']['name'], array('controller' => 'sellers', 'action' => 'view', $product['Seller']['id'])); ?>
    </div>

    <div class="text">
        <?php echo $product['Product']['text']; ?>
    </div>

    <div class="packing">
        <h4><?php
        __('Confezione');
        echo ': ';
        ?></h4>
        <?php
        echo $product['Product']['packing'];
        ?>
    </div>

	<?php if(!empty($product['Product']['weight'])): ?>
    <div class="weight detail">
        <h4 class="title"><?php
        __('Peso');
        echo ': ';
        ?></h4>
        <?php echo $product['Product']['weight']; ?>
    </div>
	<?php endif; ?>
    <div class="value detail">
        <h4 class="title"><?php
        __('Prezzo');
        echo ': ';
        ?></h4>
        <?php echo $this->Number->currency($product['Product']['value'], 'EUR'); ?> 
    </div>

	<div class="comments">
	<?php
							/*
							 * COMMENTI
							 */
//visualizzo i commenti solo per gli utenti registrati
							if ($this->Session->read('Auth.User.id')) {

								//elenco dei commenti
								echo $this->Html->tag('h3', __('Commenti', true));
								echo $this->UserComment->view($comments, false, true);


								//form di inserimento commenti
								echo $this->UserComment->add('Product', $product['Product']['id']);
							}
	?>
	</div>
	
</div>

<div class="actions">
    <ul>
        <li><?php echo $this->Html->link('<< '.__('indietro', true), $referer); ?></li>
    </ul>
</div>