<?php

class _api extends MX_Controller {

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
        
        header('Access-Control-Allow-Origin'  . ': ' . '*');
        header('Access-Control-Allow-Credential: false');
        header('Connection: Keep-Alive');
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
        header('Access-Control-Allow-Methods' . ': ' . 'POST, GET, OPTIONS, PUT');
        header('Accept' . ': ' . 'application/json');
        header('Content-type' . ': ' . 'application/json');
    }

    public function index() {
        // show_404();
    }

    public function login() {
        // var_dump()
        if ((isset($_GET['username']) && $_GET['username'] != '') && (isset($_GET['password']) && $_GET['password'])) {
			$this->__globalmodule->set_tablename('users');
            $tablename = $this->__globalmodule->get_tablename();
            $data = $_GET;
            $query = "SELECT * FROM $tablename WHERE user_login = \"{$data['username']}\" LIMIT 1";

			$row = $this->__globalmodule->_custom_query($query);
			if ($row->result()) {
				foreach ($row->result() as $key => $val) {

					if ($val->user_status == 0) {
						$login_status = array(
							'code' => 403,
							'message' => 'User not activated, please check your email inbox or spam to activate your account.'
						);
						echo json_encode($login_status);
					}

					if (compare_encrypted_data($this->encryption->encrypt($data['password']), $val->user_password)) {
						$this->session->set_userdata('user_cookie', array(
							'logged_in' => true,
							'id' => $val->id
						));
					     echo json_encode(['code' => 200, 'message' => 'Successful', 'responseText' => encrypt_data($val->id)]);
					} else {
						$login_status = array(
							'code' => 403,
							'message' => 'Wrong password.'
						);
						echo json_encode($login_status);
					}
				}
			} else {
				$login_status = array(
					'code' => 403,
					'message' => 'Credential not found.'
				);
				echo json_encode($login_status);
			}
        } else {
            echo json_encode(['code' => 403, 'message' => 'Authentication failed']);
        }
    }

    public function v1($endpoint, $action = '') {
        // var_dump($endpoint);
        // $e = $endpoint;
        // $a = $action;
        $data['endpoint'] = $endpoint;
        $data['action'] = $action;
        // require(__DIR__ . '../hooks.php');

        $this->load->view('_api-endpoints.php', $data);
    }

 }