<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

	function __construct()
	{
		parent::__construct();
	}

	private function getJsonInput()
	{
		$input = file_get_contents('php://input');

		if(empty($input))
		{
			$this->set_response([
					'status' => 0,
					'message' => 'Empty Request Body'
			], REST_Controller::HTTP_BAD_REQUEST);
			exit;
		}

		$data = json_decode($input, true);

		if(json_last_error() !== JSON_ERROR_NONE)
		{
			$this->set_response([
					'status' => 0,
					'message' => 'Invalid JSON Format'
			], REST_Controller::HTTP_BAD_REQUEST);
			exit;
		}

		return $data;
	}

	public function index_get()
	{
		return $this->set_response([
				"status" => 1,
				"message" => "API Working"
		], REST_Controller::HTTP_OK);
	}

	public function check_dedupe_post($status = null)
	{
		$isFail = isset($status) && (string)$status === '0';

		$response = [
			"success"    => !$isFail,
			"statusCode" => 200,
			"message"    => $isFail ? "Dedup Success" : "Dedup Fail",
			"data"       => []
		];

		return $this->response($response, REST_Controller::HTTP_OK);
	}


	public function lead_push_post($status = null)
	{
		$isFail = isset($status) && (string)$status === '0';

		/*$response = [
			"success"    => true,
			"statusCode" => 200,
			"message"    => "User already associated with us",
			"data"       => []
		];*/

		$response = [
			"success"    => true,
			"statusCode" => 200,
			"message"    => "Attributed Successfully",
			"data"       => []
		];

		return $this->response($response, REST_Controller::HTTP_OK);
	}

	public function lead_create_post($status = null)
	{
			/*$response = [
				"success" => true,
				"statusCode" => 200,
				"message" => "This mobile number is already associated with a different PAN",
				"data" => []
			];*/

			$response = [
				"success" => true,
				"statusCode" => 200,
				"message" => "DSA Lead Creation successful",
				"data" => [
					"leadID" => 848189,
				"breDecision" => "approved",
				"offeredAmount" => 15000,
				"jwt_access_token" => "TOKEN_HERE",
				"customerID" => 8088571,
				"step" => [
					"id" => 69,
				"current_route" => "/finbox",
				"product_id" => 2,
				"step_order" => 4,
				"step_name" => "FINBOX"
				]
				]
			];

		return $this->response($response, REST_Controller::HTTP_OK);
	}

	public function auto_login_post()
	{
	    $response = [
	        "success" => true,
	        "statusCode" => 200,
	        "message" => "Login Successful",
	        "data" => [
	            "customer" => [
	                "mobile" => "8076371422",
	                "customerID" => 1111111786,
	                "otp" => null,
	                "name" => "MIHIR SHARMA"
	            ],
	            "jwtToken" => "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOjExMTExMTE3ODYsImlzcCI6MTc3MjAxODM4MCwiZXhwIjoxNzczMzE0MzgwLCJ2ZW5kb3JLZXkiOiIiLCJzdXRtU291cmNlIjoiZHVtbXkiLCJ1dG1fY2FtcGFpZ24iOiIiLCJ1dG1fbWVkaXVtIjoiIiwidXRtX3RyYWNraW5naWQiOiIiLCJpYXQiOjE3NzIwMTgzODB9.Ki8FWMHj7A7gymMxWOXzKSNGn2qQMVy9-q6SgPMFby96HL9__hW_uGtbLv6mMUv1sVNwWzCBi5Q7fkEWwjzSGXFiHZZRGtZ1Cby_aQrlqVKPQ7tqwhKP3ybR5gaP5bD4dtKyFkdidTZfV4gZBXrHHfBC79V1-d6FEuFq3vlGwiXbuw5j-ryub18Bz1WaSpnpcth1U85V6aLuJRmrOARhO-oEWx-bARfZqrl4HrO3jhonApecjHTKoBwrXheTesLXWQnPCp978VtCJO_H4zFytJEP19_tDaIcCtyAR6vUkx_QGluwvzU41bdMPKaXSfPiLL-ng19GsHSw6UGDEXcutg",
	            "accessToken" => "dWx6Qi9YZk1YNTRlRW9lOTZXMHlQRnZGc0lqbllPTjkvb3p1cWwzbCs3bEhGcjhOTzBoV0tJejV3MHNRaUxpVy8vQUFuTmkyenpLMkhnT0R2cU9KcUNnTFp2YXJiZWtXT2dDNmhLcDVENGM9",
	            "attributeKey" => "",
	            "lead" => [
	                "customer_type" => "New Customer",
	                "leadID" => 160933830,
	                "productId" => 2,
	                "leadStatus" => "Fresh Lead",
	                "leadType" => "New Case"
	            ]
	        ]
	    ];

	    return $this->response($response, REST_Controller::HTTP_OK);
	}

	public function auth_post()
	{
	    $response = [
	        "success" => true,
	        "statusCode" => 200,
	        "message" => "Success",
	        "data" => [
	            "customer" => [
	                "customerID" => 1111111786,
	                "name" => "MIHIR SHARMA",
	                "mobile" => "XXXXXX1422"
	            ],
	            "jwtToken" => "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOjExMTExMTE3ODYsImlzcCI6MTc3MjAxODM4MCwiZXhwIjoxNzczMzE0MzgwLCJ2ZW5kb3JLZXkiOiIiLCJzdXRtU291cmNlIjoiZHVtbXkiLCJ1dG1fY2FtcGFpZ24iOiIiLCJ1dG1fbWVkaXVtIjoiIiwidXRtX3RyYWNraW5naWQiOiIiLCJpYXQiOjE3NzIwMTgzODB9.Ki8FWMHj7A7gymMxWOXzKSNGn2qQMVy9-q6SgPMFby96HL9__hW_uGtbLv6mMUv1sVNwWzCBi5Q7fkEWwjzSGXFiHZZRGtZ1Cby_aQrlqVKPQ7tqwhKP3ybR5gaP5bD4dtKyFkdidTZfV4gZBXrHHfBC79V1-d6FEuFq3vlGwiXbuw5j-ryub18Bz1WaSpnpcth1U85V6aLuJRmrOARhO-oEWx-bARfZqrl4HrO3jhonApecjHTKoBwrXheTesLXWQnPCp978VtCJO_H4zFytJEP19_tDaIcCtyAR6vUkx_QGluwvzU41bdMPKaXSfPiLL-ng19GsHSw6UGDEXcutg",
	            "accessToken" => "dWx6Qi9YZk1YNTRlRW9lOTZXMHlQRnZGc0lqbllPTjkvb3p1cWwzbCs3bEhGcjhOTzBoV0tJejV3MHNRaUxpVy8vQUFuTmkyenpLMkhnT0R2cU9KcUNnTFp2YXJiZWtXT2dDNmhLcDVENGM9",
	            "attributeKey" => "",
	            "lead" => [
	                "customer_type" => "New Customer",
	                "leadID" => 160933830,
	                "productId" => 2,
	                "leadStatus" => "Fresh Lead",
	                "leadType" => "New Case"
	            ],
	            "redirection" => new stdClass()
	        ]
	    ];

	    return $this->response($response, REST_Controller::HTTP_OK);
	}

	public function dummy_post()
	{
	    $data = $this->getJsonInput();

	    $mobile = isset($data['mobile']) ? trim($data['mobile']) : '';

	    if (empty($mobile)) {
            return $this->set_response([
                            "status" => 0,
                            "message" => "Mobile No required"
            ], REST_Controller::HTTP_BAD_REQUEST);
	    }

	    if (!preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
            return $this->set_response([
                            "status" => 0,
                            "message" => "Invalid mobile number. Must be 10 digits and start with 6-9"
            ], REST_Controller::HTTP_BAD_REQUEST);
	    }

	    $response = [
	        "full_name"        => "Sourabh Sharma",
	        "mobile"           => $mobile,
	        "pan_number"	   => "EHHPS5025R",
	        "email"			   => "sourabh.aquarius@gmail.com",
	        "employment_type"  => "Salaried",
	        //"employment_type"  => "Self Employed",
	        "monthly_income"   => "50000",
	        "loan_amount"      => "60000",
	        "users_pincode"    => "333333",
	        "users_address"    => "124 SHYAM COLONY JWALA NAGAR RAMPUR MORADABAD UTTAR PRADESH 244901 244901 UP",
	        "users_city"       => "RAMPUR",
	        "users_state"      => "UTTAR PRADESH",
	        "company_users_pincode" => "244901",
	        "users_gender"     => 'Male',
	        "users_company_name" => "Prudigital Media pvt Ltd",
	        "users_bank_name"  => "ICICI BANK",
	        "business_name"    => "ZOMATO DELIVERY",
	        "business_gst"     => "07AAEPM0111C1ZP",
	        "business_turnover" => "454545",
	        "business_loan_amount" => "456000",
	        "users_dob"  => "1979-01-01",
	        "business_vintage" => "10",
	        "statusCode"       => 200,
	        "message"          => "Successfully",
	    ];

	    return $this->response($response, REST_Controller::HTTP_OK);
	}

}