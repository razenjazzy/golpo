<?php
/* Promotion view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_promotions');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_employee_name');?></th>
          <th><?php echo $this->lang->line('xin_promotion_title');?></th>
          <th><?php echo $this->lang->line('xin_promotion_date');?></th>
          <th><?php echo $this->lang->line('xin_added_by');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
