<?php
/* Generate Payslip view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('left_generate_payslip');?></span> </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'set_salary_details', 'id' => 'set_salary_details', 'class' => 'm-b-1 add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/payroll/set_salary_details', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="department"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
                <option value="0"><?php echo $this->lang->line('xin_all_companies');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" id="employee_ajax">
              <label for="department"><?php echo $this->lang->line('dashboard_single_employee');?></label>
              <select id="employee_id" name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                <option value="0"><?php echo $this->lang->line('xin_all_employees');?></option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('xin_select_month');?></label>
              <input class="form-control month_year" placeholder="<?php echo $this->lang->line('xin_select_month');?>" readonly id="month_year" name="month_year" type="text" value="<?php echo date('Y-m');?>">
            </div>
          </div>
        </div>
        <div class="row">
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
  <h6 class="card-header"> <?php echo $this->lang->line('xin_payment_info_for');?> <span class="text-danger" id="p_month"><?php echo date('F, Y');?></span> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('dashboard_employee_id');?></th>
          <th><?php echo $this->lang->line('xin_name');?></th>
          <th><?php echo $this->lang->line('xin_salary_type');?></th>
          <th><?php echo $this->lang->line('xin_payroll_basic_salary');?></th>
          <th><?php echo $this->lang->line('xin_payroll_net_salary');?></th>
          <th><?php echo $this->lang->line('xin_details');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <th><?php echo $this->lang->line('xin_action');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
