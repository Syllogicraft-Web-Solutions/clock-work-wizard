<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Globalcontroller extends MX_Controller {

	var $tablename;

	function __construct() {
		parent::__construct();
	}

	function get_tablename() {
		return $this->tablename;
	}

	function set_tablename_mdl($table) {
		$this->load->model('globalmodel');
		$this->globalmodel->set_tablename($table);
	}

	function get($order_by) {
		$this->load->model('globalmodel');
		$query = $this->globalmodel->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$this->load->model('globalmodel');
		$query = $this->globalmodel->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) {
		$this->load->model('globalmodel');
		$query = $this->globalmodel->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) {
		$this->load->model('globalmodel');
		$query = $this->globalmodel->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		$this->load->model('globalmodel');
		$this->globalmodel->_insert($data);
	}

	function _update($id, $data) {
		$this->load->model('globalmodel');
		$this->globalmodel->_update($id, $data);
	}

	function _delete($id) {
		$this->load->model('globalmodel');
		$this->globalmodel->_delete($id);
	}

	function count_where($column, $value) {
		$this->load->model('globalmodel');
		$count = $this->globalmodel->count_where($column, $value);
		return $count;
	}

	function get_max() {
		$this->load->model('globalmodel');
		$max_id = $this->globalmodel->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$this->load->model('globalmodel');
		$query = $this->globalmodel->_custom_query($mysql_query);
		return $query;
	}

}