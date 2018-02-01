<?php
/**
 * Plugin Name: Hello Worldasdasd
 * Plugin URI: https://github.com/jhyland87/CI3_Plugin_System
 * Version: 1.0
 * Description: Apply colors to asset table cells or rows depending on values
 * Author: Justin Hyland
 * Author URI: http://justinhyland.com
 */
require_once(APPPATH . 'libraries/abstract.plugins.php');
require_once(APPPATH . 'libraries/trait.plugins.php');
class Hello_world extends CI3_plugin_system {
    use plugin_trait;

    public function __construct() {
        parent::__construct();

        add_filter('plugin_test.name', [$this,'alter_name'], 10);

        add_action('plugin_test.log', [$this, 'log_stuff']);


        add_filter('nyeam', [$this,'nyeam'], 10);

        //add_action('hello.person', [$this,'hello_age'], 4);
        //add_action('hello.person', [$this,'hello_name'], 3);
        //add_action('hello.person', [$this,'hello_height'], 3);
    }

  
    public function add_menu() {
        $CI =& get_instance();
        $uri = "plugin/" . strtolower(get_class($this));
        $CI->functions->add_menu('asd', false, base_url($uri), 'fa-clock', 'Clocker', '', 6);
    }

    static function install($data = NULL) {

    }

    function activate($data = NULL) {

    }

    function deactivate() {

    }

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
