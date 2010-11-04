<?php
$config = array(
    'GAS.name' => '%website_name%',
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
    'email.from' => '%website_email%',
    'email.SMTPoptions' => array(
        /* 
         * 'port' => '',
         * 'host' => '',
         * 'timeout' => '',
         * 'username' => '',
         * 'password' => '',
         * 'client' => ''
         */
    )
);