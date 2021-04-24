<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Finance_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	// bank and cash
	public function get_bankcash()
	{
	  return $this->db->get("xin_finance_bankcash");
	}
	
	// deposit
	public function get_deposit()
	{
	  return $this->db->get("xin_finance_deposit");
	}
	
	// expense
	public function get_expense()
	{
	  return $this->db->get("xin_finance_expense");
	}
	
	// transfer
	public function get_transfer()
	{
	  return $this->db->get("xin_finance_transfer");
	}
	
	// transactions
	public function get_transactions()
	{
	  return $this->db->query("SELECT * from xin_finance_transactions order by transaction_date asc");
	}
	
	// bank wise transactions
	public function get_bankwise_transactions($id)
	{
		$sql = 'SELECT * FROM xin_finance_transactions WHERE account_type_id = ? order by transaction_date asc';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	 
	public function read_bankcash_information($id) {
	
		$sql = 'SELECT * FROM xin_finance_bankcash WHERE bankcash_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_deposit_information($id) {
	
		$sql = 'SELECT * FROM xin_finance_deposit WHERE deposit_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_transaction_by_bank_info($id) {
	
		$sql = 'SELECT * FROM xin_finance_transactions WHERE account_type_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_payer_record($id){
		$this->db->where('payer_id', $id);
		$this->db->delete('xin_finance_payers');
		
	}
	
	// Function to Delete selected record from table
	public function delete_payee_record($id){
		$this->db->where('payee_id', $id);
		$this->db->delete('xin_finance_payees');
		
	}
	
	public function read_expense_information($id) {
	
		$sql = 'SELECT * FROM xin_finance_expense WHERE expense_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_transfer_information($id) {
	
		$sql = 'SELECT * FROM xin_finance_transfer WHERE transfer_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// get all payers
	public function get_payers()
	{
	  return $this->db->get("xin_finance_payers");
	}
	
	// get all payees
	public function get_payees()
	{
	  return $this->db->get("xin_finance_payees");
	}
	
	// Function to add record in table
	public function add_payer_record($data){
		$this->db->insert('xin_finance_payers', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_payee_record($data){
		$this->db->insert('xin_finance_payees', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to update record in table
	public function update_payer_record($data, $id){
		$this->db->where('payer_id', $id);
		if( $this->db->update('xin_finance_payers',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get payer single record
	public function read_payer_info($id) {
	
		$sql = 'SELECT * FROM xin_finance_payers WHERE payer_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to update record in table
	public function update_payee_record($data, $id){
		$this->db->where('payee_id', $id);
		if( $this->db->update('xin_finance_payees',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get payee single record
	public function read_payee_info($id) {
	
		$sql = 'SELECT * FROM xin_finance_payees WHERE payee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to add record in table
	public function add_bankcash($data){
		$this->db->insert('xin_finance_bankcash', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_deposit($data){
		$this->db->insert('xin_finance_deposit', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_expense($data){
		$this->db->insert('xin_finance_expense', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_transfer($data){
		$this->db->insert('xin_finance_transfer', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	// get all income categories
	public function all_income_categories_list()
	{
	  $query = $this->db->query("SELECT * from xin_income_categories");
  	  return $query->result();
	}
	
	// get all table rows 
	public function get_all_payment_method() {
	 	$query = $this->db->query("SELECT * from xin_payment_method");
		return $query->result();
	}
	
	// get single record > db table > constant
	public function read_income_category($id) {
	
		$sql = 'SELECT * FROM xin_income_categories WHERE category_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	// Function to add record in table
	public function add_transactions($data){
		$this->db->insert('xin_finance_transactions', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_bankcash_record($id){
		$this->db->where('bankcash_id', $id);
		$this->db->delete('xin_finance_bankcash');
		
	}
	
	// Function to Delete selected record from table
	public function delete_deposit_record($id){
		$this->db->where('deposit_id', $id);
		$this->db->delete('xin_finance_deposit');
		
	}
	
	// Function to Delete selected record from table
	public function delete_expense_record($id){
		$this->db->where('expense_id', $id);
		$this->db->delete('xin_finance_expense');
		
	}
	
	// Function to Delete selected record from table
	public function delete_transfer_record($id){
		$this->db->where('transfer_id', $id);
		$this->db->delete('xin_finance_transfer');
		
	}
	
	// Delete Transaction data
	
	// Function to Delete selected record from table
	public function delete_transaction_deposit_record($id){
		$this->db->where('deposit_id', $id);
		$this->db->delete('xin_finance_transactions');
		
	}
	
	// Function to Delete selected record from table
	public function delete_transaction_expense_record($id){
		$this->db->where('expense_id', $id);
		$this->db->delete('xin_finance_transactions');
		
	}
	
	// Function to Delete selected record from table
	public function delete_transaction_transfer_record($id){
		$this->db->where('transfer_id', $id);
		$this->db->delete('xin_finance_transactions');
		
	}
	
	// Function to update record in table
	public function update_bankcash_record($data, $id){
		$this->db->where('bankcash_id', $id);
		if( $this->db->update('xin_finance_bankcash',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get all payees..
	public function all_payees()
	{
	  $query = $this->db->query("SELECT * from xin_finance_payees");
  	  return $query->result();
	}
	
	// Function to update record in table
	public function update_deposit_record($data, $id){
		$this->db->where('deposit_id', $id);
		if( $this->db->update('xin_finance_deposit',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_expense_record($data, $id){
		$this->db->where('expense_id', $id);
		if( $this->db->update('xin_finance_expense',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record in table
	public function update_transfer_record($data, $id){
		$this->db->where('transfer_id', $id);
		if( $this->db->update('xin_finance_transfer',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get all bank cash..
	public function all_bank_cash()
	{
	  $query = $this->db->query("SELECT * from xin_finance_bankcash");
  	  return $query->result();
	}
	// get all payers..
	public function all_payers()
	{
	  $query = $this->db->query("SELECT * from xin_finance_payers");
  	  return $query->result();
	}
	
	/* REPORTS START */
	// account statement > report	
	public function account_statement_search($start_date,$end_date,$account_id,$type_id){
		//
		if($account_id==0 && $type_id==0) {
			
			$sql = 'SELECT * FROM `xin_finance_transactions` where DATE(transaction_date) BETWEEN ? AND ? order by transaction_date asc';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;		
		
		} else if($account_id!=0 && $type_id==0) {
			
			$sql = 'SELECT * FROM `xin_finance_transactions` where account_type_id = ? and DATE(transaction_date) BETWEEN ? AND ? order by transaction_date asc';
			$binds = array($account_id,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($account_id!=0 && $type_id==1) {
			
			$sql = 'SELECT * FROM `xin_finance_transactions` where account_type_id = ? and deposit_id != ? and DATE(transaction_date) BETWEEN ? AND ? order by transaction_date asc';
			$binds = array($account_id,0,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($account_id!=0 && $type_id==2) {
			
			$sql = 'SELECT * FROM `xin_finance_transactions` where account_type_id = ? and expense_id != ? and DATE(transaction_date) BETWEEN ? AND ? order by transaction_date asc';
			$binds = array($account_id,0,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($account_id!=0 && $type_id==3) {
			$sql = 'SELECT * FROM `xin_finance_transactions` where account_type_id = ? and transfer_id != ? and DATE(transaction_date) BETWEEN ? AND ? order by transaction_date asc';
			$binds = array($account_id,0,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($account_id==0 && $type_id==1) {
			$sql = 'SELECT * FROM `xin_finance_transactions` where deposit_id != ? and DATE(transaction_date) BETWEEN ? AND ? order by transaction_date asc';
			$binds = array(0,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($account_id==0 && $type_id==2) {
			$sql = 'SELECT * FROM `xin_finance_transactions` where expense_id != ? and DATE(transaction_date) BETWEEN ? AND ? order by transaction_date asc';
			$binds = array(0,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($account_id==0 && $type_id==3) {
			$sql = 'SELECT * FROM `xin_finance_transactions` where transfer_id != ? and DATE(transaction_date) BETWEEN ? AND ? order by transaction_date asc';
			$binds = array(0,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	
	// expense > report	
	public function get_expense_search($start_date,$end_date,$type_id){
		if($type_id==0) {
			
			$sql = 'SELECT * FROM `xin_finance_expense` where DATE(expense_date) BETWEEN ? AND ?';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($type_id!=0) {
			
			$sql = 'SELECT * FROM `xin_finance_expense` where category_id = ? and DATE(expense_date) BETWEEN ? AND ?';
			$binds = array($type_id,$start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	
	// income > report	
	public function get_deposit_search($start_date,$end_date,$type_id){
		if($type_id==0) {
			
			$sql = 'SELECT * FROM `xin_finance_deposit` where DATE(deposit_date) BETWEEN ? AND ?';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
			
		} else if($type_id!=0) {
			
			$sql = 'SELECT * FROM `xin_finance_deposit` where category_id = ? and DATE(deposit_date) BETWEEN ? AND ?';
			$binds = array($type_id, $start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	
	// transfer > report	
	public function get_transfer_search($start_date,$end_date){
		    
			$sql = 'SELECT * FROM `xin_finance_transfer` where DATE(transfer_date) BETWEEN ? AND ?';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
	}
	
	// income vs expense > report	
	public function get_income_expense_search($start_date,$end_date){
			
			$sql = 'SELECT * FROM `xin_finance_transactions` where DATE(transaction_date) BETWEEN ? AND ?';
			$binds = array($start_date,$end_date);
			$query = $this->db->query($sql, $binds);
			return $query;
	}
	
	/* REPORTS END */
}
?>