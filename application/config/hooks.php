<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_controller'][] = array(
    "class"    => "Check_session",// any name of class that you want
    "function" => "validate",// a method of class
    "filename" => "Check_session.php",// where the class declared
    "filepath" => "hooks"// this is location inside application folder
);

$hook['pre_controller'][] = array(
    "class"    => "Restrict_user_roles",// any name of class that you want
    "function" => "check_restriction",// a method of class
    "filename" => "Restrict_user_roles.php",// where the class declared
    "filepath" => "hooks"// this is location inside application folder
);