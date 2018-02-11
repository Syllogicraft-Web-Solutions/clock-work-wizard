<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class _public extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('date');
		$this->load->module('_globalmodule');
	}

	public function get_time($format = 'json') {
		// $timestamp = time();
		// $timezone  = 'UP8';
		// $daylight_saving = TRUE;
		// $t = gmt_to_local($timestamp, $timezone, $daylight_saving);
		
		date_default_timezone_set('Asia/Manila');
		echo date('h:i:s A', time());
		// $datestring = '%L';
		// $time = time();
		// echo mdate($datestring, $time);
		// echo local_to_gmt(time());
		// $timestamp = local_to_gmt(time());
		// $timezone  = 'UM8';
		// $daylight_saving = TRUE;
		// echo gmt_to_local($timestamp, $timezone, $daylight_saving);
		
		// echo timezone_menu('UP8');
	}

	public function get_day() {
		
		echo date('l', time());
	}

	public function get_month() {
		
		echo date('F', time());
	}

	public function get_day_of_month() {
		
		echo date('d', time());
	}
}