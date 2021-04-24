<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class department_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_departments()
	{
	  return $this->db->get("xin_departments");
	}
	 
	 public function read_department_information($id) {
	
		$sql = 'SELECT * FROM xin_departments WHERE department_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > company | locations
	 public function ajax_location_information($id) {
	
		$sql = 'SELECT * FROM xin_office_location WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get single record > company | employees
	 public function ajax_company_employee_info($id) {
	
		$sql = 'SELECT * FROM xin_employees WHERE company_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_departments', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('department_id', $id);
		$this->db->delete('xin_departments');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('department_id', $id);
		$data = $this->security->xss_clean($data);
		if( $this->db->update('xin_departments',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get all departments
	public function all_departments()
	{
	  $query = $this->db->query("SELECT * from xin_departments");
  	  return $query->result();
	}
}
?>