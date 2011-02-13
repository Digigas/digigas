<div class="links">
	<?php
	echo $this->Html->image('oxygen/32x32/actions/rss.png', array('url' => array('controller' => 'news', 'action' => 'rss')))
	?>
</div>

<?php echo $this->Html->link(
					$this->Html->image('digigas_web.png', array('alt'=> __('Digigas, software per la gestione di gruppi di acquisto solidale', true), 'border' => '0')),
					'http://www.digigas.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>