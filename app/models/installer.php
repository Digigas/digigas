<?php

class Installer extends AppModel {

	var $name = 'Installer';
	var $useTable = false;
	var $writableDirsForInstall = array('config', 'tmp');
	var $writableDirsForProduction = array('tmp', 'webroot/documents');
	var $sqlFilename = 'digigas.sql';

	function step1($data) {

		//imposto i permessi sulle directories
		if (!$this->setFolderPermissions($this->writableDirsForInstall)) {
			return false;
		}

		//scrivo il file di configurazione del database
		if (!$this->configDatabase($data)) {
			return false;
		}

		//scrivo il file di configurazione config.php
		if (!$this->writeConfig($data)) {
			return false;
		}

		return true;
	}

	function step2($data) {

		//eseguo lo script MySQL
		if(!$this->mySqlInstall()) {
			return false;
		}
		
		//inserisco i dati di configurazione dell'utente admin
		App::import('model', 'User');
		$User = new User;
		$User->create(array('User' => array(
			'first_name' => $data['admin_first_name'],
			'last_name' => $data['admin_last_name'],
			'username' => $data['admin_username'],
			'password' => Security::hash($data['admin_pwd'], null, true),
			'email' => $data['admin_email'],
			'role' => 0,
			'active' => 1
			)));

		if(!$User->save()) {
			return false;
		}

		//scrivo il file installed.txt nella directory config
		App::import('core', 'File');
		$installedFile = new File(APP . 'config' . DS . 'installed.txt');
		$installedFile->create();

		//imposto correttamente i permessi sulle directories per la produzione
		if(!$this->setFolderPermissions($this->writableDirsForInstall, '0755')) {
			return false;
		}
		if(!$this->setFolderPermissions($this->writableDirsForProduction, '0755')) {
			return false;
		}

		//tutto ok
		return true;
	}

	function setFolderPermissions($folder, $permission = '0755') {
		if (is_string($folder)) {
			$folder = array($folder);
		}

		App::import('core', 'Folder');

		$return = true;
		foreach ($folder as $dir) {
			$dir = APP . str_replace('/', DS, $dir);
			//$dir = new Folder($dir, $permission);
			$Folder = new Folder($dir);
			if (!$Folder->chmod($dir, $permission)) {
				$return = false;
			}
		}
		return $return;
	}

	function configDatabase($config) {
		App::import('core', 'File');

		$file = new File(APP . 'config' . DS . 'database.php');

		$tpl = new File(APP . 'config' . DS . 'database_empty.php');

		$string = $tpl->read();

		$string_to_write = str_replace(
				array('empty', '%host%', '%login%', '%password%', '%database%'),
				array('mysql', $config['db_host'], $config['db_user'], $config['db_pwd'], $config['db_name']),
				$string);

		if($file->write($string_to_write)) {
			return true;
		}
		return false;
	}

	function writeConfig($config) {
		App::import('core', 'File');

		$file = new File(APP . 'config' . DS . 'config.php');

		$tpl = new File(APP . 'config' . DS . 'config_empty.php');

		$string = $tpl->read();

		$string_to_write = str_replace(
				array('%website_name%', '%website_email%'),
				array($config['website_name'], $config['website_email']),
				$string);

		if($file->write($string_to_write)) {
			return true;
		}
		return false;
	}

	function mySqlInstall() {
		App::import('core', 'Folder');
		App::import('core', 'File');

		$sqlPath = APP . 'config' . DS . 'sql' . DS;

		$sqlFolder = new Folder($sqlPath);
		$sqlFiles = $sqlFolder->read();
		$sqlFiles = $sqlFiles[1];

		$db = ConnectionManager::getDataSource('default');

        if(!$db->isConnected()) {
            echo 'Could not connect to database. Please check the settings in app/config/database.php and try again';
            exit();
        }

		//eseguo lo script principale
		if(is_file($sqlPath.$this->sqlFilename)) {
			$this->__executeSQLScript($db, $sqlPath.$this->sqlFilename);
		} else {
			return false;
		}

		foreach($sqlFiles as $sqlFile) {
			if(preg_match('/^update_/', $sqlFile)) {
				$this->__executeSQLScript($db, $sqlPath.$sqlFile);
			}
		}

		return true;
	}

	function __executeSQLScript($db, $fileName) {
        $statements = file_get_contents($fileName);
        $statements = explode(';', $statements);

        foreach ($statements as $statement) {
            if (trim($statement) != '') {
                $db->query($statement);
            }
        }
    }

}