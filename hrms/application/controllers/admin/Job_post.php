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

class Job_post extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->library('email');
		$this->load->model("Designation_model");
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
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_job_posts');
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_job_types'] = $this->Job_post_model->all_job_types();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_job_posts');
		$data['path_url'] = 'job_post';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('49',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/job_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function job_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/job_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$jobs = $this->Job_post_model->get_jobs();
		
		$data = array();

        foreach($jobs->result() as $r) {
			 			  
		// get job designation
		$designation = $this->Designation_model->read_designation_information($r->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';
		}
		// get job type
		$job_type = $this->Job_post_model->read_job_type_information($r->job_type);
		if(!is_null($job_type)){
			$jtype = $job_type[0]->type;
		} else {
			$jtype = '--';
		}
		// get date
		$date_of_closing = $this->Xin_model->set_date_format($r->date_of_closing);
		$created_at = $this->Xin_model->set_date_format($r->created_at);
		/* get job status*/
		if($r->status==1): $status = $this->lang->line('xin_published'); elseif($r->status==2): $status = $this->lang->line('xin_unpublished'); endif;
		$p_company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($p_company)){
			$company = $p_company[0]->name;
		} else {
			$company = '--';	
		}
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-job_id="'. $r->job_id . '"><span class="fas fa-pencil-alt"></span></button></span><a href="'.site_url().'frontend/jobs/detail/'.$r->job_id.'" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"><span class="fa fa-eye"></span></button></a><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->job_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$company,
			$r->job_title,
			$designation_name,
			$jtype,
			$r->job_vacancy,
			$date_of_closing,
			$status,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $jobs->num_rows(),
			 "recordsFiltered" => $jobs->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // get company > designations
	 public function get_designations() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/get_designations", $data);
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
		$id = $this->input->get('job_id');
		$result = $this->Job_post_model->read_job_information($id);
		$data = array(
				'job_id' => $result[0]->job_id,
				'company_id' => $result[0]->company_id,
				'job_title' => $result[0]->job_title,
				'designation_id' => $result[0]->designation_id,
				'job_type_id' => $result[0]->job_type,
				'job_vacancy' => $result[0]->job_vacancy,
				'gender' => $result[0]->gender,
				'minimum_experience' => $result[0]->minimum_experience,
				'date_of_closing' => $result[0]->date_of_closing,
				'short_description' => $result[0]->short_description,
				'long_description' => $result[0]->long_description,
				'status' => $result[0]->status,
				'all_designations' => $this->Designation_model->all_designations(),
				'all_job_types' => $this->Job_post_model->all_job_types(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/job_post/dialog_job_post', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_job() {
	
		if($this->input->post('add_type')=='job') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$long_description = $_POST['long_description'];	
		$short_description = $_POST['short_description'];	
		$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
		$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);
		
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('job_title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_title');
		} else if($this->input->post('job_type')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_type');
		} else if($this->input->post('designation_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_designation');
		} else if($this->input->post('vacancy')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_positions');
		} else if($this->input->post('date_of_closing')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_closing_date');
		} else if($qt_short_description==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_short_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'job_title' => $this->input->post('job_title'),
		'company_id' => $this->input->post('company'),
		'job_type' => $this->input->post('job_type'),
		'designation_id' => $this->input->post('designation_id'),
		'short_description' => $qt_short_description,
		'long_description' => $qt_description,
		'status' => $this->input->post('status'),
		'job_vacancy' => $this->input->post('vacancy'),
		'date_of_closing' => $this->input->post('date_of_closing'),
		'gender' => $this->input->post('gender'),
		'minimum_experience' => $this->input->post('experience'),
		'created_at' => date('Y-m-d h:i:s'),
		
		);
		$result = $this->Job_post_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='job') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$long_description = $_POST['long_description'];	
		$short_description = $_POST['short_description'];	
		$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
		$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);
		
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('job_title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_title');
		} else if($this->input->post('job_type')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_type');
		} else if($this->input->post('designation_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_designation');
		} else if($this->input->post('vacancy')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_positions');
		} else if($this->input->post('date_of_closing')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_closing_date');
		} else if($qt_short_description==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_short_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'job_title' => $this->input->post('job_title'),
		'company_id' => $this->input->post('company'),
		'job_type' => $this->input->post('job_type'),
		'designation_id' => $this->input->post('designation_id'),
		'short_description' => $qt_short_description,
		'long_description' => $qt_description,
		'status' => $this->input->post('status'),
		'job_vacancy' => $this->input->post('vacancy'),
		'date_of_closing' => $this->input->post('date_of_closing'),
		'gender' => $this->input->post('gender'),
		'minimum_experience' => $this->input->post('experience')		
		);
		
		$result = $this->Job_post_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_updated');
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
		$result = $this->Job_post_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_job_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
