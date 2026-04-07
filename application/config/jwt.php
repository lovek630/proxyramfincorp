<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['jwt_key'] = '9f3c8a7d4b6e1c2a8f5d9e3b7a4c6d1e2f8a9b3c4d5e6f7a8b9c0d1e2f3a4b5c'; //bin2hex(random_bytes(32));
$config['jwt_algo'] = 'HS256';
$config['token_expire'] = 3600; // 1 hour
