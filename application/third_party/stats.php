<?php
class Stats {
    private $CI;
    private $master;
    private $slave;
    function __construct() {
    
            echo "-----";
            $this->CI =& get_instance();
             "===".print_r($this->CI);
            /* $this->CI->load->helper('url');
             $this->master = $this->CI->load->database('master', TRUE);
             $this->slave = $this->CI->load->database('slave', TRUE);*/
    
       }
    
     public function get_datatables(){
    
            echo "inside datatables";
           /* $this->slave->select('country_id, name, code, status, created_on');
            $this->slave->from('ho_countries');
            $this->get_datatables_query();
            $user = $this->slave->get();
            echo "<pre>";
            print_r($user);
            return $user->result();*/
        }
}

$stats = new Stats();
$test = get_class_methods($stats);
print_r($test);
$stats->get_datatables();
