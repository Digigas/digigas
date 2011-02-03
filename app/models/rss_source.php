<?php
class RssSource extends AppModel {
	var $name = 'RssSource';
	var $HttpSocket;

	function __construct() {
		App::import('Xml');
		App::import('Core', 'HttpSocket');
		$this->HttpSocket = new HttpSocket();

		Cache::config('rss', array(
			'engine' => 'File',
			'duration'=> '+12 hours',
			'path' => CACHE . 'rss',
			'prefix' => 'rss_'
		));

		parent::__construct();
	}

	function getConnectedRss() {

		$activeSources = $this->find('all', array(
			'conditions' => array('active' => 1),
			'fields' => array('title', 'url'),
			'order' => array('weight ASC', 'id DESC')));

		$results = array();
		foreach($activeSources as $n => $source) {
			$results[$n] = $this->readRss($source['RssSource']['url']);
			$results[$n]['digigas_title'] = $source['RssSource']['title'];
		}

		return $results;
	}

	function readRss($url) {
		$rss = Cache::read($url);
		if(!$rss) {
			$rss = $this->HttpSocket->get($url);
			$rss =& new XML($rss);
			$rss = $rss->toArray();
			Cache::write($url, $rss);
		}
		return $rss;
	}
}

