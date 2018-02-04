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
        $this->page['not_installed'] = get_orphaned_plugins();

        if (isset($_GET['plugin_message']) && $_GET['plugin_message'] != '') {
            $decrypted_data = json_decode($this->functions->decrypt_data($_GET['plugin_message']));
            $this->page['plugin_change_message'] = (array) $decrypted_data;
        }

        if (isset($_POST['plugin_name']) && $_POST['plugin_name'] != '') {
            $action = $_POST['action_type'] . '_plugin';
            $plugin_name = $_POST['plugin_name'];
            if ($action == 'activate_plugin') {
                $res = $this->$action($plugin_name);
                $message = $res == true ? "Plugin activated." : "Failed to activate $plugin_name plugin";
                
                $page_message['alert_type'] = $res == true ? 'w3-green' : 'w3-red';
                $page_message['message'] = $message;
                
                $json = json_encode($page_message);
                $encrypt = $this->functions->encrypt_data($json);
                redirect(base_url('/plugins?plugin_message=' . urlencode($encrypt)));
            }
            else if ($action == 'deactivate_plugin') {
                $res = $this->$action($plugin_name);
                $message = $res == true ? "Plugin deactivated." : "Failed to deactivate $plugin_name plugin";
                
                $page_message['alert_type'] = $res == true ? 'w3-green' : 'w3-red';
                $page_message['message'] = $message;
                
                $json = json_encode($page_message);
                $encrypt = $this->functions->encrypt_data($json);
                redirect(base_url('/plugins?plugin_message=' . urlencode($encrypt)));
            }
        }

        if (isset($_POST['install_type']) && $_POST['install_type'] != '') {
            $type = $_POST['install_type'];
            $plugin_name = $_POST['plugin'];
            if ($type == 'install') {
                $res =  $this->install_to_database($plugin_name);

                // var_dump($res);exit();

                $message = ! $res ? "Plugin installed." : "Failed to install $plugin_name plugin";
                
                $page_message['alert_type'] = ! $res ? 'w3-green' : 'w3-red';
                $page_message['message'] = $message;
                
                $json = json_encode($page_message);
                $encrypt = $this->functions->encrypt_data($json);
                redirect(base_url('/plugins?plugin_message=' . urlencode($encrypt)));
            } else if ($type == 'install_activate') {
                $res = $this->install_activate_to_database($plugin_name);

                $mess = $res['install'] ? "Failed to install. " : "Installed successfully. ";
                $mess .= $res['activate'] != true ? "Failed to activate. " : "Plugin activated.";

                $message = $mess;
                
                $page_message['alert_type'] = $res ? 'w3-green' : 'w3-red';
                $page_message['message'] = $message;
                
                $json = json_encode($page_message);
                $encrypt = $this->functions->encrypt_data($json);
                redirect(base_url('/plugins?plugin_message=' . urlencode($encrypt)));
            }
        }

		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
    }

    public function activate_plugin($system_name, $data = NULL) {
        return enable_plugin($system_name, $data);
    }

    public function deactivate_plugin($system_name, $data = NULL) {
        return disable_plugin($system_name, $data);
    }

    public function install_to_database($system_name) {
        return install_plugin($system_name);
    }

    public function install_activate_to_database($system_name, $data = NULL) {
        $res['install'] = $this->install_to_database($system_name);
        $res['activate'] = $this->activate_plugin($system_name, $data);
        return $res;
    }

    public function config($plugin = "") {
        $data = array();

        if( ! $plugin ) {
            $plugin = $_GET['plugin'];
            // redirect('/plugins');
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

    public function view_plugin_as_mdl($plugin = false, $display = 'index') {
        if (! $plugin)
            redirect(base_url('dashboard'));
            
        $mdl = "_{$plugin}";
        $this->load->module("{$plugin}/" . $mdl);
        $m_e = method_exists($this->$mdl, $display);
        if ($m_e) 
            $this->$mdl->$display();
    }

}