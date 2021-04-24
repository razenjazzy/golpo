<?php
/* Employees view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_employee');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/employees/add_employee', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="">
                  </div>
                </div>
              </div>
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
                </div>
                <div class="col-md-6">
                  <div class="form-group" id="department_ajax">
                    <label for="department"><?php echo $this->lang->line('xin_employee_department');?></label>
                    <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username"><?php echo $this->lang->line('dashboard_username');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date_of_birth"><?php echo $this->lang->line('xin_employee_dob');?></label>
                    <input class="form-control date_of_birth" readonly placeholder="<?php echo $this->lang->line('xin_employee_dob');?>" name="date_of_birth" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_no" class="control-label"><?php echo $this->lang->line('xin_contact_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_no" type="text" value="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="employee_id"><?php echo $this->lang->line('dashboard_employee_id');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_employee_id');?>" name="employee_id" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date_of_joining" class="control-label"><?php echo $this->lang->line('xin_employee_doj');?></label>
                    <input class="form-control date_of_joining" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="date_of_joining" type="text" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6" id="designation_ajax">
                  <div class="form-group">
                    <label for="designation"><?php echo $this->lang->line('xin_designation');?></label>
                    <select class="form-control" name="designation_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="role"><?php echo $this->lang->line('xin_employee_role');?></label>
                    <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_role');?>">
                      <option value=""></option>
                      <?php foreach($all_user_roles as $role) {?>
                      <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                    <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                      <option value="Male"><?php echo $this->lang->line('xin_gender_male');?></option>
                      <option value="Female"><?php echo $this->lang->line('xin_gender_female');?></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="office_shift_id" class="control-label"><?php echo $this->lang->line('xin_employee_office_shift');?></label>
                    <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_office_shift');?>">
                      <?php foreach($all_office_shifts as $shift) {?>
                      <option value="<?php echo $shift->office_shift_id?>"><?php echo $shift->shift_name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="xin_employee_password"><?php echo $this->lang->line('xin_employee_password');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="confirm_password" class="control-label"><?php echo $this->lang->line('xin_employee_cpassword');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_cpassword');?>" name="confirm_password" type="text" value="">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="address"><?php echo $this->lang->line('xin_employee_address');?></label>
            <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_address');?>" name="address" cols="30" rows="3" id="address"></textarea>
          </div>
        </div>
        <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_employees');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th style="width:80px;"><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_employees_id');?></th>
          <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('dashboard_username');?></th>
          <th><?php echo $this->lang->line('dashboard_email');?></th>
          <th><?php echo $this->lang->line('xin_employee_role');?></th>
          <th><?php echo $this->lang->line('xin_designation');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
