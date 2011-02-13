<?php

class Configurator extends AppModel {

	var $name = 'Configurator';

	function saveConfigs($data) {
		$return = true;
		foreach ($data as $key => $value) {
			if (!empty($value)) {
				$this->create();
				$data = $this->find('first', array(
						'conditions' => array('Configurator.key' => $key),
						'fields' => 'id'
					));
				if (!empty($data)) {
					if (!$this->save(array(
							'id' => $data['Configurator']['id'],
							'key' => $key,
							'value' => $value
						))) {
						$return = false;
					}
				} else {
					if (!$this->save(array(
							'key' => $key,
							'value' => $value
						))) {
						$return = false;
					}
				}
			}
		}
		Cache::delete('Config');

		//metto in cache i risultati
		$cache = $this->config();

		return $return;
	}

	function config() {
		$data = $this->find('all');
		$data = Set::combine($data, '{n}.Configurator.key', '{n}.Configurator.value');
		Cache::write('Config', $data);
		return $data;
	}

}
