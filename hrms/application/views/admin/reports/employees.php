<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-3">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_hr_report_filters');?> </h6>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'employee_reports', 'id' => 'employee_reports', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('euser_id' => $session['user_id']);?>
            <?php echo form_open('admin/reports/employee_reports', $attributes, $hidden);?>
            <?php
                    $data = array(
                      'name'        => 'user_id',
                      'id'          => 'user_id',
                      'type'        => 'hidden',
                      'value'   	   => $session['user_id'],
                      'class'       => 'form-control',
                    );
                
                echo form_input($data);
                ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                    <?php foreach($all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="department_ajax">
                  <label for="department"><?php echo $this->lang->line('xin_employee_department');?></label>
                  <select class="form-control" name="department_id" id="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" id="designation_ajax">
                <div class="form-group">
                  <label for="designation"><?php echo $this->lang->line('xin_designation');?></label>
                  <select class="form-control" id="designation_id" name="designation_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_get');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_hr_report_employees');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_employees_id');?></th>
              <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
              <th><?php echo $this->lang->line('dashboard_email');?></th>
              <th><?php echo $this->lang->line('left_company');?></th>
              <th><?php echo $this->lang->line('xin_employee_department');?></th>
              <th><?php echo $this->lang->line('xin_designation');?></th>
              <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
