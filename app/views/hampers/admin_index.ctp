<div class="hampers index">
    <h2><?php __('Panieri');?></h2>
	<?php //echo __('Data attuale', true) . ': ' . date('D j M Y, H:i'); ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Stato'); ?></th>
            <th><?php echo $this->Paginator->sort( __('Produttore', true), 'seller_id');?></th>
            <th><?php echo $this->Paginator->sort(__('Nome', true), 'name');?></th>
            <th><?php echo $this->Paginator->sort(__('Data di apertura', true), 'start_date');?></th>
            <th><?php echo $this->Paginator->sort(__('Data di chiusura', true), 'end_date');?></th>
            <th class="actions"><?php __('Azioni');?></th>
			<th class="actions"><?php __('Esporta');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($hampers as $hamper):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
        <tr<?php echo $class;?>>
            <td>
                <?php
                $now = strtotime('now');
                if(strtotime($hamper['Hamper']['start_date']) < $now && strtotime($hamper['Hamper']['end_date']) > $now) {
                    //paniere aperto
                    echo $this->Html->image('oxygen/16x16/actions/button_ok.png', array(
                        'alt' => __('Aperto', true),
                        'title' => __('Aperto', true)));
                } else if(strtotime($hamper['Hamper']['end_date']) < $now && strtotime($hamper['Hamper']['delivery_date_off']) > $now) {
                    //paniere in consegna
                    echo $this->Html->image('oxygen/16x16/actions/alarmclock.png', array(
                        'alt' => __('In consegna entro ', true).digi_date($hamper['Hamper']['delivery_date_off']),
                        'title' => __('In consegna entro ', true).digi_date($hamper['Hamper']['delivery_date_off'])));
                } else if(strtotime($hamper['Hamper']['end_date']) < $now && date_is_empty($hamper['Hamper']['delivery_date_on'])) {
                    //paniere in consegna,ma la data di consegna non è specificata
                    echo $this->Html->image('oxygen/16x16/actions/alarmclock.png', array(
                        'alt' => __('In attesa di consegna', true),
                        'title' => __('In attesa di consegna', true)));
                } else {
                    //paniere chiuso
                    echo $this->Html->image('oxygen/16x16/actions/button_cancel.png', array(
                        'alt' => __('Chiuso', true),
                        'title' => __('Chiuso', true)));
                }
                ?>
            </td>
            <td>
                    <?php echo $this->Html->link($hamper['Seller']['name'], array('seller' => $hamper['Seller']['id'])); ?>
            </td>
            <td><?php echo $hamper['Hamper']['name']; ?>&nbsp;</td>
            <td><?php echo digi_date($hamper['Hamper']['start_date']); ?>&nbsp;</td>
            <td>
				<?php
				if (!date_is_empty($hamper['Hamper']['end_date'])) {
					echo digi_date($hamper['Hamper']['end_date']);
				} else {
					__('Data non assegnata');
				}
				?>
				&nbsp;</td>
            <td class="actions">
                    <?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $hamper['Hamper']['id'])); ?>
                    <?php echo $this->Html->link(__('Dettaglio ordini', true), array('controller' => 'ordered_products', 'action' => 'index_hamper', $hamper['Hamper']['id'])); ?>
                    <?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $hamper['Hamper']['id']), null, sprintf(__('Sei sicuro di voler eliminare il Paniere # %s?', true), $hamper['Hamper']['id'])); ?>
			</td>
			<td class="actions">
					<?php echo $this->Html->image('oxygen/16x16/mimetypes/pdf.png', array('url' => array('controller' => 'ordered_products', 'action' => 'print_pdf_hamper', $hamper['Hamper']['id']), 'title' => __('PDF', true))); ?>
                    <?php echo $this->Html->image('oxygen/16x16/mimetypes/application_vnd.ms_excel.png', array('url' => array('controller' => 'ordered_products', 'action' => 'print_excel_hamper', $hamper['Hamper']['id']), 'title' => __('esporta excel', true))); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
        'format' => __('Pagina %page% di %pages%, paniere da %start% a %end% di %count%', true)
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
        <li class="dropdown"><?php __('Nuovo paniere'); ?>
            <ul>
                <?php foreach($sellers as $seller): ?>
                <li><?php echo $this->Html->link(__('Per ', true).$seller['Seller']['name'], array('action' => 'add', $seller['Seller']['id'])); ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li><?php echo $this->Html->link(__('Nuovo paniere da modello', true), array('action' => 'index_templates')); ?></li>
        <li class="dropdown"><?php __('Visualizza'); ?>
            <ul>
                <li><?php echo $this->Html->link(__('Tutti', true), array('action' => 'index')); ?></li>
                <li><?php echo $this->Html->link(__('Solo panieri aperti', true), array('actives' => 1)); ?></li>
                <li><?php echo $this->Html->link(__('Solo i modelli', true), array('templates' => 1)); ?></li>
            </ul>
        </li>
        <li class="dropdown"><?php __('Visualizza per produttore'); ?>
            <ul>
                <li><?php echo $this->Html->link(__('Tutti', true), array('action' => 'index')); ?></li>
                <?php foreach($sellers as $seller): ?>
                <li><?php echo $this->Html->link($seller['Seller']['name'], array('seller' => $seller['Seller']['id'])); ?></li>
                <?php endforeach; ?>
            </ul>
        </li>        
    </ul>
</div>