<div class="products index">
	<h2>
    <?php
    __('Archivio prodotti');
    if(isset($categoryName)) {
        echo ' '.__('nella categoria', true).' '.$categoryName;
    }
    if(isset($sellerName)) {
        echo ' '.__('del produttore', true).' '.$sellerName;
    }
    ?>
    </h2>
    
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort(__('Categoria', true), 'product_category_id');?></th>
			<th><?php echo $this->Paginator->sort(__('Codice', true), 'code');?></th>
			<th><?php echo $this->Paginator->sort(__('Nome', true), 'name');?></th>
			<th><?php echo $this->Paginator->sort(__('Produttore', true), 'seller_id');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($products as $product):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($product['ProductCategory']['name'], array('category' => $product['ProductCategory']['id']), array('title' => __('Visualizza solo questa categoria di prodotti', true))); ?>
		</td>		
		<td><?php echo $product['Product']['code']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['name']; ?>&nbsp;</td>
        <td>
			<?php echo $this->Html->link($product['Seller']['name'], array('seller' => $product['Seller']['id']), array('title' => __('Visualizza solo prodotti di questo produttore', true))); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $product['Product']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $product['Product']['id']), null, sprintf(__('Sei sicuro di voler eliminare il Prodotto # %s?', true), $product['Product']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%, riga da %start% a %end% di %count%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('precedente', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('successiva', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>        
        <li><?php 
		if(isset($this->params['named']['seller'])) {
			echo $this->Html->link(__('Nuovo prodotto', true), array('action' => 'add', 'seller' => $this->params['named']['seller']));
		} else {
			echo $this->Html->link(__('Nuovo prodotto', true), array('action' => 'add'));
		}
		?></li>
		<li><?php echo $this->Html->link(__('Gestisci i produttori', true), array('controller' => 'sellers', 'action' => 'index')); ?> </li>
        <li class="dropdown">
            <?php __('Visualizza per produttore'); ?>
            <ul>
                <li><?php echo $this->Html->link('Tutti i produttori', array('action' => 'index')) ?></li>
                <?php
                foreach($sellers as $id => $seller) {
                    echo $this->Html->tag('li',
                        $this->Html->link($seller,
                            array('seller' => $id)));
                }
                ?>
            </ul>
        </li>
		<li class="dropdown">
            <?php __('Visualizza per categoria'); ?>
            <ul>
                <li><?php echo $this->Html->link('Tutte le categorie', array('action' => 'index')) ?></li>
                <?php
                foreach($productCategories as $id => $productCategory) {
                    echo $this->Html->tag('li',
                        $this->Html->link($productCategory,
                            array('category' => $id)));
                }
                ?>
            </ul>
        </li>
        <li><?php echo $this->Html->link(__('Gestisci le categorie', true), array('controller' => 'product_categories', 'action' => 'index')); ?> </li>
	</ul>
</div>