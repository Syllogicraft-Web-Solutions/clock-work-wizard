<?php

class Main_hooks extends MX_Controller {
	
	var $module;

	function __construct() {
		$this->redirect_url_save();

		// str_replace(base_url(), replace, subject)
	}

	public function redirect_url_save() {
		$this->session->userdata('redirect_here', urlencode((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
	}

	public function check_login($module_name) {
		// var_dump($this->session->userdata());
		if ($this->session->userdata('user_cookie') == NULL) {
			//$this->load->module('login');
			//$this->login->index();
			header('Location: ' . base_url() . '?refURL=' . $this->session->userdata('redirect_here'));
			// redirect('http://localhost/atss/', 'auto');
			// exit();
		}
	}


}