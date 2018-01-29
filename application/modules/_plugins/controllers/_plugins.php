<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class _plugins extends MX_Controller {

    private $_plugins;
	var $page;
	var $assets;
	var $script_tags;
	var $link_tags;
	var $meta_tags;

    public function __construct() {
        parent::__construct();

        $this->_plugins = $this->Plugins_model->get_plugins();

        $this->plugins_lib->update_all_plugin_headers();

		$this->assets = base_url() . 'public/assets/';
		$this->load->module('__globalmodule');
		$user_id = $this->session->userdata('user_cookie')['id'];

		/*
		* Add and set variable for the page here
		*/
		$this->page['page_title'] = "Plugins";
		$this->page['module_name'] = $this->router->fetch_class() . '/';

		$default_view = $this->init->default_view_vars();
		$this->script_tags = $default_view['scripts'];
		$this->link_tags = $default_view['links'];
		$this->meta_tags = $default_view['metas'];
    }

    public function index() {

		$view = $this->page['module_name'] . 'plugin_list';
		$this->page['assets_url'] = $this->assets;

        $this->page['plugins'] = $this->Plugins_model->get_plugins();



        // var_dump(get_orphaned_plugins());

		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
    }

    public function config() {
        $data = array();

        if( ! $plugin = $this->input->get('plugin'))
        {
            redirect('/plugins');
        }
        elseif( ! isset($this->_plugins[$plugin]))
        {
            die("Unknown plugin {$plugin}");
        }
        elseif($this->_plugins[$plugin]->status != 1)
        {
            die("The plugin {$plugin} isn't enabled");
        }
        else
        {
            $data['plugin'] = $plugin;

            // Just some random stuff to send to the data, not needed unless the plugin
            // controller requires it
            $plugin_data = array('some' => 'data');

            if( ! $data['plugin_content'] = $this->plugins_lib->view_controller($plugin, $plugin_data))
            {
                die('No controller for this plugin');
            }
        }


        // $this->load->view('plugin_settings', $data);

		$view = $this->page['module_name'] . 'plugin_settings';
		$this->page['assets_url'] = $this->assets;

		$this->page['plugin'] = $data['plugin'];
		$this->page['plugin_content'] = $data['plugin_content'];

		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
    }


}