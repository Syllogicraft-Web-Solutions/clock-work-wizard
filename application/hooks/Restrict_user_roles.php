<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict_user_roles {
    public function __construct() {
            
    }

    public function __get($property) {
        if ( ! property_exists(get_instance(), $property)) {
            show_error('property: <strong>' . $property . '</strong> not exist.');
        }
        return get_instance()->$property;
    }

    public function is_logged_in() {
       if ($this->session->has_userdata('user_cookie'))
            return true;
        else
            return false;
    }

    public function get_capability() { // checks the capability of current user
        $CI =& get_instance();

        $current_user_id = $this->session->userdata('user_cookie')['id'];

        $res = $CI->functions->get_user_meta('user_role', $current_user_id);

        return $res;
    }
}