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

class Job_candidates extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
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
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_job_candidates');
		$data['path_url'] = 'job_candidates';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('51',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/job_candidates", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
 
    public function candidate_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/job_candidates", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$candidates = $this->Job_post_model->get_jobs_candidates();
		
		$data = array();

        foreach($candidates->result() as $r) {
			 			  
		// get user
		$user = $this->Xin_model->read_user_info($r->user_id);
		// get full name
		if(!is_null($user)){
			$full_name = $user[0]->first_name. ' ' .$user[0]->last_name;
			$uemail = $user[0]->email;
		} else {
			$full_name = '--';	
			$uemail = '--';
		}
		// get job title
		$job = $this->Job_post_model->read_job_information($r->job_id);
		if(!is_null($job)){
			$job_title = $job[0]->job_title;
		} else {
			$job_title = '--';	
		}
		// get date
		$created_at = $this->Xin_model->set_date_format($r->created_at);
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'">
			<a href="'.site_url().'admin/download?type=resume&filename='.$r->job_resume.'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="fa fa-download"></i></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fa fa-trash-o"></i></button></span>',
			$job_title,
			$full_name,
			$uemail,
			$r->application_status,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $candidates->num_rows(),
			 "recordsFiltered" => $candidates->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 	
	// delete job candidate / job application	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Job_post_model->delete_application_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_error_job_application');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
