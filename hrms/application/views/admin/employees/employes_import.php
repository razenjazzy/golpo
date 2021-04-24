<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_employee_import_csv_file');?></span> </div>
  <div class="card-body">
    <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line1');?></p>
    <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line2');?></p>
    <h6><a href="<?php echo base_url();?>uploads/csv/sample-csv-employees.csv" class="btn btn-info"> <i class="fa fa-download"></i> <?php echo $this->lang->line('xin_employee_import_download_sample');?> </a></h6>
    <?php $attributes = array('name' => 'import_attendance', 'id' => 'xin-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open_multipart('admin/employees/import_employees', $attributes, $hidden);?>
    <div class="row">
      <div class="col-md-4">
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
      <div class="col-md-4">
        <div class="form-group" id="department_ajax">
          <label for="department"><?php echo $this->lang->line('xin_employee_department');?></label>
          <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
            <option value=""></option>
          </select>
        </div>
      </div>
      <div class="col-md-4" id="designation_ajax">
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
      <div class="col-md-6">
        <div class="form-group">
          <fieldset class="form-group">
            <label for="logo"><?php echo $this->lang->line('xin_employee_upload_file');?></label>
            <input type="file" class="form-control-file" id="file" name="file">
            <small><?php echo $this->lang->line('xin_employee_imp_allowed_size');?></small>
          </fieldset>
        </div>
      </div>
    </div>
    <div class="mt-1">
      <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
