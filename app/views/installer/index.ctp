<div class="installer form">
	<h2>Benvenuto nel programma di installazione di Digigas3</h2>

	<p>
		Digigas è un software <a href="http://it.wikipedia.org/wiki/Opensource">opensource</a> dedicato
		ai Gruppi di Acquisto Solidale (GAS) e studiato per facilitare la gestione quotidiana degli acquisti.
	</p>
	<p>
		Puoi trovare tutto il supporto che cerchi sul sito <a href="http://www.digigas.org">www.digigas.org</a>
	</p>
	<p>
		Questo software è distribuito con licenza <a href="http://it.wikipedia.org/wiki/GNU_General_Public_License">GPL</a>
	</p>

	<h2>Inizia da qui</h2>
	<?php
	echo $this->Form->create();

	echo $this->Html->tag('h3', 'Configurazione di base del sito');
	echo $this->Html->div('note', 'Definisci il nome e l\'e-mail del sito');
	echo $this->Form->input('website_name', array('type' => 'text', 'label' => 'Nome del GAS'));
	echo $this->Form->input('website_email', array('type' => 'text', 'label' => 'Email generale da utilizzare per tutti i messaggi provenienti da Digigas'));

	echo $this->Html->tag('h3', 'Dati del database');
	echo $this->Html->div('note', 'Normalmente questi dati ti vengono forniti dal tuo provider');
	echo $this->Form->input('db_host', array('type' => 'text', 'label' => 'Nome host'));
	echo $this->Form->input('db_name', array('type' => 'text', 'label' => 'Nome del database'));
	echo $this->Form->input('db_user', array('type' => 'text', 'label' => 'Utente'));
	echo $this->Form->input('db_pwd', array('type' => 'text', 'label' => 'Password'));

	echo $this->Html->tag('h3', 'Dati dell\'utente amministratore');
	echo $this->Html->div('note', 'Ricordati username e password: ti serviranno per accedere all\'amminsitrazione di Digigas!');
	echo $this->Form->input('admin_username', array('type' => 'text', 'label' => 'Username'));
	echo $this->Form->input('admin_pwd', array('type' => 'text', 'label' => 'Password'));
	echo $this->Form->input('admin_email', array('type' => 'text', 'label' => 'E-mail'));
	echo $this->Form->input('admin_first_name', array('type' => 'text', 'label' => 'Nome'));
	echo $this->Form->input('admin_last_name', array('type' => 'text', 'label' => 'Cognome'));

	echo $this->Form->end('Avanti >');
	?>
</div>