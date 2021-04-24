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

class Accounting extends MY_Controller
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
		  $this->load->model('Finance_model');
		  $this->load->model('Expense_model');
     }
	 
	public function deposit() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_deposit');
		$data['path_url'] = 'accounting_deposit';
		$data['all_payers'] = $this->Finance_model->all_payers();
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$data['get_all_payment_method'] = $this->Finance_model->get_all_payment_method();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('75',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/deposit_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transfer() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_transfer');
		$data['path_url'] = 'accounting_transfer';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$data['get_all_payment_method'] = $this->Finance_model->get_all_payment_method();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('77',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/transfer_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function expense() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_expense');
		$data['path_url'] = 'accounting_expense';
		$data['all_payees'] = $this->Finance_model->all_payees();
		$data['all_expense_types'] = $this->Expense_model->all_expense_types();
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$data['get_all_payment_method'] = $this->Finance_model->get_all_payment_method();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('76',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/expense_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function bank_cash() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_accounts');
		$data['path_url'] = 'accounting_bank_cash';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('72',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/bank_cash_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function payers() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_payers');
		$data['path_url'] = 'accounting_payers';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('81',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/payers_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function payees() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_payees');
		$data['path_url'] = 'accounting_payees';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('80',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/payees_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function account_balances() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_account_balances');
		$data['path_url'] = 'accounting_account_balances';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('73',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/account_balances", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transactions() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_view_transactions');
		$data['path_url'] = 'accounting_transactions';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('78',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/transaction_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function bankwise_transactions() {
	
		$id = $this->uri->segment(4);
		
		$bac_id = $this->Finance_model->read_transaction_by_bank_info($id);
		if(is_null($bac_id)){
			redirect('admin/accounting/transactions');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_view_bankwise_transactions');
		$data['path_url'] = 'accounting_bankwise_transactions';
		$session = $this->session->userdata('username');
		//$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/accounting/bankwise_transaction_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}
	
	public function account_statement() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_account_statement');
		$data['breadcrumbs'] = $this->lang->line('xin_acc_account_statement');
		$data['path_url'] = 'accounting_report_statement';
		$data['all_payers'] = $this->Finance_model->all_payers();
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$data['get_all_payment_method'] = $this->Finance_model->get_all_payment_method();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('83',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/report_account_statement", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function expense_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_expense_reports');
		$data['breadcrumbs'] = $this->lang->line('xin_acc_expense_reports');
		$data['path_url'] = 'accounting_report_expense';
		$data['all_payers'] = $this->Finance_model->all_payers();
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_expense_types'] = $this->Expense_model->all_expense_types();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('84',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/report_expense", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function income_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_income_reports');
		$data['breadcrumbs'] = $this->lang->line('xin_acc_income_reports');
		$data['path_url'] = 'accounting_report_income';
		$data['all_payers'] = $this->Finance_model->all_payers();
		$data['all_bank_cash'] = $this->Finance_model->all_bank_cash();
		$data['all_income_categories_list'] = $this->Finance_model->all_income_categories_list();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('85',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/report_income", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function transfer_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_accounting!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_acc_transfer_report');
		$data['breadcrumbs'] = $this->lang->line('xin_acc_transfer_report');
		$data['path_url'] = 'accounting_report_transfer';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('86',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/accounting/report_transfer", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
	}
		
	public function read_deposit()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('deposit_id');
		$result = $this->Finance_model->read_deposit_information($id);
		$data = array(
				'deposit_id' => $result[0]->deposit_id,
				'account_type_id' => $result[0]->account_type_id,
				'amount' => $result[0]->amount,
				'deposit_date' => $result[0]->deposit_date,
				'categoryid' => $result[0]->category_id,
				'payer_id' => $result[0]->payer_id,
				'payment_method_id' => $result[0]->payment_method,
				'deposit_reference' => $result[0]->deposit_reference,
				'deposit_file' => $result[0]->deposit_file,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_payers' => $this->Finance_model->all_payers(),
				'all_bank_cash' => $this->Finance_model->all_bank_cash(),
				'all_income_categories_list' => $this->Finance_model->all_income_categories_list(),
				'get_all_payment_method' => $this->Finance_model->get_all_payment_method()
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_expense()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('expense_id');
		$result = $this->Finance_model->read_expense_information($id);
		$data = array(
				'expense_id' => $result[0]->expense_id,
				'account_type_id' => $result[0]->account_type_id,
				'amount' => $result[0]->amount,
				'expense_date' => $result[0]->expense_date,
				'categoryid' => $result[0]->category_id,
				'payee_id' => $result[0]->payee_id,
				'payment_method_id' => $result[0]->payment_method,
				'expense_reference' => $result[0]->expense_reference,
				'expense_file' => $result[0]->expense_file,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_payees' => $this->Finance_model->all_payees(),
				'all_bank_cash' => $this->Finance_model->all_bank_cash(),
				'all_expense_types' => $this->Expense_model->all_expense_types(),
				'all_income_categories_list' => $this->Finance_model->all_income_categories_list(),
				'get_all_payment_method' => $this->Finance_model->get_all_payment_method()
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_transfer()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('transfer_id');
		$result = $this->Finance_model->read_transfer_information($id);
		$data = array(
				'transfer_id' => $result[0]->transfer_id,
				'from_account_id' => $result[0]->from_account_id,
				'to_account_id' => $result[0]->to_account_id,
				'transfer_date' => $result[0]->transfer_date,
				'transfer_amount' => $result[0]->transfer_amount,
				'payment_method_id' => $result[0]->payment_method,
				'transfer_reference' => $result[0]->transfer_reference,
				'description' => $result[0]->description,
				'created_at' => $result[0]->created_at,
				'all_bank_cash' => $this->Finance_model->all_bank_cash(),
				'get_all_payment_method' => $this->Finance_model->get_all_payment_method()
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('bankcash_id');
		$result = $this->Finance_model->read_bankcash_information($id);
		$data = array(
				'bankcash_id' => $result[0]->bankcash_id,
				'account_name' => $result[0]->account_name,
				'account_balance' => $result[0]->account_balance,
				'account_number' => $result[0]->account_number,
				'branch_code' => $result[0]->branch_code,
				'bank_branch' => $result[0]->bank_branch,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_payer() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('payer_id');
		$result = $this->Finance_model->read_payer_info($id);
		$data = array(
				'payer_id' => $result[0]->payer_id,
				'payer_name' => $result[0]->payer_name,
				'contact_number' => $result[0]->contact_number,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	public function read_payee() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('payee_id');
		$result = $this->Finance_model->read_payee_info($id);
		$data = array(
				'payee_id' => $result[0]->payee_id,
				'payee_name' => $result[0]->payee_name,
				'contact_number' => $result[0]->contact_number,
				'created_at' => $result[0]->created_at
				);
		if(!empty($session)){ 
			$this->load->view('admin/accounting/dialog_accounting', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// bank and cash list
	public function bank_cash_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/bank_cash_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$bankcash = $this->Finance_model->get_bankcash();
		
		$data = array();

          foreach($bankcash->result() as $r) {
			  
			// get currency
			$account_balance = $this->Xin_model->currency_sign($r->account_balance);
			$bank_cash = $this->Finance_model->read_transaction_by_bank_info($r->bankcash_id);
			if(!is_null($bank_cash)){
				$account = '<a data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_acc_view_transactions').'" href="'.site_url('admin/accounting/bankwise_transactions/'.$r->bankcash_id.'').'">'.$r->account_name.'</a>';
			} else {
				$account = $r->account_name;
			}

		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target="#edit-modal-data"  data-bankcash_id="'. $r->bankcash_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->bankcash_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$account,
				$r->account_number,
				$r->branch_code,
				$account_balance,
				$r->bank_branch
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $bankcash->num_rows(),
                 "recordsFiltered" => $bankcash->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	// payers list
	public function payers_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/payers_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$payer = $this->Finance_model->get_payers();
		
		$data = array();

          foreach($payer->result() as $r) {
			  
		   // create at
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".payroll_template_modal"  data-payer_id="'. $r->payer_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->payer_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$r->payer_name,
				$r->contact_number,
				$created_at
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $payer->num_rows(),
                 "recordsFiltered" => $payer->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 /****Reports ***/
    	 
	// report account statement > search
	public function report_statement_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/report_account_statement", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
				
		$account_statement = $this->Finance_model->account_statement_search($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('account_id'),$this->input->get('type_id'));
		
		$data = array();
		$balance2 = 0;
        foreach($account_statement->result() as $r) {
			  
		   // transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->total_amount);
			// credit
			$transaction_credit = $this->Xin_model->currency_sign($r->transaction_credit);
			// debit
			$transaction_debit = $this->Xin_model->currency_sign($r->transaction_debit);
			
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_type_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// total credit
			// balance
			if($r->transaction_debit == 0) {
				$balance2 = $balance2 - $r->transaction_credit;
			} else {
				$balance2 = $balance2 + $r->transaction_debit;
			}
			$balance = $this->Xin_model->currency_sign($balance2);
			
			$data[] = array(
				$transaction_date,
				$account,
				$r->transaction_type,
				$transaction_credit,
				$transaction_debit,
				$balance
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $account_statement->num_rows(),
                 "recordsFiltered" => $account_statement->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // report expense list
	public function report_expense_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/report_expense", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$expense = $this->Finance_model->get_expense_search($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('type_id'));
		
		$data = array();

          foreach($expense->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_type_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// get user > added by
			$payee = $this->Finance_model->read_payee_info($r->payee_id);
			// user full name
			if(!is_null($payee)){
				$full_name = $payee[0]->payee_name;
			} else {
				$full_name = '--';	
			}
			
			// deposit date
			$expense_date = $this->Xin_model->set_date_format($r->expense_date);
			// category
			$expense_type = $this->Expense_model->read_expense_type_information($r->category_id);
			if(!is_null($expense_type)){
				$category = $expense_type[0]->name;
			} else {
				$category = '--';	
			}
			
		   $data[] = array(
				$expense_date,
				$account,
				$category,
				$full_name,
				$r->expense_reference,
				$amount,
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $expense->num_rows(),
			 "recordsFiltered" => $expense->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // income report list
	public function report_income_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/report_income", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$deposit = $this->Finance_model->get_deposit_search($this->input->get('from_date'),$this->input->get('to_date'),$this->input->get('type_id'));
		
		$data = array();

          foreach($deposit->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_type_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// get user > added by
			$payer = $this->Finance_model->read_payer_info($r->payer_id);
			// user full name
			if(!is_null($payer)){
				$full_name = $payer[0]->payer_name;
			} else {
				$full_name = '--';	
			}
			
			// deposit date
			$deposit_date = $this->Xin_model->set_date_format($r->deposit_date);
			// category
			$category_id = $this->Finance_model->read_income_category($r->category_id);
			if(!is_null($category_id)){
				$category = $category_id[0]->name;
			} else {
				$category = '--';	
			}

		   $data[] = array(
				$deposit_date,
				$account,
				$category,
				$full_name,
				$r->deposit_reference,		
				$amount		
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $deposit->num_rows(),
			 "recordsFiltered" => $deposit->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     } 
	 
	 // report transfer list
	public function report_transfer_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/report_transfer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transfer = $this->Finance_model->get_transfer_search($this->input->get('from_date'),$this->input->get('to_date'));
		
		$data = array();

        foreach($transfer->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->transfer_amount);
			// from account type
			$from_account_id = $this->Finance_model->read_bankcash_information($r->from_account_id);
			if(!is_null($from_account_id)){
				$from_account = $from_account_id[0]->account_name;
			} else {
				$from_account = '--';	
			}
			
			// to account type
			$to_account_id = $this->Finance_model->read_bankcash_information($r->to_account_id);
			if(!is_null($to_account_id)){
				$to_account = $to_account_id[0]->account_name;
			} else {
				$to_account = '--';	
			}
						
			// transfer date
			$transfer_date = $this->Xin_model->set_date_format($r->transfer_date);
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}

		   $data[] = array(
				$transfer_date,
				$from_account,
				$to_account,
				$r->transfer_reference,
				$method_name,
				$amount
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $transfer->num_rows(),
			 "recordsFiltered" => $transfer->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     } 
	 
	 // report income vs expense > search
	public function report_income_expense_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
				
		$account_statement = $this->Finance_model->get_income_expense_search($this->input->get('from_date'),$this->input->get('to_date'));
		
		$data = array();
		$debit="";
		$debit_total=0;
		$credit="";
		$credit_total=0;
        foreach($account_statement->result() as $r) {
			  		  
			if($r->transaction_credit!=0.00 && $r->transaction_credit > 0){
				$credit_total=$credit_total+$r->transaction_credit;
			}
			else if($r->transaction_debit!=0.00 && $r->transaction_debit > 0){
				$debit_total = $debit_total+$r->transaction_debit;
			}
		 }
		 
		 $totalD = "<b class='pull-right'>".$this->lang->line('xin_acc_total_credit').": ".$this->Xin_model->currency_sign($debit_total)."</b>";
		 $totalC = "<b class='pull-right'>".$this->lang->line('xin_acc_total_debit').": ".$this->Xin_model->currency_sign($credit_total)."</b>";
		 $data[] = array(
			$totalC.' '.$totalC,
			$totalD.' '.$totalD
	   );
          
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $account_statement->num_rows(),
                 "recordsFiltered" => $account_statement->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // ***** LISTING
	 
	 // payees list
	public function payees_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/payees_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$payee = $this->Finance_model->get_payees();
		
		$data = array();

          foreach($payee->result() as $r) {
			  
		   // create at
			$created_at = $this->Xin_model->set_date_format($r->created_at);
			
			$data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".payroll_template_modal"  data-payee_id="'. $r->payee_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->payee_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$r->payee_name,
				$r->contact_number,
				$created_at
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $payee->num_rows(),
                 "recordsFiltered" => $payee->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	// account balances list
	public function account_balances_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/account_balances", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$bankcash = $this->Finance_model->get_bankcash();
		
		$data = array();

          foreach($bankcash->result() as $r) {
			  
			  // get currency
			  $account_balance = $this->Xin_model->currency_sign($r->account_balance);
			  $bank_cash = $this->Finance_model->read_transaction_by_bank_info($r->bankcash_id);
			  if(!is_null($bank_cash)){
			  	$account = '<a data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_acc_view_transactions').'" href="'.site_url('admin/accounting/bankwise_transactions/'.$r->bankcash_id.'').'">'.$r->account_name.'</a>';
			  } else {
				  $account = $r->account_name;
			  }

               $data[] = array(
                    $account,
                    $account_balance
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $bankcash->num_rows(),
                 "recordsFiltered" => $bankcash->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	// transactions list
	public function transaction_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/transaction_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transaction = $this->Finance_model->get_transactions();
		
		$data = array();
		$balance2 = 0;
          foreach($transaction->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->total_amount);
			// credit
			$transaction_credit = $this->Xin_model->currency_sign($r->transaction_credit);
			// debit
			$transaction_debit = $this->Xin_model->currency_sign($r->transaction_debit);
			
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_type_id);
			if(!is_null($acc_type)){
				$account = '<a href="'.site_url('admin/accounting/bankwise_transactions/'.$r->account_type_id.'').'">'.$acc_type[0]->account_name.'</a>';
			} else {
				$account = '--';	
			}
			
			// balance
			if($r->transaction_debit == 0) {
				$balance2 = $balance2 - $r->transaction_credit;
			} else {
				$balance2 = $balance2 + $r->transaction_debit;
			}
			$balance = $this->Xin_model->currency_sign($balance2);
			
			$data[] = array(
				$transaction_date,
				$account,
				$r->transaction_type,
				$total_amount,
				$transaction_credit,
				$transaction_debit,
				$balance
			);
		  }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $transaction->num_rows(),
                 "recordsFiltered" => $transaction->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // bank wise transactions list
	public function bankwise_transactions_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/bankwise_transaction_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$ac_id = $this->uri->segment(4);
		$transactions = $this->Finance_model->get_bankwise_transactions($ac_id);
		
		$data = array();
		$balance2 = 0;
          foreach($transactions->result() as $r) {
			  
			// transaction date
			$transaction_date = $this->Xin_model->set_date_format($r->transaction_date);
			// get currency
			$total_amount = $this->Xin_model->currency_sign($r->total_amount);
			// credit
			$transaction_credit = $this->Xin_model->currency_sign($r->transaction_credit);
			// debit
			$transaction_debit = $this->Xin_model->currency_sign($r->transaction_debit);
			
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_type_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// total credit
			// balance
			if($r->transaction_debit == 0) {
				$balance2 = $balance2 - $r->transaction_credit;
			} else {
				$balance2 = $balance2 + $r->transaction_debit;
			}
			$balance = $this->Xin_model->currency_sign($balance2);
			
			$data[] = array(
				$transaction_date,
				$account,
				$r->transaction_type,
				$total_amount,
				$transaction_credit,
				$transaction_debit,
				$balance
			);
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $transactions->num_rows(),
                 "recordsFiltered" => $transactions->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     } 
	 
	// deposit list
	public function deposit_list() {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/deposit_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$deposit = $this->Finance_model->get_deposit();
		
		$data = array();

          foreach($deposit->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_type_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// get user > added by
			$payer = $this->Finance_model->read_payer_info($r->payer_id);
			// user full name
			if(!is_null($payer)){
				$full_name = $payer[0]->payer_name;
			} else {
				$full_name = '--';	
			}
			
			// deposit date
			$deposit_date = $this->Xin_model->set_date_format($r->deposit_date);
			// category
			$category_id = $this->Finance_model->read_income_category($r->category_id);
			if(!is_null($category_id)){
				$category = $category_id[0]->name;
			} else {
				$category = '--';	
			}
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}

		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-deposit_id="'. $r->deposit_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->deposit_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$account,
				$full_name,
				$amount,
				$category,
				$r->deposit_reference,
				$method_name,
				$deposit_date
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $deposit->num_rows(),
			 "recordsFiltered" => $deposit->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 	 
	// expense list
	public function expense_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/expense_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$expense = $this->Finance_model->get_expense();
		
		$data = array();

          foreach($expense->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->amount);
			// account type
			$acc_type = $this->Finance_model->read_bankcash_information($r->account_type_id);
			if(!is_null($acc_type)){
				$account = $acc_type[0]->account_name;
			} else {
				$account = '--';	
			}
			
			// get user > added by
			$payee = $this->Finance_model->read_payee_info($r->payee_id);
			// user full name
			if(!is_null($payee)){
				$full_name = $payee[0]->payee_name;
			} else {
				$full_name = '--';	
			}
			
			// deposit date
			$expense_date = $this->Xin_model->set_date_format($r->expense_date);
			// category
			$expense_type = $this->Expense_model->read_expense_type_information($r->category_id);
			if(!is_null($expense_type)){
				$category = $expense_type[0]->name;
			} else {
				$category = '--';	
			}
			
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}

		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-expense_id="'. $r->expense_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->expense_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$account,
				$full_name,
				$amount,
				$category,
				$r->expense_reference,
				$method_name,
				$expense_date
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $expense->num_rows(),
			 "recordsFiltered" => $expense->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	// transfer list
	public function transfer_list()
     {

		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		if(!empty($session)){ 
			$this->load->view("admin/accounting/transfer_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$transfer = $this->Finance_model->get_transfer();
		
		$data = array();

        foreach($transfer->result() as $r) {
			  
			// get amount
			$amount = $this->Xin_model->currency_sign($r->transfer_amount);
			// from account type
			$from_account_id = $this->Finance_model->read_bankcash_information($r->from_account_id);
			if(!is_null($from_account_id)){
				$from_account = $from_account_id[0]->account_name;
			} else {
				$from_account = '--';	
			}
			
			// to account type
			$to_account_id = $this->Finance_model->read_bankcash_information($r->to_account_id);
			if(!is_null($to_account_id)){
				$to_account = $to_account_id[0]->account_name;
			} else {
				$to_account = '--';	
			}
						
			// transfer date
			$transfer_date = $this->Xin_model->set_date_format($r->transfer_date);
			// payment method 
			$payment_method = $this->Xin_model->read_payment_method($r->payment_method);
			if(!is_null($payment_method)){
				$method_name = $payment_method[0]->method_name;
			} else {
				$method_name = '--';	
			}

		   $data[] = array(
				'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-transfer_id="'. $r->transfer_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->transfer_id . '"><span class="far fa-trash-alt"></span></button></span>',
				$from_account,
				$to_account,
				$amount,
				$r->transfer_reference,
				$method_name,
				$transfer_date
		   );
	  }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $transfer->num_rows(),
			 "recordsFiltered" => $transfer->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     } 
	 
	// Validate and add info in database
	public function add_payer() {
	
		if($this->input->post('add_type')=='add_payer') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('payer_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_payer_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payer_name' => $this->input->post('payer_name'),
		'contact_number' => $this->input->post('contact_number'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Finance_model->add_payer_record($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_payer_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_payee() {
	
		if($this->input->post('add_type')=='add_payee') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('payee_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_payee_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payee_name' => $this->input->post('payee_name'),
		'contact_number' => $this->input->post('contact_number'),
		'created_at' => date('d-m-Y h:i:s')
		);
		
		$result = $this->Finance_model->add_payee_record($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_payee_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_payer() {
	
		if($this->input->post('edit_type')=='payer') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('payer_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_payer_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payer_name' => $this->input->post('payer_name'),
		'contact_number' => $this->input->post('contact_number'),
		);
		
		$result = $this->Finance_model->update_payer_record($data,$id);
		if ($id) {
			$Return['result'] = $this->lang->line('xin_acc_success_payer_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_payee() {
	
		if($this->input->post('edit_type')=='payee') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('payee_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_payee_name');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'payee_name' => $this->input->post('payee_name'),
		'contact_number' => $this->input->post('contact_number'),
		);
		
		$result = $this->Finance_model->update_payee_record($data,$id);
		if ($id) {
			$Return['result'] = $this->lang->line('xin_acc_success_payee_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	 
	// Validate and add info in database
	public function add_deposit() {
	
		if($this->input->post('add_type')=='deposit') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('bank_cash_id')==='') {
        $Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('deposit_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_deposit_date');
		}
		else if($_FILES['deposit_file']['size'] == 0) {
			$fname = 'no_file';
		}
		else if(is_uploaded_file($_FILES['deposit_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','gif','txt','doc','docx','xls','xlsx');
			$filename = $_FILES['deposit_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["deposit_file"]["tmp_name"];
				$profile = "uploads/accounting/deposit/";
				$set_img = base_url()."uploads/accounting/deposit/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["deposit_file"]["name"]);
				$newfilename = 'deposit_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;					
			} else {
				$Return['error'] = $this->lang->line('xin_acc_error_attachment');
			}
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'account_type_id' => $this->input->post('bank_cash_id'),
		'amount' => $this->input->post('amount'),
		'deposit_date' => $this->input->post('deposit_date'),
		'deposit_file' => $fname,
		'category_id' => $this->input->post('category_id'),
		'payer_id' => $this->input->post('payer_id'),
		'payment_method' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'deposit_reference' => $this->input->post('deposit_reference'),
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Finance_model->add_deposit($data);
		if ($result == TRUE) {
			
			$transaction_data = array(
			'transaction_type' => 'Deposit',
			'deposit_id' => $result,
			'account_type_id' => $this->input->post('bank_cash_id'),
			'total_amount' => $this->input->post('amount'),
			'transaction_debit' => '0.00',
			'transaction_credit' => $this->input->post('amount'),
			'transaction_date' => $this->input->post('deposit_date'),
			'created_at' => date('Y-m-d H:i:s')
			);
			$this->Finance_model->add_transactions($transaction_data);
			
			// add data to bank account
			$account_id = $this->Finance_model->read_bankcash_information($this->input->post('bank_cash_id'));
			$acc_balance = $account_id[0]->account_balance + $this->input->post('amount');
			
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$this->input->post('bank_cash_id'));
		
			$Return['result'] = $this->lang->line('xin_acc_success_deposit_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	} 
	
	// Validate and add info in database
	public function add_expense() {
	
		if($this->input->post('add_type')=='expense') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('bank_cash_id')==='') {
        $Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('amount') > $this->input->post('account_balance')) {
			$Return['error'] = $this->lang->line('xin_acc_error_amount_should_be_less_than_current');
		} else if($this->input->post('expense_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_expense_date');
		}
		else if($_FILES['expense_file']['size'] == 0) {
			$fname = 'no_file';
		}
		else if(is_uploaded_file($_FILES['expense_file']['tmp_name'])) {
			//checking image type
			$allowed =  array('png','jpg','jpeg','pdf','gif','txt','doc','docx','xls','xlsx');
			$filename = $_FILES['expense_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext,$allowed)){
				$tmp_name = $_FILES["expense_file"]["tmp_name"];
				$profile = "uploads/accounting/expense/";
				$set_img = base_url()."uploads/accounting/expense/";
				// basename() may prevent filesystem traversal attacks;
				// further validation/sanitation of the filename may be appropriate
				$name = basename($_FILES["expense_file"]["name"]);
				$newfilename = 'expense_'.round(microtime(true)).'.'.$ext;
				move_uploaded_file($tmp_name, $profile.$newfilename);
				$fname = $newfilename;					
			} else {
				$Return['error'] = $this->lang->line('xin_acc_error_attachment');
			}
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'account_type_id' => $this->input->post('bank_cash_id'),
		'amount' => $this->input->post('amount'),
		'expense_date' => $this->input->post('expense_date'),
		'expense_file' => $fname,
		'category_id' => $this->input->post('category_id'),
		'payee_id' => $this->input->post('payee_id'),
		'payment_method' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'expense_reference' => $this->input->post('expense_reference'),
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Finance_model->add_expense($data);
		if ($result == TRUE) {
			
			$transaction_data = array(
			'transaction_type' => 'Expense',
			'expense_id' => $result,
			'account_type_id' => $this->input->post('bank_cash_id'),
			'total_amount' => $this->input->post('amount'),
			'transaction_debit' => $this->input->post('amount'),
			'transaction_credit' => '0.00',
			'transaction_date' => $this->input->post('expense_date'),
			'created_at' => date('Y-m-d H:i:s')
			);
			$this->Finance_model->add_transactions($transaction_data);
			
			// update data in bank account
			$account_id = $this->Finance_model->read_bankcash_information($this->input->post('bank_cash_id'));
			$acc_balance = $account_id[0]->account_balance - $this->input->post('amount');
			
			$data3 = array(
			'account_balance' => $acc_balance
			);
			$this->Finance_model->update_bankcash_record($data3,$this->input->post('bank_cash_id'));
			
			$Return['result'] = $this->lang->line('xin_acc_success_expense_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	} 
	
	// Validate and add info in database
	public function add_transfer() {
	
		if($this->input->post('add_type')=='transfer') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('from_bank_cash_id')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_from_account');
		} else if($this->input->post('to_bank_cash_id')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_to_account');
		} else if($this->input->post('from_bank_cash_id')== $this->input->post('to_bank_cash_id')) {
        	$Return['error'] = $this->lang->line('xin_acc_error_transer_to_same_account');
		} else if($this->input->post('transfer_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_transer_date');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('amount') > $this->input->post('account_balance')) {
			$Return['error'] = $this->lang->line('xin_acc_error_amount_should_be_less_than_current');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$from_account_id = $this->Finance_model->read_bankcash_information($this->input->post('from_bank_cash_id'));
		$frm_acc = $from_account_id[0]->account_balance - $this->input->post('amount');
		
		$to_bank_cash_id = $this->Finance_model->read_bankcash_information($this->input->post('to_bank_cash_id'));
		$to_acc = $to_bank_cash_id[0]->account_balance + $this->input->post('amount');
		
		$data = array(
		'from_account_id' => $this->input->post('from_bank_cash_id'),
		'transfer_amount' => $this->input->post('amount'),
		'transfer_date' => $this->input->post('transfer_date'),
		'to_account_id' => $this->input->post('to_bank_cash_id'),
		'payment_method' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'transfer_reference' => $this->input->post('transfer_reference'),
		'created_at' => date('Y-m-d H:i:s')
		);
		$result = $this->Finance_model->add_transfer($data);
		
		$data2 = array(
		'account_balance' => $frm_acc
		);
		$result2 = $this->Finance_model->update_bankcash_record($data2,$this->input->post('from_bank_cash_id'));
		
		$data3 = array(
		'account_balance' => $to_acc
		);
		$result3 = $this->Finance_model->update_bankcash_record($data3,$this->input->post('to_bank_cash_id'));
		
		if ($result == TRUE) {
			
			$transaction_data = array(
			'transaction_type' => 'Transfer',
			'transfer_id' => $result,
			'account_type_id' => $this->input->post('from_bank_cash_id'),
			'total_amount' => $this->input->post('amount'),
			'transaction_debit' => $this->input->post('amount'),
			'transaction_credit' => '0.00',
			'transaction_date' => $this->input->post('transfer_date'),
			'created_at' => date('Y-m-d H:i:s')
			);
			$this->Finance_model->add_transactions($transaction_data);
			
			$transaction_data2 = array(
			'transaction_type' => 'Transfer',
			'transfer_id' => $result,
			'account_type_id' => $this->input->post('to_bank_cash_id'),
			'total_amount' => $this->input->post('amount'),
			'transaction_debit' => '0.00',
			'transaction_date' => $this->input->post('transfer_date'),
			'transaction_credit' => $this->input->post('amount'),
			'created_at' => date('Y-m-d H:i:s')
			);
			$this->Finance_model->add_transactions($transaction_data2);
			
			$Return['result'] = $this->lang->line('xin_acc_success_transfer_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
	
		
		}
	}
	
	// Validate and add info in database> add bank-cash
	public function add_bankcash() {
	
		if($this->input->post('add_type')=='bankcash') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$bank_branch = $this->input->post('bank_branch');
		$qt_bank_branch = htmlspecialchars(addslashes($bank_branch), ENT_QUOTES);
			
		/* Server side PHP input validation */
		if($this->input->post('account_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_account_name_field');
		} else if($this->input->post('account_balance')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_account_balance_field');
		} else if($this->input->post('account_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_acc_number');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'account_name' => $this->input->post('account_name'),
		'account_balance' => $this->input->post('account_balance'),
		'account_number' => $this->input->post('account_number'),
		'branch_code' => $this->input->post('branch_code'),
		'bank_branch' => $qt_bank_branch,
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Finance_model->add_bankcash($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_bank_cash_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	} 
	
	// Validate and update info in database
	public function deposit_update() {
	
		if($this->input->post('edit_type')=='deposit') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('bank_cash_id')==='') {
        $Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} else if($this->input->post('deposit_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_deposit_date');
		}		
		/* Check if file uploaded..*/
		else if($_FILES['deposit_file']['size'] == 0) {
			 $fname = 'no_file';
			 $data = array(
			'account_type_id' => $this->input->post('bank_cash_id'),
			'amount' => $this->input->post('amount'),
			'deposit_date' => $this->input->post('deposit_date'),
			'category_id' => $this->input->post('category_id'),
			'payer_id' => $this->input->post('payer_id'),
			'payment_method' => $this->input->post('payment_method'),
			'description' => $qt_description,
			'deposit_reference' => $this->input->post('deposit_reference'),		
			);
			 $result = $this->Finance_model->update_deposit_record($data,$id);
		} else {
			if(is_uploaded_file($_FILES['deposit_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['deposit_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["deposit_file"]["tmp_name"];
					$bill_copy = "uploads/accounting/deposit/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["deposit_file"]["name"]);
					$newfilename = 'deposit_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					 $data = array(
					'account_type_id' => $this->input->post('bank_cash_id'),
					'amount' => $this->input->post('amount'),
					'deposit_date' => $this->input->post('deposit_date'),
					'deposit_file' => $fname,
					'category_id' => $this->input->post('category_id'),
					'payer_id' => $this->input->post('payer_id'),
					'payment_method' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'deposit_reference' => $this->input->post('deposit_reference'),	
					);
					// update record > model
					$result = $this->Finance_model->update_deposit_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_deposit_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function expense_update() {
	
		if($this->input->post('edit_type')=='expense') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('bank_cash_id')==='') {
        $Return['error'] = $this->lang->line('xin_acc_error_account_field');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		} /*else if($this->input->post('amount') > $this->input->post('account_balance')) {
			$Return['error'] = $this->lang->line('xin_acc_error_amount_should_be_less_than_current');
		}*/ else if($this->input->post('expense_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_expense_date');
		}		
		/* Check if file uploaded..*/
		else if($_FILES['expense_file']['size'] == 0) {
			 $fname = 'no_file';
			 $data = array(
			'account_type_id' => $this->input->post('bank_cash_id'),
			'amount' => $this->input->post('amount'),
			'expense_date' => $this->input->post('expense_date'),
			'category_id' => $this->input->post('category_id'),
			'payee_id' => $this->input->post('payee_id'),
			'payment_method' => $this->input->post('payment_method'),
			'description' => $qt_description,
			'expense_reference' => $this->input->post('expense_reference'),		
			);
			 $result = $this->Finance_model->update_expense_record($data,$id);
		} else {
			if(is_uploaded_file($_FILES['expense_file']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['expense_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["expense_file"]["tmp_name"];
					$bill_copy = "uploads/accounting/deposit/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["expense_file"]["name"]);
					$newfilename = 'expense_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					 $data = array(
					'account_type_id' => $this->input->post('bank_cash_id'),
					'amount' => $this->input->post('amount'),
					'expense_date' => $this->input->post('expense_date'),
					'expense_file' => $fname,
					'category_id' => $this->input->post('category_id'),
					'payee_id' => $this->input->post('payee_id'),
					'payment_method' => $this->input->post('payment_method'),
					'description' => $qt_description,
					'expense_reference' => $this->input->post('expense_reference'),	
					);
					// update record > model
					$result = $this->Finance_model->update_expense_record($data,$id);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_expense_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database> update transfer
	public function transfer_update() {
	
		if($this->input->post('edit_type')=='transfer') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
					
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('transfer_date')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_transer_date');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$data = array(
		'transfer_date' => $this->input->post('transfer_date'),
		'payment_method' => $this->input->post('payment_method'),
		'description' => $qt_description,
		'transfer_reference' => $this->input->post('transfer_reference')
		);
		
		$result = $this->Finance_model->update_transfer_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_transfer_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	} 
	
	// Validate and add info in database> add bank-cash
	public function bankcash_update() {
	
		if($this->input->post('edit_type')=='bankcash') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$bank_branch = $this->input->post('bank_branch');
		$qt_bank_branch = htmlspecialchars(addslashes($bank_branch), ENT_QUOTES);
			
		/* Server side PHP input validation */
		if($this->input->post('account_name')==='') {
        	$Return['error'] = $this->lang->line('xin_acc_error_account_name_field');
		} else if($this->input->post('account_balance')==='') {
			$Return['error'] = $this->lang->line('xin_acc_error_account_balance_field');
		} else if($this->input->post('account_number')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_acc_number');
		} 
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'account_name' => $this->input->post('account_name'),
		'account_balance' => $this->input->post('account_balance'),
		'account_number' => $this->input->post('account_number'),
		'branch_code' => $this->input->post('branch_code'),
		'bank_branch' => $qt_bank_branch,
		);
		$result = $this->Finance_model->update_bankcash_record($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_acc_success_bank_cash_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	} 
		 
	 // delete record
	public function delete() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_bankcash_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_success_bank_cash_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_deposit() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_deposit_record($id);
			if(isset($id)) {
				$this->Finance_model->delete_transaction_deposit_record($id);
				$Return['result'] = $this->lang->line('xin_acc_success_deposit_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_expense() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_expense_record($id);
			if(isset($id)) {
				$this->Finance_model->delete_transaction_expense_record($id);
				$Return['result'] = $this->lang->line('xin_acc_success_expense_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_payer() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_payer_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_success_payer_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_payee() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_payee_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_success_payee_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete record
	public function delete_transfer() {
		
		if($this->input->post('is_ajax')=='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = $this->uri->segment(4);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Finance_model->delete_transfer_record($id);
			if(isset($id)) {
				$this->Finance_model->delete_transaction_transfer_record($id);
				$Return['result'] = $this->lang->line('xin_acc_success_transfer_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	// get statement footer - data
	 public function get_statement_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'account_id' => $this->input->get('account_id'),
			'type_id' => $this->input->get('type_id')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_statement_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get expense footer - data
	 public function get_expense_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'type_id' => $this->input->get('type_id')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_expense_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get income footer - data
	 public function get_income_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'type_id' => $this->input->get('type_id')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_income_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 // get transfer footer - data
	 public function get_transfer_footer() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date')
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/accounting/footer/get_transfer_footer", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
} 
?>