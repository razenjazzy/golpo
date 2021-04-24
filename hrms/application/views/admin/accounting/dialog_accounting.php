<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['bankcash_id']) && $_GET['data']=='bankcash'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_edit_account');?></h4>
</div>
<?php $attributes = array('name' => 'bankcash_update', 'id' => 'bankcash_update', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $bankcash_id, 'ext_name' => $account_name);?>
<?php echo form_open('admin/accounting/bankcash_update/'.$bankcash_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="account_name"><?php echo $this->lang->line('xin_acc_account_name');?></label>
          <input type="text" class="form-control" name="account_name" placeholder="<?php echo $this->lang->line('xin_acc_account_name');?>" value="<?php echo $account_name;?>">
        </div>
        <div class="form-group">
          <label for="account_balance"><?php echo $this->lang->line('xin_acc_initial_balance');?></label>
          <input type="number" class="form-control" name="account_balance" placeholder="<?php echo $this->lang->line('xin_acc_initial_balance');?>" value="<?php echo $account_balance;?>">
        </div>
        <div class="form-group">
          <label for="account_number"><?php echo $this->lang->line('xin_e_details_acc_number');?></label>
          <input type="text" class="form-control" name="account_number" placeholder="<?php echo $this->lang->line('xin_e_details_acc_number');?>" value="<?php echo $account_number;?>">
        </div>
        <div class="form-group">
          <label for="branch_code"><?php echo $this->lang->line('xin_acc_branch_code');?></label>
          <input type="text" class="form-control" name="branch_code" placeholder="<?php echo $this->lang->line('xin_acc_branch_code');?>" value="<?php echo $branch_code;?>">
        </div>
      </div>
      <div class="col-md-6">
        <label for="description"><?php echo $this->lang->line('xin_e_details_bank_branch');?></label>
        <textarea class="form-control" name="bank_branch" placeholder="<?php echo $this->lang->line('xin_e_details_bank_branch');?>" rows="5"><?php echo $bank_branch;?></textarea>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){ 

		/* Edit data */
		$("#bankcash_update").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=bankcash&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/accounting/bank_cash_list") ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
					}
				}
			});
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['deposit_id']) && $_GET['data']=='deposit'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_edit_deposit');?></h4>
</div>
<?php $attributes = array('name' => 'deposit_update', 'id' => 'deposit_update', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $deposit_id, 'ext_name' => $deposit_id);?>
<?php echo form_open('admin/accounting/deposit_update/'.$deposit_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="award_type"><?php echo $this->lang->line('xin_acc_account');?></label>
          <select name="bank_cash_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
            <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($account_type_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->account_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('xin_amount');?></label>
              <input class="form-control" name="amount" type="text" value="<?php echo $amount;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="deposit_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="deposit_date" type="text" value="<?php echo $deposit_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="employee"><?php echo $this->lang->line('xin_acc_category');?></label>
              <select name="category_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_category');?>">
                <option value=""></option>
                <?php foreach($all_income_categories_list as $income_category) {?>
                <option value="<?php echo $income_category->category_id;?>" <?php if($categoryid==$income_category->category_id):?> selected="selected"<?php endif;?>> <?php echo $income_category->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="employee"><?php echo $this->lang->line('xin_acc_payer');?></label>
              <select name="payer_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_payer');?>">
                <option value=""></option>
                <?php foreach($all_payers as $payer) {?>
                <option value="<?php echo $payer->payer_id;?>" <?php if($payer_id==$payer->payer_id):?> selected="selected"<?php endif;?>> <?php echo $payer->payer_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
          <select name="payment_method" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_payment_method');?>">
            <option value=""></option>
            <?php foreach($get_all_payment_method as $payment_method) {?>
            <option value="<?php echo $payment_method->payment_method_id;?>" <?php if($payment_method_id==$payment_method->payment_method_id):?> selected="selected"<?php endif;?>> <?php echo $payment_method->method_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="employee"><?php echo $this->lang->line('xin_acc_ref_no');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_ref_example');?>" name="deposit_reference" type="text" value="<?php echo $deposit_reference;?>">
          <br />
        </div>
      </div>
      <div class="col-md-6">
        <div class='form-group'>
          <div>
            <label for="photo"><?php echo $this->lang->line('xin_acc_attach_file');?></label>
          </div>
          <span class="btn btn-primary btn-file"> <?php echo $this->lang->line('xin_browse');?>
          <input type="file" name="deposit_file" id="deposit_file">
          </span>
          <?php if($deposit_file!='' && $deposit_file!='no_file'):?>
          <br>
          <a href="<?php echo site_url()?>download?type=finance/deposit&filename=<?php echo $deposit_file;?>"><?php echo $this->lang->line('xin_download');?></a>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){ 

		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').trumbowyg();
				
		$('.d_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
		});
		
		/* Edit data */
		$("#deposit_update").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'deposit');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						$('.icon-spinner3').hide();
				} else {
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/accounting/deposit_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} 	        
	   });
	});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['expense_id']) && $_GET['data']=='expense'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_expense');?></h4>
</div>
<?php $attributes = array('name' => 'expense_update', 'id' => 'expense_update', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $expense_id, 'ext_name' => $expense_id);?>
<?php echo form_open('admin/accounting/expense_update/'.$expense_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="award_type"><?php echo $this->lang->line('xin_acc_account');?></label>
          <select name="bank_cash_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
            <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($account_type_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->account_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('xin_amount');?></label>
              <input class="form-control" name="amount" type="text" value="<?php echo $amount;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="deposit_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="expense_date" type="text" value="<?php echo $expense_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="employee"><?php echo $this->lang->line('xin_acc_category');?></label>
              <select name="category_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_category');?>">
                <option value=""></option>
                <?php foreach($all_expense_types as $expense_type) {?>
                <option value="<?php echo $expense_type->expense_type_id;?>" <?php if($categoryid==$expense_type->expense_type_id):?> selected="selected"<?php endif;?>> <?php echo $expense_type->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="employee"><?php echo $this->lang->line('xin_acc_payee');?></label>
              <select name="payee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_payee');?>">
                <option value=""></option>
                <?php foreach($all_payees as $payee) {?>
                <option value="<?php echo $payee->payee_id;?>" <?php if($payee_id==$payee->payee_id):?> selected="selected"<?php endif;?>> <?php echo $payee->payee_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
          <select name="payment_method" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_payment_method');?>">
            <option value=""></option>
            <?php foreach($get_all_payment_method as $payment_method) {?>
            <option value="<?php echo $payment_method->payment_method_id;?>" <?php if($payment_method_id==$payment_method->payment_method_id):?> selected="selected"<?php endif;?>> <?php echo $payment_method->method_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="expense_reference"><?php echo $this->lang->line('xin_acc_ref_no');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_ref_example');?>" name="expense_reference" type="text" value="<?php echo $expense_reference;?>">
          <br />
        </div>
      </div>
      <div class="col-md-6">
        <div class='form-group'>
          <div>
            <label for="photo"><?php echo $this->lang->line('xin_acc_attach_file');?></label>
          </div>
          <span class="btn btn-primary btn-file"> <?php echo $this->lang->line('xin_browse');?>
          <input type="file" name="expense_file" id="expense_file">
          </span>
          <?php if($expense_file!='' && $expense_file!='no_file'):?>
          <br>
          <a href="<?php echo site_url()?>download?type=accounting/expense&filename=<?php echo $expense_file;?>"><?php echo $this->lang->line('xin_download');?></a>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){ 

		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').trumbowyg();
		
		$('.d_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
		});
		
		/* Edit data */
		$("#expense_update").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'expense');
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						$('.icon-spinner3').hide();
				} else {
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/accounting/expense_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.icon-spinner3').hide();
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} 	        
	   });
	});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['transfer_id']) && $_GET['data']=='transfer'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_transfer');?></h4>
</div>
<?php $attributes = array('name' => 'transfer_update', 'id' => 'transfer_update', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $transfer_id, 'ext_name' => $transfer_id);?>
<?php echo form_open('admin/accounting/transfer_update/'.$transfer_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="bank_cash_id"><?php echo $this->lang->line('xin_acc_from_account');?></label>
          <select disabled="disabled" name="from_bank_cash_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
            <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($from_account_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->account_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="transfer_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
          <input class="form-control d_date" placeholder="<?php echo date('Y-m-d');?>" readonly name="transfer_date" type="text" value="<?php echo $transfer_date;?>">
        </div>
        <div class="form-group">
          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
          <select name="payment_method" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_payment_method');?>">
            <option value=""></option>
            <?php foreach($get_all_payment_method as $payment_method) {?>
            <option value="<?php echo $payment_method->payment_method_id;?>" <?php if($payment_method_id==$payment_method->payment_method_id):?> selected="selected"<?php endif;?>> <?php echo $payment_method->method_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="bank_cash_id"><?php echo $this->lang->line('xin_acc_to_account');?></label>
          <select disabled="disabled" name="to_bank_cash_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
            <option value=""></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
            <option value="<?php echo $bank_cash->bankcash_id;?>" <?php if($to_account_id==$bank_cash->bankcash_id):?> selected="selected"<?php endif;?>><?php echo $bank_cash->account_name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="month_year"><?php echo $this->lang->line('xin_amount');?></label>
          <input disabled="disabled" class="form-control" name="amount" type="text" value="<?php echo $transfer_amount;?>">
        </div>
        <div class="form-group">
          <label for="transfer_reference"><?php echo $this->lang->line('xin_acc_ref_no');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_ref_example');?>" name="transfer_reference" type="text" value="<?php echo $transfer_reference;?>">
          <br />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){ 

		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').trumbowyg();
		
		$('.d_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
		});
		
		$("#transfer_update").submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=transfer&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/accounting/transfer_list") ?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
				}
			}
		});
	});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['payer_id']) && $_GET['data']=='payer'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_edit_payer');?></h4>
</div>
<?php $attributes = array('name' => 'update_payer', 'id' => 'update_payer', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $payer_id, 'ext_name' => $payer_name);?>
<?php echo form_open('admin/accounting/update_payer/'.$payer_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="payer_name"><?php echo $this->lang->line('xin_acc_payer');?></label>
          <input type="text" class="form-control" name="payer_name" placeholder="<?php echo $this->lang->line('xin_acc_payer_name');?>" value="<?php echo $payer_name;?>">
        </div>
        <div class="form-group">
          <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
          <input type="number" class="form-control" name="contact_number" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" value="<?php echo $contact_number;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){ 

		/* Edit data */
		$("#update_payer").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=payer&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/accounting/payers_list") ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.payroll_template_modal').modal('toggle');
						$('.save').prop('disabled', false);
					}
				}
			});
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['payee_id']) && $_GET['data']=='payee'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_acc_edit_payee');?></h4>
</div>
<?php $attributes = array('name' => 'update_payee', 'id' => 'update_payee', 'autocomplete' => 'off');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $payee_id, 'ext_name' => $payee_name);?>
<?php echo form_open('admin/accounting/update_payee/'.$payee_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="payee_name"><?php echo $this->lang->line('xin_acc_payee');?></label>
          <input type="text" class="form-control" name="payee_name" placeholder="<?php echo $this->lang->line('xin_acc_payee_name');?>" value="<?php echo $payee_name;?>">
        </div>
        <div class="form-group">
          <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
          <input type="number" class="form-control" name="contact_number" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" value="<?php echo $contact_number;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){ 

		/* Edit data */
		$("#update_payee").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=payee&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/accounting/payees_list") ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.payroll_template_modal').modal('toggle');
						$('.save').prop('disabled', false);
					}
				}
			});
		});
	});	
  </script>
<?php }
?>
