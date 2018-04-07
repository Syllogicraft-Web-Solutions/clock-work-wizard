<?php

class _clocker extends MX_Controller {

    var $page;
    var $assets;
    var $script_tags;
    var $link_tags;
    var $meta_tags;

    public function __construct() {
        parent::__construct();
		$this->load->helper('date');

        $this->assets = base_url() . 'public/assets/';
        $this->load->module('__globalmodule');
        $user_id = $this->session->userdata('user_cookie')['id'];

        /*
        * Add and set variable for the page here
        */
        $this->page['page_title'] = "Clocker";
        $this->page['module_name'] = str_replace('_', '', get_class()) . '/';

        $default_view = $this->init->default_view_vars();
        $this->script_tags = $default_view['scripts'];
        $this->link_tags = $default_view['links'];
        $this->meta_tags = $default_view['metas'];
    }

    public function index() {
        $view = $this->page['module_name'] . 'index';

        $this->page['assets_url'] = $this->assets;
        $this->page['data'] = array();

        if (! is_logged_in())
            return;

        if (get_user_role(get_current_user_id()) == 'manager') {
            $this->page['data']['data'] = encrypt_data(get_current_user_id());
        } else
            $this->page['data']['data'] = encrypt_data('false');

        log_message('error', "DATA MANA: " . get_current_user_id());

		add_sidebar('_' . $this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
        render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
    }
 
    public function install_table() {
        $this->load->model('_clockerModel');
        $this->_clockerModel->install_clocker_table();
    }
    
    public function do_clockers($action, $user_id = '') {
        $user_id = get_current_user_id();
        if ($action == 'punch-in')
            echo do_action('clocker.punch-in', [$user_id])[0];
        elseif ($action == 'punch-out')
            echo do_action('clocker.punch-out', [$user_id])[0];
        elseif ($action == 'break-in')
            echo do_action('clocker.break-in', [$user_id])[0];
        elseif ($action == 'break-out')
            echo do_action('clocker.break-out', [$user_id])[0];
        else
            echo json_encode(false);
    }

    public function verification() {
        $view = $this->page['module_name'] . 'components/list-users.php';

        $this->page['assets_url'] = $this->assets;
        $this->page['data'] = array();
        
		add_sidebar('_' . $this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
        render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
    }

    public function verify() {
        if (isset($_GET['rec_id']) && $_GET['rec_id'] != '') {
            $data['status'] = 'verified';
            $this->__globalmodule->set_tablename('clocker_records');
            if ($this->__globalmodule->_update($_GET['rec_id'], $data))
                echo json_encode(true);
            else
                echo json_encode(false);
        } else
            echo json_encode('s');
    }

    public function unverify() {
        if (isset($_GET['rec_id']) && $_GET['rec_id'] != '') {
            $data['status'] = 'pending';
            $this->__globalmodule->set_tablename('clocker_records');
            if ($this->__globalmodule->_update($_GET['rec_id'], $data))
                echo json_encode(true);
            else
                echo json_encode(false);
        } else
            echo json_encode('s');
    }

 }