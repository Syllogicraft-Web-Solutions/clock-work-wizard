<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _default extends MX_Controller {

	var $page;
	var $assets;
	var $script_tags;
	var $link_tags;
	var $meta_tags;

	function __construct() {
		parent::__construct();


		/*$this->load->helper('text');
		$this->load->helper('string');
		$this->load->library('shortcode');*/
		$this->assets = base_url() . 'public/assets/';
		$this->img = base_url() . 'public/img/';
		$this->img = base_url() . 'public/img/';
		$this->load->module('globalcontroller');
		// $this->shortcode->add('bartag', array($this, 'bartag_func'));

		/*
		* Add and set variable for the page here
		*/
		$this->page['page_title'] = "Coming Soon";
		$this->page['module_name'] = "_default/";
		$this->page['assets_url'] = base_url($this->assets);
		$this->page['img_url'] = base_url($this->img);
	}


	function index() {
		$view = $this->page['module_name'] . 'sample';
		// $this->load_default();
		modules::run('__globalmodule/__globalmodule/set_tablename', 'nyeam_table');
		$this->page['data'] = modules::run('__globalmodule/__globalmodule/get_tablename');
		$this->page['assets_url'] = $this->assets;
		$this->page['img_url'] = $this->img;

		$this->link_tags = array(		);
		$this->link_tags = array(
			array(
				'link_name' => 'W3.CSS',
				'rel' => '',
				'type' => '',
				'href' => $this->assets . 'w3-css/4-w3.css'
			), array(
				'link_name' => 'Font Google',
				'rel' => 'stylesheet',
				'type' => '',
				'href' => 'https://fonts.googleapis.com/css?family=Raleway'
			), array(
				'link_name' => 'FontAwesome 5',
				'href' => $this->assets . 'fontawesome/web/css/fontawesome-all.min.css',
				'type' => '',
				'rel' => ''
			)

		);
		$this->meta_tags = array(
			array(
				'meta_name' => 'Viewport',
				'name' => 'viewport',
				'content' => 'width=device-width, initial-scale=1'
			)
		);
		$this->functions->render_blank(array(), array(), $view, $this->page);
	}


	/*
	* Call this function to load all the JS and CSS frameworks and libraries
	*/
	function load_default() {
		$this->script_tags = array(
			array(
				'script_name' => 'jQuery',
				'src' => $this->assets . 'jquery/jquery-3.2.1.min.js',
				'type' => '',
				'attrs' => array()
			),
			array(
				'script_name' => 'jQuery Migrate Plugin',
				'src' => $this->assets . 'jquery/jquery-migrate-1.4.1.min.js',
				'type' => '',
				'attrs' => array()
			),
			array(
				'script_name' => 'jQuery UI',
				'src' => $this->assets . 'jq-default-ui/jquery-ui.min.js',
				'type' => '',
				'attrs' => array()
			),
			array(
				'script_name' => 'Bootstrap JS',
				'src' => $this->assets . 'bootstrap/js/bootstrap.min.js',
				'type' => 'type',
				'attrs' => array()
			),
			array(
				'script_name' => 'FontAwesome 5',
				'src' => $this->assets . 'fontawesome/svg-with-js/js/fontawesome-all.min.js',
				'type' => '',
				'attrs' => array('defer')
			)
		);
		$this->link_tags = array(
			array(
				'link_name' => 'Bootstrap CSS',
				'rel' => '',
				'type' => 'type',
				'href' => $this->assets . 'bootstrap/css/bootstrap.min.css'
			),
			array(
				'link_name' => 'jQuery UI CSS',
				'rel' => '',
				'type' => 'type',
				'href' => $this->assets . 'jq-default-ui/jquery-ui.min.css'
			),
			array(
				'link_name' => 'W3.CSS',
				'rel' => '',
				'type' => 'type',
				'href' => $this->assets . 'w3-css/4-w3.css'
			)
		);
		$this->meta_tags = array(
			array(
				'meta_name' => 'Viewport',
				'name' => 'viewport',
				'content' => 'width=device-width, initial-scale=1'
			)
		);
	}
}

	/*function bartag_func($atts) {
		extract($this->shortcode->shortcode_atts(array(
			'foo' => 'no foo',
			'baz' => 'default baz',
		), $atts));

		return "foo = {$foo}";
	}*/