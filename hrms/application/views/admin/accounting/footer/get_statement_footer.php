<?php $account_statement = $this->Finance_model->account_statement_search($from_date,$to_date,$account_id,$type_id);?>
<?php
$balance2 = 0; $transaction_credit = 0; $transaction_debit = 0;
foreach($account_statement->result() as $r) {
	// balance
	if($r->transaction_debit == 0) {
		$balance2 = $balance2 - $r->transaction_credit;
	} else {
		$balance2 = $balance2 + $r->transaction_debit;
	}
	// credit
	$transaction_credit += $r->transaction_credit;
	// debit
	$transaction_debit += $r->transaction_debit;
}
?>
<tr>
  <th colspan="3">&nbsp;</th>
  <th><?php echo $this->lang->line('xin_acc_credit');?>: <?php echo $this->Xin_model->currency_sign($transaction_credit);?></th>
  <th><?php echo $this->lang->line('xin_acc_debit');?>: <?php echo $this->Xin_model->currency_sign($transaction_debit);?></th>
  <th><?php echo $this->lang->line('xin_acc_balance');?>: <?php echo $this->Xin_model->currency_sign($balance2);?></th>
</tr>