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
				'duration' => '+12 hours',
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
		foreach ($activeSources as $n => $source) {
			$results[$n] = $this->readRss($source['RssSource']['url']);
			$results[$n]['digigas_title'] = $source['RssSource']['title'];

			$results[$n] = $this->array_change_key_case_recursive($results[$n]);

			if ($this->isRss($results[$n])) {
				//seleziono solo le ultime 4 news
				$results[$n]['rss']['channel']['item'] = array_slice($results[$n]['rss']['channel']['item'], 0, 4);
			} else {
				unset($results[$n]);
			}
		}
		return $results;
	}

	function readRss($url) {
		$rss = Cache::read($url);
		if (!$rss) {
			$rss = $this->HttpSocket->get($url);
			$rss = & new XML($rss);
			$rss = $rss->toArray();
			Cache::write($url, $rss);
		}
		return $rss;
	}

	function isRss($rssArray) {
		if (isset($rssArray['rss'])
			&& isset($rssArray['rss']['channel'])
			&& isset($rssArray['rss']['channel']['item'])) {
			return true;
		}
		return false;
	}

	function array_change_key_case_recursive($input, $case = CASE_LOWER) {
		if (!is_array($input)) {
			trigger_error("Invalid input array '{$array}'", E_USER_NOTICE);
			exit;
		}
		// CASE_UPPER|CASE_LOWER
		if (null === $case) {
			$case = CASE_LOWER;
		}
		if (!in_array($case, array(CASE_UPPER, CASE_LOWER))) {
			trigger_error("Case parameter '{$case}' is invalid.", E_USER_NOTICE);
			exit;
		}
		$input = array_change_key_case($input, $case);
		foreach ($input as $key => $array) {
			if (is_array($array)) {
				$input[$key] = $this->array_change_key_case_recursive($array, $case);
			}
		}
		return $input;
	}

}

