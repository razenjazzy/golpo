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

class Invoices extends MY_Controller
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
          //load the login model
          $this->load->model('Company_model');
		  $this->load->model('Xin_model');
		  $this->load->model("Project_model");
		  $this->load->model("Tax_model");
		  $this->load->model("Invoices_model");
		  $this->load->model("Clients_model");
     }
	 
	// invoices page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_invoices_title');
		$data['breadcrumbs'] = $this->lang->line('xin_invoices_title');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrsale_invoices';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('121',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/invoices_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// create invoice page
	public function create() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_invoice_create');
		$data['breadcrumbs'] = $this->lang->line('xin_invoice_create');
		$data['all_projects'] = $this->Project_model->get_projects();
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'create_hrsale_invoice';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('120',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/create_invoice", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	public function taxes()
     {
		$data['title'] = $this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Tax Types';
		$data['path_url'] = 'invoice_taxes';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('122',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/invoices/invoice_taxes", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 
	 public function taxes_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/invoices/invoice_taxes", $data);
		} else {
			redirect('admin/dashboard');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$taxes = $this->Invoices_model->get_taxes();
		
		$data = array();

          foreach($taxes->result() as $r) {
			
				// get type
				if($r->type == 'fixed'): $type = 'Fixed'; else: $type = 'Percentage'; endif;
					
				$data[] = array(
						'<span data-toggle="tooltip" data-placement="top" title="Edit"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-tax_id="'. $r->tax_id . '"><span class="fas fa-pencil-alt"></span></button></span><span data-toggle="tooltip" data-placement="top" title="Delete"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->tax_id . '"><span class="far fa-trash-alt"></span></button></span>',
						$r->name,
						$r->rate,
						$type
				   );
			  }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $taxes->num_rows(),
                 "recordsFiltered" => $taxes->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	 
	 // tax data
	public function tax_read()
	{
		
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('tax_id');
		$result = $this->Invoices_model->read_tax_information($id);
		$data = array(
				'tax_id' => $result[0]->tax_id,
				'name' => $result[0]->name,
				'rate' => $result[0]->rate,
				'type' => $result[0]->type,
				'description' => $result[0]->description
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/invoices/dialog_tax', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_tax() {
	
		if($this->input->post('add_type')=='tax') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('tax_name')==='') {
       		$Return['error'] = "The tax name field is required.";
		} else if($this->input->post('tax_rate')==='') {
			$Return['error'] = "The tax rate field is required.";
		} else if($this->input->post('tax_type')==='') {
			$Return['error'] = "The tax type field is required.";
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('tax_name'),
		'rate' => $this->input->post('tax_rate'),
		'type' => $this->input->post('tax_type'),
		'description' => $qt_description,
		'created_at' => date('d-m-Y h:i:s'),
		
		);
		$result = $this->Invoices_model->add_tax_record($data);
		
		if ($result == TRUE) {
			$Return['result'] = 'Product Tax added.';
		} else {
			$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update_tax() {
	
		if($this->input->post('edit_type')=='tax') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$id = $this->uri->segment(4);
			
		/* Server side PHP input validation */
		$description = $this->input->post('description');
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('tax_name')==='') {
       		$Return['error'] = "The tax name field is required.";
		} else if($this->input->post('tax_rate')==='') {
			$Return['error'] = "The tax rate field is required.";
		} else if($this->input->post('tax_type')==='') {
			$Return['error'] = "The tax type field is required.";
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'name' => $this->input->post('tax_name'),
		'rate' => $this->input->post('tax_rate'),
		'type' => $this->input->post('tax_type'),
		'description' => $qt_description		
		);
		$result = $this->Invoices_model->update_tax_record($data,$id);
		
		if ($result == TRUE) {
			$Return['result'] = 'Product Tax updated.';
		} else {
			$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$this->output($Return);
		exit;
		}
	}
	
	// edit invoice page
	public function edit() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$invoice_id = $this->uri->segment(4);
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		if(is_null($invoice_info)){
			redirect('admin/invoices');
		}
		// get project
		$project = $this->Project_model->read_project_information($invoice_info[0]->project_id);
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		$data = array(
			'title' => 'Edit Invoice #'.$invoice_info[0]->invoice_id,
			'breadcrumbs' => 'Edit Invoice',
			'path_url' => 'create_hrsale_invoice',
			'invoice_id' => $invoice_info[0]->invoice_id,
			'invoice_number' => $invoice_info[0]->invoice_number,
			'project_id' => $project[0]->project_id,
			'invoice_date' => $invoice_info[0]->invoice_date,
			'invoice_due_date' => $invoice_info[0]->invoice_due_date,
			'sub_total_amount' => $invoice_info[0]->sub_total_amount,
			'discount_type' => $invoice_info[0]->discount_type,
			'discount_figure' => $invoice_info[0]->discount_figure,
			'total_tax' => $invoice_info[0]->total_tax,
			'total_discount' => $invoice_info[0]->total_discount,
			'grand_total' => $invoice_info[0]->grand_total,
			'invoice_note' => $invoice_info[0]->invoice_note,
			'all_projects' => $this->Project_model->get_projects(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/edit_invoice", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	
	// view invoice page
	public function view() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$invoice_id = $this->uri->segment(4);
		$invoice_info = $this->Invoices_model->read_invoice_info($invoice_id);
		if(is_null($invoice_info)){
			redirect('admin/invoices');
		}
		// get project
		$project = $this->Project_model->read_project_information($invoice_info[0]->project_id);
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		
		$data = array(
			'title' => 'View Invoice #'.$invoice_info[0]->invoice_id,
			'breadcrumbs' => 'View Invoice',
			'path_url' => 'create_hrsale_invoice',
			'invoice_id' => $invoice_info[0]->invoice_id,
			'invoice_number' => $invoice_info[0]->invoice_number,
			'project_id' => $project[0]->project_id,
			'invoice_date' => $invoice_info[0]->invoice_date,
			'invoice_due_date' => $invoice_info[0]->invoice_due_date,
			'sub_total_amount' => $invoice_info[0]->sub_total_amount,
			'discount_type' => $invoice_info[0]->discount_type,
			'discount_figure' => $invoice_info[0]->discount_figure,
			'total_tax' => $invoice_info[0]->total_tax,
			'total_discount' => $invoice_info[0]->total_discount,
			'grand_total' => $invoice_info[0]->grand_total,
			'invoice_note' => $invoice_info[0]->invoice_note,
			'company_name' => $company[0]->company_name,
			'company_address' => $company[0]->address_1,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_phone' => $company[0]->phone,
			'company_country' => $ccountry[0]->country_name,
			'all_projects' => $this->Project_model->get_projects(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/invoices/invoice_view", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 
	public function invoices_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/invoices/invoices_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$client = $this->Invoices_model->get_invoices();
		
		$data = array();

          foreach($client->result() as $r) {
			  
			  // get country
			 $grand_total = $this->Xin_model->currency_sign($r->grand_total);
			  // get project
			  $project = $this->Project_model->read_project_information($r->project_id); 
			  if(!is_null($project)){
			  	$project_name = $project[0]->title;
			  } else {
				  $project_name = '--';	
			  }
			  $invoice_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_date);
			  $invoice_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_due_date);
			  //invoice_number
			  $invoice_number = '<a href="'.site_url().'admin/invoices/view/'.$r->invoice_id.'/">'.$r->invoice_number.'</a>';
               $data[] = array(
			   		'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/invoices/edit/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light"><span class="fas fa-pencil-alt"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/invoices/view/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->invoice_id . '"><span class="far fa-trash-alt"></span></button></span>',
                    $r->invoice_id,
					$invoice_number,
                    $project_name,
					$grand_total,
                    $invoice_date,
                    $invoice_due_date,
                    'Paid',
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $client->num_rows(),
                 "recordsFiltered" => $client->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	
	// Validate and add info in database
	public function create_new_invoice() {
	
		if($this->input->post('add_type')=='invoice_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */	
		
		 if($this->input->post('invoice_number')==='') {
       		$Return['error'] = "The invoice number field is required.";
		} else if($this->input->post('invoice_date')==='') {
       		$Return['error'] = "The invoice date field is required.";
		} else if($this->input->post('invoice_due_date')==='') {
			$Return['error'] = "The invoice due date field is required.";
		} else if($this->input->post('unit_price')==='') {
			$Return['error'] = "The invoice due date field is required.";
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$j=0; foreach($this->input->post('item_name') as $items){
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$j];
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$j];
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$j];
				
				if($iname==='') {
					$Return['error'] = "The Item field is required.";
				} else if($qty==='') {
					$Return['error'] = "The Qty/hrs field is required.";
				} else if($price==='' || $price===0) {
					$Return['error'] = $j. " The Price field is required.";
				}
				$j++;
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
				
		
	
		$data = array(
		'project_id' => $this->input->post('project'),
		'invoice_number' => $this->input->post('invoice_number'),
		'invoice_date' => $this->input->post('invoice_date'),
		'invoice_due_date' => $this->input->post('invoice_due_date'),
		'sub_total_amount' => $this->input->post('items_sub_total'),
		'total_tax' => $this->input->post('items_tax_total'),
		'discount_type' => $this->input->post('discount_type'),
		'discount_figure' => $this->input->post('discount_figure'),
		'total_discount' => $this->input->post('discount_amount'),
		'grand_total' => $this->input->post('fgrand_total'),
		'invoice_note' => $this->input->post('invoice_note'),
		'status' => '1',
		'created_at' => date('d-m-Y H:i:s')
		);
		$result = $this->Invoices_model->add_invoice_record($data);

		if ($result) {
			$key=0;
			foreach($this->input->post('item_name') as $items){

				/* get items info */
				// item name
				//$iname = $items['item_name']; 
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$key]; 
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$key]; 
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$key]; 
				// item tax_id
				$taxt = $this->input->post('tax_type');
				$tax_type = $taxt[$key]; 
				// item tax_rate
				$tax_rate_item = $this->input->post('tax_rate_item');
				$tax_rate = $tax_rate_item[$key];
				// item sub_total
				$sub_total_item = $this->input->post('sub_total_item');
				$item_sub_total = $sub_total_item[$key];
				// add values  
				$data2 = array(
				'invoice_id' => $result,
				'project_id' => $this->input->post('project'),
				'item_name' => $iname,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'created_at' => date('d-m-Y H:i:s')
				);
				$result_item = $this->Invoices_model->add_invoice_items_record($data2);
				
			$key++; }
			$Return['result'] = 'Invoice created.';
		} else {
			$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_invoice() {
	
		if($this->input->post('add_type')=='invoice_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->uri->segment(4);
	
		// add purchase items
		foreach($this->input->post('item') as $eitem_id=>$key_val){
			
			/* get items info */
			// item qty
			$item_name = $this->input->post('eitem_name');
			$iname = $item_name[$key_val]; 
			// item qty
			$qty = $this->input->post('eqty_hrs');
			$qtyhrs = $qty[$key_val]; 
			// item price
			$unit_price = $this->input->post('eunit_price');
			$price = $unit_price[$key_val]; 
			// item tax_id
			$taxt = $this->input->post('etax_type');
			$tax_type = $taxt[$key_val]; 
			// item tax_rate
			$tax_rate_item = $this->input->post('etax_rate_item');
			$tax_rate = $tax_rate_item[$key_val];
			// item sub_total
			$sub_total_item = $this->input->post('esub_total_item');
			$item_sub_total = $sub_total_item[$key_val];
			
			// update item values  
			$data = array(
				'item_name' => $iname,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
			);
			$result_item = $this->Invoices_model->update_invoice_items_record($data,$eitem_id);
			
		}
		
		////
		$data = array(
		'sub_total_amount' => $this->input->post('items_sub_total'),
		'total_tax' => $this->input->post('items_tax_total'),
		'discount_type' => $this->input->post('discount_type'),
		'discount_figure' => $this->input->post('discount_figure'),
		'total_discount' => $this->input->post('discount_amount'),
		'grand_total' => $this->input->post('fgrand_total'),
		'invoice_note' => $this->input->post('invoice_note'),
		);
		$result = $this->Invoices_model->update_invoice_record($data,$id);
	

		if($this->input->post('item_name')) {
			$key=0;
			foreach($this->input->post('item_name') as $items){

				/* get items info */
				// item name
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$key]; 
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$key]; 
				// item price
				$unit_price = $this->input->post('unit_price');
				$price = $unit_price[$key]; 
				// item tax_id
				$taxt = $this->input->post('tax_type');
				$tax_type = $taxt[$key]; 
				// item tax_rate
				$tax_rate_item = $this->input->post('tax_rate_item');
				$tax_rate = $tax_rate_item[$key];
				// item sub_total
				$sub_total_item = $this->input->post('sub_total_item');
				$item_sub_total = $sub_total_item[$key];
				// add values  
				$data2 = array(
				'invoice_id' => $id,
				'project_id' => $this->input->post('project'),
				'item_name' => $iname,
				'item_qty' => $qtyhrs,
				'item_unit_price' => $price,
				'item_tax_type' => $tax_type,
				'item_tax_rate' => $tax_rate,
				'item_sub_total' => $item_sub_total,
				'sub_total_amount' => $this->input->post('items_sub_total'),
				'total_tax' => $this->input->post('items_tax_total'),
				'discount_type' => $this->input->post('discount_type'),
				'discount_figure' => $this->input->post('discount_figure'),
				'total_discount' => $this->input->post('discount_amount'),
				'grand_total' => $this->input->post('fgrand_total'),
				'created_at' => date('d-m-Y H:i:s')
				);
				$result_item = $this->Invoices_model->add_invoice_items_record($data2);
				
			$key++; }
			$Return['result'] = 'Invoice updated.';
		} else {
			//$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$Return['result'] = 'Invoice updated.';
		$this->output($Return);
		exit;
		}
	}
	
	// delete a purchase record
	public function delete_item() {
		
		if($this->uri->segment(5) == 'isajax') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);
			
			$result = $this->Invoices_model->delete_invoice_items_record($id);
			if(isset($id)) {
				$Return['result'] = 'Invoice Item deleted.';
			} else {
				$Return['error'] = 'Bug. Something went wrong, please try again.';
			}
			$this->output($Return);
		}
	}
	
	// delete a purchase record
	public function delete() {
		
		if($this->input->post('is_ajax') == '2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);
			
			$result = $this->Invoices_model->delete_record($id);
			if(isset($id)) {
				$result_item = $this->Invoices_model->delete_invoice_items($id);
				$Return['result'] = 'Invoice deleted.';
			} else {
				$Return['error'] = 'Bug. Something went wrong, please try again.';
			}
			$this->output($Return);
		}
	}
	
	// delete a tax record
	public function tax_delete() {
		if($this->input->post('is_ajax')==='2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'');
			$id = $this->uri->segment(4);
			$result = $this->Invoices_model->delete_tax_record($id);
			if(isset($id)) {
				$Return['result'] = 'Tax deleted.';
			} else {
				$Return['error'] = 'Bug. Something went wrong, please try again.';
			}
			$this->output($Return);
		}
	}
} 
?>