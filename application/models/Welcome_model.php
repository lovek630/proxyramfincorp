<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_model extends MY_Model{

	function __construct() {
		parent::__construct();
	}

	public function insert_data($table_name, $data)
	{
	    $data['date_added'] = date('Y-m-d H:i:s');
	    $this->master->insert($table_name, $data);
	    return $this->master->insert_id();
	}  

	public function findbyMobile($mobile)
	{
	    $this->slave->select('user_uid, mobile_number');
	    $this->slave->from('cb_cibil_users');
	    $this->slave->where('mobile_number', $mobile);
	    $this->slave->limit(1);

	    return $this->slave->get()->row();
	}

	public function get_user_by_api_key($api_key)
	{
	    $this->slave->select('user_id, api_key');
	    $this->slave->from('cb_cibil_user_dedup_api');
	    $this->slave->where('api_key', $api_key);
	    $this->slave->where('status', '1');
	    $this->slave->limit(1);
	    return $this->slave->get()->row_array();
	}

	public function get_allowed_ips()
	{
	    $this->slave->select('ip_address');
	    $this->slave->from('cb_cibil_user_dedup_api');
	    $this->slave->where('status', '1');
	    $query = $this->slave->get()->result_array();
	    return array_column($query, 'ip_address');
	}

}
