<?php
/* Warning view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_warnings');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_warning_date');?></th>
          <th><?php echo $this->lang->line('xin_subject');?></th>
          <th><?php echo $this->lang->line('xin_warning_type');?></th>
          <th><?php echo $this->lang->line('xin_approval_status');?></th>
          <th><?php echo $this->lang->line('xin_warning_by');?></th>
          <th><?php echo $this->lang->line('xin_details');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
