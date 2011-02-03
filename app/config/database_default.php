<?php

//file iniziale da includere nel pacchetto di installazione con il nome database.php

class DATABASE_CONFIG {
	var $default = array(
		'driver' => 'empty',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'database_name',
		'prefix' => '',
	);
}