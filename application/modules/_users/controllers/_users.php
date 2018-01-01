<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _users extends MX_Controller {

	var $page;
	var $assets;
	var $script_tags;
	var $link_tags;
	var $meta_tags;

	function __construct() {
		parent::__construct();
		$this->assets = base_url() . 'public/assets/';
		$this->load->module('__globalmodule');
		$user_id = $this->session->userdata('user_cookie')['id'];

		/*
		* Add and set variable for the page here
		*/
		$this->page['page_title'] = "Users";
		$this->page['module_name'] = $this->router->fetch_class() . '/';

		$default_view = $this->init->default_view_vars();
		$this->script_tags = $default_view['scripts'];
		$this->link_tags = $default_view['links'];
		$this->meta_tags = $default_view['metas'];

		if (! $user_id) {
			header('Location: ' . base_url('login'));
			exit();
		}


		if ($this->check_user_profile($user_id))
			header('Location: ' . base_url($this->page['module_name'] . 'edit_profile/' . $user_id));
	}

	function index() {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;

		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function check_user_profile($id) {
		$this->__globalmodule->set_tablename('user_meta');
		$query = "SELECT * FROM user_meta WHERE user_id = $id";
		$result = $this->__globalmodule->_custom_query($query)->result();
		return $result;
	}

	function edit_profile($id) {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;
		
		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}


	function register() {
		$view = $this->page['module_name'] . 'register-account';
		$this->page['assets_url'] = $this->assets;

		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function register_employee() {
		$referral = isset($_GET['referral']);

		// if (! $referral)
		// 	exit("You need a referral");

		$view = $this->page['module_name'] . 'register-employee';
		$this->page['assets_url'] = $this->assets;

		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function add_employee() {
		$view = $this->page['module_name'] . 'add-employee';
		$this->page['assets_url'] = $this->assets;

		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function add_default_meta_key($id, $manager) {
		$user_meta_keys = array(
			array(
				'user_id' => $id,
				'meta_key' => 'first_name'
			), array(
				'user_id' => $id,
				'meta_key' => 'last_name'
			), array(
				'user_id' => $id,
				'meta_key' => 'middle_name'
			), array(
				'user_id' => $id,
				'meta_key' => 'description'
			), array(
				'user_id' => $id,
				'meta_key' => 'capability'
			), array(
				'user_id' => $id,
				'meta_key' => 'address'
			), array(
				'user_id' => $id,
				'meta_key' => 'city'
			), array(
				'user_id' => $id,
				'meta_key' => 'state'
			), array(
				'user_id' => $id,
				'meta_key' => 'zip'
			), array(
				'user_id' => $id,
				'meta_key' => 'cellphone'
			), array(
				'user_id' => $id,
				'meta_key' => 'workphone'
			), array(
				'user_id' => $id,
				'meta_key' => 'homephone'
			), array(
				'user_id' => $id,
				'meta_key' => 'birthday'
			), array(
				'user_id' => $id,
				'meta_key' => 'status'
			), array(
				'user_id' => $id,
				'meta_key' => 'clock_status',
				'meta_value' => '0'
			), array(
				'user_id' => $id,
				'meta_key' => 'manager'
			)
		);
	}
}