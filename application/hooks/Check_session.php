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

        // exit($this->router->fetch_class())


        // $this->session->unset_userdata('redirect_here');

        if ($this->router->fetch_class() == '_login' || $this->router->fetch_class() == '_default' || $this->session->userdata('user_cookie'))//login is a sample login controller {
            return;

        if (! $this->session->userdata('user_cookie')) {
            header('Location: ' . base_url('login') . '?ref=' . $this->session->userdata('redirect_here')) ;
            // $this->session->set_userdata('redirect_here', urlencode((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
        }
    }
}