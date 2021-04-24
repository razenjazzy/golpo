<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GOLPOCOM License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.golpocom.com
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to golpocommunications@gmail.com so we can send you a copy immediately.
 *
 * @author   GOLPOCOM
 * @author-email  golpocommunications@gmail.com
 * @copyright  Copyright © golpocom.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Clients_model");
		$this->load->model("Xin_model");
		
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_projects_tasks!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_project_clients');
		$data['all_countries'] = $this->Xin_model->get_countries();
		$data['breadcrumbs'] = $this->lang->line('xin_project_clients');
		$data['path_url'] = 'clients';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('119',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/clients/clients_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function clients_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/clients/clients_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$client = $this->Clients_model->get_clients();
		
		$data = array();

          foreach($client->result() as $r) {
			  
			  // get country
			  $country = $this->Xin_model->read_country_info($r->country);
			  if(!is_null($country)){
			  	$c_name = $country[0]->country_name;
			  } else {
				  $c_name = '--';	
			  }	  
			  
               $data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-client_id="'. $r->client_id . '"><span class="fa fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-client_id="'. $r->client_id . '"><span class="fa fa-eye"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->client_id . '"><span class="far fa-trash-alt"></span></button></span>',
                    $r->name,
                    $r->email,
					$r->company_name,
                    $r->website_url,
                    $r->city,
                    $c_name,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $client->num_rows(),
                 "recordsFiltered" => $client->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 public function client_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('client_id');
		$result = $this->Clients_model->read_client_info($id);
		$data = array(
				'client_id' => $result[0]->client_id,
				'name' => $result[0]->name,
				'company_name' => $result[0]->company_name,
				'client_username' => $result[0]->client_username,
				'client_profile' => $result[0]->client_profile,
				'email' => $result[0]->email,
				'contact_number' => $result[0]->contact_number,
				'website_url' => $result[0]->website_url,
				'address_1' => $result[0]->address_1,
				'address_2' => $result[0]->address_2,
				'city' => $result[0]->city,
				'state' => $result[0]->state,
				'zipcode' => $result[0]->zipcode,
				'countryid' => $result[0]->country,
				'is_active' => $result[0]->is_active,
				'all_countries' => $this->Xin_model->get_countries(),
				);
		$this->load->view('admin/clients/dialog_clients', $data);
	}
	
	// Validate and add info in database
	public function add_client() {
	
		if($this->input->post('add_type')=='client') {
		// Check validation for user input
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		
		$name = $this->input->post('name');
		$company_name = $this->input->post('company_name');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$website = $this->input->post('website');
		$address_1 = $this->input->post('address_1');
		$address_2 = $this->input->post('address_2');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zipcode = $this->input->post('zipcode');
		$country = $this->input->post('country');
		$user_id = $this->input->post('user_id');
		$file = $_FILES['client_photo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($name==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($company_name==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($contact_number==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		} else if($email==='') {
			$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if($website==='') {
			$Return['error'] = $this->lang->line('xin_error_website_field');
		}  else if($city==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($zipcode==='') {
			$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		} else if($country==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		} else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		}
		
		/* Check if file uploaded..*/
		else if($_FILES['client_photo']['size'] == 0) {
			$fname = 'no file';
			 $Return['error'] = $this->lang->line('xin_project_client_photo_error');
		} else {
			if(is_uploaded_file($_FILES['client_photo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['client_photo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["client_photo"]["tmp_name"];
					$bill_copy = "uploads/clients/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["client_photo"]["name"]);
					$newfilename = 'client_photo_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		$options = array('cost' => 12);
		$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
	
		$data = array(
		'name' => $this->input->post('name'),
		'company_name' => $this->input->post('company_name'),
		'email' => $this->input->post('email'),
		'client_username' => $this->input->post('username'),
		'client_password' => $password_hash,
		'client_profile' => $fname,
		'contact_number' => $this->input->post('contact_number'),
		'website_url' => $this->input->post('website'),
		'address_1' => $this->input->post('address_1'),
		'address_2' => $this->input->post('address_2'),
		'city' => $this->input->post('city'),
		'state' => $this->input->post('state'),
		'zipcode' => $this->input->post('zipcode'),
		'country' => $this->input->post('country'),
		'is_active' => 1,
		'created_at' => date('Y-m-d H:i:s'),
		
		);
		$result = $this->Clients_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_client_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='client') {
		$id = $this->uri->segment(4);
		// Check validation for user input
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		
		$name = $this->input->post('name');
		$company_name = $this->input->post('company_name');
		$email = $this->input->post('email');
		$contact_number = $this->input->post('contact_number');
		$website = $this->input->post('website');
		$address_1 = $this->input->post('address_1');
		$address_2 = $this->input->post('address_2');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zipcode = $this->input->post('zipcode');
		$country = $this->input->post('country');
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($name==='') {
			$Return['error'] = $this->lang->line('xin_error_name_field');
		} else if($company_name==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($contact_number==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		} else if($email==='') {
			$Return['error'] = $this->lang->line('xin_error_cemail_field');
		} else if($website==='') {
			$Return['error'] = $this->lang->line('xin_error_website_field');
		}  else if($city==='') {
			$Return['error'] = $this->lang->line('xin_error_city_field');
		} else if($zipcode==='') {
			$Return['error'] = $this->lang->line('xin_error_zipcode_field');
		} else if($country==='') {
			$Return['error'] = $this->lang->line('xin_error_country_field');
		} else if($this->input->post('username')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_username');
		}
				
		/* Check if file uploaded..*/
		else if($_FILES['client_photo']['size'] == 0) {
			 //$fname = 'no file';
			 $no_logo_data = array(
			'name' => $this->input->post('name'),
			'company_name' => $this->input->post('company_name'),
			'email' => $this->input->post('email'),
			'client_username' => $this->input->post('username'),
			'contact_number' => $this->input->post('contact_number'),
			'website_url' => $this->input->post('website'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zipcode' => $this->input->post('zipcode'),
			'country' => $this->input->post('country'),
			'is_active' => $this->input->post('status'),
			);
			 $result = $this->Clients_model->update_record($no_logo_data,$id);
		} else {
			if(is_uploaded_file($_FILES['client_photo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['client_photo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["client_photo"]["tmp_name"];
					$bill_copy = "uploads/clients/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["client_photo"]["name"]);
					$newfilename = 'client_photo_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'name' => $this->input->post('name'),
					'company_name' => $this->input->post('company_name'),
					'email' => $this->input->post('email'),
					'client_username' => $this->input->post('username'),
					'client_profile' => $fname,
					'contact_number' => $this->input->post('contact_number'),
					'website_url' => $this->input->post('website'),
					'address_1' => $this->input->post('address_1'),
					'address_2' => $this->input->post('address_2'),
					'city' => $this->input->post('city'),
					'state' => $this->input->post('state'),
					'zipcode' => $this->input->post('zipcode'),
					'country' => $this->input->post('country'),		
					'is_active' => $this->input->post('status'),
					);
					// update record > model
					$result = $this->Clients_model->update_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
	
		if($Return['error']!=''){
       		$this->output($Return);
    	}		
			
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_project_client_updated');
		} else {
			$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			$session = $this->session->userdata('username');
			if(empty($session)){ 
				redirect('admin/');
			}
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Clients_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_project_client_deleted');
			} else {
				$Return['error'] = $Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
