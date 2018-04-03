<?php

defined('BASEPATH') OR exit("No direct script access allowed");

$config['exceptions']['classes'] = array(
    '_login',
    '_default',
    '_public',
    '_error',
    '_api'
);

$config['exceptions']['methods'] = array(
    'register',
    'sample',
    'username_check',
    'email_check',
    'activate_account',
    'display_page',
    'registration_complete',
    'registration_failed',
    'account_activated'
);

