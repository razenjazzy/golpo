<?php
/* Manage Salary view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('left_manage_salary');?></span> </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'set_salary_details', 'id' => 'set_salary_details', 'autocomplete' => 'off', 'class' => 'm-b-1 add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/payroll/set_salary_details', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
                <option value="0"><?php echo $this->lang->line('xin_all_companies');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" id="employee_ajax">
              <label for="name"><?php echo $this->lang->line('dashboard_single_employee');?></label>
              <select id="employee_id" name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                <option value="0"><?php echo $this->lang->line('xin_all_employees');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <div class="form-actions">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_search');?> </button>
              </div>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_employee_salaries');?> </h6>
  <?php $attributes = array('name' => 'user_salary_template', 'id' => 'user_salary_template', 'autocomplete' => 'off');?>
  <?php $hidden = array('user_id' => $session['user_id']);?>
  <?php echo form_open('admin/payroll/user_salary_template', $attributes, $hidden);?>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_view');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('xin_employee_name');?></th>
          <th><?php echo $this->lang->line('dashboard_username');?></th>
          <th><?php echo $this->lang->line('dashboard_designation');?></th>
          <th><?php echo $this->lang->line('xin_payroll_hourly');?></th>
          <th><?php echo $this->lang->line('xin_payroll_monthly');?></th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="form-group row">
    <div class="col-sm-10 ml-sm-auto">
      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_update');?> </button>
    </div>
  </div>
  <?php echo form_close(); ?> </div>
