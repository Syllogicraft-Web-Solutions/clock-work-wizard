<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = '_login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/**
* Custom URI
*/
$route['login'] = "_login";
$route['dashboard'] = "_dashboard";
$route['enroll'] = "_enroll";
$route['users'] = "_users";
$route['options'] = "_options";
$route['plugins'] = "_plugins";
$route['plugin-settings/(:any)'] = "_plugins/config/$1";

$route['mdl/(:any)'] = "_plugins/view_plugin_as_mdl/$1";
$route['mdl/(:any)/(:any)'] = "_plugins/view_plugin_as_mdl/$1/$2";

$route['register'] = "_users/register";
$route['register/complete'] = "_users/registration_complete";
$route['register/failed'] = "_users/registration_failed";
$route['register/account-activated'] = "_users/account_activated";


$route['verify-account'] = '_users/activate_account';
$route['display-page'] = '__globalmodule/display_page';

// include_once('')
$route['api/(:any)'] = "api/_api/$1";
$route['api/(:any)/(:any)'] = "api/_api/$1/$2";
$route['api/v1/(:any)'] = "api/_api/v1/$1";
$route['api/v1/(:any)/(:any)'] = "api/_api/v1/$1/$2";

/**
* Custom Error pages
*/
$route['error/400'] = '_error/error_400';
$route['error/404'] = '_error/error_404';
$route['error/500'] = '_error/error_500';
$route['error/restricted'] = '_error/error_restricted';