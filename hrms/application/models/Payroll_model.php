<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class payroll_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	// get payroll templates
	public function get_templates() {
	  return $this->db->get("xin_salary_templates");
	}
	
	// get payroll templates > for companies
	public function get_comp_template($cid,$id) {
		
		$sql = 'SELECT * FROM xin_employees WHERE company_id = ?';
		$binds = array($cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get payroll templates > employee/company
	public function get_employee_comp_template($cid,$id) {
		
		$sql = 'SELECT * FROM xin_employees WHERE company_id = ? and user_id = ?';
		$binds = array($cid,$id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get total hours work > hourly template > payroll generate
	public function total_hours_worked($id,$attendance_date) {
		
		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date like ?';
		$binds = array($id, '%'.$attendance_date.'%');
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get total hours work > hourly template > payroll generate
	public function total_hours_worked_payslip($id,$attendance_date) {
		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date like ?';
		$binds = array($id, '%'.$attendance_date.'%');
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get advance salaries > all employee
	public function get_advance_salaries() {
	  return $this->db->get("xin_advance_salaries");
	}
	
	// get advance salaries > single employee
	public function get_advance_salaries_single($id) {
	    
		$sql = 'SELECT * FROM xin_advance_salaries WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get advance salaries report
	public function get_advance_salaries_report() {
	  return $this->db->query("SELECT advance_salary_id,employee_id,company_id,month_year,one_time_deduct,monthly_installment,reason,status,total_paid,is_deducted_from_salary,created_at,SUM(`xin_advance_salaries`.advance_amount) AS advance_amount FROM `xin_advance_salaries` where status=1 group by employee_id");
	}
	
	// get advance salaries report >> single employee > current user
	public function advance_salaries_report_single($id) {
	  $sql = 'SELECT advance_salary_id,employee_id,company_id,month_year,one_time_deduct,monthly_installment,reason,status,total_paid,is_deducted_from_salary,created_at,SUM(`xin_advance_salaries`.advance_amount) AS advance_amount FROM `xin_advance_salaries` where status=1 and employee_id = ? group by employee_id';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	
	// get payment history > all payslips
	public function all_payment_history() {
	  return $this->db->get("xin_make_payment");
	}
	
	// get payslips of single employee
	public function get_payroll_slip($id) {
		
		$sql = 'SELECT * FROM xin_make_payment WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get hourly wages
	public function get_hourly_wages()
	{
	  return $this->db->get("xin_hourly_templates");
	}
	 
	 public function read_template_information($id) {
	
		$sql = 'SELECT * FROM xin_salary_templates WHERE salary_template_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get request date details > advance salary
	public function requested_date_details($id) {
		
		$sql = 'SELECT * FROM `xin_advance_salaries` WHERE employee_id = ? and status = ?';
		$binds = array($id,1);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function read_hourly_wage_information($id) {
	
		$sql = 'SELECT * FROM xin_hourly_templates WHERE hourly_rate_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get advance salaries report > view all
	public function advance_salaries_report_view($id) {
	  $sql = 'SELECT advance_salary_id,company_id,employee_id,month_year,one_time_deduct,monthly_installment,reason,status,total_paid,is_deducted_from_salary,created_at,SUM(`xin_advance_salaries`.advance_amount) AS advance_amount FROM `xin_advance_salaries` where status=1 and employee_id= ? group by employee_id';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
	    return $query->result();
	}
	
	public function read_make_payment_information($id) {
	
		$sql = 'SELECT * FROM xin_make_payment WHERE make_payment_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_advance_salary_info($id) {
	
		$sql = 'SELECT * FROM xin_advance_salaries WHERE advance_salary_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get advance salary by employee id >paid.total
	public function get_paid_salary_by_employee_id($id) {
	
		$sql = 'SELECT advance_salary_id,employee_id,month_year,one_time_deduct,monthly_installment,reason,status,total_paid,is_deducted_from_salary,created_at,SUM(`xin_advance_salaries`.advance_amount) AS advance_amount FROM `xin_advance_salaries` where status=1 and employee_id=? group by employee_id';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	
	// get advance salary by employee id
	public function advance_salary_by_employee_id($id) {
	
		$sql = 'SELECT * FROM xin_advance_salaries WHERE employee_id = ? and status = ? order by advance_salary_id desc';
		$binds = array($id,1);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	
	// Function to add record in table
	public function add_template($data){
		$this->db->insert('xin_salary_templates', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table > advance salary
	public function add_advance_salary_payroll($data){
		$this->db->insert('xin_advance_salaries', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_hourly_wages($data){
		$this->db->insert('xin_hourly_templates', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_monthly_payment_payslip($data){
		$this->db->insert('xin_make_payment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_hourly_payment_payslip($data){
		$this->db->insert('xin_make_payment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_template_record($id){
		$this->db->where('salary_template_id', $id);
		$this->db->delete('xin_salary_templates');
		
	}
	
	// Function to Delete selected record from table
	public function delete_hourly_wage_record($id){
		$this->db->where('hourly_rate_id', $id);
		$this->db->delete('xin_hourly_templates');
		
	}
	
	// Function to Delete selected record from table
	public function delete_advance_salary_record($id){
		$this->db->where('advance_salary_id', $id);
		$this->db->delete('xin_advance_salaries');
		
	}
	
	// Function to update record in table
	public function update_template_record($data, $id){
		$this->db->where('salary_template_id', $id);
		if( $this->db->update('xin_salary_templates',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get all hourly templates
	public function all_hourly_templates()
	{
	  $query = $this->db->query("SELECT * from xin_hourly_templates");
  	  return $query->result();
	}
	
	// get all salary tempaltes > payroll templates
	public function all_salary_templates()
	{
	  $query = $this->db->query("SELECT * from xin_salary_templates");
  	  return $query->result();
	}
	
	// Function to update record in table
	public function update_hourly_wages_record($data, $id){
		$this->db->where('hourly_rate_id', $id);
		if( $this->db->update('xin_hourly_templates',$data)) {
			return true;
		} else {
			return false;
		}		
	}	
	
	// Function to update record in table > manage salary
	public function update_salary_template($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > deduction of advance salary
	public function updated_advance_salary_paid_amount($data, $id){
		$this->db->where('employee_id', $id);
		if( $this->db->update('xin_advance_salaries',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > advance salary
	public function updated_advance_salary_payroll($data, $id){
		$this->db->where('advance_salary_id', $id);
		if( $this->db->update('xin_advance_salaries',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > empty grade status
	public function update_empty_salary_template($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > set hourly grade
	public function update_hourlygrade_salary_template($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > set monthly grade
	public function update_monthlygrade_salary_template($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table > zero hourly grade
	public function update_hourlygrade_zero($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	// Function to update record in table > zero monthly grade
	public function update_monthlygrade_zero($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('xin_employees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function read_make_payment_payslip_check($employee_id,$p_date) {
	
		$sql = 'SELECT * FROM xin_make_payment WHERE employee_id = ? and payment_date = ?';
		$binds = array($employee_id,$p_date);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function read_make_payment_payslip($employee_id,$p_date) {
	
		$sql = 'SELECT * FROM xin_make_payment WHERE employee_id = ? and payment_date = ?';
		$binds = array($employee_id,$p_date);
		$query = $this->db->query($sql, $binds);
		
		return $query->result();
	}
}
?>