<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _dashboard extends MX_Controller {

	var $page;
	var $assets;
	var $script_tags;
	var $link_tags;
	var $meta_tags;

	function __construct() {
		parent::__construct();
		$this->assets = base_url() . 'public/assets/';
		$this->load->module('__globalmodule');

		/*
		* Add and set variable for the page here
		*/
		$this->page['page_title'] = "Dashboard";
		$this->page['module_name'] = $this->router->fetch_class() . '/';


		$default_view = $this->init->default_view_vars();
		$this->script_tags = $default_view['scripts'];
		$this->link_tags = $default_view['links'];
		$this->meta_tags = $default_view['metas'];

		$this->init_();
	}

	function index() {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;

		add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center', 'padding' => '10px'));
		render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function init_() {
		$this->hooks();
	}

	function hooks() {
		add_action('display_widgets_dashboard', [$this, 'asd']);
	}

	function asd() {
		echo render_blank('components/widget', true);
	}
}