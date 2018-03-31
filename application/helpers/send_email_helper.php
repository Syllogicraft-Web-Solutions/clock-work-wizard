<?php

function send_email($data = array()) {
     $CI =& get_instance();
     $receiver_email = $data['to'];
     $from_name = isset($data['from_name']) && $data['from_name'] != '' ? $data['from_name'] : 'Clock Work Wizard';
     $subject = $data['subject'];
     $sender_email = "no-reply@" . $_SERVER['HTTP_HOST'];

     $message = $data['message'];

     $CI->config->load('email');
     $config = $CI->config->item('mail');

     // Load email library and passing configured values to email library
     $CI->load->library('email', $config);
     $CI->email->set_newline("\r\n");

     // Sender email address
     $CI->email->from($sender_email, $from_name);
     // Receiver email address
     $CI->email->to($receiver_email);
     // Subject of email
     $CI->email->subject($subject);
     // Message in email
     $CI->email->message($message);

     $sent = $CI->email->send();
     // print_r($CI->email->print_debugger());
     return $sent;
}

function get_email_template($template_name, $data = array()) {
     $CI =& get_instance();
     return $CI->load->view($template_name, $data, TRUE);
}