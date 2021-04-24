<?php
/* Training view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_training');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_employee');?></th>
          <th><?php echo $this->lang->line('left_training_type');?></th>
          <th><?php echo $this->lang->line('xin_trainer');?></th>
          <th><?php echo $this->lang->line('xin_training_duration');?></th>
          <th><?php echo $this->lang->line('xin_cost');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
