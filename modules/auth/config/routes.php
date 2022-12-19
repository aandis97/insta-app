<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['auth'] = 'AuthController/index';
$route['auth/logout']['GET'] = 'AuthController/logout';
$route['auth/login']['GET'] = 'LoginController/index';
$route['auth/login']['POST'] = 'LoginController/store';


$route['auth/register']['GET'] = 'RegisterController/index';
$route['auth/register']['POST'] = 'RegisterController/store';
