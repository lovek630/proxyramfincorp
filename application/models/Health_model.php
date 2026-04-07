<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Health_model extends MY_Model
{
    function __construct() {
        parent::__construct();        
    }

    public function check_all()
    {
        $status = [
            "api" => "OK",
            "timestamp" => date("Y-m-d H:i:s"),
        ];

        $status['database'] = $this->check_database();
        $status['jwt'] = $this->check_jwt();
        $status['external_api'] = $this->check_external_api();

        return $status;
    }

    private function check_database()
    {
        try {
            $this->db->query("SELECT 1");
            return "OK";
        } catch (Exception $e) {
            return "DOWN";
        }
    }

    private function check_jwt()
    {
        try {
            $CI =& get_instance();

            $testToken = $CI->jwt_auth->generate_token([
                'user_uid' => 'test',
                'mobile'   => '9999999999'
            ]);

            $decoded = $CI->jwt_auth->validate_token($testToken);

            return $decoded ? "OK" : "FAILED";
        } catch (Exception $e) {
            return "ERROR";
        }
    }

    private function check_external_api()
    {
        $url = "https://apipingversescore.kredbharat.com/api/test";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 3
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            curl_close($ch);
            return "DOWN";
        }

        curl_close($ch);
        return "OK";
    }
}