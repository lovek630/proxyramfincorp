<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Jwt_auth {

    private $CI;
    private $key;
    private $algo;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('jwt');

        $this->key  = $this->CI->config->item('jwt_key');
        $this->algo = $this->CI->config->item('jwt_algo');
    }

    public function generate_token($data)
    {
        $payload = [
            'iss' => "ci3_api",
            'iat' => time(),
            'exp' => time() + 3600,
            'data' => $data
        ];

        return JWT::encode($payload, $this->key, $this->algo);
    }

    public function validate_token($token)
    {
        try {
            return JWT::decode($token, new Key($this->key, $this->algo));
        } catch (Exception $e) {
            return false;
        }
    }
}