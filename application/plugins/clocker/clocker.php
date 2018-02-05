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

        add_filter('plugin_test.name', [$this,'alter_name'], 10);

        add_action('plugin_test.log', [$this, 'log_stuff']);
        add_action('clocker.clocker_menu_button', [$this, 'add_menu']);
        add_action('clocker.clock', [$this, 'display_realtime_clock']);
        add_action('clocker.display_buttons', [$this, 'display_clocker_buttons']);
        add_action('clocker.check_clocker_status', [$this, 'check_clocker_status']);
        //add_action('hello.person', [$this,'hello_age'], 4);
        //add_action('hello.person', [$this,'hello_name'], 3);
        //add_action('hello.person', [$this,'hello_height'], 3);
        // do_action('clocker.check_clocker_status');

        do_action('clocker.clocker_menu_button');
    }

    function display_realtime_clock() {
        $CI =& get_instance();
        $CI->load->view('clock');
    }
  
    public function add_menu() {
        $CI =& get_instance();
        $uri = "mdl/" . strtolower(get_class());
        $CI->functions->add_menu('clocker', false, base_url($uri), 'fa-clock', 'Clocker', '_clocker', 6);
    }

    public function display_clocker_buttons() {
        $clocker_status = $this->check_clocker_status();
        if ($clocker_status == 0) {
    ?> <button class="w3-button w3-ripple w3-theme-action w3-hover-theme">Punch in</button>
    <?php } elseif (is_array($clocker_status)) { ?>
        <button class="w3-button w3-red">Punch out</button>

        <button class="w3-button w3-ripple w3-theme-l1 w3-hover-theme">Break</button>
        <button class="w3-button w3-orange">Stop break</button>
    <?php
        }
    }

    public function check_clocker_status() {
        $punched_out = 0;
        $punched_in = 1;
        $break_in = 2;
        $break_out = 3;
        $CI =& get_instance();
        $this->current_user_id = $CI->functions->get_current_user_id();
        if (! $this->current_user_id)
            return false;
        if ($CI->functions->user_meta_exists('clocker_status', $this->current_user_id))
            return $CI->functions->get_user_meta('clocker_status', $this->current_user_id);
        else {
            $CI->functions->add_user_meta('clocker_status', json_encode(0), $this->current_user_id);
            return $CI->functions->get_user_meta('clocker_status', $this->current_user_id);
        }
    }

    static function install($data = NULL) {

    }

    function activate($data = NULL) {

    }

    /* function deactivate() {

	} */

    // Controller for plugin, used to manage the plugin, not required though.
    public function controller($data = NULL) {
        $content = '';

        // See if form was submitted
        if(isset($_POST['foo']))
        {
            $foo = $_POST['foo'];

            // Do something with POST data
            $content .= "You said <strong>{$foo}</strong>..<hr>";
        }

        ob_clean();

        // do_action('nyeam');

        $content .= '<form action="" method="POST">'
            . '<input type="text" name="foo" value="' . @$foo . '"><br>'
            . '<input type="submit">'
            . '</form>';

        echo $content;

        return ob_get_clean();
    }

    public function nyeam() {
        $CI =& get_instance();
        return get_class();
        $CI->functions->add_menu('asd', false, base_url('asda'), 'fa-plug', 'Pluadagins', 'asdas', 6);
        echo "<h1>Nyeam!</h1>";
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
