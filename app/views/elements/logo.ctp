<?php
$logo = Configure::read('GAS.image');
if(empty($logo)) {
	echo $this->Html->image('digigas.png', array('url' => '/', 'alt' => Configure::read('GAS.name')));
} else {
	echo $this->Html->image($logo, array('url' => '/', 'alt' => Configure::read('GAS.name')));
}
?>