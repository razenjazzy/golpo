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

class Employees_last_login extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Employees_model");
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
		$data['title'] = $this->lang->line('left_employees_last_login');
		$data['breadcrumbs'] = $this->lang->line('left_employees_last_login');
		$data['path_url'] = 'employees_last_login';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('22',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/last_login/last_login_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
 
    public function last_login_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/last_login/last_login_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$employee = $this->Employees_model->get_employees();
		
		$data = array();
		
		foreach($employee->result() as $r) {
						  
		// login date and time
		if($r->last_login_date==''){
			$edate = '-';
			$etime = '-';
		} else {
			$edate = $this->Xin_model->set_date_format($r->last_login_date);
			$last_login =  new DateTime($r->last_login_date);
			$etime = $last_login->format('h:i a');
		}
		// employee link
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('13',$role_resources_ids)) {
			$emp_link = '<a href="'.site_url().'admin/employees/detail/'.$r->user_id.'" data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'">'.$r->employee_id.'</a>';
		} else {
			$emp_link = $r->employee_id;
		}
		// user full name
		$full_name = $r->first_name.' '.$r->last_name;
		// user role
		$role = $this->Xin_model->read_user_role_info($r->user_role_id);
		if(!is_null($role)){
			$role_name = $role[0]->role_name;
		} else {
			$role_name = '--';	
		}
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		/* get status*/
		if($r->is_active==1): $status = $this->lang->line('xin_employees_active'); elseif($r->is_active==0): $status = $this->lang->line('xin_employees_inactive'); endif;
		// last login date and time
		$elast_login = $edate.' '.$etime;
		$data[] = array(
			$emp_link,
			$full_name,
			$r->username,
			$comp_name,
			$elast_login,
			$role_name,
			$status
		);
		}
		
		$output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
		}
}
