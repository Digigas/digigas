<div class="hampers index">
    <h2><?php __('Stai ordinando i prodotti per'); ?> <?php echo $user['User']['fullname']; ?></h2>
	<?php
	echo $this->Form->create('OrderedProduct', array('url' => array('action' => 'order_for_user_3')));
	echo $this->Form->hidden('user_id', array('value' => $user_id));
	echo $this->Form->hidden('hamper_id', array('value' => $hamper_id));
	echo $this->Form->hidden('seller_id', array('value' => $hamper['Hamper']['seller_id']));
	?>

    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php __('Prodotto'); ?></th>
            <th><?php __('Peso'); ?></th>
            <th><?php __('Prezzo unitario'); ?></th>
			<th><?php __('Opzioni'); ?></th>
            <th><?php __('Quantità'); ?></th>
        </tr>
		<?php
		foreach ($hamper['Product'] as $product):
			$selectOptions = array();
			for ($i = 1; $i < 11; $i++) {
				$value = (string) ($i * $product['number']);
				$selectOptions[$value] = $value;
			}
		?>
			<tr>
				<td>
				<?php
				echo $product['name'];
				?>
            </td>
            <td>
				<?php
				echo $product['weight'];
				?>
            </td>          
            <td>
				<?php
				echo $product['value'];
				?> &euro;
            </td>

			<td>
				<?php
				if ($product['option_list_1']) {
					$options = array();
					foreach (explode(';', $product['option_list_1']) as $opt)
						$options[$opt] = $opt;

					echo $this->Form->input('Product.' . $product['id'] . '.option_1', array('type' => 'select', 'options' => $options, 'label' => __($product['option_1'], true)));
				}
				if ($product['option_list_2']) {
					$options = array();
					foreach (explode(';', $product['option_list_2']) as $opt)
						$options[$opt] = $opt;
					echo $this->Form->input('Product.' . $product['id'] . '.option_2', array('type' => 'select', 'options' => $options, 'label' => __($product['option_2'], true)));
				}
				if ($product['show_note'] == 1) {
					echo $this->Form->input('Product.' . $product['id'] . '.note', array('type' => 'text', 'label' => __('Note', true)));
				}
				?>
			</td>

            <td class="actions">
				<?php echo $this->Form->select('Product.' . $product['id'] . '.quantity', $selectOptions); ?>
				&nbsp;
				<?php echo ucfirst($product['units']); ?>
            </td>
        </tr>
		<?php endforeach; ?>
			</table>
	<?php
				echo $this->Form->end(__('Avanti', true));
	?>
</div>