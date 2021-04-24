<?php
/* Employee Exit view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_employee_exit');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_exit', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/employee_exit/add_exit', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_employee_to_exit');?></label>
                  <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exit_date"><?php echo $this->lang->line('xin_exit_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_exit_date');?>" readonly name="exit_date" type="text">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="type"><?php echo $this->lang->line('xin_type_of_exit');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_type_of_exit');?>" name="type">
                        <option value=""></option>
                        <?php foreach($all_exit_types as $exit_type) {?>
                        <option value="<?php echo $exit_type->exit_type_id?>"><?php echo $exit_type->type;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exit_interview"><?php echo $this->lang->line('xin_exit_interview');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_exit_interview');?>" name="exit_interview">
                        <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                        <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="is_inactivate_account"><?php echo $this->lang->line('xin_exit_inactive_employee_account');?></label>
                      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_exit_inactive_employee_account');?>" name="is_inactivate_account">
                        <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                        <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="reason" cols="30" rows="10" id="reason"></textarea>
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
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_employee_exit');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th style="width:96px;"><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
          <th><?php echo $this->lang->line('xin_exit_type');?></th>
          <th><?php echo $this->lang->line('xin_exit_date');?></th>
          <th><?php echo $this->lang->line('xin_exit_interview');?></th>
          <th><?php echo $this->lang->line('xin_in_active_account');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
