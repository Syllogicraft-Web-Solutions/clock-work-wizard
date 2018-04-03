<?php
/**
 * Plugin Name: API Plugin
 * Plugin URI: http://johnabelardom.epizy.com/api-plugin
 * Version: 0.0.1
 * Description: API plugin for outside authentication and stuff
 * Author: John Abelardo Manangan II
 * Author URI: http://johnabelardom.epizy.com
 */
class api extends CI3_plugin_system {
    use plugin_trait;

    var $mdl_name;
    var $current_user_id;

    public function __construct() {
        parent::__construct();
        $this->mdl_name = get_class();
        $CI =& get_instance();
        $CI->load->library('functions');
        get_current_user_id();
        require_once(__DIR__ . '/hooks.php');
        // add_action('display_widgets_dashboard', [$this, 'add_widget']);
    }

    /** Default functions */
    static function install($data = NULL) {
        $CI =& get_instance();
        // $CI->load->module('api_plugin/_api_plugin');
        // $CI->_api_plugin->install_table();
    }

    function activate($data = NULL) {

    }

    function deactivate($data = NULL) {

	}

    // Controller for plugin, used to manage the plugin, not required though.
    public function controller($data = NULL) {
    
    }

    // Example plugin action, just logs.. stuff
    public function log_stuff($prefix, $data) {

        log_message('info', "[{$prefix}] " . __METHOD__ . ": Logging stuff - " . ((is_array($data) || is_object($data)) ? serialize($data) : $data));
    }
}
