<?php
/* Expense view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Exin_model->read_employee_info($session['user_id']);?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_expense');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_expense', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id'],'company_id' => $user_info[0]->company_id,'employee_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/user/add_expense', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="expense_type"><?php echo $this->lang->line('xin_expense_type');?></label>
                <select name="expense_type" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_expense_type');?>...">
                  <option value=""></option>
                  <?php foreach($all_expense_types as $expense_type) {?>
                  <option value="<?php echo $expense_type->expense_type_id;?>"><?php echo $expense_type->name;?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="purchase_date"><?php echo $this->lang->line('xin_purchase_date');?></label>
                    <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_purchase_date');?>" readonly name="purchase_date" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="amount"><?php echo $this->lang->line('xin_amount');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="number" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_bill_copy');?></label>
                      <input type="file" class="form-control-file" id="bill_copy" name="bill_copy">
                      <small><?php echo $this->lang->line('xin_expense_allow_files');?></small>
                    </fieldset>
                  </div>
                </div>
              </div>
              <div class="add_billycopy_fields"></div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="description"><?php echo $this->lang->line('xin_remarks');?></label>
                <textarea class="form-control textarea" name="remarks" cols="25" rows="6" id="description"></textarea>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_expenses');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
          <th><?php echo $this->lang->line('xin_expense');?></th>
          <th><?php echo $this->lang->line('xin_amount');?></th>
          <th><?php echo $this->lang->line('xin_purchase_date');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
