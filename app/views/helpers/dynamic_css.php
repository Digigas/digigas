<?php
class DynamicCssHelper extends Helper {
	var $helpers = array('Html', 'Session');
	var $cssParams = array(
		'colors.body_background' => array('selector' => 'body', 'style' => 'background'),
		'colors.content_background' => array('selector' => '#content', 'style' => 'background'),
		'colors.h2' => array('selector' => 'h2', 'style' => 'color'),
		'colors.text_2' => array('selector' => 'a', 'style' => 'background'),
		'colors.text_3' => array('selector' => 'a:hover', 'style' => 'background')
	);

	function render() {
		$return = '';

		foreach($this->cssParams as $param => $css) {
			$config = Configure::read($param);
			if(!empty($config)) {
				$return .= $css['selector'] . "{" . $css['style'] . ": " . $config . "} \n";
			}
		}

		return '<style type="text/css">' . $return . '</style>';
	}
}