<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _error extends MX_Controller {

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
		$this->page['page_title'] = "Error - ";
		$this->page['module_name'] = $this->router->fetch_class() . '/';

		$default_view = $this->init->default_view_vars();
		$this->script_tags = $default_view['scripts'];
		$this->link_tags = $default_view['links'];
		$this->meta_tags = $default_view['metas'];
	}

	function error_400() {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;
		$this->page['page_title'] .= "400 Bad Request";
		set_status_header(400);

		render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function error_404() {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;
		$this->page['page_title'] .= "404 Not Found";
		set_status_header(404);
		show_404();

		render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function error_restricted() {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;
		$this->page['page_title'] .= "Restricted Page";
		set_status_header(401);

		render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

}