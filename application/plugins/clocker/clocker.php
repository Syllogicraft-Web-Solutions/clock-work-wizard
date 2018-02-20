<?php
/**
 * Plugin Name: Clocker
 * Plugin URI: http://johnabelardom.epizy.com/clocker
 * Version: 0.0.1
 * Description: Display current time, record time-in time-out of the user
 * Author: John Abelardo Manangan II
 * Author URI: http://johnabelardom.epizy.com
 */
class Clocker extends CI3_plugin_system {
    use plugin_trait;

    var $mdl_name;
    var $current_user_id;

    public function __construct() {
        parent::__construct();
        $this->mdl_name = get_class();
        $CI =& get_instance();
        $CI->functions->get_current_user_id();
        require_once(__DIR__ . '/hooks.php');
    }
  
    public function add_menu() {
        $CI =& get_instance();
        $uri = "mdl/" . strtolower(get_class());
        $CI->functions->add_menu('clocker', false, base_url($uri), 'fa-clock', 'Clocker', '_clocker', 6);
    }

    function set_default_timezone($timezone_id = '') {
        // $CI =& get_instance();
        // $this->current_user_id = $CI->functions->get_current_user_id();

        // if (! $this->current_user_id)
        //     return false;
        // if ($CI->functions->option_exists('clocker_timezone', $this->current_user_id)) {
        //     $time_zone = $CI->functions->get_option('clocker_timezone', $this->current_user_id);
        // } else {
        //     $CI->functions->add_option('clocker_timezone', $_POST['clocker_timezone'], $this->current_user_id);
        //     $time_zone = $CI->functions->get_option('clocker_timezone', $this->current_user_id);
        // }
        date_default_timezone_set($timezone_id);
    }
    
    function display_realtime_clock() {
        require_once(__DIR__ . '/views/clock.php');
    }
    
    public function display_clocker_buttons() {
        $punched_out = 0;
        $punched_in = 1;
        $break_in = 2;
        $break_out = 3;

        $clocker_status = $this->check_clocker_status();
        if ($clocker_status == $punched_out) {
            do_action('clocker.punch-in-btn');
        } elseif ($clocker_status > 0) { 
            if ($clocker_status == $punched_in) {
                //display break in and punched_out
                do_action('clocker.break-in-btn');
                do_action('clocker.punch-out-btn');
            } elseif ($clocker_status == $break_in) {
                // display break out and punch out
                do_action('clocker.break-out-btn');
                do_action('clocker.punch-out-btn');
            } elseif ($clocker_status == $break_out) {
                // display break in and punch out
                do_action('clocker.break-in-btn');
                do_action('clocker.punch-out-btn');
            }
        }
    }

    public function display_punch_in_btn() {
    ?>
        <button id="punch-in-btn" class="w3-button w3-ripple w3-theme-action w3-hover-theme">Punch in</button>
        <script>
            jQuery('#punch-in-btn').click(function() {
                jQuery.post('<?= base_url('clocker/_clocker/do_clockers/punch-in/' . $this->current_user_id) ?>', function(data) {
                    console.log(data);
                    if (data)
                        window.location = window.location;
                    else
                        alert("Unable to do action, please try refreshing the page.");
                })
            });
        </script>
    <?php 
    }

    public function display_punch_out_btn() {
    ?>
        <button id="punch-out-btn" class="w3-button w3-red">Punch out</button>
        <script>
            jQuery('#punch-out-btn').click(function() {
                jQuery.post('<?= base_url('clocker/_clocker/do_clockers/punch-out/' . $this->current_user_id) ?>', function(data) {
                    console.log(data);
                    if (data)
                        window.location = window.location;
                    else
                        alert("Unable to do action, please try refreshing the page.");
                })
            });
        </script>
    <?php 
    }

    public function display_break_in_btn() {
    ?>
        <button id="break-in-btn" class="w3-button w3-ripple w3-theme-l1 w3-hover-theme">Break</button>
        <script>
            jQuery('#break-in-btn').click(function() {
                jQuery.post('<?= base_url('clocker/_clocker/do_clockers/break-in/' . $this->current_user_id) ?>', function(data) {
                    console.log(data);
                    if (data)
                        window.location = window.location;
                    else
                        alert("Unable to do action, please try refreshing the page.");
                })
            });
        </script>
    <?php 
    }

    public function display_break_out_btn() {
    ?>
        <button id="break-out-btn" class="w3-button w3-orange">Stop break</button>
        <script>
            jQuery('#break-out-btn').click(function() {
                jQuery.post('<?= base_url('clocker/_clocker/do_clockers/break-out/' . $this->current_user_id) ?>', function(data) {
                    console.log(data);
                    if (data)
                        window.location = window.location;
                    else
                        alert("Unable to do action, please try refreshing the page.");
                })
            });
        </script>
    <?php 
    }

    public function check_clocker_status() {
        $CI =& get_instance();
        $this->current_user_id = $CI->functions->get_current_user_id();
        if (! $this->current_user_id)
            return false;

        if ($CI->functions->user_meta_exists('clocker_status', $this->current_user_id))
            return $CI->functions->get_user_meta('clocker_status', $this->current_user_id);
        else {
            $CI->functions->add_user_meta('clocker_status', 0, $this->current_user_id);
            return $CI->functions->get_user_meta('clocker_status', $this->current_user_id);
        }
    }

    public function do_punch_in($user_id) {
        $CI =& get_instance();
        $CI->load->helper('date');
        $CI->__globalmodule->set_tablename('clocker_records');
        
        $data['user_id'] = $user_id;
        $data['punch_in'] = date('Y-m-d H:i:s');
        $data['crypt_code'] = $CI->functions->encrypt_data($data['punch_in']);
        if($CI->__globalmodule->_insert($data))
            return $CI->functions->update_meta_user('clocker_status', 1, $user_id);
    }

    public function do_punch_out($user_id) {
        $CI =& get_instance();
        $CI->load->helper('date');
        $CI->__globalmodule->set_tablename('clocker_records');
        $table = $CI->__globalmodule->get_tablename();
        
        $data['user_id'] = $user_id;
        $data['punch_out'] = date('Y-m-d H:i:s');
        $id_to_update = $CI->__globalmodule->_custom_query("SELECT id FROM $table WHERE user_id = $user_id ORDER BY id desc LIMIT 1")->result()[0]->id;

        if($CI->__globalmodule->_update_where('id', $id_to_update, $data))
            return $CI->functions->update_meta_user('clocker_status', 0, $user_id);
    }

    public function do_break_in($user_id) {
        $CI =& get_instance();
        $CI->load->helper('date');
        $CI->__globalmodule->set_tablename('clocker_records');
        $table = $CI->__globalmodule->get_tablename();
        
        $data['user_id'] = $user_id;
        $data['break_in'] = date('Y-m-d H:i:s');
        $id_to_update = $CI->__globalmodule->_custom_query("SELECT id FROM $table WHERE user_id = $user_id ORDER BY id desc LIMIT 1")->result()[0]->id;

        if($CI->__globalmodule->_update_where('id', $id_to_update, $data))
            return $CI->functions->update_meta_user('clocker_status', 2, $user_id);
    }

    public function do_break_out($user_id) {
        $CI =& get_instance();
        $CI->load->helper('date');
        $CI->__globalmodule->set_tablename('clocker_records');
        $table = $CI->__globalmodule->get_tablename();
        
        $data['user_id'] = $user_id;
        $data['break_out'] = date('Y-m-d H:i:s');
        $id_to_update = $CI->__globalmodule->_custom_query("SELECT id FROM $table WHERE user_id = $user_id ORDER BY id desc LIMIT 1")->result()[0]->id;

        if($CI->__globalmodule->_update_where('id', $id_to_update, $data))
            return $CI->functions->update_meta_user('clocker_status', 3, $user_id);
    }


    /** Default functions */
    static function install($data = NULL) {
        $CI =& get_instance();
        $CI->load->module('clocker/_clocker');
        $CI->_clocker->install_table();
    }

    function activate($data = NULL) {

    }

    function deactivate($data = NULL) {

	}

    // Controller for plugin, used to manage the plugin, not required though.
    public function controller($data = NULL) {
        $CI =& get_instance();
        $this->current_user_id = $CI->functions->get_current_user_id();
        $CI->load->helper('date');
        
        $time_zone = $CI->functions->get_option('clocker_timezone', $this->current_user_id);
        $time_zone = $time_zone == '' ? 'UP8' : $time_zone;

        if(isset($_POST['save_settings'])) {
            $this->current_user_id = $CI->functions->get_current_user_id();
            if (! $this->current_user_id)
                return false;
            if ($CI->functions->option_exists('clocker_timezone', $this->current_user_id)) {
                $CI->functions->update_option('clocker_timezone', $_POST['clocker_timezone'], $this->current_user_id);
                $time_zone = $CI->functions->get_option('clocker_timezone', $this->current_user_id);
            } else {
                $CI->functions->add_option('clocker_timezone', $_POST['clocker_timezone'], $this->current_user_id);
                $time_zone = $CI->functions->get_option('clocker_timezone', $this->current_user_id);
            }
            $time_zone = $_POST['clocker_timezone'];
        }
        ob_clean();
        require_once('views/components/settings-form.php');
        return ob_get_clean();
    }

    // Just an example filter to alter the values of an array
    public function alter_name($data)
    {
        array_walk($data, function(&$item, $key){
            if(strtolower($item) === 'jane')
                $item = 'john';

            $item = ucfirst($item);
        });

        return $data;
    }

    // Example plugin action, just logs.. stuff
    public function log_stuff($prefix, $data)
    {

        log_message('info', "[{$prefix}] " . __METHOD__ . ": Logging stuff - " . ((is_array($data) || is_object($data)) ? serialize($data) : $data));
    }
}
