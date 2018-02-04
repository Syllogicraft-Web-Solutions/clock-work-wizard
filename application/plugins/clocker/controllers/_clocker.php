<?php

class _clocker extends MX_Controller {

    var $page;
    var $assets;
    var $script_tags;
    var $link_tags;
    var $meta_tags;

    public function __construct() {
        parent::__construct();

        $this->assets = base_url() . 'public/assets/';
        $this->load->module('__globalmodule');
        $user_id = $this->session->userdata('user_cookie')['id'];

        /*
        * Add and set variable for the page here
        */
        $this->page['page_title'] = "Plugins";
        $this->page['module_name'] = str_replace('_', '', get_class()) . '/';

        $default_view = $this->init->default_view_vars();
        $this->script_tags = $default_view['scripts'];
        $this->link_tags = $default_view['links'];
        $this->meta_tags = $default_view['metas'];
    }

    public function index() {
        $view = $this->page['module_name'] . 'index';

        $this->page['assets_url'] = $this->assets;
        ;
		$this->functions->add_sidebar('_' . $this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
        $this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
    }
 
    public function nyea() {
        echo "ASdasdasdas";
    }
 
 }