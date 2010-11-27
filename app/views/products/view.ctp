<div class="products view">
    <h2><?php  echo $product['Product']['name']; ?></h2>
    <div class="code">
        <?php echo  $product['Product']['code']; ?>
    </div>

    
    <div class="image">
        <?php echo$this->Image->resize('/documents/image/product/' . $product['Product']['image'], 400, 400); ?>
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

    <div class="weight detail">
        <h4 class="title"><?php
        __('Peso');
        echo ': ';
        ?></h4>
        <?php echo $product['Product']['weight']; ?>
    </div>

    <div class="number detail">
        <h4 class="title"><?php
        __('Capi per collo');
        echo ': ';
        ?></h4>
        <?php echo $product['Product']['number']; ?>
    </div>

    <div class="value detail">
        <h4 class="title"><?php
        __('Prezzo');
        echo ': ';
        ?></h4>
        <?php echo $product['Product']['value']; ?> &euro;
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
								echo $this->Comment->view($product['Comment']);


								//form di inserimento commenti
								echo $this->Comment->add('Product', $product['Product']['id']);
							}
	?>
	</div>
	
</div>

<div class="actions">
    <ul>
        <li><?php echo $this->Html->link('<< '.__('indietro', true), $referer); ?></li>
    </ul>
</div>