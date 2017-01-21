<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['gallery'] = 'app/gallery';
$route['redirect'] = 'app/redirect';
$route['redirect/(:num)'] = 'app/redirect/$1';
$route['my_pic'] = 'app/my_pic';
$route['default_controller'] = 'app';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
