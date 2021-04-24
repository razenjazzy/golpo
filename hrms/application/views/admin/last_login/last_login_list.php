<?php
/* Employees Last Login view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('left_employees_last_login');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_employees_id');?></th>
          <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
          <th><?php echo $this->lang->line('dashboard_username');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('dashboard_last_login');?> </th>
          <th><?php echo $this->lang->line('xin_employee_role');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
