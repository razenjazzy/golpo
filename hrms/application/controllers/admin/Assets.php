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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          //load the models
          $this->load->model('Xin_model');
		  $this->load->model('Employees_model');
		  $this->load->model('Department_model');
		  $this->load->model('Assets_model');
     }
	 	
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_assets!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_assets');
		$data['path_url'] = 'assets';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_assets_categories'] = $this->Assets_model->get_all_assets_categories();
		if(in_array('25',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/assets/assets_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function category() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_assets_category');
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'assets_category';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('26',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/assets/assets_category_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/assets/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
			 	 
	 // category list
	public function category_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/languages_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$assets_category = $this->Assets_model->get_assets_categories();
		
		$data = array();
		
          foreach($assets_category->result() as $r) {						
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
			 	$comp_name = '--';	
			}
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".payroll_template_modal" data-field_id="'. $r->assets_category_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->assets_category_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$r->category_name,
			$comp_name
		);
		}
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $assets_category->num_rows(),
                 "recordsFiltered" => $assets_category->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	// assets list
	public function assets_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/languages/languages_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$assets = $this->Assets_model->get_assets();
		
		$data = array();
		
          foreach($assets->result() as $r) {						
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
			 	$comp_name = '--';	
			}
			// get category
			$assets_category = $this->Assets_model->read_assets_category_info($r->assets_category_id);
			if(!is_null($assets_category)){
				$category = $assets_category[0]->category_name;
			} else {
			 	$category = '--';	
			}
			//working?
			if($r->is_working==1){
				$working = $this->lang->line('xin_yes');
			} else {
				$working = $this->lang->line('xin_no');
			}
			// get user > added by
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".edit-modal-data" data-field_id="'. $r->assets_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-asset_id="'. $r->assets_id . '"><span class="fa fa-eye"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->assets_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$r->name,
			$category,
			$r->company_asset_code,
			$working,
			$full_name,
			$comp_name
		);
		}
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $assets->num_rows(),
                 "recordsFiltered" => $assets->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	public function asset_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('asset_id');
		$result = $this->Assets_model->read_assets_info($id);
		$data = array(
				'assets_id' => $result[0]->assets_id,
				'assets_category_id' => $result[0]->assets_category_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'company_asset_code' => $result[0]->company_asset_code,
				'name' => $result[0]->name,
				'purchase_date' => $result[0]->purchase_date,
				'invoice_number' => $result[0]->invoice_number,
				'manufacturer' => $result[0]->manufacturer,
				'serial_number' => $result[0]->serial_number,
				'warranty_end_date' => $result[0]->warranty_end_date,
				'asset_note' => $result[0]->asset_note,
				'asset_image' => $result[0]->asset_image,
				'is_working' => $result[0]->is_working,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_assets_categories' => $this->Assets_model->get_all_assets_categories(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/assets/dialog_asset', $data);
		} else {
			redirect('admin/');
		}
	}
	 	 	 
	// Validate and add info in database
	public function add_category() {
	
		if($this->input->post('add_type')=='add_category') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// set data
		$data = array(
		'company_id' => $this->input->post('company_id'),
		'category_name' => $this->input->post('name'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Assets_model->add_assets_category($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_assets_category_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_asset() {
	
		if($this->input->post('add_type')=='add_asset') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('category_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_category_field');
		} else if($this->input->post('asset_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_asset_name_field');
		} else if($this->input->post('company_asset_code')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		} else if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('manufacturer')==='') {
        	$Return['error'] = $this->lang->line('xin_error_manufacturer_field');
		} else if($this->input->post('asset_note')==='') {
        	$Return['error'] = $this->lang->line('xin_error_asset_note_field');
		} 
		/* Check if file uploaded..*/
		else if($_FILES['asset_image']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_error_asset_image_field');
		} else {
			if(is_uploaded_file($_FILES['asset_image']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['asset_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["asset_image"]["tmp_name"];
					$asset_image = "uploads/asset_image/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["asset_image"]["name"]);
					$newfilename = 'asset_image_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $asset_image.$newfilename);
					$fname = $newfilename;
				} else {
					$Return['error'] = $this->lang->line('xin_error_asset_image_attachment');
				}
			}
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// set data
		$data = array(
		'assets_category_id' => $this->input->post('category_id'),
		'name' => $this->input->post('asset_name'),
		'company_asset_code' => $this->input->post('company_asset_code'),
		'is_working' => $this->input->post('is_working'),
		'company_id' => $this->input->post('company_id'),
		'employee_id' => $this->input->post('employee_id'),
		'purchase_date' => $this->input->post('purchase_date'),
		'invoice_number' => $this->input->post('invoice_number'),
		'manufacturer' => $this->input->post('manufacturer'),
		'serial_number' => $this->input->post('serial_number'),
		'warranty_end_date' => $this->input->post('warranty_end_date'),
		'asset_note' => $this->input->post('asset_note'),
		'asset_image' => $fname,
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Assets_model->add_asset($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_asset_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_asset() {
	
		if($this->input->post('edit_type')=='update_asset') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');		
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('category_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_category_field');
		} else if($this->input->post('asset_name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_asset_name_field');
		} else if($this->input->post('company_asset_code')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		} else if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('manufacturer')==='') {
        	$Return['error'] = $this->lang->line('xin_error_manufacturer_field');
		} else if($this->input->post('asset_note')==='') {
        	$Return['error'] = $this->lang->line('xin_error_asset_note_field');
		} 
		/* Check if file uploaded..*/
		else if($_FILES['asset_image']['size'] == 0) {
			// set data
			$data = array(
			'assets_category_id' => $this->input->post('category_id'),
			'name' => $this->input->post('asset_name'),
			'company_asset_code' => $this->input->post('company_asset_code'),
			'is_working' => $this->input->post('is_working'),
			'company_id' => $this->input->post('company_id'),
			'employee_id' => $this->input->post('employee_id'),
			'purchase_date' => $this->input->post('purchase_date'),
			'invoice_number' => $this->input->post('invoice_number'),
			'manufacturer' => $this->input->post('manufacturer'),
			'serial_number' => $this->input->post('serial_number'),
			'warranty_end_date' => $this->input->post('warranty_end_date'),
			'asset_note' => $this->input->post('asset_note')
			);
			
			$result = $this->Assets_model->update_assets_record($data,$id);
		} else {
			if(is_uploaded_file($_FILES['asset_image']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['asset_image']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["asset_image"]["tmp_name"];
					$asset_image = "uploads/asset_image/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["asset_image"]["name"]);
					$newfilename = 'asset_image_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $asset_image.$newfilename);
					$fname = $newfilename;
					
					// set data
					$data = array(
					'assets_category_id' => $this->input->post('category_id'),
					'name' => $this->input->post('asset_name'),
					'company_asset_code' => $this->input->post('company_asset_code'),
					'is_working' => $this->input->post('is_working'),
					'company_id' => $this->input->post('company_id'),
					'employee_id' => $this->input->post('employee_id'),
					'purchase_date' => $this->input->post('purchase_date'),
					'invoice_number' => $this->input->post('invoice_number'),
					'manufacturer' => $this->input->post('manufacturer'),
					'serial_number' => $this->input->post('serial_number'),
					'warranty_end_date' => $this->input->post('warranty_end_date'),
					'asset_note' => $this->input->post('asset_note'),
					'asset_image' => $fname
					);
					
					$result = $this->Assets_model->update_assets_record($data,$id);
		
				} else {
					$Return['error'] = $this->lang->line('xin_error_asset_image_attachment');
				}
			}
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_asset_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_assets_category() {
	
		if($this->input->post('edit_type')=='assets_category') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('name')==='') {
        	$Return['error'] = $this->lang->line('xin_error_cat_name_field');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// set data
		$data = array(
		'company_id' => $this->input->post('company_id'),
		'category_name' => $this->input->post('name')
		);
		
		$result = $this->Assets_model->update_assets_category_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_assets_category_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function read_assets_category() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('assets_category_id');
		$result = $this->Assets_model->read_assets_category_info($id);
		$data = array(
				'assets_category_id' => $result[0]->assets_category_id,
				'company_id' => $result[0]->company_id,
				'category_name' => $result[0]->category_name,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/assets/dialog_assets_category', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// delete record > table
	public function delete_asset() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Assets_model->delete_assets_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_asset_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// delete record > table
	public function delete_assets_category() {
		
		if($this->input->post('type')=='delete_record') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Assets_model->delete_assets_category_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_assets_category_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>