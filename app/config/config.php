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
        'super-amministratore', 'amministratore', 'referente prodotti', 'utente'
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

	//unità di misura per le schede prodotto
	'Product.units' => array(
		'pezzi' => 'pezzi',
		'kg' => 'kg',
		'etti' => 'etti',
		'litri' => 'litri',		
		'cassette' => 'cassette',
		'scatole' => 'scatole',
		'bottiglie' => 'bottiglie',
		'barattoli' => 'barattoli',
		'fette' => 'fette',
		'paia' => 'paia'
	),

	//controller alla cui gestione possono accedere i referenti - non modificare
	'ReferentUser' => array(
		'allowed_controllers' => array('OrderedProducts', 'Hampers', 'Products', 'Sellers'),
		'allowed_sellers' => false)
);