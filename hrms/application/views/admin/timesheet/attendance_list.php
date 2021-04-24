<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_set_date');?></span> </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'attendance_daily_report', 'id' => 'attendance_daily_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/attendance_list', $attributes, $hidden);?>
        <?php
				$data = array(
				  'type'        => 'hidden',
				  'name'        => 'date_format',
				  'id'          => 'date_format',
				  'value'       => $this->Xin_model->set_date_format(date('Y-m-d')),
				  'class'       => 'form-control',
				);
				echo form_input($data);
				?>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="attendance_date" name="attendance_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
          <div class="col-md-6">
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
  <h6 class="card-header"> <?php echo $this->lang->line('xin_daily_attendance_report');?> </h6>
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
          <th style="width:100px;"><?php echo $this->lang->line('xin_e_details_date');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('dashboard_clock_in');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('dashboard_clock_out');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('dashboard_late');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('dashboard_early_leaving');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('dashboard_overtime');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('dashboard_total_work');?></th>
          <th style="width:100px;"><?php echo $this->lang->line('dashboard_total_rest');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
