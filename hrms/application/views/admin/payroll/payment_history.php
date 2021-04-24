<?php
/* Payment History view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_payment_history');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('dashboard_employee_id');?></th>
          <th><?php echo $this->lang->line('xin_employee_name');?></th>
          <th><?php echo $this->lang->line('xin_paid_amount');?></th>
          <th><?php echo $this->lang->line('xin_payment_month');?></th>
          <th><?php echo $this->lang->line('xin_payment_date');?></th>
          <th><?php echo $this->lang->line('xin_payment_type');?></th>
          <th><?php echo $this->lang->line('xin_payslip');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
