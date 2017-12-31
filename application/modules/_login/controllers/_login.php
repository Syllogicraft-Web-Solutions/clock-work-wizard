<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _login extends MX_Controller {

	var $page;
	var $assets;
	var $script_tags;
	var $link_tags;
	var $meta_tags;
	var $global;
	var $view;

	function __construct() {
		parent::__construct();

        if ($this->session->has_userdata('user_cookie'))
			header('Location: ' . base_url('dashboard'));

		$this->global = '__globalmodule';

		$this->assets = base_url() . 'public/assets/';
		$this->load->module($this->global);

		/*
		* Add and set variable for the page here
		*/
		$this->page['page_title'] = "Login";
		$this->page['module_name'] = $this->router->fetch_class() . "/";
		$this->page['assets_url'] = $this->assets;

		$default_view = $this->init->default_view_vars();
		$this->script_tags = $default_view['scripts'];
		$this->link_tags = $default_view['links'];
		$this->meta_tags = $default_view['metas'];
	}

	function index() {

		$view = $this->page['module_name'] . 'index';

		if (isset($_POST['login']) != '') {
			$result = $this->do_login($_POST);
			$this->page['login_status'] = $result;
		}

		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function do_login($data) {
		$global = $this->global;

		if ($data['login'] != "") {
			$this->$global->set_tablename('users');
			$tablename = $this->$global->get_tablename();
			$query = "SELECT * FROM $tablename WHERE user_login = \"{$data['username']}\" AND user_password = \"{$data['password']}\" LIMIT 1";

			$row = $this->$global->_custom_query($query);
			if ($row->result()) {
				foreach ($row->result() as $key => $val) {
					if ($val->user_status == 0) {
						return;
					}
					$this->session->set_userdata('user_cookie', array(
						'logged_in' => true,
						'id' => $val->id
					));
					$this->session->unset_userdata('redirect_here');
					if (isset($_GET['ref']) != '')
						header('Location: ' .  urldecode($_GET['ref']));
					redirect(base_url() . '_dashboard/', 'location');
				}
				return true;
			} else {
				$login_status = array(
					'code' => 'invalid_acc',
					'message' => 'Credential not found.'
				);
				return $login_status;
			}
		}
	}

	function do_logout() {
		$this->session->unset_userdata('user_cookie');
	}
}