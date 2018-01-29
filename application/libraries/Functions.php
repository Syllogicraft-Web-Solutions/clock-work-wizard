<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Functions {

	var $page;
	var $sidebar;


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
	function render_page($display_header = false, $page_title = "", $js = array(), $link = array(), $meta = array(), $view_file = "", $data = []) {
		$CI =& get_instance();
		$page['page_title'] = $page_title;
		$page['page'] = $data;
		$this->sidebar['with_sidebar'] = false;

		$CI->load->view('head/html-start.php', $page); //start head tag
		
		if (sizeof($js) > 0) { // add script tags
			foreach ($js as $key => $val) {
				$this->add_script($val['script_name'], $val['src'], $val['type'], $val['attrs']);
			}
		}
		if (sizeof($link) > 0) { // add link tags
			foreach ($link as $key => $val) {
				$this->add_link($val['link_name'], $val['rel'], $val['type'], $val['href']);
			}
		}
		if (sizeof($meta) > 0) { // add meta tags
			foreach ($meta as $key => $val) {
				$this->add_meta($val['meta_name'], $val['name'], $val['content']);
			}
		}

		$CI->load->view('head/html-end-head.php'); //end head tag

		if ($display_header)
			$CI->load->view('components/header-logged-in'); //end head tag

		if (isset($this->sidebar['show'])) {
			$this->sidebar['with_sidebar'] = true;
			if ($this->is_logged_in())
				$this->render_sidebar($CI->globals->get_globals('menu_links'), $this->sidebar['options'], $this->sidebar['current_module_name']);
		}

		$CI->load->view('the-content/start-content', $this->sidebar); // start the content div

		if ($view_file != "")
			$CI->load->view($view_file); // the content

		$CI->load->view('the-content/end-content'); // end the content div

		$this->add_modal_overlay();

		$CI->load->view('foot/html-end.php'); // end of html

	}

	function render_blank($js = array(), $link = array(), $view_file = "", $data = []) {
		$CI =& get_instance();
		$page['page'] = $data;

		if (sizeof($js) > 0) { // add script tags
			foreach ($js as $key => $val) {
				$this->add_script($val['script_name'], $val['src'], $val['type'], $val['attrs']);
			}
		}
		if (sizeof($link) > 0) { // add link tags
			foreach ($link as $key => $val) {
				$this->add_link($val['link_name'], $val['rel'], $val['type'], $val['href']);
			}
		}
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
		if ($bool == true)
			$this->sidebar = array('current_module_name' => str_replace('/', '', $current_module_name), 'show' => true, 'options' => $options);
		else
			$this->sidebar = array('current_module_name' => str_replace('/', '', $current_module_name), 'show' => false, 'options' => $options);
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
	        $role = $this->get_user_role($user_id);

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
		echo $CI->globals->set_globals('menu_links', $menu_links);
	}

	function add_header_menu($position = false) {

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
		$data1 = $this->decrypt_data($data1);
		$data2 = $this->decrypt_data($data2);

		if ($data1 == $data2)
			return true;
		else
			return false;
	}

    public function is_logged_in() {
    	$CI =& get_instance();

       	if ($CI->session->has_userdata('user_cookie'))
            return true;
        else
            return false;
    }

	// For Options module
	function add_option($option_name, $option_value, $user_id) {

		$value = json_encode($option_value);

		// $data['owner_id']
		$data['owner_id'] = $user_id;
		$data['option_name'] = $option_name;
		$data['option_value'] = $value;

		if (! $this->option_exists($option_name, $user_id)) {
			$this->__globalmodule->set_tablename('options');
			return $this->__globalmodule->_insert($data);
		} else {
			return;
		}
	}

	function option_exists($option_name, $user_id) {

		if ($this->get_option($option_name, $user_id) != '') {
			return true;
		} else {
			return false;
		}

	}

	function get_option($option_name, $user_id = '') {

		if ( $user_id != '' ) {
			$current_user_id = $this->user_id;
		}

		$this->__globalmodule->set_tablename('options');
		$table = $this->__globalmodule->get_tablename();

		$query = "SELECT option_value FROM $table WHERE option_name = '$option_name'";

		$query .= $user_id ? " AND owner_id = " . $current_user_id : "";

		$query .= " LIMIT 1 ";

		$data = $this->__globalmodule->_custom_query($query)->result();

		if (sizeof($data) < 1)
			return "";

		foreach ($data as $key => $value) {
			$data = $value->option_value;
		}

		return json_decode($data);
	}


	// For Users module
	function add_user_meta($meta_key, $meta_value, $user_id) {

		$value = json_encode($meta_value);

		// $data['owner_id']
		$data['owner_id'] = $user_id;
		$data['meta_key'] = $meta_key;
		$data['meta_value'] = $value;

		if (! $this->option_exists($meta_key, $user_id)) {
			$this->__globalmodule->set_tablename('options');
			return $this->__globalmodule->_insert($data);
		} else {
			return;
		}
	}

	function user_meta_exists($meta_key, $user_id) {

		if ($this->get_option($meta_key, $user_id) != '') {
			return true;
		} else {
			return false;
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
		if (sizeof($data) < 1)
			return "";

		foreach ($data as $key => $value) {
			$data = $value->meta_value;
		}

		return json_decode($data);
	}

    public function get_user_role($user_id) { // checks the capability of current user

		$CI =& get_instance();

        $res = $this->get_user_meta('user_role', $user_id);

        if ($res != '') {
            $query = "SELECT user_meta.meta_value FROM users INNER JOIN user_meta ON users.id = user_meta.user_id WHERE users.id = $user_id AND user_meta.meta_key = 'user_role'";

			$role = $CI->__globalmodule->_custom_query($query)->result();
			if (sizeof($role) > 0) {
				foreach ($role as $key => $value) {
					$res = $value->meta_value;
				}
			}
        }

        return json_decode($res);
    }


}