<?php
/* Invoice view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system_setting = $this->Xin_model->read_setting_info(1);?>
<?php
// get project
	$project = $this->Project_model->read_project_information($project_id);
	$result2 = $this->Clients_model->read_client_info($project[0]->client_id);
	if(!is_null($result2)) {
		$client_name = $result2[0]->name;
		$client_contact_number = $result2[0]->contact_number;
		$client_company_name = $result2[0]->company_name;
		$client_website_url = $result2[0]->website_url;
		$client_address_1 = $result2[0]->address_1;
		$client_address_2 = $result2[0]->address_2;
		$client_country = $result2[0]->country;
		$client_city = $result2[0]->city;
		$client_zipcode = $result2[0]->zipcode;
	} else {
		$client_name = '--';
	}
?>

<div class="card">
              <div class="card-body p-5" id="print_invoice_hr">

                <div class="row">
                  <div class="col-md-6 pb-4">

                    <div class="media align-items-center mb-4">
                      <div class="ui-w-40">
                        <div class="w-100 position-relative" style="padding-bottom: 54%">
                          <img src="<?php echo base_url('uploads/logo/payroll/').$system_setting[0]->payroll_logo;?>" alt="<?php echo $company_name;?>" class="">
                        </div>
                      </div>
                    </div>
                    
                    <div class="mb-1"><?php echo $company_address;?></div>
                    <div class="mb-1"><?php echo $company_zipcode;?>, <?php echo $company_city;?>, <?php echo $company_country;?></div>
                    <div><?php echo $company_phone;?></div>

                  </div>

                  <div class="col-md-6 text-right pb-4">

                    <h6 class="text-big text-large font-weight-bold mb-3">Invoice #<?php echo $invoice_number;?></h6>
                    <div class="mb-1">Date:
                      <strong class="font-weight-semibold"><?php echo $this->Xin_model->set_date_format($invoice_date);?></strong>
                    </div>
                    <div>Due date:
                      <strong class="font-weight-semibold"><?php echo $this->Xin_model->set_date_format($invoice_due_date);?></strong>
                    </div>

                  </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div class="font-weight-bold mb-2">Invoice To:</div>
                    <div><?php echo $client_name;?></div>
                    <div><?php echo $client_company_name;?></div>
                    <div><?php echo $client_address_1.' '.$client_address_2;?></div>
                    <div><?php echo $client_city;?></div>
                    <div><?php echo $client_website_url;?></div>
                    <div><?php echo $client_contact_number;?></div>

                  </div>
                  <div class="col-md-6 mb-4">                    
                    <div class="font-weight-bold mb-2">From:</div>
                    <table>
                      <tbody>
                        <tr>
                          <td class="pr-3"><?php echo $company_name;?></td>
                        </tr>
                        <tr>
                          <td class="pr-3"><?php echo $company_address;?></td>
                        </tr>
                        <tr>
                          <td class="pr-3"><?php echo $company_zipcode;?>, <?php echo $company_city;?></td>
                        </tr>
                        <tr>
                          <td class="pr-3"><?php echo $company_country;?></td>
                        </tr>
                        <tr>
                          <td class="pr-3"><?php echo $company_phone;?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                        
                <div class="table-responsive mb-4">
                  <table class="table m-0">
                    <thead>
                      <tr>
                        <th class="py-3">
                          #
                        </th>
                        <th class="py-3">
                          Item
                        </th>
                        <th class="py-3">
                          Tax Rate
                        </th>
                        <th class="py-3">
                          Qty/Hrs
                        </th>
                        <th class="py-3">
                          Unit Price
                        </th>
                        <th class="py-3">
                          Subtotal
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
						$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
						$sc_show = $ar_sc[1];
						?>
                      <?php $prod = array(); $i=1; foreach($this->Invoices_model->get_invoice_items($invoice_id) as $_item):?>
                      <tr>
                        <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div>
                        </td>
                        <td class="py-3" style="width:">
                          <div class="font-weight-semibold"><?php echo $_item->item_name;?></div>
                        </td>
                        <td class="py-3">
                          <strong><?php echo $this->Xin_model->currency_sign($_item->item_tax_rate);?></strong>
                        </td>
                        <td class="py-3">
                          <strong><?php echo $_item->item_qty;?></strong>
                        </td>
                        <td class="py-3">
                          <strong><?php echo $this->Xin_model->currency_sign($_item->item_unit_price);?></strong>
                        </td>
                        <td class="py-3">
                          <strong><?php echo $this->Xin_model->currency_sign($_item->item_sub_total);?></strong>
                        </td>
                      </tr>
                      <?php $i++; endforeach;?>
                      <tr>
                        <td colspan="5" class="text-right py-3">
                          Sub Total:
                          <br> TAX:
                          <br> Discount:
                          <br />
                          <span class="d-block text-big mt-2">Total:</span>
                        </td>
                        <td class="py-3">
                          <strong><?php echo $this->Xin_model->currency_sign($sub_total_amount);?></strong>
                          <br>
                          <strong><?php echo $this->Xin_model->currency_sign($total_tax);?></strong>
                          <br>
                          <strong><?php echo $this->Xin_model->currency_sign($total_discount);?></strong>
                          <br>
                          <strong class="d-block text-big mt-2"><?php echo $this->Xin_model->currency_sign($grand_total);?></strong>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="text-muted">
                  <strong>Note:</strong> <?php echo $invoice_note;?>
                </div>

              </div>
              <div class="card-footer text-right">

                <a href="javascript:void(0);" target="_blank" class="btn btn-default print-invoice">
                  <i class="ion ion-md-print"></i>&nbsp; Print</a>
              </div>
            </div>