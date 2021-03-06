<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class Init extends Functions {

	var $redirect;
	var $assets;

	var $script_tags;
	var $link_tags;
	var $meta_tags;


	function __construct() {
		$this->redirect_url_save();
		$this->display_menu_links();
		$this->assets = base_url() . 'public/assets/';
	}

	function display_menu_links() {		
		// add more links here
		add_menu('dashboard', false, base_url() . 'dashboard', 'fa-home', 'Dashboard', '_dashboard', 1);
		add_menu('users', false, base_url() . 'users', 'fa-user', 'Users', '_users', 2);
		add_menu('options', false, base_url('options'), 'fa-cogs', 'Options', '_options', 3);
		add_menu('plugins', false, base_url('plugins'), 'fa-plug', 'Plugins', '_plugins', 4);
		add_menu('logout', false, base_url() . '_login/do_logout', 'fa-power-off', 'Logout', '_login', 99);
	}

	public function redirect_url_save() {
		$CI =& get_instance();

		$CI->load->library('session');
		$curr_class = $CI->router->fetch_class();
		if ($curr_class == '_login' || $curr_class == '_default' || $CI->session->userdata('user_cookie'))
			return;
		$CI->session->set_userdata('redirect_here', urlencode((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
	}

	function default_view_vars() {
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
			), array(
				'script_name' => 'Custom JS',
				'src' => $this->assets . 'js/custom.js',
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
				'link_name' => 'Widgets Stylings',
				'rel' => '',
				'type' => '',
				'href' => $this->assets . 'css/widgets.css'
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
			), array(
				'link_name' => 'FontAwesome 5',
				'rel' => 'icon',
				'type' => 'image/png',
				'href' => $this->assets . 'img/logo.png'
			)
		);
		$this->meta_tags = array(
			array(
				'meta_name' => 'Viewport',
				'name' => 'viewport',
				'content' => 'width=device-width, initial-scale=1'
			)
		);
		return array('scripts' => $this->script_tags, 'links' => $this->link_tags, 'metas' => $this->meta_tags);
	}

	function load_admin_vars() {
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
}