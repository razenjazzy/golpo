<?php
/* Performance Appraisals view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_performance_apps');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
          <th><?php echo $this->lang->line('left_department');?></th>
          <th><?php echo $this->lang->line('dashboard_designation');?></th>
          <th><?php echo $this->lang->line('xin_performance_app_date');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
