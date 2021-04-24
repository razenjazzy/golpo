<?php
/* Update Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-4">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('left_update_attendance');?> </h6>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'update_attendance_report', 'id' => 'update_attendance_report', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/timesheet/update_attendance', $attributes, $hidden);?>
            <?php
				$data = array(
				  'name'        => 'emp_id',
				  'id'          => 'emp_id',
				  'value'       => $session['user_id'],
				  'type'   		=> 'hidden',
				  'class'       => 'form-control',
				);
			
				echo form_input($data);
				?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                  <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>" readonly id="attendance_date" name="attendance_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
                  <select name="employee_id" id="employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                  </select>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_get');?> </button>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('left_update_attendance');?></span>
        <div class="card-header-elements ml-md-auto">
          <button type="button" class="btn btn-xs btn-outline-primary" id="add_attendance_btn" data-toggle="modal" style="display:none;" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </div>
      </div>
      <div class="card-body">
        <div class="card-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_in_time');?></th>
                <th><?php echo $this->lang->line('xin_out_time');?></th>
                <th><?php echo $this->lang->line('dashboard_total_work');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
