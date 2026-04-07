<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

 function ipaddress() {
        $remote_address = "";
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $remote_address = trim($_SERVER['HTTP_CF_CONNECTING_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            $remote_address = trim($ips[0]);
        } else {
            $remote_address = $_SERVER['REMOTE_ADDR'] ?? '';
        }
        return $remote_address;
    }

?>