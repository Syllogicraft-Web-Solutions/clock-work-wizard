<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class _public extends MX_Controller{

	function __construct() {
		parent::__construct();
	}

	public function get_time($format = 'json') {
		echo date("m/d/y : H:i:s", time());
	}

}