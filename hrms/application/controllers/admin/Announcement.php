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

class Announcement extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Announcement_model");
		$this->load->model("Xin_model");
		$this->load->model("Company_model");
		$this->load->model("Location_model");
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
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_announcements');
		$data['path_url'] = 'announcements';
		$data['get_all_companies'] = $this->Company_model->get_all_companies();
		$data['all_office_locations'] = $this->Location_model->all_office_locations();
		$data['all_departments'] = $this->Department_model->all_departments();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('11',$role_resources_ids)) {
		$data['subview'] = $this->load->view("admin/announcement/announcement_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load	
		} else {
			redirect('admin/dashboard');
		}
     }
 
    public function announcement_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$this->load->view("admin/announcement/announcement_list", $data);
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$announcement = $this->Announcement_model->get_announcements();
		
		$data = array();

        foreach($announcement->result() as $r) {
			 			  
		// get date
		$sdate = $this->Xin_model->set_date_format($r->start_date);
		$edate = $this->Xin_model->set_date_format($r->end_date);
		
		$department = $this->Department_model->read_department_information($r->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-announcement_id="'. $r->announcement_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-announcement_id="'. $r->announcement_id . '"><span class="fa fa-eye"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->announcement_id . '"><span class="far fa-trash-alt"></span></button></span>',
			$r->title,
			$comp_name,
			$r->summary,
			$department_name,
			$sdate,
			$edate
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $announcement->num_rows(),
			 "recordsFiltered" => $announcement->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('announcement_id');
		$result = $this->Announcement_model->read_announcement_information($id);
		$data = array(
				'announcement_id' => $result[0]->announcement_id,
				'title' => $result[0]->title,
				'company_id' => $result[0]->company_id,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'company_id' => $result[0]->company_id,
				//'location_id' => $result[0]->location_id,
				'department_id' => $result[0]->department_id,
				'published_by' => $result[0]->published_by,
				'summary' => $result[0]->summary,
				'description' => $result[0]->description,
				'get_all_companies' => $this->Company_model->get_all_companies(),
				'all_office_locations' => $this->Location_model->all_office_locations(),
				'all_departments' => $this->Department_model->all_departments()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/announcement/dialog_announcement', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get company > departments
	 public function get_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/announcement/get_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	// Validate and add info in database
	public function add_announcement() {
	
		if($this->input->post('add_type')=='announcement') {		
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
		
		if($this->input->post('title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('company_id')==='') {
       		$Return['error'] = $this->lang->line('error_company_field');
		} /*else if($this->input->post('location_id')==='') {
       		$Return['error'] = $this->lang->line('error_location_dept_field');
		} */
		else if($this->input->post('department_id')==='') {
       		$Return['error'] = $this->lang->line('error_department_field');
		} else if($this->input->post('summary')==='') {
       		$Return['error'] = $this->lang->line('xin_error_summary_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
			
		$data = array(
		'title' => $this->input->post('title'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'company_id' => $this->input->post('company_id'),
		//'location_id' => $this->input->post('location_id'),
		'department_id' => $this->input->post('department_id'),
		'description' => $qt_description,
		'summary' => $this->input->post('summary'),
		'published_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y'),
		
		);
		$result = $this->Announcement_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_announcement');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='announcement') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date_modal');
		$end_date = $this->input->post('end_date_modal');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('company_id')==='') {
       		$Return['error'] = $this->lang->line('error_company_field');
		} /*else if($this->input->post('location_id')==='') {
       		$Return['error'] = $this->lang->line('error_location_dept_field');
		} */else if($this->input->post('department_id')==='') {
       		$Return['error'] = $this->lang->line('error_department_field');
		} else if($this->input->post('summary')==='') {
       		$Return['error'] = $this->lang->line('xin_error_summary_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
				
	
		$data = array(
		'title' => $this->input->post('title'),
		'start_date' => $this->input->post('start_date_modal'),
		'end_date' => $this->input->post('end_date_modal'),
		'company_id' => $this->input->post('company_id'),
		//'location_id' => $this->input->post('location_id'),
		'department_id' => $this->input->post('department_id'),
		'description' => $qt_description,
		'summary' => $this->input->post('summary')		
		);
		
		$result = $this->Announcement_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_announcement');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		
		if($this->input->post('is_ajax')==2) {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Announcement_model->delete_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_success_delete_announcement');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
}
