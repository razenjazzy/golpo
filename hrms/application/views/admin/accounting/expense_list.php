<?php
/* Accounting > New Expense view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_expense');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_expense', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/accounting/add_expense', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="bank_cash_id"><?php echo $this->lang->line('xin_acc_account');?> <span id="acc_balance" style="display:none; font-weight:600; color:#F00;"></span></label>
                  <select name="bank_cash_id" id="select2-demo-6" class="from-account form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_account_type');?>">
                    <option value=""></option>
                    <?php foreach($all_bank_cash as $bank_cash) {?>
                    <option value="<?php echo $bank_cash->bankcash_id;?>" account-balance="<?php echo $bank_cash->account_balance;?>"><?php echo $bank_cash->account_name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="month_year"><?php echo $this->lang->line('xin_amount');?></label>
                      <input class="form-control" name="amount" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="expense_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                      <input class="form-control date" placeholder="<?php echo date('Y-m-d');?>" readonly name="expense_date" type="text">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="hidden" name="account_balance" id="account_balance" value="" />
                      <label for="employee"><?php echo $this->lang->line('xin_acc_category');?></label>
                      <select name="category_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_category');?>">
                        <option value=""></option>
                        <?php foreach($all_expense_types as $expense_type) {?>
                        <option value="<?php echo $expense_type->expense_type_id;?>"> <?php echo $expense_type->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="employee"><?php echo $this->lang->line('xin_acc_payee');?></label>
                      <select name="payee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_choose_a_payee');?>">
                        <option value=""></option>
                        <?php foreach($all_payees as $payee) {?>
                        <option value="<?php echo $payee->payee_id;?>"> <?php echo $payee->payee_name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
                  <select name="payment_method" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_payment_method');?>">
                    <option value=""></option>
                    <?php foreach($get_all_payment_method as $payment_method) {?>
                    <option value="<?php echo $payment_method->payment_method_id;?>"> <?php echo $payment_method->method_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="expense_reference"><?php echo $this->lang->line('xin_acc_ref_no');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_ref_example');?>" name="expense_reference" type="text">
                  <br />
                </div>
              </div>
              <div class="col-md-6">
                <div class='form-group'>
                  <fieldset class="form-group">
                    <label for="logo"><?php echo $this->lang->line('xin_acc_attach_file');?></label>
                    <input type="file" class="form-control-file" id="expense_file" name="expense_file">
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_acc_expense');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_acc_account');?></th>
          <th><?php echo $this->lang->line('xin_acc_payee');?></th>
          <th><?php echo $this->lang->line('xin_amount');?></th>
          <th><?php echo $this->lang->line('xin_acc_category');?></th>
          <th><?php echo $this->lang->line('xin_acc_ref_no');?></th>
          <th><?php echo $this->lang->line('xin_acc_payment');?></th>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
