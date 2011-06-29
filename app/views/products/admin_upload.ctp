<div class="products form">
	<?php echo $this->Form->create('Product', array('type' => 'file')); ?>
    <fieldset>
        <h2><?php __('Importa prodotti'); ?></h2>

        <h3 class="expander"><?php __('Carica foglio di calcolo'); ?></h3>
        <div class="accordion">
			<?php
			
			echo $this->Form->input('seller_id', array('label' => __('Produttore', true)));
			echo $this->Form->input('spreadsheet', array('type' => 'file', 'label' => __('File xls', true)));
			?>
		<?php echo $this->Form->end(__('Carica', true)); ?>
        </div>
    </fieldset>    
		<?php if(isset($products)): ?>
            <?php echo $this->Form->create('Products', array('action' => 'import')); ?>
            <h3 ><?php __('Seleziona prodotti'); ?></h3>
            <div >
                <table cellpadding="0" cellspacing="0">
                <tr >
                        <th>&nbsp;</th>
                        <th> Produttore</th>
                        <th> Nome</th>
                        <th> Codice</th>
                        <th> Categoria</th>
                        <th> Peso</th>
                        <th> unità</th>
                        <th> Prezzo</th>
                        <th> U.M.</th>
                        <th> Opzioni 1</th>
                        <th> Opzioni 1: elenco </th>
                        <th> Opzioni 2</th>
                        <th> Opzioni 2: elenco </th>
                        <th> Permetti note</th>
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
                    
                    <td> <?php echo $this->Form->checkbox("importable.$i", array('checked' => true, 'value' => serialize($product), 'hiddenField' => false)) ?> </td>       
                    <td> <?php echo $product['Seller']['name']; ?> </td>    
                    <td> <?php echo $product['Product']['name']; ?> </td>       
                    <td><?php echo $product['Product']['code']; ?>&nbsp;</td>
                    <td><?php echo $product['ProductCategory']['name']; ?>&nbsp;</td>
                    <td><?php echo $product['Product']['weight']; ?>&nbsp;</td>
                    <td><?php echo $product['Product']['number']; ?>&nbsp;</td>
                    <td><?php echo $product['Product']['value']; ?>&nbsp;</td>
                    <td><?php echo $product['Product']['units']; ?>&nbsp;</td>
                    <td><?php echo $product['Product']['option_1']; ?>&nbsp;</td>
                    <td><?php echo $product['Product']['option_list_1']; ?>&nbsp;</td>
                    <td><?php echo $product['Product']['option_2']; ?>&nbsp;</td>
                    <td><?php echo $product['Product']['option_list_2']; ?>&nbsp;</td>
                    <td><?php if($product['Product']['show_note']) echo "Sì"; ?>&nbsp;</td>
                </tr>
            <?php endforeach; ?>
            </table>
            
            <?php echo $this->Form->end(__('Importa selezionati', true)); ?>
            </div>
        <?php endif ?>
        
        <h3 class="expander"><?php __('Istruzioni'); ?></h3>
        <div class="accordion">
            <p>Selezionare il produttore per il quale si vogliono importare i prodotti dopodiché scegliere il file</p>
            <p>E' possibile importare qualsiasi tipo di foglio di calcolo (.xls, .csv, .odt etc...). </p>
            <p>La prima riga del foglio di calcolo contiene le intestazioni delle colonne e pertanto verrà ingorata qualsiasi sia il suo contenuto</p>
            <p>Una volta selezionato il file premere 'Carica'. Apparirà un elenco dei prodotti disponibili per l'importazione. A questo punto premere 'Importa selezionati' per procedere all'importazione vera e propria'
            <p>Al prodotto verrà associata la categoria trovata nel foglio di calcolo. Se la categoria non è già presente nell'elenco categorie di digigas ne verrà creata una nuova</p>
            <p>Esempio di foglio di calcolo</p>
            <?php echo $this->Html->image('spreadsheet.png', array('alt' => 'esempio di foglio di calcolo'))?>
            
        </div>
    </div>
		<div class="actions">
		    <h3><?php __('Actions'); ?></h3>
		    <ul>
		        <li><?php echo $this->Html->link(__('Torna a produttori', true), array('controller' => 'sellers','action' => 'index')); ?></li>
            </ul>
        </div>