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

class Training extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Training_model");
		$this->load->model("Xin_model");
		$this->load->model("Trainers_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
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
		if($system[0]->module_training!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_trainers'] = $this->Trainers_model->all_trainers();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_training');
		$data['path_url'] = 'training';
		$data['all_training_types'] = $this->Training_model->all_training_types();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('54',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/training/training_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function training_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/training/training_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$training = $this->Training_model->get_training();
		
		$data = array();

        foreach($training->result() as $r) {
		
		// get training type
		$type = $this->Training_model->read_training_type_information($r->training_type_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';	
		}
		// get trainer
		$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
		// trainer full name
		if(!is_null($trainer)){
			$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$trainer_name = '--';	
		}
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$finish_date = $this->Xin_model->set_date_format($r->finish_date);
		// training date
		$training_date = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
		// set currency
		$training_cost = $this->Xin_model->currency_sign($r->training_cost);
		/* get Employee info*/
		if($r->employee_id == '') {
			$ol = '--';
		} else {
			$ol = '';
			foreach(explode(',',$r->employee_id) as $uid) {
				$user = $this->Xin_model->read_user_info($uid);
				if(!is_null($user)){
					$assigned_name = $user[0]->first_name.' '.$user[0]->last_name;
					if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {
                    $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$user[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                    } else {
                    if($user[0]->gender=='Male') { 
                    	$de_file = base_url().'uploads/profile/default_male.jpg';
                     } else {
                     	$de_file = base_url().'uploads/profile/default_female.jpg';
                     }
                    $ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
                    }
				} else {
					$ol .= '';
				}
			 }
			 $ol .= '';
		}
		// status
		if($r->training_status==0): $status = $this->lang->line('xin_pending');
		elseif($r->training_status==1): $status = $this->lang->line('xin_started'); elseif($r->training_status==2): $status = $this->lang->line('xin_completed');
		else: $status = $this->lang->line('xin_terminated'); endif;
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
		$comp_name = $company[0]->name;
		} else {
		  $comp_name = '--';	
		}
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/training/details/'.$r->training_id.'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-training_id="'. $r->training_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->training_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$comp_name,
			$ol,
			$itype,
			$trainer_name,
			$training_date,
			$training_cost,
			$status
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $training->num_rows(),
			 "recordsFiltered" => $training->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
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
			$this->load->view("admin/training/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('training_id');
		$result = $this->Training_model->read_training_information($id);
		$data = array(
				'title' => $this->Xin_model->site_title(),
				'company_id' => $result[0]->company_id,
				'training_id' => $result[0]->training_id,
				'employee_id' => $result[0]->employee_id,
				'training_type_id' => $result[0]->training_type_id,
				'trainer_id' => $result[0]->trainer_id,
				'start_date' => $result[0]->start_date,
				'finish_date' => $result[0]->finish_date,
				'training_cost' => $result[0]->training_cost,
				'training_status' => $result[0]->training_status,
				'description' => $result[0]->description,
				'performance' => $result[0]->performance,
				'remarks' => $result[0]->remarks,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_training_types' => $this->Training_model->all_training_types(),
				'all_trainers' => $this->Trainers_model->all_trainers(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/training/dialog_training', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_training() {
	
		if($this->input->post('add_type')=='training') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('company')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('training_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_training_type');
		} else if($this->input->post('trainer')==='') {
			$Return['error'] = $this->lang->line('xin_error_trainer_field');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('employee_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_employee_id');
		} 
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$employee_ids = implode(',',$_POST['employee_id']);
		$employee_id = $employee_ids;
	
		$data = array(
		'training_type_id' => $this->input->post('training_type'),
		'company_id' => $this->input->post('company'),
		'trainer_id' => $this->input->post('trainer'),
		'training_cost' => $this->input->post('training_cost'),
		'start_date' => $this->input->post('start_date'),
		'finish_date' => $this->input->post('end_date'),
		'employee_id' => $employee_id,
		'description' => $qt_description,
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Training_model->add($data);
		if ($result == TRUE) {
			$row = $this->db->select("*")->limit(1)->order_by('training_id',"DESC")->get("xin_training")->row();
			$Return['result'] = $this->lang->line('xin_success_training_added');	
			// get training type
			$type = $this->Training_model->read_training_type_information($row->training_type_id);
			if(!is_null($type)){
				$itype = $type[0]->type;
			} else {
				$itype = '--';	
			}
			$Return['re_last_id'] = $row->training_id;
			$Return['re_type'] = $itype;	
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='training') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('company')==='') {
        	$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('training_type')==='') {
        	$Return['error'] = $this->lang->line('xin_error_training_type');
		} else if($this->input->post('trainer')==='') {
			$Return['error'] = $this->lang->line('xin_error_trainer_field');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if(isset($_POST['employee_id'])) {
			$employee_ids = implode(',',$_POST['employee_id']);
			$employee_id = $employee_ids;
		} else {
			$employee_id = '';
		}
	
		$data = array(
		'training_type_id' => $this->input->post('training_type'),
		'company_id' => $this->input->post('company'),
		'trainer_id' => $this->input->post('trainer'),
		'training_cost' => $this->input->post('training_cost'),
		'start_date' => $this->input->post('start_date'),
		'finish_date' => $this->input->post('end_date'),
		'employee_id' => $employee_id,
		'description' => $qt_description
		);
		
		$result = $this->Training_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_training_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// training details
	public function details()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		$result = $this->Training_model->read_training_information($id);
		if(is_null($result)){
			redirect('admin/training');
		}
		// get training type
		$type = $this->Training_model->read_training_type_information($result[0]->training_type_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';	
		}
		// get trainer
		$trainer = $this->Trainers_model->read_trainer_information($result[0]->trainer_id);
		// trainer full name
		if(!is_null($trainer)){
			$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$trainer_name = '--';	
		}
		$data = array(
				'title' => $this->Xin_model->site_title(),
				'training_id' => $result[0]->training_id,
				'company_id' => $result[0]->company_id,
				'type' => $itype,
				'trainer_name' => $trainer_name,
				'training_cost' => $result[0]->training_cost,
				'start_date' => $result[0]->start_date,
				'finish_date' => $result[0]->finish_date,
				'created_at' => $result[0]->created_at,
				'description' => $result[0]->description,
				'performance' => $result[0]->performance,
				'training_status' => $result[0]->training_status,
				'remarks' => $result[0]->remarks,
				'employee_id' => $result[0]->employee_id,
				'all_employees' => $this->Xin_model->all_employees(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		$data['breadcrumbs'] = $this->lang->line('xin_training_details');
		$data['path_url'] = 'training_details';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('54',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/training/training_details", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 
	 // Validate and update info in database
	public function update_status() {
	
		if($this->input->post('edit_type')=='update_status') {
			
			$id = $this->input->post('token_status');
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
			$data = array(
			'performance' => $this->input->post('performance'),
			'training_status' => $this->input->post('status'),
			'remarks' => $this->input->post('remarks')
			);
			
			$result = $this->Training_model->update_status($data,$id);		
			
			if ($result == TRUE) {
				$Return['result'] = $this->lang->line('xin_success_training_status_updated');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
			exit;
		}
	}
	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Training_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_training_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
