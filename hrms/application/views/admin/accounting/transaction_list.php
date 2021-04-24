<?php
/*
* All Transactions - Finance View
*/
$session = $this->session->userdata('username');
$currency = $this->Xin_model->currency_sign(0);
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
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

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_acc_transactions');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <input type="hidden" id="current_currency" value="<?php $curr = explode('0',$currency); echo $curr[0];?>" />
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
          <th><?php echo $this->lang->line('xin_acc_accounts');?></th>
          <th><?php echo $this->lang->line('xin_type');?></th>
          <th><?php echo $this->lang->line('xin_amount');?></th>
          <th><?php echo $this->lang->line('xin_acc_credit');?></th>
          <th><?php echo $this->lang->line('xin_acc_debit');?></th>
          <th><?php echo $this->lang->line('xin_acc_balance');?></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="3">&nbsp;</th>
          <th><?php echo $this->lang->line('xin_total_amount');?>: <?php echo $this->Xin_model->currency_sign($total_amount);?></th>
          <th><?php echo $this->lang->line('xin_acc_credit');?>: <?php echo $this->Xin_model->currency_sign($transaction_credit);?></th>
          <th><?php echo $this->lang->line('xin_acc_debit');?>: <?php echo $this->Xin_model->currency_sign($transaction_debit);?></th>
          <th><?php echo $this->lang->line('xin_acc_balance');?>: <?php echo $this->Xin_model->currency_sign($balance2);?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
