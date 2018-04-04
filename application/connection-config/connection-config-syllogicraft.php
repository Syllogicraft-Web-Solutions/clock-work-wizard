<?php
	
     $environment = "development";

     $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/cww/';
     // exit($url);
     $url = $url;
     $host = 'localhost';
     $username = 'root';
     $password = '';
     $database_name = 'cww';

     if ($_SERVER['HTTP_HOST'] != 'localhost' && explode('.', $_SERVER['HTTP_HOST'])[0] != '192') {
          $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/';
          //if ($environment == 'development')
          //     $url .= 'dev/';
          //exit($url);
          if (explode('.', $_SERVER['HTTP_HOST'])[0] == 'syllogicraft') {
	          $url = $url;
	          $host = 'sql303.epizy.com';
	          $username = 'epiz_21585450';
	          $password = 'syllogicraft123';
	          $database_name = 'epiz_21585450_cww';
	  } else if (explode('.', $_SERVER['HTTP_HOST'])[0] == 'jitsemt') {
	          $url = $url;
	          $host = 'localhost';
	          $username = 'cww_admin';
	          $password = 'syllogicraft12399';
	          $database_name = 'cww';
	  }
     } 
     define('BASE_URL', $url);
     // DB Settings here
     define('DB_HOSTNAME', $host);
     define('DB_USERNAME', $username);
     define('DB_PASSWORD', $password);
     define('DB_DATABASE', $database_name);