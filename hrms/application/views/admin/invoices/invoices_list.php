<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_invoices_title');?></span>
    <div class="card-header-elements ml-md-auto">
      <button type="button" class="btn btn-xs btn-outline-primary" onclick="window.location='<?php echo site_url('admin/invoices/create/')?>'"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_invoice_create');?></button>
    </div>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th>ID
            <?php //echo $this->lang->line('xin_client_name');?></th>
          <th>Invoice#
            <?php //echo $this->lang->line('xin_client_name');?></th>
          <th><?php echo $this->lang->line('xin_project');?></th>
          <th>Total
            <?php //echo $this->lang->line('xin_email');?></th>
          <th>Invoice Date
            <?php //echo $this->lang->line('xin_website');?></th>
          <th>Due Date
            <?php //echo $this->lang->line('xin_city');?></th>
          <th>Status
            <?php //echo $this->lang->line('xin_country');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
