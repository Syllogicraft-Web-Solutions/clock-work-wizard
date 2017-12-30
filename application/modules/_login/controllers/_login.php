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
		// exit();

		// if ($this->session->has_userdata('user_cookie') && isset($_GET['ref']) != '') {
		// 	header('Location: ' .  urldecode($_GET['ref']));//$this->session->userdata('redirect_here')));
        // } else 
        if ($this->session->has_userdata('user_cookie'))
			header('Location: ' . base_url('dashboard'));

		/*$this->load->helper('text');
		$this->load->helper('string');
		$this->load->library('shortcode');*/
		$this->global = '__globalmodule';

		$this->assets = base_url() . 'public/assets/';
		$this->load->module($this->global);
		// $this->load->model('__globalmodel');
		// $this->shortcode->add('bartag', array($this, 'bartag_func'));

		/*
		* Add and set variable for the page here
		*/
		$this->page['page_title'] = "Login";
		$this->page['module_name'] = $this->router->fetch_class() . "/";
		$this->page['assets_url'] = $this->assets;


		$this->view = $this->page['module_name'] . 'index';

		$this->script_tags = array(
			array(
				'script_name' => 'jQuery',
				'src' => $this->assets . 'jquery/jquery-3.2.1.min.js',
				'type' => '',
				'attrs' => array()
			), array(
				'script_name' => 'jQuery Migrate Plugin',
				'src' => $this->assets . 'jquery/jquery-migrate-1.4.1.min.js',
				'type' => '',
				'attrs' => array()
			), array(
				'script_name' => 'jQuery UI',
				'src' => $this->assets . 'jquery-ui-custom/jquery-ui.min.js',
				'type' => '',
				'attrs' => array()
			)
		);
		$this->link_tags = array(
			array(
				'link_name' => 'W3.CSS',
				'rel' => '',
				'type' => '',
				'href' => $this->assets . 'w3-css/4-w3.css'
			),
			array(
				'link_name' => 'W3.CSS Theme',
				'rel' => '',
				'type' => '',
				'href' => $this->assets . 'css/theme.css'
			), array(
				'link_name' => 'Custom Stylings',
				'rel' => '',
				'type' => '',
				'href' => $this->assets . 'css/custom.css'
			), array(
				'link_name' => 'jQuery UI CSS',
				'rel' => '',
				'type' => '',
				'href' => $this->assets . 'jquery-ui-custom/jquery-ui.min.css'
			), array(
				'link_name' => 'FontAwesome 5',
				'rel' => '',
				'type' => '',
				'href' => $this->assets . 'fontawesome/web/css/fontawesome-all.min.css'
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


	function index() {		


		// if ($this->session->has_userdata('user_cookie') && isset($_GET['ref']) != '') {
		// 	header('Location: ' .  urldecode($_GET['ref']));//$this->session->userdata('redirect_here')));
  //       } else if ($this->session->has_userdata('user_cookie'))
		// 	header('Location: ' . base_url('_dashboard'));	

		if (isset($_POST['login']) != '') {
			$result = $this->do_login($_POST);
			$this->page['login_status'] = $result;
		}

		$this->functions->render_page(true, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $this->view, true, $this->page);
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
				//$this->functions->render_page(true, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $this->view, true, $this->page);
			}
		}
	}

	function do_logout() {

		$this->session->unset_userdata('user_cookie');

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