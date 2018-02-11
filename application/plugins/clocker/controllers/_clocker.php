<?php

class _clocker extends MX_Controller {

    var $page;
    var $assets;
    var $script_tags;
    var $link_tags;
    var $meta_tags;

    public function __construct() {
        parent::__construct();
		$this->load->helper('date');

        $this->assets = base_url() . 'public/assets/';
        $this->load->module('__globalmodule');
        $user_id = $this->session->userdata('user_cookie')['id'];

        /*
        * Add and set variable for the page here
        */
        $this->page['page_title'] = "Clocker";
        $this->page['module_name'] = str_replace('_', '', get_class()) . '/';

        $default_view = $this->init->default_view_vars();
        $this->script_tags = $default_view['scripts'];
        $this->link_tags = $default_view['links'];
        $this->meta_tags = $default_view['metas'];
    }

    public function index() {
        $view = $this->page['module_name'] . 'index';

        $this->page['assets_url'] = $this->assets;

		$this->functions->add_sidebar('_' . $this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
        $this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
    }
 
    public function install_table() {
        $this->load->model('_clockerModel');
        $this->_clockerModel->install_clocker_table();
    }
    
    public function do_clockers($action, $user_id = '') {
        $user_id = $this->functions->get_current_user_id();
        if ($action == 'punch-in')
            echo do_action('clocker.punch-in', [$user_id])[0];
        elseif ($action == 'punch-out')
            echo do_action('clocker.punch-out', [$user_id])[0];
        elseif ($action == 'break-in')
            echo do_action('clocker.break-in', [$user_id])[0];
        elseif ($action == 'break-out')
            echo do_action('clocker.break-out', [$user_id])[0];
        else
            echo json_encode(false);
    }

 }