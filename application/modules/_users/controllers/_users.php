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

	}

	function send_email_activation($user_activation_key, $email, $nickname) {
		//Load email library
		// $this->load->library('email');

		//SMTP & mail configuration
		// $config = array(
		//     'protocol'  => 'smtp',
		//     'smtp_host' => 'ssl://smtp.gmail.com',
		//     'smtp_port' => 465,
		//     'smtp_user' => 'johnabeman@gmail.com',
		//     'smtp_pass' => '09467035106',
		//     'smtp_crypto' => 'ssl',
		//     'mailtype'  => 'html'
		// );
		// $config['protocol']    = 'smtp';
		// $config['smtp_host']    = 'ssl://smtp.gmail.com';
		// $config['smtp_port']    = '465';
		// $config['smtp_timeout'] = '7';
		// $config['smtp_user']    = 'johnabeman@gmail.com';
		// $config['smtp_pass']    = '09467035106';
		// // $config['smtp_crypto'] = 'ssl';

		// // Load email library and passing configured values to email library
		// $this->load->library('email', $config);
		// // $this->email->initialize($config);
		// // $this->email->set_mailtype("html");
		// // $this->email->set_newline("\r\n");

		// //Email content
		// $htmlContent = "<h1>Sending email via SMTP server $user_activation_key, $email, $nickname</h1>";
		// $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

		// $this->email->to($email);
		// $this->email->from('johnabeman@gmail.com','Clock Work Wizard');
		// $this->email->subject('How to send email via SMTP server in CodeIgniter');
		// $this->email->message($htmlContent);

		// //Send email
		// $this->email->send();
		// The mail sending protocol.
		// $config['protocol'] = 'smtp';
		// // SMTP Server Address for Gmail.
		// $config['smtp_host'] = 'ssl://smtp.googlemail.com';
		// // SMTP Port - the port that you is required
		// $config['smtp_port'] = '465';
		// // SMTP Username like. (abc@gmail.com)
		// $config['smtp_user'] = 'johnabeman@gmail.com';
		// // SMTP Password like (abc***##)
		// $config['smtp_pass'] = '09467035106';
		// // Load email library and passing configured values to email library
		// $this->load->library('email', $config);
		// // Sender email address
		// $this->email->from('johnabeman@gmail.com', 'Clock Work Wizard');
		// // Receiver email address.for single email
		// $this->email->to($email);
		// //send multiple email
		// // $this->email->to(abc@gmail.com,xyz@gmail.com,jkl@gmail.com);
		// // Subject of email
		// $this->email->subject('nyeam');
		// // Message in email
		// $this->email->message('nyeam nyeam');
		// // It returns boolean TRUE or FALSE based on success or failure
		// $this->email->send(); 

		// Storing submitted values
		$this->load->library('encrypt');
		$sender_email = 'johnabeman@gmail.com';
		$user_password = '09467035106';
		$receiver_email = 'abelardomanangan@gmail.com';
		$username = 'abelardomanangan';
		$subject = 'Sample';
		$message = '<h>asdwasdwasd<Asd?>ASd';

		// Configure email library
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = $sender_email;
		$config['smtp_pass'] = $user_password;

		// Load email library and passing configured values to email library
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		// Sender email address
		$this->email->from($sender_email, $username);
		// Receiver email address
		$this->email->to($receiver_email);
		// Subject of email
		$this->email->subject($subject);
		// Message in email
		$this->email->message($message);

		if ($this->email->send()) {
		$data['message_display'] = 'Email Successfully Send !';
		} else {
		$data['message_display'] =  '<p class="error_msg">Invalid Gmail Account or Password !</p>';
		}

		exit($data['message_display']);
		// $this->load->view('view_form', $data);
	}

	function register() {
		 // echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
		$view = $this->page['module_name'] . 'register-account';
		$this->page['page_title'] = "Sign Up for a new account.";
		$this->page['assets_url'] = $this->assets;

		if (isset($_POST['register']) == 'register') {
			$data = $_POST;
			unset($data['register']);
			unset($data['confirm_password']);
			$data['user_password'] = $this->functions->encrypt_data($data['user_password']);
			$data['user_activation_key'] = $this->functions->encrypt_data($data['user_email'], $data['user_login']);

			if (! empty(array_filter($data))) {
				$this->__globalmodule->set_tablename('users');
				if ($this->__globalmodule->_insert($data) == 1) {
					$view = $this->page['module_name'] . 'congratulations-page';
					$this->send_email_activation($data['user_activation_key'], $data['user_email'], $data['user_nickname']);
					$this->functions->render_page(false, 'Successful sign up', $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
				}
			    else
			    	$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
			    return;
			} else {
				$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
				return;
			}
		}

		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

	function register_employee() {
		$referral = isset($_GET['referral']);

		$view = $this->page['module_name'] . 'register-employee';
		$this->page['assets_url'] = $this->assets;

		$this->functions->render_page(false, $this->page['page_title'], $this->script_tags, $this->link_tags, $this->meta_tags, $view, $this->page);
	}

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
			), array(
				'user_id' => $id,
				'meta_key' => 'clock_status',
				'meta_value' => '0'
			)
		);

		if ($this->session->userdata('user_cookie')['id'] != NULL || $manager != '') {
			$manager = array(
				'meta_key' => 'manager',
				'meta_value' => $manager
			);
			$capability = array(
				'meta_key' => 'capability',
				'meta_value' => 'employee'
			);
			array_push($user_meta_keys, $manager);
			array_push($user_meta_keys, $capability);
		} else {
			$capability = array(
				'meta_key' => 'capability',
				'meta_value' => 'manager'
			);
			array_push($user_meta_keys, $capability);
		}
		echo '<pre>';
		var_dump($user_meta_keys);
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