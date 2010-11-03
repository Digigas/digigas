<?php
$config = array(
    'GAS.name' => 'test',
    'language' => array('it'),
    'default_language' => 'it',
    'date.format' => 'D j M Y, H:i',
    'roles' => array(
        /*
         * -  prefix map
         * 0: root
         * 1: admin
         * 2: seller
         * 3: user
         *
         * - puoi modificare i nomi qui sotto come preferisci, ma mantieni lo stesso ordine
         */
        'root', 'admin', 'fornitore', 'utente'
    ),
    'email.from' => 'alessandro.falezza@gmail.com',
    'email.SMTPoptions' => array(
        /* 
         * 'port' => '',
         * 'host' => '',
         * 'timeout' => '',
         * 'username' => '',
         * 'password' => '',
         * 'client' => ''
         */
    ),

	'Product.units' => array(
		'pezzi' => 'pezzi',
		'kg' => 'kg',
		'etti' => 'etti',
		'litri' => 'litri',
		'fette' => 'fette',
		'scatole' => 'scatole',
		'bottiglie' => 'bottiglie',
		'cassette' => 'cassette',
		'paia' => 'paia'
	)
);