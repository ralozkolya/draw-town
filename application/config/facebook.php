<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['facebook']['app_id'] = get_env('FB_APP_ID');
$config['facebook']['app_secret'] = get_env('FB_APP_SECRET');
$config['facebook']['default_graph_version'] = get_env('FB_API_V');