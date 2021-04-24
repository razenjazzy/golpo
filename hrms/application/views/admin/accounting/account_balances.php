<?php
/*
* Account Balances - Finance View
*/
$session = $this->session->userdata('username');
$currency = $this->Xin_model->currency_sign(0);
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $bankcash = $this->Finance_model->get_bankcash();?>
<?php
$account_balance = 0;;
foreach($bankcash->result() as $r) {
	// account balance
	$account_balance += $r->account_balance;
}
?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_acc_account_balances');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <input type="hidden" id="current_currency" value="<?php $curr = explode('0',$currency); echo $curr[0];?>" />
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_acc_account');?></th>
          <th><?php echo $this->lang->line('xin_acc_balance');?></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="1" style="text-align:right"><?php echo $this->lang->line('xin_acc_total');?>:</th>
          <th><?php echo $this->Xin_model->currency_sign($account_balance);?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
