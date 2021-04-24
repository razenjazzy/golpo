<?php
/* Date Wise Attendance Report > EMployees view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-3">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_hr_report_filters');?> </h6>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'attendance_datewise_report', 'id' => 'attendance_datewise_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('euser_id' => $session['user_id']);?>
            <?php echo form_open('admin/reports/attendance_xin', $attributes, $hidden);?>
            <?php
                    $data = array(
                      'name'        => 'user_id',
                      'id'          => 'user_id',
                      'value'       => $session['user_id'],
                      'type'   		=> 'hidden',
                      'class'       => 'form-control',
                    );
                
                echo form_input($data);
                ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="start_date" name="start_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="end_date" name="end_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>" <?php /*?><?php if($company_id==$company->company_id):?> selected 
						<?php endif;?><?php */?>><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" id="employee_ajax">
                  <select name="employee_id" id="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                    <option value="">All</option>
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
      <h6 class="card-header"> <?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_hr_reports_attendance_employee');?> </h6>
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
              <th style="width:120px;"><?php echo $this->lang->line('dashboard_total_work');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
