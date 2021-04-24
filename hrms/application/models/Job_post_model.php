<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class job_post_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 	
	// get jobs
	public function get_jobs() {
	  return $this->db->get("xin_jobs");
	}
			
	// get all job candidates
	public function get_jobs_candidates() {
	  return $this->db->get("xin_job_applications");
	}
	
	// get all employee applied jobs
	public function get_employee_jobs_applied($id) {
	  $sql = 'SELECT * from xin_job_applications where user_id = ?';
	  $binds = array($id);
	  $query = $this->db->query($sql, $binds);
	  return $query;
	}
	 // read job info
	 public function read_job_information($id) {
	
		$sql = 'SELECT * from xin_jobs where job_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get all jobtype jobs
	 public function read_all_jobs_by_type() {
	
		$sql = 'SELECT * from xin_jobs where job_type != ? group by job_type';
		$binds = array('');
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get all job types
	public function all_job_types() {
	  $query = $this->db->query("SELECT * from xin_job_type");
  	  return $query->result();
	}
	
	// get all jobs by designation
	 public function read_all_jobs_by_designation() {
	
		$sql = 'SELECT * from xin_jobs where designation_id != ?';
		$binds = array('');
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// check apply jobs > remove duplicate
	 public function check_apply_job($job_id,$user_id) {
	
		$sql = 'SELECT * from xin_job_applications where job_id = ? and user_id = ?';
		$binds = array($job_id,$user_id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	// get all interview jobs > 
	public function all_interview_jobs()
	{
	  $query = $this->db->query("SELECT j.*, jap.* FROM xin_jobs as j, xin_job_applications as jap where j.job_id = jap.job_id group by j.job_id");
  	  return $query->result();
	}
	
	// read job type info
	 public function read_job_type_information($id) {
	
		$sql = 'SELECT * from xin_job_type where job_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get all interviews
	public function all_interviews() {
	  return $this->db->get("xin_job_interviews");
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_jobs', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_resume($data){
		$this->db->insert('xin_job_applications', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// get all job > frontend
	public function all_jobs() {
	  $query = $this->db->query("SELECT * from xin_jobs");
  	  return $query->result();
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('job_id', $id);
		$this->db->delete('xin_jobs');
		
	}
	
	// Function to Delete selected record from table
	public function delete_application_record($id){
		$this->db->where('application_id', $id);
		$this->db->delete('xin_job_applications');
		
	}
	
	// Function to Delete selected record from table
	public function delete_interview_record($id){
		$this->db->where('job_interview_id', $id);
		$this->db->delete('xin_job_interviews');
		
	}
	
	// get department > designations
	public function ajax_job_user_information($id) {
	
		$sql = 'SELECT * from xin_job_applications where job_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_interview($data){
		$this->db->insert('xin_job_interviews', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('job_id', $id);
		if( $this->db->update('xin_jobs',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>