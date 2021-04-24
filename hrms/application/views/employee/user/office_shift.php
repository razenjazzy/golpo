<?php
/* Office Shift view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('dashboard_office_shift');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('left_office_shift');?></th>
          <th><?php echo $this->lang->line('xin_e_details_duration');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
