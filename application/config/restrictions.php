<?php

defined('BASEPATH') OR exit("No direct script access allowed");

$classes = array(
	'admin' => array(
	),
	'manager' => array(
		'_options'
	),
	'employee' => array(
		'_options', '_plugins'
	)	
);

$methods = array(
	'admin' => array(
	),
	'manager' => array(
	),
	'employee' => array(
		'add_employee'
	)
);

$config['restrictions']['classes'] = $classes;

$config['restrictions']['methods'] = $methods;