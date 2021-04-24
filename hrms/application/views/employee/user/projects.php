<?php
/* Projects view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_projects');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_project_summary');?></th>
          <th><?php echo $this->lang->line('xin_p_priority');?></th>
          <th><?php echo $this->lang->line('xin_p_enddate');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
          <th><?php echo $this->lang->line('xin_project_users');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
