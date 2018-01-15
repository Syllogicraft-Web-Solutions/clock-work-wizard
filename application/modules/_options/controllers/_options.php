<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _options extends MX_Controller {

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
		$this->page['page_title'] = "Options";
		$this->page['module_name'] = $this->router->fetch_class() . '/';

		$default_view = $this->init->default_view_vars();
		$this->script_tags = $default_view['scripts'];
		$this->link_tags = $default_view['links'];
		$this->meta_tags = $default_view['metas'];
	}

	function index() {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;


		


		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function add_option($option_name, $option_value) {

		$value = json_encode($option_value);

		// $data['owner_id']
		$data['option_name'] = $option_name;
		$data['option_value'] = $value;

		$this->__globalmodule->set_tablename('options');
		return $this->__globalmodule->_insert($data);
	}

	function get_option($option_name, $current_user = true) {

		$this->__globalmodule->set_tablename('options');
		$table = $this->__globalmodule->get_tablename();

		$query = "SELECT option_value FROM $table WHERE option_name = '$option_name'";

		$query .= $current_user ? " AND owner_id = " : "";

		return json_decode($this->__globalmodule->_custom_query($query));
	}
}