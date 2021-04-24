<?php
/* Date Wise Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php
// get employee
/*$user = $this->Xin_model->read_user_info($session['user_id']);
if(!is_null($user)){
	$company_id = $user[0]->company_id;
} else {
	$company_id = 1;
}*/
?>

<div class="card mb-4">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_select_date');?></span> </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'attendance_datewise_report', 'id' => 'attendance_datewise_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/datewise_attendance_list', $attributes, $hidden);?>
        <?php
				$data = array(
				  'type'        => 'hidden',
				  'name'        => 'user_id',
				  'id'          => 'user_id',
				  'value'       => $session['user_id'],
				  'class'       => 'form-control',
				);
				echo form_input($data);
				?>
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php /*?><?php if($company_id==$company->company_id):?> selected 
						<?php endif;?><?php */?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group" id="employee_ajax">
              <?php //$result = $this->Department_model->ajax_company_employee_info($company_id);?>
              <select name="employee_id" id="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                <option value="">All</option>
                <!--<?php foreach($result as $employee) {?>
                        <option value="<?php echo $employee->user_id;?>" <?php if($session['user_id']==$employee->user_id):?> selected <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                        <?php } ?>-->
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group"> &nbsp;
              <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_get');?></button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('dashboard_attendance');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th colspan="2"><?php echo $this->lang->line('xin_hr_info');?></th>
          <th colspan="9"><?php echo $this->lang->line('xin_attendance_report');?></th>
        </tr>
        <tr>
          <th style="width:120px;"><?php echo $this->lang->line('xin_employee');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('left_company');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('xin_e_details_date');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('dashboard_clock_in');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('dashboard_clock_out');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('dashboard_late');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('dashboard_early_leaving');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('dashboard_overtime');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('dashboard_total_work');?></th>
          <th style="width:120px;"><?php echo $this->lang->line('dashboard_total_rest');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
