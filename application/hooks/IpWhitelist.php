<?php
class IpWhitelist {

    public function check_ip()
    {
        $CI =& get_instance();        
        $CI->load->model('Welcome_model');

        $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';

        if (strpos($user_ip, ',') !== false) {
            $user_ip = explode(',', $user_ip)[0];
        }

        $user_ip = trim($user_ip);

        $allowed_ips_raw = $CI->Welcome_model->get_allowed_ips();

        $allowed_ips = [];
        foreach ($allowed_ips_raw as $row) {
            $ips = explode(',', $row);
            foreach ($ips as $ip) {
                $allowed_ips[] = trim($ip);
            }
        }
        if (!in_array($user_ip, $allowed_ips)) {
            header('Content-Type: application/json');
            header('HTTP/1.1 403 Forbidden');

            echo json_encode([
                "status" => 0,
                "message" => "Unauthorized IP",
                "your_ip" => $user_ip
            ]);
            exit;
        }
    }
}
