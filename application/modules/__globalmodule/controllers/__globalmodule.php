<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class __globalmodule extends MX_Controller {

	public function __construct() {
		// $this->load->model('__globalmodel');
		parent::__construct();
	}

	public function set_tablename($table) {
		$this->load->model('__globalmodel');
		$this->__globalmodel->set_tablename($table);
	}

	public function get_tablename() {
		$this->load->model('__globalmodel');
		return $this->__globalmodel->tablename;
	}

	public function get($order_by) {
		$this->load->model('__globalmodel');
		$query = $this->__globalmodel->get($order_by);
		return $query;
	}

	public function get_with_limit($limit, $offset, $order_by) {
		$this->load->model('__globalmodel');
		$query = $this->__globalmodel->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	public function get_where($id) {
		$this->load->model('__globalmodel');
		$query = $this->__globalmodel->get_where($id);
		return $query;
	}

	public function get_where_custom($col, $value) {
		$this->load->model('__globalmodel');
		$query = $this->__globalmodel->get_where_custom($col, $value);
		return $query;
	}

	public function _insert($data) {
		$this->load->model('__globalmodel');
		return $this->__globalmodel->_insert($data);
	}

	public function _update($id, $data) {
		$this->load->model('__globalmodel');
		$this->__globalmodel->_update($id, $data);
	}

	public function _delete($id) {
		$this->load->model('__globalmodel');
		$this->__globalmodel->_delete($id);
	}

	public function count_where($column, $value) {
		$this->load->model('__globalmodel');
		$count = $this->__globalmodel->count_where($column, $value);
		return $count;
	}

	public function get_max() {
		$this->load->model('__globalmodel');
		$max_id = $this->__globalmodel->get_max();
		return $max_id;
	}

	public function _custom_query($mysql_query) {
		$this->load->model('__globalmodel');
		$query = $this->__globalmodel->_custom_query($mysql_query);
		return $query;
	}


	public function _insert_batch($data) {
		$this->load->model('__globalmodel');
		$this->__globalmodel->_insert_batch($data);
	}




	/**
	* 
	* Non-database functions
	*
	*/
	function read_email_template($filename, $type = "", $data = array()) {
		// use key 'http' even if you send the request to https://...
		$options = array('http' => array(
		    'method'  => 'POST',
		    'content' => http_build_query($data)
		));
		$context  = stream_context_create($options);

		if ($type == 'render') {
			$email =  @file_get_contents(base_url('display-page?p=' . urlencode('email/' . $filename)), false, $context);
			echo $email != false ? $email : '';
		} else if ($type == 'read') {
			$email = @file_get_contents(base_url('display-page?p=' . urlencode('email/' . $filename)), false, $context);
			return $email;
		}
	}

	function display_page() {
		if (! (isset($_GET['p']) && $_GET['p'])) {
			show_404();
			return;
		}

		if (! $this->functions->view_exists($_GET['p'])) {
			show_404();
			return;
		}

		if (sizeof($_POST) > 0) {
			$data = $_POST;
			$this->load->view($_GET['p'], $data);
		} else {
			$this->load->view($_GET['p']);
		}

	}

}