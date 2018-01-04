<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Check_session {
    public function __construct() {
            
    }

    public function __get($property) {
        if ( ! property_exists(get_instance(), $property)) {
                show_error('property: <strong>' . $property . '</strong> not exist.');
        }
        return get_instance()->$property;
    }
    public function validate() {

        $exceptions['class'] = array(
            '_login', '_default'
        );

        $exceptions['method'] = array(
            'register', 'sample', 'username_check', 'email_check'
        );

        foreach ($exceptions['class'] as $key => $value) {
            if ($this->router->fetch_class() == $value) {
                // echo $value;
                return;
            }
        }

        foreach ($exceptions['method'] as $key => $value) {
            if ($this->router->fetch_method() == $value) {
                // echo $value;
                return;
            }
        }

        if ($this->session->userdata('user_cookie')['id'] != NULL) {
            return;
        }

        if (! $this->session->userdata('user_cookie')) {
            header('Location: ' . base_url('login') . '?ref=' . $this->session->userdata('redirect_here')) ;
        }
    }
}