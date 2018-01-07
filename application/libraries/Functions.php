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

	function add_menu($name, $show_name, $url, $icon, $text, $module_name = '') {
		$CI =& get_instance();

		$menu_links = array(
			'url' => $url,
			'show_name' => $show_name,
			'icon' => $icon,
			'text' => $text,
			'module_name' => $module_name
		);
		$CI->load->library('globals');
		$CI->globals->set_globals($name, $menu_links, 'menu_links', $module_name = '');
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

}