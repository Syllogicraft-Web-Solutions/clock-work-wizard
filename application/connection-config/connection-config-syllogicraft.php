<?php
	
	$environment = "development";

     if ($_SERVER['HTTP_HOST'] != 'localhost') {
          $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/';
          if ($environment == 'development')
               $url .= 'dev/';
          // exit($url);
          $url = $url;
          $host = 'sql303.epizy.com';
          $username = 'epiz_21585450';
          $password = 'syllogicraft123';
          $database_name = 'epiz_21585450_cww';
     } else {
          $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/cww/';
          // exit($url);
          $url = $url;
          $host = 'localhost';
          $username = 'root';
          $password = '';
          $database_name = 'cww';
     }
     
     define('BASE_URL', $url);
     // DB Settings here
     define('DB_HOSTNAME', $host);
     define('DB_USERNAME', $username);
     define('DB_PASSWORD', $password);
     define('DB_DATABASE', $database_name);