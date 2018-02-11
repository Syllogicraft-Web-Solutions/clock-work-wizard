<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _clockerModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

     function install_clocker_table() {
          $create = "CREATE TABLE `clocker_records` (
               `id` int(11) NOT NULL AUTO_INCREMENT,
               `user_id` int(11) NOT NULL,
               `punch_in` timestamp NULL DEFAULT NULL,
               `punch_out` timestamp NULL DEFAULT NULL,
               `break_in` timestamp NULL DEFAULT NULL,
               `break_out` timestamp NULL DEFAULT NULL,
               `status` enum('verified','canceled','stop','simple','pending') DEFAULT NULL,
               `crypt_code` varchar(255) NOT NULL,
               `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
               `data` LONGTEXT NULL,
               PRIMARY KEY (`id`)
          );";

          if (! $this->is_clocker_exists()) {
               $query = $this->db->query($create);
               return $query;
          } else
               return false;
               exit('asdasd');
     }

     function is_clocker_exists() {
          return $this->db->table_exists('clocker_records');
     }

}