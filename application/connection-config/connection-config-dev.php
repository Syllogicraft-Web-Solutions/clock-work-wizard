<?php
	
	$environment = "development";

	define('BASE_URL', 'http://syllogicraft.epizy.com/cww/dev/');

	define('DB_HOSTNAME', 'sql100.epizy.com');
	define('DB_USERNAME', 'epiz_21301143');
	define('DB_PASSWORD', 'syllogicraft99');
	define('DB_DATABASE', 'epiz_21301143_cww');

	$email = array(
		'smtp_user' => 'registration@syllogicraft.epizy.com',
		'smtp_pass' => 'syllogicraft99',
		'mailtype' => 'html'
	);
	define('MAIL_SETTINGS', $email);