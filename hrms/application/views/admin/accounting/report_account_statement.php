<?php
/* Accounting > Account Statement view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $transaction = $this->Finance_model->get_transactions();?>
<?php
$balance2 = 0; $total_amount = 0; $transaction_credit = 0; $transaction_debit = 0;
foreach($transaction->result() as $r) {
	// balance
	if($r->transaction_debit == 0) {
		$balance2 = $balance2 - $r->transaction_credit;
	} else {
		$balance2 = $balance2 + $r->transaction_debit;
	}
	// total amount
	$total_amount += $r->total_amount;
	// credit
	$transaction_credit += $r->transaction_credit;
	// debit
	$transaction_debit += $r->transaction_debit;
}
?>

<div class="card mb-4">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_acc_account_statement');?> </h6>
  <div class="card-body">
    <?php $attributes = array('name' => 'report_account_statement', 'id' => 'hrm-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('re_user_id' => $session['user_id']);?>
    <?php echo form_open('admin/accounting/report_statement_list', $attributes, $hidden);?>
    <?php
				$data = array(
				  'name'        => 'user_id',
				  'id'          => 'user_id',
				  'type'       => 'hidden',
				  'value'   => $session['user_id'],
				  'class'       => 'form-control',
				);
			
			echo form_input($data);
			?>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <select name="account_id" id="account_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_select_account');?>">
            <option value="0"><?php echo $this->lang->line('xin_acc_all_accounts');?></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
            <option value="<?php echo $bank_cash->bankcash_id;?>"> <?php echo $bank_cash->account_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_frm_date');?>" readonly id="from_date" name="from_date" type="text" value="<?php echo date('Y-m-d')?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_to_date');?>" readonly id="to_date" name="to_date" type="text" value="<?php echo date('Y-m-d')?>">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <select name="type_id" id="type_id" class="form-control" data-plugin="select_hrm" data-placeholder="xin_acc_select_type">
            <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            <option value="1"><?php echo $this->lang->line('xin_acc_deposit');?></option>
            <option value="2"><?php echo $this->lang->line('xin_acc_expense');?></option>
            <option value="3"><?php echo $this->lang->line('xin_acc_transfer');?></option>
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_get');?></button>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_acc_account_statement');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
          <th><?php echo $this->lang->line('xin_acc_account');?></th>
          <th><?php echo $this->lang->line('xin_description');?></th>
          <th><?php echo $this->lang->line('xin_acc_credit');?></th>
          <th><?php echo $this->lang->line('xin_acc_debit');?></th>
          <th><?php echo $this->lang->line('xin_acc_balance');?></th>
        </tr>
      </thead>
      <tfoot id="get_footer">
      </tfoot>
    </table>
  </div>
</div>
