<?php
/* Hourly Wage/Rate view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-3">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_hr_report_filters');?> </h6>
      <div class="card-body">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'payslip_report', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/reports/payslip_report', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group" id="employee_ajax">
              <label for="employee"><?php echo $this->lang->line('dashboard_single_employee');?></label>
              <select name="employee_id" id="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="month_year"><?php echo $this->lang->line('xin_award_month_year');?></label>
              <input class="form-control r_month_year" placeholder="<?php echo $this->lang->line('xin_award_month_year');?>" readonly name="month_year" id="month_year" type="text">
            </div>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_hr_reports_payslip');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_employee_name');?></th>
              <th><?php echo $this->lang->line('xin_paid_amount');?></th>
              <th><?php echo $this->lang->line('xin_payment_month');?></th>
              <th><?php echo $this->lang->line('xin_payment_date');?></th>
              <th><?php echo $this->lang->line('xin_payment_type');?></th>
              <th><?php echo $this->lang->line('xin_payslip');?></th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- responsive --> 
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
