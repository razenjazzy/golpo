<?php
/* Leave view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row">
  <?php foreach($all_leave_types as $type) {?>
  <?php $count_l = $this->Timesheet_model->count_total_leaves($type->leave_type_id,$session['user_id']);?>
  <?php
	if($count_l == 0){
		$progress_class = '';
		$count_data = 0;
	} else {
		$count_data = $count_l / $type->days_per_year * 100;
		// progress
		if($count_data <= 20) {
			$progress_class = 'progress-success';
		} else if($count_data > 20 && $count_data <= 50){
			$progress_class = 'progress-info';
		} else if($count_data > 50 && $count_data <= 75){
			$progress_class = 'progress-warning';
		} else {
			$progress_class = 'progress-danger';
		}
	}
?>
  <div class="col-md-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-calendar display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"> <?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $type->days_per_year;?>)</div>
            <div class="text-large">
              <div class="progress" style="height: 6px;">
                <div class="progress-bar" style="width: <?php echo $count_data;?>%;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
		}
		?>
</div>
<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_leave');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_leave', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/user/add_leave', $attributes, $hidden);?>
        <?php
				$data = array(
				  'name'        => 'user_id',
				  'id'          => 'user_id',
				  'value'       => $session['user_id'],
				  'type'  		=> 'hidden',
				  'class'       => 'form-control',
				);
			echo form_input($data);
			?>
        <?php
				$data1 = array(
				  'name'        => 'employee_id',
				  'id'          => 'employee_id',
				  'value'       => $session['user_id'],
				  'type'  		=> 'hidden',
				  'class'       => 'form-control',
				);
			echo form_input($data1);
			?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="leave_type" class="control-label"><?php echo $this->lang->line('xin_leave_type');?></label>
                  <select class="form-control" name="leave_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_leave_type');?>">
                    <option value=""></option>
                    <?php foreach($all_leave_types as $type) {?>
                    <option value="<?php echo $type->leave_type_id;?>"> <?php echo $type->type_name;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_remarks');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_remarks');?>" name="remarks" cols="30" rows="15" id="remarks"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="summary"><?php echo $this->lang->line('xin_leave_reason');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_leave_reason');?>" name="reason" cols="30" rows="3" id="reason"></textarea>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_leave');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_employee');?></th>
          <th><?php echo $this->lang->line('xin_leave_type');?></th>
          <th><?php echo $this->lang->line('xin_leave_duration');?></th>
          <th><?php echo $this->lang->line('xin_applied_on');?></th>
          <th><?php echo $this->lang->line('xin_reason');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
