<?php
/* Worksheets view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_worksheets');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
          <th><?php echo $this->lang->line('xin_end_date');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <th><?php echo $this->lang->line('xin_assigned_to');?></th>
          <th><?php echo $this->lang->line('xin_created_by');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
