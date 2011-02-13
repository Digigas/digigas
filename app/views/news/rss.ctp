<?php

$this->set('documentData', array(
	'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

$this->set('channelData', array(
	'title' => Configure::read('GAS.name'),
	'link' => $this->Html->url('/', true),
	'description' => Configure::read('GAS.name') . ' news',
	'language' => 'it-IT'));


foreach ($news as $post) {
	$postTime = strtotime($post['News']['created']);

	$postLink = array(
		'controller' => 'news',
		'action' => 'view',
		$post['News']['id']);
	// You should import Sanitize
	App::import('Sanitize');
	// This is the part where we clean the body text for output as the description
	// of the rss item, this needs to have only text to make sure the feed validates
	$bodyText = preg_replace('=\(.*?\)=is', '', $post['News']['summary'] . $post['News']['text']);
	$bodyText = $this->Text->stripLinks($bodyText);
	$bodyText = Sanitize::stripAll($bodyText);
	$bodyText = $this->Text->truncate($bodyText, 400, array(
			'ending' => '...',
			'exact' => true,
			'html' => true,
		));

	echo $this->Rss->item(array(), array(
		'title' => $post['News']['title'],
		'link' => $postLink,
		'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
		'description' => $bodyText,
		'dc:creator' => $post['User']['fullname'],
		'pubDate' => $post['News']['created']));
}
?>