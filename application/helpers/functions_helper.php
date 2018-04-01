<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$page;
$sidebar;


/**
*
* Frontend Functions
*
*/

/**
 * @param $start - true if you want to render the start of the HTML document
 * @param $page_title - the title of the page
 * @param $js = array(
 *					'script_name' => 'name',
     *					'src' => 'location',
     *					'type' => 'javascript',
     *					'attrs' => array('async', 'defer')
     *				);
     * @param $link = array(
     *					'link_name' => $link_name,
     *					'rel' => $rel,
     *					'type' => $type,
     *					'href' => $href
     *				  );
     * @param $meta = array(
     *					'meta' => $meta_name,
     *					'name' => $name,
     *					'content' => $content
     *				  );
     * @param $view_loc = location of the view
     * @param $data = the data that will be passed inside the view
     */
function index() {
    echo "nyeam";
}

// Please use $page variable inside the page you are going to render, if you have a data to pass in it
function render_page($display_header = false, $page_title = "", $js = array(), $link = array(), $meta = array(), $view_file = "", $data = [], $preloader = '94') {
    $CI =& get_instance();
    $page['page_title'] = $page_title;
    $page['page'] = $data;
    global $sidebar;
    $sidebar['with_sidebar'] = false;

    $CI->load->view('head/html-start.php', $page); //start head tag
    
    if (sizeof($js) > 0) { // add script tags
        foreach ($js as $key => $val) {
            add_script($val['script_name'], $val['src'], $val['type'], $val['attrs']);
        }
    }
    if (sizeof($link) > 0) { // add link tags
        foreach ($link as $key => $val) {
            add_link($val['link_name'], $val['rel'], $val['type'], $val['href']);
        }
    }
    if (sizeof($meta) > 0) { // add meta tags
        foreach ($meta as $key => $val) {
            add_meta($val['meta_name'], $val['name'], $val['content']);
        }
    }

    $CI->load->view('head/html-end-head.php'); //end head tag

    if ($preloader) {
        $view = "components/pre-loader-";
        if (view_exists($view . $preloader))
            $CI->load->view($view . $preloader);
        else
            $CI->load->view($view . '94');
    }

    if ($display_header)
        $CI->load->view('components/header-logged-in'); //end head tag

    if (isset($sidebar['show'])) {
        $sidebar['with_sidebar'] = true;
        if (is_logged_in())
            render_sidebar($CI->globals->get_globals('menu_links'), $sidebar['options'], $sidebar['current_module_name']);
    }

    $CI->load->view('the-content/start-content', $sidebar); // start the content div

    if ($view_file != "")
        $CI->load->view($view_file); // the content

    $CI->load->view('the-content/end-content'); // end the content div

    add_modal_overlay();

    $CI->load->view('foot/html-end.php'); // end of html

}

function render_blank($view_file = "", $data = [], $as_data = false, $js = array(), $link = array()) {
    $CI =& get_instance();
    $page['page'] = $data;

    if (sizeof($js) > 0) { // add script tags
        foreach ($js as $key => $val) {
            add_script($val['script_name'], $val['src'], $val['type'], $val['attrs']);
        }
    }
    if (sizeof($link) > 0) { // add link tags
        foreach ($link as $key => $val) {
            add_link($val['link_name'], $val['rel'], $val['type'], $val['href']);
        }
    }

    if ($as_data == true)
        return $CI->load->view($view_file, $page, TRUE);

    if ($view_file != "")
        $CI->load->view($view_file, $page); // the content
}

function render_sidebar($links = null, $options, $current_module_name) {
    $CI =& get_instance();
    $data['links'] = $links;
    $data['options'] = $options;
    $data['current_module_name'] = $current_module_name;
    $CI->load->view('sidebar/sidebar', $data);
}

function add_sidebar($current_module_name = "", $bool = false, $options = array('width' => '10%')) {
    global $sidebar;
    if ($bool == true)
        $sidebar = array('current_module_name' => str_replace('/', '', $current_module_name), 'show' => true, 'options' => $options);
    else
        $sidebar = array('current_module_name' => str_replace('/', '', $current_module_name), 'show' => false, 'options' => $options);
}

function add_menu($name, $show_name, $url, $icon, $text, $module_name = '', $order = '', $restrict_displaying = true) {
    $CI =& get_instance();

    if ($order == '')
        return;

    $menu_links = array(
        'url' => $url,
        'show_name' => $show_name,
        'icon' => $icon,
        'text' => $text,
        'module_name' => $module_name,
        'order' => $order
    );

    if ($restrict_displaying) {
        $CI->config->load('restrictions');
        $restrictions = $CI->config->item('restrictions');

        $user_id = $CI->session->userdata('user_cookie')['id'];
        if ($user_id == '')
        return;
        
        $role = get_user_role($user_id);

        if (! $role)
            return;

        $classes = $restrictions['classes'][$role];
        $methods = $restrictions['methods'][$role];

        if (in_array($module_name, $classes))
        return;

        if (in_array($module_name, $methods))
        return;
    }

    $CI->load->library('globals');
    $CI->globals->set_globals($name, $menu_links, 'menu_links', $module_name = '');

    // Sort and print the menu_links
    $menu_links = $CI->globals->get_globals('menu_links');
    uasort($menu_links, function ($a, $b) {
        if ($a['order'] == $b['order']) {
            return 0;
        }
        return ($a['order'] < $b['order']) ? -1 : 1;
    });
    $CI->globals->set_globals('menu_links', $menu_links);
}

function add_header_menu($position = false) {

}

function render_widget($id = '', $class = '', $title = '', $content = '', $footer = '') {
    $data['id'] = $id;
    //display_widgets_dashboard
    $data['class'] = $class;
    $data['content'] = $content;
    $data['widget_title'] = $title;
    $data['widget_footer'] = $footer;

    echo render_blank('components/widget', $data, TRUE);
}

function add_modal_overlay() {
    $CI =& get_instance();

    $CI->load->view('components/modal');
    $CI->load->view('components/overlay');
}

function add_script($script_name, $src = '', $type = "", $attrs = array()) {
    $CI =& get_instance();
    $a = "";
    $type = $type == '' ? '' : $type;
    if (sizeof($attrs) > 0) {
        foreach ($attrs as $key => $attr) {
            $a .= " " . $attr;
        }
    }
    $script_tag = array(
        'script_name' => $script_name,
        'src' => $src,
        'type' => $type,
        'attrs' => $a
    );
    // ob_start();
    $CI->load->view('tags/script-tag.php', $script_tag);
    // return ob_get_clean();
}

function add_link($link_name, $rel = '', $type = '', $href) {
    $CI =& get_instance();
    $rel = $rel == '' ? 'stylesheet' : $rel;
    $type = $type == '' ? 'text/css' : $type;
    $link_tag = array(
        'link_name' => $link_name,
        'rel' => $rel,
        'type' => $type,
        'href' => $href
    );
    // ob_start();
    $CI->load->view('tags/link-tag.php', $link_tag);
    // return ob_get_clean();
}

function add_meta($meta_name, $name = "", $content = "") {
    $CI =& get_instance();
    $meta_tag = array(
        'meta_name' => $meta_name,
        'name' => $name,
        'content' => $content
    );
    // ob_start();
    $CI->load->view('tags/meta-tag.php', $meta_tag);
    // return ob_get_clean();
}

function view_exists($file = "", $module = false, $module_name = '') {
    if ($module) {
        if (file_exists(APPPATH . "modules/{$module_name}/views/{$file}" . EXT)) {
            return true;
        }
        else
            return false;
    } else {
        if (file_exists(APPPATH . "views/{$file}" . EXT)) {
            return true;
        }
        else
            return false;
    }
}

function file_to_string($file) {
    ob_start();
    include($file);
    $string = ob_get_clean();
    return $string;
}

$error_messages = array();
function add_error_message($message) {
    global $error_messages;

    $error_messages[] = $message;
}

function get_error_messages() {
    global $error_messages;

    return $error_messages;
}

function modal_bool($bool = true) {
    $style = "";
    if ($bool)
        $style = 'style="display: block !important;"';
    echo $style;
}

function overlay_bool($bool = true) {
    $style = "";
    if ($bool)
        $style = 'style="display: block !important;"';
    echo $style;
}

function return_modal_content() {
    $true_content = "";
    global $error_messages;
    $content = $error_messages;

    if ($content != NULL && sizeof($content) > 0) {
        foreach ($content as $key => $value) {
            $true_content .= "<p>$value</p>";
        }
    }
    echo $true_content;
}

function display_error_messages() {
    global $error_messages;
    add_action('overlay.display_bool', 'overlay_bool');
    add_action('modal.display_bool', 'modal_bool');
    add_action('modal.do_content', 'return_modal_content');
}

/** Modal Displays functions helpers */
$modal_before_content = array();
$modal_content = array();
$modal_after_content = array();
function add_modal_before_content($message) {
    global $modal_before_content;
    $modal_before_content[] = $message;
}

function add_modal_content($message) {
    global $modal_content;
    $modal_content[] = $message;
}

function add_modal_after_content($message) {
    global $modal_after_content;
    $modal_after_content[] = $message;
}

function get_modal_content() {
    global $modal_content;

    return $modal_content;
}

function modal_before_content() {
    $true_content = "";
    global $modal_before_content;

    $content = $modal_before_content;

    if ($content != NULL && sizeof($content) > 0) {
        foreach ($content as $key => $value) {
            $true_content .= "<p>$value</p>";
        }
    }
    echo $true_content;
}

function modal_content() {
    $true_content = "";
    global $modal_content;
    $content = $modal_content;

    if ($content != NULL && sizeof($content) > 0) {
        foreach ($content as $key => $value) {
            $true_content .= "<p>$value</p>";
        }
    }
    echo $true_content;
}

function modal_after_content() {
    $true_content = "";
    global $modal_after_content;
    $content = $modal_after_content;

    if ($content != NULL && sizeof($content) > 0) {
        foreach ($content as $key => $value) {
            $true_content .= "<p>$value</p>";
        }
    }
    echo $true_content;
}

function display_modal_content() {
    global $modal_content;
    add_action('overlay.display_bool', 'overlay_bool');
    add_action('modal.display_bool', 'modal_bool');
    add_action('modal.before_do_content', 'modal_before_content');
    add_action('modal.do_content', 'modal_content');
    add_action('modal.after_do_content', 'modal_after_content');
}

/** Generate input fields */
function generate_textfield($field_name = '', $name = '', $value) {
?>
    <div class="w3-margin">
        <label for="<?= $name ?>"><?= $field_name ?></label>
        <input id="<?= $name ?>" class="w3-input w3-border-theme" type="text" name="<?= $name ?>" value="<?= $value ?>">
    </div>
<?php
}
function generate_numberfield($field_name = '', $name = '', $value) {
?>
    <div class="w3-margin">
        <label for="<?= $name ?>"><?= $field_name ?></label>
        <input id="<?= $name ?>" class="w3-input w3-border-theme" type="text" name="<?= $name ?>" value="<?= $value ?>">
        <script>
            jQuery('#<?= $name ?>').on('keyup', function(e) {
                if (isNaN(e.key)) {
                    var old = jQuery(this).val();
                    var _new = '';
                    for (var i = 0; i < old.length -1; i++) {
                        _new += '' + old[i];
                    }
                    jQuery(this).val(_new);
                }
            });
        </script>
    </div>
<?php
}

function generate_date_field($field_name = '', $name = '', $value) {
?>
    <div class="w3-margin">
        <label for="<?= $name ?>"><?= $field_name ?></label>
        <input id="<?= $name ?>" class="w3-input w3-border-theme date-field-chooser" type="text" name="<?= $name ?>" value="<?= $value ?>">
        <script>
            jQuery('#<?= $name ?>.date-field-chooser').datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "c-99:c+1"
            });
        </script>
    </div>
<?php
}

/**
*
* Backend Functions
*
*/
function encrypt_data($data) {
    $CI =& get_instance();
    $encrypted = $CI->encryption->encrypt($data);
    return $encrypted;
}

function decrypt_data($data) {
    $CI =& get_instance();
    $decrypted = $CI->encryption->decrypt($data);
    return $decrypted;
}

function compare_encrypted_data($data1, $data2) {
    $data1 = decrypt_data($data1);
    $data2 = decrypt_data($data2);

    if ($data1 == $data2)
        return true;
    else
        return false;
}

function is_logged_in() {
    $CI =& get_instance();

    if ($CI->session->has_userdata('user_cookie') && is_user_exists($CI->session->userdata('user_cookie')['id']))
        return true;
    else
        return false;
}

// For Options module
function add_option($option_name, $option_value, $user_id) {
    $CI =& get_instance();
    $value = json_encode($option_value);

    // $data['owner_id']
    $data['owner_id'] = $user_id;
    $data['option_name'] = $option_name;
    $data['option_value'] = $value;

    if (! $option_exists($option_name, $user_id)) {
        $CI->__globalmodule->set_tablename('options');
        return $CI->__globalmodule->_insert($data);
    } else {
        return;
    }
}

function update_option($option_name, $option_value, $user_id) {
    $CI =& get_instance();
    $value = json_encode($option_value);

    $data['owner_id'] = $user_id;
    $data['option_name'] = $option_name;
    $data['option_value'] = json_encode($option_value);

    if (! option_exists($option_name, $user_id)) {
        $CI->__globalmodule->set_tablename('options');
        return $CI->__globalmodule->_insert($data);
    } else {
        $CI->__globalmodule->set_tablename('options');
        $table = $CI->__globalmodule->get_tablename();
        $id_to_update = $CI->__globalmodule->_custom_query("SELECT option_id FROM $table WHERE option_name = '$option_name' AND owner_id = $user_id")->result()[0]->option_id;
        unset($data['owner_id']);
        unset($data['option_name']);
        return $CI->__globalmodule->_update_where('option_id', (int) $id_to_update, $data);
    }
}	

function option_exists($option_name, $user_id) {
    if (strlen(get_option($option_name, $user_id)) > 0) {
        return true;
    } else {
        return false;
    }

}

function get_option($option_name, $user_id) {
    $CI =& get_instance();
    $CI->__globalmodule->set_tablename('options');
    $table = $CI->__globalmodule->get_tablename();

    $query = "SELECT option_value FROM $table WHERE option_name = '$option_name'";

    $query .= " AND owner_id = " . $user_id;

    $query .= " LIMIT 1 ";

    $data = $CI->__globalmodule->_custom_query($query)->result();

    if (sizeof($data) < 1)
        return "";

    foreach ($data as $key => $value) {
        $data = $value->option_value;
    }

    return json_decode($data);
}


// For Users module
function is_user_exists($user_id) {
    $CI =& get_instance();
    $CI->load->module('__globalmodule');
    $CI->__globalmodule->set_tablename('users');
    $table = $CI->__globalmodule->get_tablename();

    $query = "SELECT id FROM $table WHERE id = '$user_id'";
    $data = $CI->__globalmodule->_custom_query($query)->result();

    return $data ? true : false;
}

function add_user_meta($meta_key, $meta_value, $user_id) {
    $CI =& get_instance();
    $value = json_encode($meta_value);

    // $data['owner_id']
    $data['user_id'] = $user_id;
    $data['meta_key'] = $meta_key;
    $data['meta_value'] = $value;

    if (! option_exists($meta_key, $user_id)) {
        $CI->__globalmodule->set_tablename('user_meta');
        return $CI->__globalmodule->_insert($data);
    } else {
        return;
    }
}

function update_user_meta($meta_key, $meta_value, $user_id) {
    $CI =& get_instance();
    $value = json_encode($meta_value);

    $data['user_id'] = $user_id;
    $data['meta_key'] = $meta_key;
    $data['meta_value'] = $value;

    if (! user_meta_exists($meta_key, $user_id)) {
        $CI->__globalmodule->set_tablename('user_meta');
        return $CI->__globalmodule->_insert($data);
    } else {
        $CI->__globalmodule->set_tablename('user_meta');
        $table = $CI->__globalmodule->get_tablename();
        $id_to_update = $CI->__globalmodule->_custom_query("SELECT id FROM $table WHERE meta_key = '$meta_key' AND user_id = $user_id")->result()[0]->id;
        unset($data['user_id']);
        unset($data['meta_key']);
        return $CI->__globalmodule->_update_where('id', (int) $id_to_update, $data);
    }
}

function get_current_user_id() {
    $CI =& get_instance();
    if ($CI->session->has_userdata('user_cookie'))
        return $CI->session->userdata('user_cookie')['id'];
    return false;
}

function get_username($user_id) {
    $CI =& get_instance();
    $CI->__globalmodule->set_tablename('users');
    $table = $CI->__globalmodule->get_tablename();
    $id = $CI->__globalmodule->_custom_query("SELECT user_login FROM $table WHERE id = $user_id")->result();

    if (isset($id[0]))
        return $id[0]->user_login;
}

function get_all_user_metas($user_id) {
    $CI =& get_instance();
    $CI->__globalmodule->set_tablename('user_meta');
    $table = $CI->__globalmodule->get_tablename();
    return $CI->__globalmodule->_custom_query("SELECT * FROM $table WHERE user_id = $user_id")->result();
}

function user_meta_exists($meta_key, $user_id) {
    
    $CI =& get_instance();

    $CI->load->module('__globalmodule');
    $CI->__globalmodule->set_tablename('user_meta');
    $table = $CI->__globalmodule->get_tablename();

    $query = "SELECT id FROM $table WHERE meta_key = '$meta_key'";

    $query .= " AND user_id = " . $user_id;

    $query .= " LIMIT 1 ";
    // exit($query);
    $data = $CI->__globalmodule->_custom_query($query)->result();

    if (isset($data[0])) {
        return true;
    } else {
        return false;
    }

}

function check_user_metas($user_id) {
    if ($res != '') {
        $query = "SELECT * FROM users INNER JOIN user_meta ON users.id = user_meta.user_id WHERE users.id = $user_id";

        $role = $CI->__globalmodule->_custom_query($query)->result();
        if (sizeof($role) > 0) {
            foreach ($role as $key => $value) {
                $res = $value->meta_value;
            }
        } else {
            return false;
        }
    }
}

function get_user_meta($meta_key, $user_id) {
    $CI =& get_instance();

    $CI->load->module('__globalmodule');
    $CI->__globalmodule->set_tablename('user_meta');
    $table = $CI->__globalmodule->get_tablename();

    $query = "SELECT meta_value FROM $table WHERE meta_key = '$meta_key'";

    $query .= " AND user_id = " . $user_id;

    $query .= " LIMIT 1 ";
    // exit($query);
    $data = $CI->__globalmodule->_custom_query($query)->result();
    // var_dump($data);
    if ($data == NULL)
        return "";

    $data = $data[0]->meta_value;
    // foreach ($data as $key => $value) {
    // 	$data = $value->meta_value;
    // }
    return json_decode($data);
}

function get_user_role($user_id) { // checks the capability of current user

    $CI =& get_instance();

    $res = get_user_meta('user_role', $user_id);

    if ($res != '') {
        $query = "SELECT user_meta.meta_value FROM users INNER JOIN user_meta ON users.id = user_meta.user_id WHERE users.id = $user_id AND user_meta.meta_key = 'user_role'";

        $role = $CI->__globalmodule->_custom_query($query)->result();
        if (sizeof($role) > 0) {
            foreach ($role as $key => $value) {
                $res = $value->meta_value;
            }
        } else 
            $res = false;
    }

    return $res ? json_decode($res) : $res;
}

function is_user_capable_to_this_user($user_id, $to_this_user_id) {
    $is_this_id = get_user_meta('manager', $to_this_user_id);
    if ($is_this_id == $user_id || get_current_user_id() == $to_this_user_id)
        return true;
    return false;
}

function username_exists($username) {
    $CI =& get_instance();
    $CI->__globalmodule->set_tablename('user_meta');
    $query = "SELECT * FROM users WHERE user_login = '$username'";
    $result = $CI->__globalmodule->_custom_query($query)->result();
    // var_dump( $result );
    
    if (isset($_GET['return']) == 'json') {
        if (sizeof($result) > 0)
            echo json_encode(true);
        else
            echo json_encode(false);
    } else {
        if (sizeof($result) > 0)
            return true;
        else 
            return false;
    }
}

function email_exists($email) {
    $CI =& get_instance();
    $CI->__globalmodule->set_tablename('user_meta');
    $query = "SELECT * FROM users WHERE user_email = '$email'";
    $result = $CI->__globalmodule->_custom_query($query)->result();
    // var_dump( $result );
    
    if (isset($_GET['return']) == 'json') {
        if (sizeof($result) > 0)
            echo json_encode(true);
        else
            echo json_encode(false);
    } else {
        if (sizeof($result) > 0)
            return true;
        else 
            return false;
    }
}
