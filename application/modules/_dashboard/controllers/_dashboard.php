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
		// $this->shortcode->add('bartag', array($this, 'bartag_func'));

		/*
		* Add and set variable for the page here
		*/
		$this->page['page_title'] = "Dashboard";
		$this->page['module_name'] = $this->router->fetch_class() . '/';


		$default_view = $this->init->default_view_vars();
		$this->script_tags = $default_view['scripts'];
		$this->link_tags = $default_view['links'];
		$this->meta_tags = $default_view['metas'];
		
	}


	function index() {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;

		// $this->functions->add_menu('dashboard', base_url() . 'dashboard', 'fa-home', 'Dashboard');
		// $this->functions->add_menu('nyeam', base_url() . 'dashboard', 'fa-home', 'Dashboard');

		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(true, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, true, $this->page);
		// var_dump($GLOBALS);
	}

}