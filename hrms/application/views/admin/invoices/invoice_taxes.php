<?php
/* Catalog > Product Tax view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-4">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> Tax<?php //echo $this->lang->line('xin_department');?> </h6>
      <div class="card-body">

        <?php $attributes = array('name' => 'add_tax', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/invoices/add_tax', $attributes, $hidden);?>
        <div class="form-group">
          <label for="tax_name">Tax Name</label>
          <input type="text" class="form-control" name="tax_name" placeholder="Tax Name">
        </div>
        <div class="form-group">
          <label for="tax_rate">Tax Rate</label>
          <input type="text" class="form-control" name="tax_rate" placeholder="Tax Rate">
        </div>
        <div class="form-group">
          <label for="tax_type">Tax Type</label>
          <select class="form-control" name="tax_type" data-plugin="select_hrm" data-placeholder="Tax Type">
            <option value=""></option>
            <option value="fixed">Fixed</option>
            <option value="percentage">Percentage</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" placeholder="Description" name="description" id="description"></textarea>
        </div>
        <div class="form-actions">
		  <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> Taxes<?php //echo $this->lang->line('xin_departments');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th>Action</th>
              <th>Tax Name</th>
              <th>Tax Rate</th>
              <th>Tax Type</th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- responsive --> 
    </div>
  </div>
</div>
