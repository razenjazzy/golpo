<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_assets');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_asset_name');?></th>
          <th><?php echo $this->lang->line('xin_acc_category');?></th>
          <th><?php echo $this->lang->line('xin_company_asset_code');?></th>
          <th><?php echo $this->lang->line('xin_is_working');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
