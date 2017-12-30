<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Globals {

	function __construct() {
		// $GLOBALS['user_defined_globals'] = array();
	}

	function set_globals($name, $value = '', $type = '') {

		if ($type != '' && $name) {
			$GLOBALS['user_defined_globals'][$type][$name] = $value;
		} elseif ($name) {
			$GLOBALS['user_defined_globals'][$name] = $value;
		} else {
			exit('Setting a global variable needs the paramater "name"');
		}

	}

	function get_globals($name = '', $type = '') {
		if ($name != '' && $type != '')
			return $GLOBALS['user_defined_globals'][$type][$name];
		else if ($name == '')
			return $GLOBALS['user_defined_globals'];
		else if ($name != '')
			return $GLOBALS['user_defined_globals'][$name];
	}

}