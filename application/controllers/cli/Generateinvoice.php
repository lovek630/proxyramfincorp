<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH.'vendor/autoload.php';

use Dompdf\Dompdf;

class Generateinvoice extends CI_Controller {

	function __construct() {

		parent::__construct();

	}

	public function index() {

		echo "inside index invoice";
	}

	public function generate_invoice_pdf($invoic_id, $client_id) {

		echo "INVOICE ID: ".$invoic_id." CLIENT_ID : ".$client_id;
		$this->load->model('Clients_model');
		$this->load->model('Package_model');
		$this->load->model('Order_model');
		$this->load->model('Invoice_model');

		$this->config->load('custom_config');
		$dompdf = new Dompdf();

        $client_pdf_path = $this->config->item('CLIENT_PDF_PATH');
        $client_data = $this->Clients_model->get_userId($client_id);

        $full_name = $client_data->fname." ".$client_data->lname;
        $address = $client_data->company_address;
        $city_name = $client_data->company_city;
        $state_id = $client_data->state_id;
        $country_id = $client_data->country_id;

        $country_details = $this->Clients_model->get_country($country_id);
        $state_details   =  $this->Clients_model->get_state($country_id, $state_id);

        $country_name =  $country_details[0]->name;
        $state_name = $state_details [0]->name;

        $client_pincode = $client_data->company_pincode;
        $gst_no = $client_data->company_gst_no;

        $company_name = $client_data->company_name;
        $reseller_id = $client_data->admin_id;
        
        $invoice_data = $this->Invoice_model->find_by_id($invoice_id);

        $total_amount = $invoice_data->total_amount;

        $amount_in_words = getIndianCurrency($total_amount);

        $invoice_details_data = $this->Invoice_model->find_invoice_details($invoice_id);

        $package_id = $invoice_details_data->package_id;
        $package_details_data = $this->Package_model->get_prepaid_package_by_id($package_id);

        $app_path = APPPATH;
        $fc_path = FCPATH;

		$logo_path = $fc_path.'/assets/img/pru_small-2.gif';

		//echo "logo_path".$logo_path;

		$logo_path_info = pathinfo($logo_path, PATHINFO_EXTENSION);
		$logo_data = file_get_contents($logo_path);
		$logo_base64 = 'data:image/' . $logo_path_info . ';base64,' . base64_encode($logo_data);

		//echo "<pre>";print_r($inv_gen_data);//die();

		$signature_path = $fc_path.'/assets/img/stamp.gif';

		//echo "signature_path".$signature_path;
		$signature_path_info = pathinfo($signature_path, PATHINFO_EXTENSION);
		$signature_data = file_get_contents($signature_path);
		$signature_base64 = 'data:image/' . $signature_path_info . ';base64,' . base64_encode($signature_data);
		// instantiate and use the dompdf class

		$path_template = $app_path."views/invoice-template/invoice-template-2.html";
		$file_content = file_get_contents($path_template);
		$file_content = str_replace("#company_logo#", $logo_base64 , $file_content);
		$file_content = str_replace("#stamp#", $signature_base64, $file_content);

		$file_content = str_replace("#client_name#", $full_name , $file_content);

		$file_content = str_replace("#client_address#", $address, $file_content);
		
		$file_content = str_replace("#client_city#", $city_name, $file_content);
		$file_content = str_replace("#client_pincode#", $client_pincode, $file_content);
		
		$file_content = str_replace("#client_state#", $state_name, $file_content);
		$file_content = str_replace("#client_country#", $country_name, $file_content);
		
		$file_content = str_replace("#GST#", $gst_no, $file_content);

		/*$file_content = str_replace("#invoice_raised_on#", $inv_gen_data['invoice_data']['invoice_gen_date'], $file_content);

		$file_content = str_replace("#invoice_number#", $inv_gen_data['invoice_data']['invoice_no'], $file_content);
		
		$file_content = str_replace("#package_name#", $inv_gen_data['package_details_data']['package_name'], $file_content);
		$file_content = str_replace("#package_quantity#", $inv_gen_data['package_details_data']['package_quantity'], $file_content);
		
		$file_content = str_replace("#package_rate#",$inv_gen_data['package_details_data']['package_rate'], $file_content);

		$file_content = str_replace("#gst_amount#", $inv_gen_data['invoice_data']['gst'], $file_content);
		
		$file_content = str_replace("#gst_percent#", $inv_gen_data['invoice_data']['invoice_gst_percent'], $file_content);
		$file_content = str_replace("#amount#", $inv_gen_data['invoice_data']['amount'], $file_content);
		
		$file_content = str_replace("#subtotal#", $inv_gen_data['invoice_data']['invoice_sub_total'], $file_content);
		$file_content = str_replace("#total_amount#", $inv_gen_data['invoice_data']['total_amount'], $file_content);
		
		$file_content = str_replace("#balance_due#", $inv_gen_data['invoice_data']['invoice_balance_due'], $file_content);
		$file_content = str_replace("#currency#", $inv_gen_data['invoice_data']['invoice_currency'], $file_content);*/

		//echo $file_content;

		//die();
		
		//$file_content = str_replace("#total_amount_due_in_words#", $inv_gen_data['invoice_data']['invoice_total_amount_in_words'], $file_content);
		$dompdf->loadHtml($file_content);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();

		$output = $dompdf->output();

		$file_invoice_pdf = "testhello.pdf";

		//$file_invoice_pdf = $inv_gen_data['invoice_data']['invoice_uid']."-".$inv_gen_data['invoice_details_data']['invoice_id'].".pdf";

		$file_path = $client_pdf_path.$file_invoice_pdf;

		//$file_path = $file_invoice_pdf;

		file_put_contents($file_path, $output);
		echo $file_invoice_pdf;
	}

	public function calculate_price() {

		$data = array();
		$data["message"] = "No record Found";
		$data["status"] = 0;
		$this->load->model('Package_model');

		if( count($this->input->post()) > 0 )
		{
			$package_uid = $this->input->post('package_uid');
			$sms_count = $this->input->post('sms_count');
			$package_details = $this->Package_model->get_prepaid_package_by_uid($package_uid);
			$package_start_limit = $package_details->start_message;
			$package_end_limit = $package_details->end_message;
			if($sms_count > $package_end_limit || $sms_count < $package_start_limit) {

				$data["message"] = 'The sms count can be between '.$package_start_limit.' to '.$package_end_limit.' <a href="'.base_url().'">Click to choose another package</a>';
		    	$data["status"] = 0;
			}
			else {
				$data["message"] = "Record Found";
		    	$data["status"] = 1;
			}
			
		    $data["package_details"] = $package_details;
			echo json_encode($data);

			die();
		}
	}
}
