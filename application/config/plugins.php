<?php

/*
|--------------------------------------------------------------------------
| Plugins Directory
|--------------------------------------------------------------------------
|
| Where are the plugins kept?
|
|       Default: FCPATH . 'plugins/' (<root>/plugins/)
*/
$config['plugin_path'] = FCPATH . 'application/plugins/';

require_once( APPPATH . 'libraries/abstract.plugins.php' );
require_once( APPPATH . 'libraries/trait.plugins.php' );