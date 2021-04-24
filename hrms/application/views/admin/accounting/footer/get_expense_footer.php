<?php $expense = $this->Finance_model->get_expense_search($from_date,$to_date,$type_id);?>
<?php
$total_amount = 0;
foreach($expense->result() as $r) {
	// amount
	$total_amount += $r->amount;
}
?>

<tr>
  <th colspan="5">&nbsp;</th>
  <th><?php echo $this->lang->line('xin_acc_total');?>: <?php echo $this->Xin_model->currency_sign($total_amount);?></th>
</tr>
