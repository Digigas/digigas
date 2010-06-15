<div class="pages index">
    <h2>Struttura del sito</h2>
    <p>
        <?php
        echo $paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
        ?></p>
    <div class="paging">
        <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
        | 	<?php echo $paginator->numbers();?>
        <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
    </div>
    <table id="tree-table" cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Menu'); ?></th>
            <th><?php __('Titolo'); ?></th>
            <th><?php __('Attiva'); ?></th>
            <th><?php __('Privata'); ?></th>
            <th class="actions" colspan="5"><?php __('Azioni'); ?></th>
        </tr>
        <?php
//L'array $elements = array ('id elemento' => 'profondita')
        $i = 0;
        foreach ($pages as $page):
            if($page['Page']['parent_id'] > 0) {
                $class = 'child-of-node-'.$page['Page']['parent_id'];
            }
            else {
                $class = '';
            }

            if ($i++ % 2 == 0) {
                $class .= ' altrow';
            }

            ?>
        <tr class="<?php echo $class;?>" id="node-<?php echo $page['Page']['id'] ?>">
            <td class="first">
    <?php
    if($page['Page']['menuable'] == '0') echo '<span class="inactive">';
                    echo $page['Page']['menu'];
                    if($page['Page']['menuable'] == '0') echo '</span>';
                    ?>
            </td>
            <td>
    <?php echo $page['Page']['title']; ?>
            </td>
            <td>
    <?php echo $this->Html->link($page['Page']['active']?__('si', true):__('no', true), array('action'=>'toggle_active', $page['Page']['id'])); ?>
            </td>
            <td>
    <?php echo $page['Page']['private']?__('si', true):__('no', true); ?>
            </td>
            <td class="actions">
    <?php echo $this->Html->link(__('Sposta in su', true), array('action'=>'up', $page['Page']['id'])); ?>
            </td>
            <td class="actions">
    <?php echo $this->Html->link(__('Sposta in giu', true), array('action'=>'down', $page['Page']['id'])); ?>
            </td>
            <td class="actions">
    <?php echo $this->Html->link(__('Visualizza', true), array('action'=>'view', $page['Page']['slug'], 'admin'=>false)); ?>
            </td>
            <td class="actions">
    <?php echo $this->Html->link(__('Modifica', true), array('action'=>'edit', $page['Page']['id'])); ?>
            </td>
            <td class="actions">
    <?php echo $this->Html->link(__('Elimina', true), array('action'=>'delete', $page['Page']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $page['Page']['id'])); ?>
            </td>
        </tr>
<?php endforeach; ?>
    </table>
</div>


<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('Nuova pagina', true), array('action'=>'add')); ?></li>
        <li><?php echo $this->Html->link(__('Gestisci le news', true), array('controller'=>'news')); ?></li>
    </ul>
</div>