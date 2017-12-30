<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class __globalmodule extends MX_Controller {

	public function __construct() {
		// $this->load->model('__globalmodel');
		parent::__construct();
	}

	public function get_tablename() {
		$this->load->model('__globalmodel');
		return $this->__globalmodel->tablename;
	}

	public function set_tablename($table) {
		$this->load->model('__globalmodel');
		$this->__globalmodel->set_tablename($table);
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
		$this->__globalmodel->_insert($data);
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

}