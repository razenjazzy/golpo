<?php
/* Awards view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_awards');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('dashboard_employee_id');?></th>
          <th><?php echo $this->lang->line('xin_employee_name');?></th>
          <th><?php echo $this->lang->line('xin_award_name');?></th>
          <th><?php echo $this->lang->line('xin_gift');?></th>
          <th><?php echo $this->lang->line('xin_cash_price');?></th>
          <th><?php echo $this->lang->line('xin_award_month_year');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
