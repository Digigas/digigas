<div class="hampers form">
    <?php echo $this->Form->create('Hamper');?>
    <fieldset>
        <h2><?php __('Modifica paniere di '); echo $this->data['Seller']['name']; ?></h2>

        <h3 class="expander"><?php __('Imposta il paniere'); ?></h3>
        <div class="accordion">
            <?php
            echo $this->Form->input('id');
            
            echo $this->Form->input('name', array('label' => __('Nome', true)));
            echo $this->Form->hidden('seller_id');
            
            echo $this->element('admin/datetimeselect', array('field' => 'start_date', 'label' => __('Data di apertura', true)));
            echo $this->element('admin/datetimeselect', array('field' => 'end_date', 'label' => __('Data di chiusura', true)));
            echo $this->element('admin/datetimeselect', array('field' => 'checkout_date', 'label' => __('Termine per il pagamento', true)));
            echo $this->element('admin/datetimeselect', array('field' => 'delivery_date_on', 'label' => __('Data di consegna', true)));
            echo $this->element('admin/datetimeselect', array('field' => 'delivery_date_off', 'label' => __('Termine massimo per la consegna', true)));

            echo $this->Form->input('delivery_position', array('type' => 'text', 'label' => __('Luogo di consegna', true)));
            echo $this->Form->input('notes', array('label' => __('Note', true)));
			echo $this->Form->input('is_template', array('label' => __('Salva come modello', true)));
            ?>
        </div>

        <h3 class="expander"><?php __('Inserisci i prodotti'); ?></h3>
        <div class="accordion">

            <?php
            //elenco delle categorie
            foreach($productCategories as $category):
            ?>
            <h3 class="expander"><?php echo $category['ProductCategory']['name']; ?></h3>
            <div class="accordion">
                <?php
                //elenco dei prodotti nella categoria
                foreach($category['Product'] as $product):
                ?>
                <div class="product-item">
                    <?php
                    if(in_array($product['id'], $relatedProducts)) {
                        $checked = 'checked';
                    } else {
                        $checked = false;
                    }
                    echo $this->Image->resize('/documents/image/product/'.$product['image'], 120, 120);
                    echo $this->Html->div('input checkbox',
                        $this->Form->checkbox('Product.Product. .', array('value' => $product['id'], 'hiddenField' => false, 'checked' => $checked))
                        .$this->Html->tag('label', $product['name'])
                    )
                    ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>

        </div>
    </fieldset>
    <?php echo $this->Form->end(__('Salva', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Torna a panieri', true), array('action' => 'index'));?></li>
        <li><?php echo $this->Html->link(__('Torna a modelli di paniere', true), array('action' => 'index_templates'));?></li>
    </ul>
</div>


<?php
$this->Layout->blockStart('js_on_load');

echo <<<JS

//selezione prodotti
$('.product-item')
    .hover(
        function(){
            $(this).addClass('hover');
        },
        function(){
            $(this).removeClass('hover');
        })
    .click(function(){
        var checkbox = $(this).find('input[type="checkbox"]');
        var checked = checkbox.attr('checked');
        if(checked) {
            checkbox.attr('checked', '');
            $(this).removeClass('checked');
        } else {
            checkbox.attr('checked', 'checked');
            $(this).addClass('checked');
        }
    })
    .has('input[checked="checked"]').addClass('checked');
JS;

$this->Layout->blockEnd();
?>