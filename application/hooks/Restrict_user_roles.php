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

    public function check_restriction() {
        $CI =& get_instance();

        $this->config->load('exceptions');
        $execs = $this->config->item('exceptions');
        $exceptions['class'] = $execs['classes'];
        $exceptions['method'] = $execs['methods'];

        foreach ($exceptions['class'] as $key => $value) {
            if ($this->router->fetch_class() == $value) {
                return;
            }
        }

        foreach ($exceptions['method'] as $key => $value) {
            if ($this->router->fetch_method() == $value) {
                return;
            }
        }

        if (! $CI->functions->is_logged_in()) {
            return;
        }

        $this->config->load('restrictions');
        $restrictions = $this->config->item('restrictions');

        $classes = $restrictions['classes'];
        $methods = $restrictions['methods'];

        $user_id = $CI->session->userdata('user_cookie')['id'];
        $role = $CI->functions->get_user_role($user_id);


        if (in_array($this->router->fetch_class(), $classes[$role]))
            redirect('/error/restricted');

        if (in_array($this->router->fetch_method(), $methods[$role]))
            redirect('/error/restricted');
    }

}