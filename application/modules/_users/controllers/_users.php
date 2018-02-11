<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _users extends MX_Controller {

	var $page;
	var $assets;
	var $script_tags;
	var $link_tags;
	var $meta_tags;

	function __construct() {
		parent::__construct();
		$this->assets = base_url() . 'public/assets/';
		$this->load->module('__globalmodule');
		$user_id = $this->session->userdata('user_cookie')['id'];

		/*
		* Add and set variable for the page here
		*/
		$this->page['page_title'] = "Users";
		$this->page['module_name'] = $this->router->fetch_class() . '/';

		$default_view = $this->init->default_view_vars();
		$this->script_tags = $default_view['scripts'];
		$this->link_tags = $default_view['links'];
		$this->meta_tags = $default_view['metas'];
	}

	function index() {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;

		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function check_user_profile($id) {
		$this->__globalmodule->set_tablename('user_meta');
		$query = "SELECT * FROM user_meta WHERE user_id = $id";
		$result = $this->__globalmodule->_custom_query($query)->result();
		return $result;
	}

	function edit_profile($id) {
		$view = $this->page['module_name'] . 'index';
		$this->page['assets_url'] = $this->assets;
		
		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function activate_account() {
		if (isset($_GET['activation_key']) && $_GET['activation_key']) {
			$raw_ak = $_GET['activation_key'];
			$verify = $_GET['activation_key'];

			$verify = $this->functions->decrypt_data($verify);
			$split = explode('|', $verify);

			$user_email = $split[0];
			$user_login = $split[1];


			$this->__globalmodule->set_tablename('users');
			$query = "SELECT id FROM users WHERE user_activation_key = '$raw_ak' AND user_status = 0";
			$result = $this->__globalmodule->_custom_query($query)->result();

			if (sizeof($result) > 0) {
				foreach ($result as $key => $value) {
					$id = $value->id;
				}
				$data['user_activation_key'] = '';
				$data['user_status'] = 1;

				$this->__globalmodule->_update($id, $data);
				$this->add_default_meta_key($id);
				header('Location: ' . base_url('register/account-activated'));
			} else {
				header('Location: ' . base_url('login'));
			}
		} else {
			show_404();
		}
	}

	function account_activated() {
		$page['page_title'] = "Account has been Activated";
		$page['assets_url'] = $this->assets;
		$view = $this->page['module_name'] . 'account-activated.php';
		$this->functions->render_page(false, $page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $page);
	}

	function send_email_activation($user_activation_key, $email, $nickname) {
		// Storing submitted values
		// $sender_email = 'johnabeman@gmail.com';
		// $user_password = '09467035106';
		$receiver_email = $email;
		$from_name = 'Clock Work Wizard';
		$subject = 'Activate your account now - ' . $from_name;

		$data['activation_key'] = $user_activation_key;
		$data['nickname'] = $nickname;
		$data['link'] = base_url('verify-account?activation_key=' . urlencode($user_activation_key));
		$message = $this->__globalmodule->read_email_template('activation-link', 'read', $data);

		// Configure email library
		// $config['protocol'] = 'smtp';
		// $config['smtp_host'] = 'smtp.gmail.com';
		// $config['smtp_port'] = 587;
		// $config['smtp_user'] = $sender_email;
		// $config['smtp_pass'] = $user_password;
		// $config['mailtype'] = 'html';
  		// $config['smtp_crypto'] = 'tls';

  		$this->config->load('email');
  		$config = $this->config->item('mail');
  		// exit(var_dump($config));


		// Load email library and passing configured values to email library
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		// Sender email address
		$this->email->from($sender_email, $from_name);
		// Receiver email address
		$this->email->to($receiver_email);
		// Subject of email
		$this->email->subject($subject);
		// Message in email
		$this->email->message($message);

		$sent = $this->email->send();
        // print_r($this->email->print_debugger());
		return $sent;
	}

	function register() {
		$view = $this->page['module_name'] . 'register-account';
		$this->page['page_title'] = "Sign Up for a new account.";
		$this->page['assets_url'] = $this->assets;

		if (isset($_POST['register']) == 'register') {
			if (! $this->is_email_exists($_POST['user_email']) && ! $this->is_username_exists($_POST['user_login'])) {
				$data = $_POST;
				unset($data['register']);
				unset($data['confirm_password']);
				$data['user_password'] = $this->functions->encrypt_data($data['user_password']);
				$data['user_activation_key'] = $this->functions->encrypt_data($data['user_email'] . '|' . $data['user_login']);

				if (! empty(array_filter($data))) {
					$this->__globalmodule->set_tablename('users');
					if ($this->send_email_activation($data['user_activation_key'], $data['user_email'], $data['user_nickname'])) {
						if ($this->__globalmodule->_insert($data) == 1) {
							header('Location: ' . base_url('register/complete'));
							exit();
						}
					    else {
							header('Location: ' . base_url('register/failed'));
							exit();
					    }
					}
					header('Location: ' . base_url('register/failed'));
					exit();
				} else {
					$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
					return;
				}
			} else {
				if ($this->is_email_exists($_POST['user_email']))
					$this->page['error_register'][] = "Email address already taken by another user.";

				if ($this->is_username_exists($_POST['user_login']))
					$this->page['error_register'][] = "Username is already taken.";

				$this->page['submitted_post'] = $_POST;
			}
		}

		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function is_email_exists($email) {
		$this->__globalmodule->set_tablename('users');
		$table = $this->__globalmodule->get_tablename();

		$sql = "SELECT user_email FROM $table WHERE user_email = '$email'";
		$result = $this->__globalmodule->_custom_query($sql)->result();

		if (sizeof($result) > 0)
			return true;
		else
			return false;
	}

	function is_username_exists($username) {
		$this->__globalmodule->set_tablename('users');
		$table = $this->__globalmodule->get_tablename();

		$sql = "SELECT user_login FROM $table WHERE user_login = '$username'";
		$result = $this->__globalmodule->_custom_query($sql)->result();

		if (sizeof($result) > 0)
			return true;
		else
			return false;
	}

	function registration_complete() {
		$page['page_title'] = "Successfully Signed Up";
		$page['assets_url'] = $this->assets;
		$view = $this->page['module_name'] . 'congratulations-page.php';
		$this->functions->render_page(false, $page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $page);
	}

	function registration_failed() {
		$page['page_title'] = "Registration Failed";
		$page['assets_url'] = $this->assets;
		$view = $this->page['module_name'] . 'registration-failed.php';
		$this->functions->render_page(false, $page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $page);
	}

	/*function register_employee() {
		$referral = isset($_GET['referral']);
		$view = $this->page['module_name'] . 'register-employee';
		$this->page['assets_url'] = $this->assets;
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}*/

	function add_employee() {
		$view = $this->page['module_name'] . 'add-employee';
		$this->page['assets_url'] = $this->assets;

		$this->functions->add_sidebar($this->page['module_name'], true, array('width' => '50px', 'text_align' => 'center'));
		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function add_default_meta_key($id, $manager = '') {
		$user_meta_keys = array(
			array(
				'user_id' => $id,
				'meta_key' => 'first_name'
			), array(
				'user_id' => $id,
				'meta_key' => 'last_name'
			), array(
				'user_id' => $id,
				'meta_key' => 'middle_name'
			), array(
				'user_id' => $id,
				'meta_key' => 'description'
			), array(
				'user_id' => $id,
				'meta_key' => 'address'
			), array(
				'user_id' => $id,
				'meta_key' => 'city'
			), array(
				'user_id' => $id,
				'meta_key' => 'state'
			), array(
				'user_id' => $id,
				'meta_key' => 'zip'
			), array(
				'user_id' => $id,
				'meta_key' => 'cellphone'
			), array(
				'user_id' => $id,
				'meta_key' => 'workphone'
			), array(
				'user_id' => $id,
				'meta_key' => 'homephone'
			), array(
				'user_id' => $id,
				'meta_key' => 'birthday'
			), array(
				'user_id' => $id,
				'meta_key' => 'status'
			)
		);
		$this->__globalmodule->set_tablename('user_meta');
		$this->__globalmodule->_insert_batch($user_meta_keys);

		if ($this->session->userdata('user_cookie')['id'] != NULL || $manager != '') {
			$user_meta_keys = array(
				array(
					'user_id' => $id,
					'meta_key' => 'manager',
					'meta_value' => json_encode($manager)
				), array(
					'user_id' => $id,
					'meta_key' => 'user_role',
					'meta_value' => json_encode('employee')
				)
			);
			$this->__globalmodule->_insert_batch($user_meta_keys);
		} else {
			$user_meta_keys = array(
				array(
					'user_id' => $id,
					'meta_key' => 'user_role',
					'meta_value' => json_encode('manager')
				)
			);
			$this->__globalmodule->_insert_batch($user_meta_keys);
		}
	}

	function username_check($username) {
		$this->__globalmodule->set_tablename('user_meta');
		$query = "SELECT * FROM users WHERE user_login = '$username'";
		$result = $this->__globalmodule->_custom_query($query)->result();
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

	function email_check($email) {
		$this->__globalmodule->set_tablename('user_meta');
		$query = "SELECT * FROM users WHERE user_email = '$email'";
		$result = $this->__globalmodule->_custom_query($query)->result();
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
}