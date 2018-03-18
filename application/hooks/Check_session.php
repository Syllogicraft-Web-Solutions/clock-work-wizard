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

       
        // if ($this->session->userdata('user_cookie')['id'] != NULL) {
        //     if (! is_user_exists($this->session->userdata('user_cookie')['id'])) {
        //         // header('Location: ' . base_url('login') . '?ref=' . $this->session->userdata('redirect_here')) ;
        //         $this->session->unset_userdata('user_cookie');
        //         redirect('/error/restricted');
        //     }
        // }

        if (! $this->session->userdata('user_cookie')) {
            header('Location: ' . base_url('login') . '?ref=' . $this->session->userdata('redirect_here')) ;
        }
    }
}