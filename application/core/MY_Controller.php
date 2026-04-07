<?php
require_once APPPATH . 'libraries/REST_Controller.php';

class MY_Controller extends REST_Controller {

    public $user_data;

    function __construct()
    {
        parent::__construct();
        $this->load->library('Jwt_auth');

        $headers = $this->input->request_headers();

        if(!isset($headers['Authorization']))
        {
            $this->response([
                "status"=>0,
                "message"=>"Token required"
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }

        $token = str_replace('Bearer ','',$headers['Authorization']);

        $decoded = $this->jwt_auth->validate_token($token);

        if(!$decoded)
        {
            $this->response([
                "status"=>0,
                "message"=>"Invalid Token"
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }

        $this->user_data = $decoded->data;
    }
}