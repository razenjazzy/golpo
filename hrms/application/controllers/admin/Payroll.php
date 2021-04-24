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

class Payroll extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		$this->load->library('Pdf');
		//load the model
		$this->load->model("Payroll_model");
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 // payroll templates
	 public function templates()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_payroll_templates');
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_payroll_templates');
		$data['path_url'] = 'payroll_templates';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('34',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/payroll/templates", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 
	 public function pdf_create() {
		 
		//$this->load->library('Pdf');
		$system = $this->Xin_model->read_setting_info(1);
		
		
		 // create new PDF document
   		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$id = $this->uri->segment(5);
		$payment = $this->Payroll_model->read_make_payment_information($id);
		$user = $this->Xin_model->read_user_info($payment[0]->employee_id);
		
		// if password generate option enable
		if($system[0]->is_payslip_password_generate==1) {
			/**
			* Protect PDF from being printed, copied or modified. In order to being viewed, the user needs
			* to provide password as selected format in settings module.
			*/
			if($system[0]->payslip_password_format=='dateofbirth') {
				$password_val = date("dmY", strtotime($user[0]->date_of_birth));
			} else if($system[0]->payslip_password_format=='contact_no') {
				$password_val = $user[0]->contact_no;
			} else if($system[0]->payslip_password_format=='full_name') {
				$password_val = $user[0]->first_name.$user[0]->last_name;
			} else if($system[0]->payslip_password_format=='email') {
				$password_val = $user[0]->email;
			} else if($system[0]->payslip_password_format=='password') {
				$password_val = $user[0]->password;
			} else if($system[0]->payslip_password_format=='user_password') {
				$password_val = $user[0]->username.$user[0]->password;
			} else if($system[0]->payslip_password_format=='employee_id') {
				$password_val = $user[0]->employee_id;
			} else if($system[0]->payslip_password_format=='employee_id_password') {
				$password_val = $user[0]->employee_id.$user[0]->password;
			} else if($system[0]->payslip_password_format=='dateofbirth_name') {
				$dob = date("dmY", strtotime($user[0]->date_of_birth));
				$fname = $user[0]->first_name;
				$lname = $user[0]->last_name;
				$password_val = $dob.$fname[0].$lname[0];
			}
			$pdf->SetProtection(array('print', 'copy','modify'), $password_val, $password_val, 0, null);
		}
		
		
		$_des_name = $this->Designation_model->read_designation_information($user[0]->designation_id);
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		//$location = $this->Xin_model->read_location_info($department[0]->location_id);
		// company info
		$company = $this->Xin_model->read_company_info($user[0]->company_id);
		
		
		$p_method = '';
		if($payment[0]->payment_method==1){
		  $p_method = 'Online';
		} else if($payment[0]->payment_method==2){
		  $p_method = 'PayPal';
		} else if($payment[0]->payment_method==3) {
		  $p_method = 'Payoneer';
		} else if($payment[0]->payment_method==4){
		  $p_method = 'Bank Transfer';
		} else if($payment[0]->payment_method==5) {
		  $p_method = 'Cheque';
		} else {
		  $p_method = 'Cash';
		}

		//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$company_name = $company[0]->name;
		// set default header data
		$c_info_email = $company[0]->email;
		$c_info_phone = $company[0]->contact_number;
		$country = $this->Xin_model->read_country_info($company[0]->country);
		$c_info_address = $company[0]->address_1.' '.$company[0]->address_2.', '.$company[0]->city.' - '.$company[0]->zipcode.', '.$country[0]->country_name;
		$email_phone_address = "".$this->lang->line('dashboard_email')." : $c_info_email | ".$this->lang->line('xin_phone')." : $c_info_phone \n".$this->lang->line('xin_address').": $c_info_address";
		$header_string = $email_phone_address;
		
		
		// set document information
		$pdf->SetCreator('HRSALE');
		$pdf->SetAuthor('HRSALE');
		//$pdf->SetTitle('Workable-Zone - Payslip');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->SetHeaderData('../../../uploads/logo/payroll/'.$system[0]->payroll_logo, 40, $company_name, $header_string);
			
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 9));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		
		// set margins
		$pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);
		
		// set image scale factor
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor($company_name);
		$pdf->SetTitle($company[0]->name.' - '.$this->lang->line('xin_print_payslip'));
		$pdf->SetSubject($this->lang->line('xin_payslip'));
		$pdf->SetKeywords($this->lang->line('xin_payslip'));
		// set font
		$pdf->SetFont('helvetica', 'B', 10);
				
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);
		
		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('dejavusans', '', 10, '', true);
		
		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();
		
		// set text shadow effect
		$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
		
		// -----------------------------------------------------------------------------
		
		$tbl = '
		<table cellpadding="1" cellspacing="1" border="0">
			<tr>
				<td align="center"><h1>'.$this->lang->line('xin_payslip').'</h1></td>
			</tr>
			<tr>
				<td align="center"><strong>'.$this->lang->line('xin_payslip_number').':</strong> #'.$payment[0]->make_payment_id.'</td>
			</tr>
			<tr>
				<td align="center"><strong>'.$this->lang->line('xin_e_details_date').':</strong> '.date("d F, Y").'</td>
			</tr>
		</table>
		';
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// -----------------------------------------------------------------------------
		
		$fname = $user[0]->first_name.' '.$user[0]->last_name;
		$tbl = '
		<table cellpadding="5" cellspacing="0" border="1">
			<tr>
				<td>'.$this->lang->line('xin_name').'</td>
				<td>'.$fname.'</td>
				<td>'.$this->lang->line('dashboard_employee_id').'</td>
				<td>'.$user[0]->employee_id.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('left_department').'</td>
				<td>'.$department[0]->department_name.'</td>
				<td>'.$this->lang->line('left_designation').'</td>
				<td>'.$_des_name[0]->designation_name.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_salary_month').'</td>
				<td>'.date("F Y", strtotime($payment[0]->payment_date)).'</td>
				<td>'.$this->lang->line('xin_payslip_number').'</td>
				<td>'.$payment[0]->make_payment_id.'</td>
			</tr>
		
		</table>
		';
	
		$pdf->writeHTML($tbl, true, false, true, false, '');
		
		if(null!=$this->uri->segment(4) && $this->uri->segment(4)=='sl') {
		// -----------------------------------------------------------------------------
		
		// Allowances
		if($payment[0]->house_rent_allowance!='' || $payment[0]->house_rent_allowance!=0){
			$hra = $this->Xin_model->currency_sign($payment[0]->house_rent_allowance);
		} else { $hra = '0';}
		if($payment[0]->medical_allowance!='' || $payment[0]->medical_allowance!=0){
			$ma = $this->Xin_model->currency_sign($payment[0]->medical_allowance);
		} else { $ma = '0';}
		if($payment[0]->travelling_allowance!='' || $payment[0]->travelling_allowance!=0){
			$ta = $this->Xin_model->currency_sign($payment[0]->travelling_allowance);
		} else { $ta = '0';}
		if($payment[0]->dearness_allowance!='' || $payment[0]->dearness_allowance!=0){
			$da = $this->Xin_model->currency_sign($payment[0]->dearness_allowance);
		} else { $da = '0';}
		
		// Deductions
		if($payment[0]->provident_fund!='' || $payment[0]->provident_fund!=0){
			$pf = $this->Xin_model->currency_sign($payment[0]->provident_fund);
		} else { $pf = '0';}
		if($payment[0]->tax_deduction!='' || $payment[0]->tax_deduction!=0){
			$td = $this->Xin_model->currency_sign($payment[0]->tax_deduction);
		} else { $td = '0';}
		if($payment[0]->security_deposit!='' || $payment[0]->security_deposit!=0){
			$sd = $this->Xin_model->currency_sign($payment[0]->security_deposit);
		} else { $sd = '0';}
		
		// get advance salary
		if($payment[0]->is_advance_salary_deduct==1){
			$re_paid_amount = $payment[0]->net_salary - $payment[0]->advance_salary_amount;
			$ad_sl = '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_advance_deducted_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->advance_salary_amount).'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_paid_amount').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->payment_amount).'</td>
			</tr>
			';
		} else {
			$ad_sl = '<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_paid_amount').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->payment_amount).'</td>
			</tr>';
		}
		
		$tbl = '
		<table cellpadding="4" cellspacing="0" border="0">
			<tr>
				<td><table cellpadding="5" cellspacing="0" border="1">
			<tr style="background-color:#9F9;">
				<td><strong>'.$this->lang->line('xin_earning_salary').'</strong></td>
				<td align="right"><strong>'.$this->lang->line('xin_amount').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_Payroll_house_rent_allowance').'</td>
				<td align="right">'.$hra.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_payroll_medical_allowance').'</td>
				<td align="right">'.$ma.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_payroll_travel_allowance').'</td>
				<td align="right">'.$ta.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_payroll_dearness_allowance').'</td>
				<td align="right">'.$da.'</td>
			</tr>
		</table></td>
				<td><table cellpadding="5" cellspacing="0" border="1">
			<tr style="background-color:#ff7575;">
				<td><strong>'.$this->lang->line('xin_deduction_salary').'</strong></td>
				<td align="right"><strong>'.$this->lang->line('xin_amount').'</strong></td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_payroll_provident_fund_de').'</td>
				<td align="right">'.$pf.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_payroll_tax_deduction_de').'</td>
				<td align="right">'.$td.'</td>
			</tr>
			<tr>
				<td>'.$this->lang->line('xin_payroll_security_deposit').'</td>
				<td align="right">'.$sd.'</td>
			</tr>
		</table></td>
			</tr>
		</table>
		';
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// -----------------------------------------------------------------------------
		
		$tbl = '
		<table cellpadding="5" cellspacing="0" border="1">
			<tr style="background-color:#c4e5fd;">
			  <th colspan="4" align="center"><strong>'.$this->lang->line('xin_payment_details').'</strong></th>
			 </tr>
			 <tr>
				<td colspan="2">'.$this->lang->line('xin_payroll_basic_salary').'</td>
				<td colspan="2" align="right">'.$this->Xin_model->currency_sign($payment[0]->basic_salary).'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_gross_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->gross_salary).'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_total_allowance').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_allowances).'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_total_deduction').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->total_deductions).'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_net_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->net_salary).'</td>
			</tr>
			'.$ad_sl.'
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payment_method').'</td>
				<td align="right">'.$p_method.'</td>
			</tr>
		</table>
		';
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		}
		if(null!=$this->uri->segment(4) && $this->uri->segment(4)=='hr') {
		// -----------------------------------------------------------------------------
		$tbl = '
		<table cellpadding="5" cellspacing="0" border="1">
			<tr style="background-color:#c4e5fd;">
			  <th colspan="4" align="center"><strong>'.$this->lang->line('xin_payment_details').'</strong></th>
			 </tr>
			<tr>
				<td colspan="2">'.$this->lang->line('xin_payroll_hourly_rate').'</td>
				<td colspan="2" align="right">'.$this->Xin_model->currency_sign($payment[0]->hourly_rate).'</td>
			</tr>
			<tr>
				<td colspan="2">'.$this->lang->line('xin_total_hours_worked').'</td>
				<td colspan="2" align="right">'.$payment[0]->total_hours_work.'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_gross_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->payment_amount).'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payroll_net_salary').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->payment_amount).'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_paid_amount').'</td>
				<td align="right">'.$this->Xin_model->currency_sign($payment[0]->payment_amount).'</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>'.$this->lang->line('xin_payment_method').'</td>
				<td align="right">'.$p_method.'</td>
			</tr>
		</table>
		';
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		}
		// -----------------------------------------------------------------------------
		
		$tbl = '
		<table cellpadding="5" cellspacing="0" border="0">
			<tr>
				<td align="right" colspan="4">'.$this->lang->line('xin_payslip_authorised_signatory').'</td>
			</tr>
		</table>
		';
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
				
		// ---------------------------------------------------------
		
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$fname = strtolower($fname);
		$pay_month = strtolower(date("F Y", strtotime($payment[0]->payment_date)));
		//Close and output PDF document
		$pdf->Output('payslip_'.$fname.'_'.$pay_month.'.pdf', 'D');
		
	 }
	 
	 // hourly wage templates
	 public function hourly_wages()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_hourly_wages');
		$data['breadcrumbs'] = $this->lang->line('left_hourly_wages');
		$data['path_url'] = 'hourly_wages';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('33',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/payroll/hourly_wages", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}	  
     }
	 
	 // manage employee salary
	 public function manage_salary()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_manage_salary');
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_manage_salary');
		$data['path_url'] = 'manage_salary';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('35',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/payroll/manage_salary", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 
	 // advance salary
	 public function advance_salary()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_advance_salary');
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_advance_salary');
		$data['path_url'] = 'advance_salary';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('38',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/payroll/advance_salary", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	  // advance salary report
	 public function advance_salary_report()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_advance_salary_report');
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('xin_advance_salary_report');
		$data['path_url'] = 'advance_salary_report';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('39',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/payroll/advance_salary_report", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 // generate payslips
	 public function generate_payslip()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('left_generate_payslip');
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['breadcrumbs'] = $this->lang->line('left_generate_payslip');
		$data['path_url'] = 'generate_payslip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('36',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/payroll/generate_payslip", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 // payment history
	 public function payslip()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$payment_id = $this->uri->segment(5);
		
		$result = $this->Payroll_model->read_make_payment_information($payment_id);
		if(is_null($result)){
			redirect('admin/payroll/payment_history');
		}
		$p_method = '';
		if($result[0]->payment_method==1){
		  $p_method = 'Online';
		} else if($result[0]->payment_method==2){
		  $p_method = 'PayPal';
		} else if($result[0]->payment_method==3) {
		  $p_method = 'Payoneer';
		} else if($result[0]->payment_method==4){
		  $p_method = 'Bank Transfer';
		} else if($result[0]->payment_method==5) {
		  $p_method = 'Cheque';
		} else {
		  $p_method = 'Cash';
		}
		// get addd by > template
		$user = $this->Xin_model->read_user_info($result[0]->employee_id);
		// user full name
		if(!is_null($user)){
			$first_name = $user[0]->first_name;
			$last_name = $user[0]->last_name;
		} else {
			$first_name = '--';
			$last_name = '--';
		}
		// get designation
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		
		// department
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		//$department_designation = $designation[0]->designation_name.'('.$department[0]->department_name.')';
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data = array(
				'title' => $this->lang->line('xin_payroll_employee_payslip'),
				'first_name' => $first_name,
				'last_name' => $last_name,
				'employee_id' => $user[0]->employee_id,
				'contact_no' => $user[0]->contact_no,
				'date_of_joining' => $user[0]->date_of_joining,
				'department_name' => $department_name,
				'designation_name' => $designation_name,
				'date_of_joining' => $user[0]->date_of_joining,
				'profile_picture' => $user[0]->profile_picture,
				'gender' => $user[0]->gender,
				'monthly_grade_id' => $user[0]->monthly_grade_id,
				'hourly_grade_id' => $user[0]->hourly_grade_id,
				'make_payment_id' => $result[0]->make_payment_id,
				'basic_salary' => $result[0]->basic_salary,
				'payment_date' => $result[0]->payment_date,
				'is_advance_salary_deduct' => $result[0]->is_advance_salary_deduct,
				'advance_salary_amount' => $result[0]->advance_salary_amount,
				'payment_amount' => $result[0]->payment_amount,
				'payment_method' => $p_method,
				'overtime_rate' => $result[0]->overtime_rate,
				'hourly_rate' => $result[0]->hourly_rate,
				'total_hours_work' => $result[0]->total_hours_work,
				'is_payment' => $result[0]->is_payment,
				'house_rent_allowance' => $result[0]->house_rent_allowance,
				'medical_allowance' => $result[0]->medical_allowance,
				'travelling_allowance' => $result[0]->travelling_allowance,
				'dearness_allowance' => $result[0]->dearness_allowance,
				'provident_fund' => $result[0]->provident_fund,
				'security_deposit' => $result[0]->security_deposit,
				'tax_deduction' => $result[0]->tax_deduction,
				'gross_salary' => $result[0]->gross_salary,
				'total_allowances' => $result[0]->total_allowances,
				'total_deductions' => $result[0]->total_deductions,
				'net_salary' => $result[0]->net_salary,
				'comments' => $result[0]->comments,
				);
		$data['breadcrumbs'] = $this->lang->line('xin_payroll_employee_payslip');
		$data['path_url'] = 'payslip';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!empty($session)){ 
		$data['subview'] = $this->load->view("admin/payroll/payslip", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
     }
	 
	 // payment history
	 public function payment_history()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['breadcrumbs'] = $this->lang->line('left_payment_history');
		$data['path_url'] = 'payment_history';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('37',$role_resources_ids)) {
			if(!empty($session)){
				$data['subview'] = $this->load->view("admin/payroll/payment_history", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 
 	// payroll template list
    public function template_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/templates", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$template = $this->Payroll_model->get_templates();
		
		$data = array();

          foreach($template->result() as $r) {

			  // get addd by > template
			  $user = $this->Xin_model->read_user_info($r->added_by);
			  // user full name
			  if(!is_null($user)){
			  	$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			  } else {
				$full_name = '--';	
			  }
			  
			  // get basic salary
			  $sbs = $this->Xin_model->currency_sign($r->basic_salary);
			  // get net salary
			  $sns = $this->Xin_model->currency_sign($r->net_salary);
			  // get date > created at > and format
			  $cdate = $this->Xin_model->set_date_format($r->created_at);
			  // total allowance
				if($r->total_allowance == 0 || $r->total_allowance=='') {
					$allowance = '--';
				} else{
					$allowance = $this->Xin_model->currency_sign($r->total_allowance);
				}
				
				$p_company = $this->Xin_model->read_company_info($r->company_id);
				if(!is_null($p_company)){
					$company = $p_company[0]->name;
				} else {
					$company = '--';	
				}

               $data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-salary_template_id="'. $r->salary_template_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->salary_template_id . '"><span class="far fa-trash-alt"></span></button></span>',
                    $company,
					$r->salary_grades,
                    $sbs,
                    $sns,
                    $allowance,
					$full_name,
					$cdate
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $template->num_rows(),
                 "recordsFiltered" => $template->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	// advance salary list
    public function advance_salary_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/advance_salary", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$advance_salary = $this->Payroll_model->get_advance_salaries();
		
		$data = array();

          foreach($advance_salary->result() as $r) {

			// get addd by > template
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			
			$d = explode('-',$r->month_year);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$month_year = $get_month.', '.$d[0];
			// get net salary
			$advance_amount = $this->Xin_model->currency_sign($r->advance_amount);
			// get date > created at > and format
			$cdate = $this->Xin_model->set_date_format($r->created_at);
			// get status
			if($r->status==0): $status = $this->lang->line('xin_pending'); elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
			// get monthly installment
			$monthly_installment = $this->Xin_model->currency_sign($r->monthly_installment);
			
			// get onetime deduction value
			if($r->one_time_deduct==1): $onetime = $this->lang->line('xin_yes'); else: $onetime = $this->lang->line('xin_no'); endif;
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			$data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-advance_salary_id="'. $r->advance_salary_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-advance_salary_id="'. $r->advance_salary_id . '"><span class="fa fa-eye"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->advance_salary_id . '"><span class="far fa-trash-alt"></span></button></span>',
                    $comp_name,
					$full_name,
                    $advance_amount,
                    $month_year,
					$onetime,
					$monthly_installment,
					$cdate,
					$status
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $advance_salary->num_rows(),
                 "recordsFiltered" => $advance_salary->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // advance salary report list
    public function advance_salary_report_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/advance_salary", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$advance_salary = $this->Payroll_model->get_advance_salaries_report();
		
		$data = array();

          foreach($advance_salary->result() as $r) {

			// get addd by > template
			$user = $this->Xin_model->read_user_info($r->employee_id);
			// user full name
			if(!is_null($user)){
				$full_name = $user[0]->first_name.' '.$user[0]->last_name;
			} else {
				$full_name = '--';	
			}
			
			$d = explode('-',$r->month_year);
			$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
			$month_year = $get_month.', '.$d[0];
			// get net salary
			$advance_amount = $this->Xin_model->currency_sign($r->advance_amount);
			// get date > created at > and format
			$cdate = $this->Xin_model->set_date_format($r->created_at);
			// get status
			if($r->status==0): $status = $this->lang->line('xin_pending'); elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
			// get monthly installment
			$monthly_installment = $this->Xin_model->currency_sign($r->monthly_installment);
			
			$remainig_amount = $r->advance_amount - $r->total_paid;
			$ramount = $this->Xin_model->currency_sign($remainig_amount);
			
			// get onetime deduction value
			if($r->one_time_deduct==1): $onetime = $this->lang->line('xin_yes'); else: $onetime = $this->lang->line('xin_no'); endif;
			if($r->advance_amount == $r->total_paid){
				$all_paid = '<span class="badge badge-success">'.$this->lang->line('xin_all_paid').'</span>';
			} else {
				$all_paid = '<span class="badge badge-warning">'.$this->lang->line('xin_remaining').'</span>';
			}
			//total paid
			$total_paid = $this->Xin_model->currency_sign($r->total_paid);
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			$data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-employee_id="'. $r->employee_id . '"><span class="fa fa-eye"></span></button></span>',
                    $comp_name,
					$full_name,
                    $advance_amount,
                    $total_paid,
					$ramount,
					$all_paid,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $advance_salary->num_rows(),
                 "recordsFiltered" => $advance_salary->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // hourly_list > templates
	 public function payment_history_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/hourly_wages", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$history = $this->Payroll_model->all_payment_history();
		
		$data = array();

          foreach($history->result() as $r) {

			  // get addd by > template
			  $user = $this->Xin_model->read_user_info($r->employee_id);
			  // user full name
			  if(!is_null($user)){
			  	$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$emp_link = '<a target="_blank" href="'.site_url().'admin/employees/detail/'.$r->employee_id.'">'.$user[0]->employee_id.'</a>';
				
				// view
			 	$functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".detail_modal_data" data-employee_id="'. $r->employee_id . '" data-pay_id="'. $r->make_payment_id . '"><span class="fa fa-arrow-circle-right"></span></button></span>';		  
			  
			  		  
			  $month_payment = date("F, Y", strtotime($r->payment_date));

			  $p_amount = $this->Xin_model->currency_sign($r->payment_amount);
	
			  // get date > created at > and format
			  $created_at = $this->Xin_model->set_date_format($r->created_at);
			   // get hourly rate
			  // payslip
		 	 $payslip = '<a class="text-success" href="'.site_url().'admin/payroll/payslip/id/'.$r->make_payment_id.'">'.$this->lang->line('left_generate_payslip').'</a>';
			 
			  
			  if($r->payment_method==1){
			  $p_method = 'Online';
			  } else if($r->payment_method==2){
				  $p_method = 'PayPal';
			  } else if($r->payment_method==3) {
				  $p_method = 'Payoneer';
			  } else if($r->payment_method==4){
				  $p_method = 'Bank Transfer';
			  } else if($r->payment_method==5) {
				  $p_method = 'Cheque';
			  } else {
				  $p_method = 'Cash';
			  }

               $data[] = array(
			   		$functions,
					$emp_link,
                    $full_name,
                    $p_amount,
                    $month_payment,
                    $created_at,
					$p_method,
					$payslip
               );
          }
		  } // if employee available

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $history->num_rows(),
                 "recordsFiltered" => $history->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // hourly_list > templates
	 public function hourly_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/hourly_wages", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$hourly_wages = $this->Payroll_model->get_hourly_wages();
		
		$data = array();

        foreach($hourly_wages->result() as $r) {
			
			// get date > created at > and format
			$cdate = $this->Xin_model->set_date_format($r->created_at);
			// get hourly rate
			$hourly_rate = $this->Xin_model->currency_sign($r->hourly_rate);
			$p_company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($p_company)){
				$company = $p_company[0]->name;
			} else {
				$company = '--';	
			}

             $data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-hourly_rate_id="'. $r->hourly_rate_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->hourly_rate_id . '"><span class="far fa-trash-alt"></span></button></span>',
                    $company,
					$r->hourly_grade,
                    $hourly_rate,
                    $cdate
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $hourly_wages->num_rows(),
                 "recordsFiltered" => $hourly_wages->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // hourly_list > templates
	 public function payslip_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/generate_payslip", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		// date and employee id/company id
		$p_date = $this->input->get("month_year");
		if($this->input->get("employee_id")==0 && $this->input->get("company_id")==0) {
			$payslip = $this->Employees_model->get_employees();
		} else if($this->input->get("employee_id")==0 && $this->input->get("company_id")!=0) {
			$payslip = $this->Payroll_model->get_comp_template($this->input->get("company_id"),0);
		} else if($this->input->get("employee_id")!=0 && $this->input->get("company_id")!=0) {
			$payslip = $this->Payroll_model->get_employee_comp_template($this->input->get("company_id"),$this->input->get("employee_id"));
		} else {
			$payslip = $this->Employees_model->get_employees();
		}
		
		
		$data = array();

          foreach($payslip->result() as $r) {
			  // user full name
			$full_name = $r->first_name.' '.$r->last_name;
			
			// get total hours > worked > employee
			$result = $this->Payroll_model->total_hours_worked_payslip($r->user_id,$this->input->get('month_year'));
			/* total work clock-in > clock-out  */
			$hrs_old_int1 = 0;//'';
			$Total = 0;
			$Trest = 0;
			$total_time_rs = 0;
			$hrs_old_int_res1 = 0;
			foreach ($result->result() as $hour_work){
				// total work			
				$clock_in =  new DateTime($hour_work->clock_in);
				$clock_out =  new DateTime($hour_work->clock_out);
				$interval_late = $clock_in->diff($clock_out);
				$hours_r  = $interval_late->format('%h');
				$minutes_r = $interval_late->format('%i');			
				$total_time = $hours_r .":".$minutes_r.":".'00';
				
				$str_time = $total_time;
			
				$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
				
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$hrs_old_int1 += $hrs_old_seconds;
				
				$Total = gmdate("H", $hrs_old_int1);			
			}
			
			if($r->monthly_grade_id =='' || $r->monthly_grade_id ==0) {
				$hourly_template = $this->Payroll_model->read_hourly_wage_information($r->hourly_grade_id);
				if(!is_null($hourly_template)){
				if($hourly_template[0]->hourly_grade){
					$template = $hourly_template[0]->hourly_grade.' ('.$this->lang->line('xin_payroll_hourly').')';
					$basic_salary = $hourly_template[0]->hourly_rate.' ('.$this->lang->line('xin_payroll_per_hour').')';
					$net_salary = $Total * $hourly_template[0]->hourly_rate;
					$create_id = $hourly_template[0]->hourly_rate_id;
					$gd = 'hr';
					$p_class = 'emo_hourly_pay';
					$unpaid_view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".hourlywages_template_modal" data-employee_id="'. $r->user_id . '"><span class="fa fa-arrow-circle-right"></span></button></span>';
				}
				} else {
					$template = '--';
					$basic_salary = '--';
					$net_salary = '--';
					$create_id = '--';
					$gd = 'hr';
					$p_class = 'emo_hourly_pay';
					$unpaid_view = '--';
				}
			} else if($r->monthly_grade_id !='' || $r->monthly_grade_id !=0) {
				$grade_template = $this->Payroll_model->read_template_information($r->monthly_grade_id);
				if(!is_null($grade_template)){
					if($grade_template[0]->salary_grades){
					$template = $grade_template[0]->salary_grades.' ('.$this->lang->line('xin_payroll_monthly').')';
					$basic_salary = $grade_template[0]->basic_salary;
					$net_salary = $grade_template[0]->net_salary;
					$create_id = $grade_template[0]->salary_template_id;
					$gd = 'sl';
					$p_class = 'emo_monthly_pay';
					$unpaid_view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".payroll_template_modal" data-employee_id="'. $r->user_id . '"><span class="fa fa-arrow-circle-right"></span></button></span>';
					} else {
						$template = '--';
						$basic_salary = '--';
						$net_salary = '--';
						$create_id = '--';
						$gd = 'sl';
						$p_class = 'emo_monthly_pay';
						$unpaid_view = '--';
					}
				  } else {
					  $template = '--';
					  $basic_salary = '--';
					  $net_salary = '--';
					  $create_id = '--';
					  $gd = 'sl';
					  $p_class = 'emo_monthly_pay';
					  $unpaid_view = '--';	
				  }
				
			}
				
			// make payment
			$payment_check = $this->Payroll_model->read_make_payment_payslip_check($r->user_id,$p_date);
			if($payment_check->num_rows() > 0){
				$make_payment = $this->Payroll_model->read_make_payment_payslip($r->user_id,$p_date);
				$functions = '<a class="text-success" href="'.site_url().'admin/payroll/payslip/id/'.$make_payment[0]->make_payment_id.'">Generate Payslip</a>';
				$status = '<span class="tag tag-success">Paid</span>';
				$p_details = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".detail_modal_data" data-employee_id="'. $r->user_id . '" data-pay_id="'. $make_payment[0]->make_payment_id . '" data-company_id="'.$this->input->get("company_id").'"><span class="fa fa-arrow-circle-right"></span></button></span>';
				} else {
					if($net_salary > 0) {
					$functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_payroll_make_payment').'"><button type="button" class="btn icon-btn btn-xs btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".'.$p_class.'" data-employee_id="'. $r->user_id . '" data-payment_date="'. $p_date . '" data-company_id="'.$this->input->get("company_id").'"><span class="fa fas fa-money-bill-alt"></span></button></span>';
					} else {
					$functions = '<span class="text-danger" data-toggle="tooltip" data-placement="left" title="'.$this->lang->line('xin_error_payroll_can_not_make_payment').'">'.$this->lang->line('xin_error_payroll_zero_net_salary').'</span>';
					}
				$status = '<span class="badge badge-outline-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
				$p_details = $unpaid_view;
				//$p_details = '-';
				}
				// get company
				$company = $this->Xin_model->read_company_info($r->company_id);
				if(!is_null($company)){
					$comp_name = $company[0]->name;
				} else {
					$comp_name = '--';	
				}
				$data[] = array(
					$comp_name,
					$r->employee_id,
					$full_name,
					$template,
					$basic_salary,
					$net_salary,
					$p_details,
					$status,
					$functions
				);
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $payslip->num_rows(),
                 "recordsFiltered" => $payslip->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // salary list
	 public function salary_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/manage_salary", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		if($this->input->get("employee_id")==0 && $this->input->get("company_id")==0) {
			$salary = $this->Employees_model->get_employees();
		} else if($this->input->get("employee_id")==0 && $this->input->get("company_id")!=0) {
			$salary = $this->Payroll_model->get_comp_template($this->input->get("company_id"),0);
		} else if($this->input->get("employee_id")!=0 && $this->input->get("company_id")!=0) {
			$salary = $this->Payroll_model->get_employee_comp_template($this->input->get("company_id"),$this->input->get("employee_id"));
		}
		
		$data = array();

		foreach($salary->result() as $r) {
		
		// get designation
		$designation = $this->Designation_model->read_designation_information($r->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		// department
		$department = $this->Department_model->read_department_information($r->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		$department_designation = $designation_name.'('.$department_name.')';		  
		  
		/* for salary template > hourly*/
		$checked = '';
		/* for salary template > monthly*/
		$m_checked = '';			
		/* for salary template > hourly*/
		$disabled = '';
		if($r->hourly_grade_id == 0 || $r->hourly_grade_id == '') {
			$disabled = 'disabled';
		} else {
			$checked = 'checked';
		}
		/* for salary template > monthly*/
		$m_disabled = '';
		if($r->monthly_grade_id == 0 || $r->monthly_grade_id == '') {
			$m_disabled = 'disabled';
		} else {
			$m_checked = 'checked';
		}
		
		/*  all hourly templates */
		$hourly_rate = '';
		$hr_radio = '
		<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_payroll_select_hourly').'"><label class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input hourly_grade hourly_'.$r->user_id.'" id="'.$r->user_id.'" name="grade_status['.$r->user_id.']" value="hourly" '.$checked.'>
			<span class="custom-control-label"></span>
			<span class="custom-control-description">&nbsp;</span>
		</label></span>
		<input type="hidden" name="user['.$r->user_id.']" value="'.$r->user_id.'">
		';
		$hourly_rate = $hr_radio . ' <select class="custom-select select-custom m-r-1 sm_hourly_'.$r->user_id.'" name="hourly_grade_id['.$r->user_id.']" '.$disabled.'>';
		$hourly_rate .= '<option value="0">--'.$this->lang->line('xin_select').'--</option>';
		$selected = '';
		foreach($this->Payroll_model->all_hourly_templates() as $hourly_template){
			if($r->hourly_grade_id == $hourly_template->hourly_rate_id) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$hourly_rate .= '<option value="'.$hourly_template->hourly_rate_id.'" '.$selected.'>'.$hourly_template->hourly_grade.'</option>';
		}
		$hourly_rate .= '</select>';
		
		/*  all salary templates */
		$_salary_template = '';
		$salary_radio = '
		<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_payroll_select_monthly').'">
		<label class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input monthly_grade monthly_'.$r->user_id.'" id="'.$r->user_id.'" name="grade_status['.$r->user_id.']" value="monthly" '.$m_checked.'>
			<span class="custom-control-label"></span>
			<span class="custom-control-description">&nbsp;</span>
		</label></span>
		';
		$_salary_template = $salary_radio . ' <select class="custom-select select-custom m-r-1 sm_monthly_'.$r->user_id.'" name="monthly_grade_id['.$r->user_id.']" '.$m_disabled.'>';
		$_salary_template .= '<option value="0">--'.$this->lang->line('xin_select').'--</option>';
		$m_selected = '';
		foreach($this->Payroll_model->all_salary_templates() as $salary_template){
		
		if($r->monthly_grade_id == $salary_template->salary_template_id) {
			$m_selected = 'selected';
		} else {
			$m_selected = '';
		}
		$_salary_template .= '<option value="'.$salary_template->salary_template_id.'" '.$m_selected.'>'.$salary_template->salary_grades.'</option>';
		}
		$_salary_template .= '</select>';
		
		$_salary_template .= '<script type="text/javascript">
		$(document).ready(function () {
			$(".hourly_grade").click(function(e){
				var th = $(this), id = th.attr("id");
				$(".monthly_"+id).prop("checked", false);
				$(".sm_monthly_"+id).prop("disabled", true);
				$(".sm_monthly_"+id).val("0");
				if (th.is(":checked")) {
					$(".sm_hourly_"+id).prop("disabled", false);
				} else {
					$(".sm_hourly_"+id).val("0");
				}
			});
		});
		</script>';
		$_salary_template .= '<script type="text/javascript">
		$(document).ready(function () {
			$(".monthly_grade").click(function(e){
				var th = $(this), id = th.attr("id");
				$(".hourly_"+id).prop("checked", false);
				$(".sm_hourly_"+id).prop("disabled", true);
				$(".sm_hourly_"+id).val("0");
				if (th.is(":checked")) {
					$(".sm_monthly_"+id).prop("disabled", false);
				} else {
					$(".sm_monthly_"+id).val("0");
				}
			});
		});
		</script>';
		$fname = $r->first_name.' '.$r->last_name;
		$p_company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($p_company)){
			$company = $p_company[0]->name;
		} else {
			$company = '--';	
		}
		
		if(($r->monthly_grade_id ==0 || $r->hourly_grade_id=='') && ($r->hourly_grade_id ==0 || $r->hourly_grade_id=='')) {
			$functions = '-';
		} else {
			if($r->monthly_grade_id!=0){
			$functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".payroll_template_modal" data-employee_id="'. $r->user_id . '"><span class="fa fa-arrow-circle-right"></span></button></span>';
			} else {
				$functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".hourlywages_template_modal" data-employee_id="'. $r->user_id . '"><i class="fa fa-arrow-circle-right"></i></button></span>';
			}
		}

               $data[] = array(
			   		$functions,
					$company,
					$fname,
                    $r->username,
                    $department_designation,
                    $hourly_rate,
                    $_salary_template
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $salary->num_rows(),
                 "recordsFiltered" => $salary->num_rows(),
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
			$this->load->view("admin/payroll/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }  
	 
	 // get company > employees > advance salary
	 public function get_advance_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/payroll/get_advance_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } 
	 
	// make payment info by id
	public function make_payment_view()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('pay_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Payroll_model->read_make_payment_information($id);
		// get addd by > template
		$user = $this->Xin_model->read_user_info($result[0]->employee_id);
		// get designation
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		// department
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		
		$data = array(
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'employee_id' => $user[0]->employee_id,
				'department_name' => $department_name,
				'designation_name' => $designation_name,
				'date_of_joining' => $user[0]->date_of_joining,
				'profile_picture' => $user[0]->profile_picture,
				'gender' => $user[0]->gender,
				'monthly_grade_id' => $user[0]->monthly_grade_id,
				'hourly_grade_id' => $user[0]->hourly_grade_id,
				'basic_salary' => $result[0]->basic_salary,
				'payment_date' => $result[0]->payment_date,
				'payment_method' => $result[0]->payment_method,
				'overtime_rate' => $result[0]->overtime_rate,
				'hourly_rate' => $result[0]->hourly_rate,
				'total_hours_work' => $result[0]->total_hours_work,
				'is_payment' => $result[0]->is_payment,
				'is_advance_salary_deduct' => $result[0]->is_advance_salary_deduct,
				'advance_salary_amount' => $result[0]->advance_salary_amount,
				'house_rent_allowance' => $result[0]->house_rent_allowance,
				'medical_allowance' => $result[0]->medical_allowance,
				'travelling_allowance' => $result[0]->travelling_allowance,
				'dearness_allowance' => $result[0]->dearness_allowance,
				'provident_fund' => $result[0]->provident_fund,
				'security_deposit' => $result[0]->security_deposit,
				'tax_deduction' => $result[0]->tax_deduction,
				'gross_salary' => $result[0]->gross_salary,
				'total_allowances' => $result[0]->total_allowances,
				'total_deductions' => $result[0]->total_deductions,
				'net_salary' => $result[0]->net_salary,
				'payment_amount' => $result[0]->payment_amount,
				'comments' => $result[0]->comments,
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_payslip', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// pay monthly > create payslip
	public function pay_monthly()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
        // get addd by > template
		$user = $this->Xin_model->read_user_info($id);
		$result = $this->Payroll_model->read_template_information($user[0]->monthly_grade_id);
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		//$location = $this->Location_model->read_location_information($department[0]->location_id);
		$data = array(
				'department_id' => $user[0]->department_id,
				'designation_id' => $user[0]->designation_id,
				//'location_id' => $location[0]->location_id,
				'company_id' => $user[0]->company_id,
				'salary_template_id' => $result[0]->salary_template_id,
				'user_id' => $user[0]->user_id,
				'salary_grades' => $result[0]->salary_grades,
				'basic_salary' => $result[0]->basic_salary,
				'overtime_rate' => $result[0]->overtime_rate,
				'house_rent_allowance' => $result[0]->house_rent_allowance,
				'medical_allowance' => $result[0]->medical_allowance,
				'travelling_allowance' => $result[0]->travelling_allowance,
				'dearness_allowance' => $result[0]->dearness_allowance,
				'security_deposit' => $result[0]->security_deposit,
				'provident_fund' => $result[0]->provident_fund,
				'tax_deduction' => $result[0]->tax_deduction,
				'gross_salary' => $result[0]->gross_salary,
				'total_allowance' => $result[0]->total_allowance,
				'total_deduction' => $result[0]->total_deduction,
				'net_salary' => $result[0]->net_salary,
				'added_by' => $result[0]->added_by,
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_make_payment', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// pay hourly > create payslip
	public function pay_hourly()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
        // get addd by > template
		$user = $this->Xin_model->read_user_info($id);
		$result = $this->Payroll_model->read_hourly_wage_information($user[0]->hourly_grade_id);
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		//$location = $this->Location_model->read_location_information($department[0]->location_id);
		$data = array(
				'department_id' => $user[0]->department_id,
				'designation_id' => $user[0]->designation_id,
				//'location_id' => $location[0]->location_id,
				'company_id' => $user[0]->company_id,
				'hourly_rate_id' => $result[0]->hourly_rate_id,
				'user_id' => $user[0]->user_id,
				'hourly_rate' => $result[0]->hourly_rate,
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_make_payment', $data);
		} else {
			redirect('admin/');
		}
	}
	 
	// get payroll template info by id
	public function template_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('salary_template_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Payroll_model->read_template_information($id);
		$data = array(
				'salary_template_id' => $result[0]->salary_template_id,
				'company_id' => $result[0]->company_id,
				'salary_grades' => $result[0]->salary_grades,
				'basic_salary' => $result[0]->basic_salary,
				'overtime_rate' => $result[0]->overtime_rate,
				'house_rent_allowance' => $result[0]->house_rent_allowance,
				'medical_allowance' => $result[0]->medical_allowance,
				'travelling_allowance' => $result[0]->travelling_allowance,
				'dearness_allowance' => $result[0]->dearness_allowance,
				'security_deposit' => $result[0]->security_deposit,
				'provident_fund' => $result[0]->provident_fund,
				'tax_deduction' => $result[0]->tax_deduction,
				'gross_salary' => $result[0]->gross_salary,
				'total_allowance' => $result[0]->total_allowance,
				'total_deduction' => $result[0]->total_deduction,
				'net_salary' => $result[0]->net_salary,
				'added_by' => $result[0]->added_by,
				'all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_templates', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get payroll template info by id
	public function payroll_template_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
		// get addd by > template
		$user = $this->Xin_model->read_user_info($id);
		// user full name
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		// get designation
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		// department
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		$data = array(
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'employee_id' => $user[0]->employee_id,
				'department_name' => $department_name,
				'designation_name' => $designation_name,
				'date_of_joining' => $user[0]->date_of_joining,
				'profile_picture' => $user[0]->profile_picture,
				'gender' => $user[0]->gender,
				'monthly_grade_id' => $user[0]->monthly_grade_id,
				'hourly_grade_id' => $user[0]->hourly_grade_id
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_templates', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get hourly wage template info by id
	public function hourlywage_template_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
		// get addd by > template
		$user = $this->Xin_model->read_user_info($id);
		// user full name
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		// get designation
		$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
		if(!is_null($designation)){
			$designation_name = $designation[0]->designation_name;
		} else {
			$designation_name = '--';	
		}
		// department
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		if(!is_null($department)){
			$department_name = $department[0]->department_name;
		} else {
			$department_name = '--';	
		}
		$data = array(
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'employee_id' => $user[0]->employee_id,
				'department_name' => $department_name,
				'designation_name' => $designation_name,
				'date_of_joining' => $user[0]->date_of_joining,
				'profile_picture' => $user[0]->profile_picture,
				'gender' => $user[0]->gender,
				'monthly_grade_id' => $user[0]->monthly_grade_id,
				'hourly_grade_id' => $user[0]->hourly_grade_id
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_templates', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get hourly wage info by id
	public function hourly_wage_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('hourly_rate_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Payroll_model->read_hourly_wage_information($id);
		$data = array(
				'hourly_rate_id' => $result[0]->hourly_rate_id,
				'company_id' => $result[0]->company_id,
				'hourly_grade' => $result[0]->hourly_grade,
				'hourly_rate' => $result[0]->hourly_rate,
				'added_by' => $result[0]->added_by,
				'all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_hourly_wages', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get advance salary info by id
	public function advance_salary_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('advance_salary_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Payroll_model->read_advance_salary_info($id);
		$data = array(
				'advance_salary_id' => $result[0]->advance_salary_id,
				'company_id' => $result[0]->company_id,
				'employee_id' => $result[0]->employee_id,
				'month_year' => $result[0]->month_year,
				'advance_amount' => $result[0]->advance_amount,
				'one_time_deduct' => $result[0]->one_time_deduct,
				'monthly_installment' => $result[0]->monthly_installment,
				'reason' => $result[0]->reason,
				'status' => $result[0]->status,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_advance_salary', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// get advance salary info by id
	public function advance_salary_report_read()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
       // $data['all_countries'] = $this->xin_model->get_countries();
		$result = $this->Payroll_model->advance_salaries_report_view($id);
		$data = array(
				'advance_salary_id' => $result[0]->advance_salary_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'month_year' => $result[0]->month_year,
				'advance_amount' => $result[0]->advance_amount,
				'total_paid' => $result[0]->total_paid,
				'one_time_deduct' => $result[0]->one_time_deduct,
				'monthly_installment' => $result[0]->monthly_installment,
				'reason' => $result[0]->reason,
				'status' => $result[0]->status,
				'created_at' => $result[0]->created_at,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		if(!empty($session)){ 
			$this->load->view('admin/payroll/dialog_advance_salary', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_template() {
	
		if($this->input->post('add_type')=='payroll') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('salary_grades')==='') {
        	$Return['error'] = $this->lang->line('xin_error_template_name');
		} else if($this->input->post('basic_salary')==='') {
			$Return['error'] = $this->lang->line('xin_error_basic_salary');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'salary_grades' => $this->input->post('salary_grades'),
		'company_id' => $this->input->post('company'),
		'basic_salary' => $this->input->post('basic_salary'),
		'overtime_rate' => $this->input->post('overtime_rate'),
		'house_rent_allowance' => $this->input->post('house_rent_allowance'),
		'medical_allowance' => $this->input->post('medical_allowance'),
		'travelling_allowance' => $this->input->post('travelling_allowance'),
		'dearness_allowance' => $this->input->post('dearness_allowance'),
		'provident_fund' => $this->input->post('provident_fund'),
		'tax_deduction' => $this->input->post('tax_deduction'),
		'security_deposit' => $this->input->post('security_deposit'),
		'gross_salary' => $this->input->post('gross_salary'),
		'total_allowance' => $this->input->post('total_allowance'),
		'total_deduction' => $this->input->post('total_deduction'),
		'net_salary' => $this->input->post('net_salary'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Payroll_model->add_template($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_payroll_template_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function add_hourly_rate() {
	
		if($this->input->post('add_type')=='payroll') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('hourly_grade')==='') {
        	$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('hourly_rate')==='') {
			$Return['error'] = $this->lang->line('xin_error_hourly_rate_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'hourly_grade' => $this->input->post('hourly_grade'),
		'company_id' => $this->input->post('company'),
		'hourly_rate' => $this->input->post('hourly_rate'),
		'added_by' => $this->input->post('user_id'),
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Payroll_model->add_hourly_wages($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_hourly_wage_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');;
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_template() {
	
		if($this->input->post('edit_type')=='payroll') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('hourly_grade')==='') {
        	$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('hourly_rate')==='') {
			$Return['error'] = $this->lang->line('xin_error_hourly_rate_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'salary_grades' => $this->input->post('salary_grades'),
		'company_id' => $this->input->post('company'),
		'basic_salary' => $this->input->post('basic_salary'),
		'overtime_rate' => $this->input->post('overtime_rate'),
		'house_rent_allowance' => $this->input->post('house_rent_allowance'),
		'medical_allowance' => $this->input->post('medical_allowance'),
		'travelling_allowance' => $this->input->post('travelling_allowance'),
		'dearness_allowance' => $this->input->post('dearness_allowance'),
		'provident_fund' => $this->input->post('provident_fund'),
		'tax_deduction' => $this->input->post('tax_deduction'),
		'security_deposit' => $this->input->post('security_deposit'),
		'gross_salary' => $this->input->post('gross_salary'),
		'total_allowance' => $this->input->post('total_allowance'),
		'total_deduction' => $this->input->post('total_deduction'),
		'net_salary' => $this->input->post('net_salary')
		);	
		
		$result = $this->Payroll_model->update_template_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_payroll_template_added');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_hourly_wages() {
	
		if($this->input->post('edit_type')=='payroll') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('hourly_grade')==='') {
        	$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('hourly_rate')==='') {
			$Return['error'] = $this->lang->line('xin_error_hourly_rate_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'hourly_grade' => $this->input->post('hourly_grade'),
		'company_id' => $this->input->post('company'),
		'hourly_rate' => $this->input->post('hourly_rate')
		);
		
		$result = $this->Payroll_model->update_hourly_wages_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_hourly_wage_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database > update salary template
	public function user_salary_template() {
	
		if($this->input->post('edit_type')=='payroll') {
					
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$count = count($this->input->post('grade_status'));
			
		/* Set Salary Template for User*/
	   if($count > 0) {
		    $grade_status = $this->input->post("grade_status");
		   foreach($grade_status as $key=>$val) {
				//update salary template info in DB
				$data = array(
				'salary_template' => $val
				);
				$this->Payroll_model->update_salary_template($data, $key);
		   }
	   }  else {
			foreach($this->input->post('user') as $key=>$val) {
				//update salary template info in DB
				if(null==$this->input->post('grade_monthly')) {
					//update salary template info in DB
					$data = array(
					'salary_template' => ''
					);
					$this->Payroll_model->update_empty_salary_template($data, $key);
				}
		   }
	   }
	   
	   /* Set Hourly Grade/ for User */
	   if(null!=$this->input->post('hourly_grade_id')) {
		foreach($this->input->post('hourly_grade_id') as $key=>$val) {
			//update Hourly Grade info in DB
			$data = array(
			'hourly_grade_id' => $val,
			'monthly_grade_id' => '0'
			);
			$this->Payroll_model->update_hourlygrade_salary_template($data, $key);
		}
	   } else {
			foreach($this->input->post('user') as $key=>$val) {
				//update salary template info in DB
				if(null==$this->input->post('hourly_grade_id')) {
					//update Hourly Grade info in DB
					$data = array(
					'hourly_grade_id' => '0',
					);
					$this->Payroll_model->update_hourlygrade_zero($data, $key);
				}
		   }
	   }
	   
	   /* Set Monthly Grade/ for User */
	   if(null!=$this->input->post('monthly_grade_id')) {
		   foreach($this->input->post('monthly_grade_id') as $key=>$val) {
				//update Hourly Grade info in DB
				$data = array(
				'hourly_grade_id' => '0',
				'monthly_grade_id' => $val
				);
				$this->Payroll_model->update_monthlygrade_salary_template($data, $key);
			
		   }
	   } else {
			foreach($this->input->post('user') as $key=>$val) {
				if(null==$this->input->post('monthly_grade_id')) {
					//update Hourly Grade info in DB
					$data = array(
					'monthly_grade_id' => '0'
					);
					$this->Payroll_model->update_monthlygrade_zero($data, $key);
				}
		   }
	   }
	   
		$Return['result'] = $this->lang->line('xin_success_salary_info_updated');
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database > add monthly payment
	public function add_pay_monthly() {
	
		if($this->input->post('add_type')=='add_monthly_payment') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('payment_method')==='') {
        	$Return['error'] = $this->lang->line('xin_error_makepayment_payment_method');
		} else if($this->input->post('comments')==='') {
			$Return['error'] = $this->lang->line('xin_error_makepayment_comments');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// get advance salary
		$advance_salary = $this->Payroll_model->advance_salary_by_employee_id($this->input->post('emp_id'));
		$emp_value = $this->Payroll_model->get_paid_salary_by_employee_id($this->input->post('emp_id'));
		if(!is_null($advance_salary)){
			$monthly_installment = $advance_salary[0]->monthly_installment;
			$total_paid = $advance_salary[0]->total_paid;
			$advance_amount = $advance_salary[0]->advance_amount;
			//check ifpaid
			$em_advance_amount = $emp_value[0]->advance_amount;
			$em_total_paid = $emp_value[0]->total_paid;
			if($em_advance_amount > $em_total_paid){
				if($monthly_installment=='' || $monthly_installment==0) {
					$add_amount = $em_total_paid + $this->input->post('advance_amount');
					//pay_date //emp_id
					$adv_data = array('total_paid' => $add_amount);
					$payslip_deduct = $this->input->post('advance_amount');
					//
					$this->Payroll_model->updated_advance_salary_paid_amount($adv_data,$this->input->post('emp_id'));
					$deduct_salary = $payslip_deduct;
					$is_advance_deducted = 1;
				} else {
					$add_amount = $em_total_paid + $this->input->post('advance_amount');
					$payslip_deduct = $this->input->post('advance_amount');
					//pay_date //emp_id
					$adv_data = array('total_paid' => $add_amount);
					//
					$this->Payroll_model->updated_advance_salary_paid_amount($adv_data,$this->input->post('emp_id'));
					$deduct_salary = $payslip_deduct;
					$is_advance_deducted = 1;
				}
				
			}
		} else {
			$deduct_salary = 0;
			$is_advance_deducted = 0;
		}
	
		$data = array(
		'employee_id' => $this->input->post('emp_id'),
		'department_id' => $this->input->post('department_id'),
		'company_id' => $this->input->post('company_id'),
		'designation_id' => $this->input->post('designation_id'),
		'payment_date' => $this->input->post('pay_date'),
		'basic_salary' => $this->input->post('basic_salary'),
		'payment_amount' => $this->input->post('payment_amount'),
		'gross_salary' => $this->input->post('gross_salary'),
		'total_allowances' => $this->input->post('total_allowances'),
		'total_deductions' => $this->input->post('total_deductions'),
		'net_salary' => $this->input->post('net_salary'),
		'house_rent_allowance' => $this->input->post('house_rent_allowance'),
		'medical_allowance' => $this->input->post('medical_allowance'),
		'travelling_allowance' => $this->input->post('travelling_allowance'),
		'dearness_allowance' => $this->input->post('dearness_allowance'),
		'provident_fund' => $this->input->post('provident_fund'),
		'tax_deduction' => $this->input->post('tax_deduction'),
		'security_deposit' => $this->input->post('security_deposit'),
		'overtime_rate' => $this->input->post('overtime_rate'),
		'is_advance_salary_deduct' => $is_advance_deducted,
		'advance_salary_amount' => $deduct_salary,
		'is_payment' => '1',
		'payment_method' => $this->input->post('payment_method'),
		'comments' => $this->input->post('comments'),
		'status' => '1',
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Payroll_model->add_monthly_payment_payslip($data);	
		
		if ($result == TRUE) {
			
			$Return['result'] = $this->lang->line('xin_success_payment_paid');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database > add hourly payment
	public function add_pay_hourly() {
	
		if($this->input->post('add_type')=='pay_hourly') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		if($this->input->post('payment_method')==='') {
        	$Return['error'] = $this->lang->line('xin_error_makepayment_payment_method');
		} else if($this->input->post('comments')==='') {
			$Return['error'] = $this->lang->line('xin_error_makepayment_comments');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'employee_id' => $this->input->post('emp_id'),
		'department_id' => $this->input->post('department_id'),
		'company_id' => $this->input->post('company_id'),
		'designation_id' => $this->input->post('designation_id'),
		'payment_date' => $this->input->post('pay_date'),
		'payment_amount' => $this->input->post('payment_amount'),
		'total_hours_work' => $this->input->post('total_hours_work'),
		'hourly_rate' => $this->input->post('hourly_rate'),
		'is_payment' => '1',
		'payment_method' => $this->input->post('payment_method'),
		'comments' => $this->input->post('comments'),
		'status' => '1',
		'created_at' => date('d-m-Y h:i:s')
		);
		$result = $this->Payroll_model->add_hourly_payment_payslip($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_payment_paid');
			
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// add advance salary
	// Validate and add info in database
	public function add_advance_salary() {
	
		if($this->input->post('add_type')=='advance_salary') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$reason = $this->input->post('reason');
		$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
			
		/* Server side PHP input validation */		
		if($this->input->post('company')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_error_advance_salary_month_year');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		// get one time value
		if($this->input->post('one_time_deduct')==1){
			$monthly_installment = 0;
		} else {
			$monthly_installment = $this->input->post('monthly_installment');
		}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company'),
		'reason' => $qt_reason,
		'month_year' => $this->input->post('month_year'),
		'advance_amount' => $this->input->post('amount'),
		'monthly_installment' => $monthly_installment,
		'total_paid' => 0,
		'one_time_deduct' => $this->input->post('one_time_deduct'),
		'status' => $this->input->post('status'),
		'created_at' => date('Y-m-d h:i:s')
		);
		
		$result = $this->Payroll_model->add_advance_salary_payroll($data);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_request_sent_advance_salary');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// updated advance salary
	// Validate and add info in database
	public function update_advance_salary() {
	
		if($this->input->post('edit_type')=='advance_salary') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		
		$reason = $this->input->post('reason');
		$qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		/* Server side PHP input validation */		
		if($this->input->post('company')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_error_advance_salary_month_year');
		} else if($this->input->post('amount')==='') {
			$Return['error'] = $this->lang->line('xin_error_amount_field');
		}
						
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		// get one time value
		if($this->input->post('one_time_deduct')==1){
			$monthly_installment = 0;
		} else {
			$monthly_installment = $this->input->post('monthly_installment');
		}
	
		$data = array(
		'employee_id' => $this->input->post('employee_id'),
		'company_id' => $this->input->post('company'),
		'reason' => $qt_reason,
		'month_year' => $this->input->post('month_year'),
		'monthly_installment' => $monthly_installment,
		'one_time_deduct' => $this->input->post('one_time_deduct'),
		'advance_amount' => $this->input->post('amount'),
		'status' => $this->input->post('status')
		);
		
		$result = $this->Payroll_model->updated_advance_salary_payroll($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_advance_salary_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
		
	public function delete_advance_salary() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Payroll_model->delete_advance_salary_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_advance_salary_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');;
		}
		$this->output($Return);
	}
	
	public function delete_template() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Payroll_model->delete_template_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_payroll_template_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');;
		}
		$this->output($Return);
	}
	
	// all payslips list
	 public function employee_payslip_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("employee/user/payslips", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$history = $this->Payroll_model->get_payroll_slip($session['user_id']);
		
		$data = array();

          foreach($history->result() as $r) {

			  // get addd by > template
			  $user = $this->Exin_model->read_user_info($r->employee_id);
			  // user full name
			  $full_name = $user[0]->first_name.' '.$user[0]->last_name;
			  
			  $emp_link = '<a target="_blank" href="'.site_url().'admin/employees/detail/'.$r->employee_id.'/">'.$user[0]->employee_id.'</a>';
			  		  
			  $month_payment = date("F, Y", strtotime($r->payment_date));
			   //$month_payment = $this->xin_model->set_date_format($r->payment_date);
			  $p_amount = $this->Xin_model->currency_sign($r->payment_amount);
	
			  // get date > created at > and format
			  $created_at = $this->Xin_model->set_date_format($r->created_at);
			   // get hourly rate
			  // payslip
		 	 $payslip = '<a class="text-success" href="'.site_url().'admin/payroll/payslip/id/'.$r->make_payment_id.'/">'.$this->lang->line('left_generate_payslip').'</a>';
			 // view
			 $functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".detail_modal_data" data-employee_id="'. $r->employee_id . '" data-pay_id="'. $r->make_payment_id . '"><i class="fa fa-arrow-circle-right"></i></button></span>';
			  
			  if($r->payment_method==1){
			  $p_method = 'Online';
			  } else if($r->payment_method==2){
				  $p_method = 'PayPal';
			  } else if($r->payment_method==3) {
				  $p_method = 'Payoneer';
			  } else if($r->payment_method==4){
				  $p_method = 'Bank Transfer';
			  } else if($r->payment_method==5) {
				  $p_method = 'Cheque';
			  } else {
				  $p_method = 'Cash';
			  }

               $data[] = array(
			   		$functions,
					'#'.$r->make_payment_id,
                    $p_amount,
                    $month_payment,
                    $created_at,
					$p_method,
					$payslip
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $history->num_rows(),
                 "recordsFiltered" => $history->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	
	public function delete_hourly_wage() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Payroll_model->delete_hourly_wage_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_hourly_wage_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');;
		}
		$this->output($Return);
	}
}
