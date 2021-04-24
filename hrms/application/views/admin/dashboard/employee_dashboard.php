<?php 
$session = $this->session->userdata('username');
$user_info = $this->Exin_model->read_user_info($session['user_id']);
$user = $this->Xin_model->read_employee_info($session['user_id']);
if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
	$lde_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
} else { 
	if($user_info[0]->gender=='Male') {  
		$lde_file = base_url().'uploads/profile/default_male.jpg'; 
	} else {  
		$lde_file = base_url().'uploads/profile/default_female.jpg';
	}
}
$last_login =  new DateTime($user_info[0]->last_login_date);
// get designation
$designation = $this->Designation_model->read_designation_information($user_info[0]->designation_id);
if(!is_null($designation)){
	$designation_name = $designation[0]->designation_name;
} else {
	$designation_name = '--';	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $announcement = $this->Announcement_model->get_new_announcements();?>
<?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
<?php $profile_pic = base_url().'uploads/profile/'.$user[0]->profile_picture;?>
<?php } else {?>
<?php  if($user[0]->gender=='Male') { ?>
<?php 	$profile_pic = base_url().'uploads/profile/default_male.jpg';?>
<?php } else { ?>
<?php 	$profile_pic = base_url().'uploads/profile/default_female.jpg';?>
<?php } ?>
<?php  } ?>
              
<h4 class="media align-items-center font-weight-bold py-3 mb-4"> <img src="<?php  echo $profile_pic;?>" alt="" class="ui-w-50 rounded-circle">
  <div class="media-body ml-3"> Welcome back, <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>!
    <div class="text-muted text-tiny mt-1"> <small class="font-weight-normal">Today is <?php echo date('l, j F Y');?></small> </div>
  </div>
</h4>
<?php foreach($announcement as $new_announcement):?>
<?php
	$current_date = strtotime(date('Y-m-d'));
	$announcement_end_date = strtotime($new_announcement->end_date);
	if($current_date <= $announcement_end_date) {
?>
<div class="alert alert-success alert-dismissible fade show">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong><?php echo $new_announcement->title;?>:</strong> <?php echo $new_announcement->summary;?> <a href="#" class="alert-link" data-toggle="modal" data-target=".view-modal-annoucement" data-announcement_id="<?php echo $new_announcement->announcement_id;?>"><?php echo $this->lang->line('xin_view');?></a> </div>
<?php } ?>
<?php endforeach;?>
<hr class="container-m--x mt-0 mb-4">
<div class="row">
  <div class="contacts-col col-4">
    <div class="card mb-4 contacts-col-view">
      <div class="card-body">
        <div class="contact-content">
          <div class="contact-content-about">
            <h5 class="contact-content-name mb-2"> <i class="fas fa-user-clock d-block" style="font-size: 2rem; line-height:1.1"></i> </h5>
            <h5 class="contact-content-name mb-1"> <?php echo $this->lang->line('xin_mark_attendance');?> </h5>

            <hr class="border-light">
            <div>
              <?php
				$att_date =  date('d-M-Y');
				$attendance_date = date('d-M-Y');
				// get office shift for employee
				$get_day = strtotime($att_date);
				$day = date('l', $get_day);
				$strtotime = strtotime($attendance_date);
				$new_date = date('d-M-Y', $strtotime);
				// office shift
				$u_shift = $this->Timesheet_model->read_office_shift_information($user_info[0]->office_shift_id);
				
				// get clock in/clock out of each employee
				if($day == 'Monday') {
					if($u_shift[0]->monday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_monday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->monday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->monday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Tuesday') {
					if($u_shift[0]->tuesday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_tuesday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->tuesday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->tuesday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Wednesday') {
					if($u_shift[0]->wednesday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_wednesday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->wednesday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->wednesday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Thursday') {
					if($u_shift[0]->thursday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_thursday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->thursday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->thursday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Friday') {
					if($u_shift[0]->friday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_friday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->friday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->friday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Saturday') {
					if($u_shift[0]->saturday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_saturday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->saturday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->saturday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Sunday') {
					if($u_shift[0]->sunday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_sunday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->sunday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->sunday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				}
			  ?>
              <?php
			  	if($system[0]->system_ip_restriction == 'yes'){
					$sys_arr = explode(',',$system[0]->system_ip_address);
					if(in_array($this->input->ip_address(),$sys_arr)) { 
					//$system[0]->system_ip_address == $this->input->ip_address()){?>
              <div class="text-xs-center">
                <div class="text-xs-center pb-0-5">
                  <?php $attributes = array('name' => 'set_clocking', 'id' => 'set_clocking', 'autocomplete' => 'off', 'class' => 'form');?>
                  <?php $hidden = array('exuser_id' => $session['user_id']);?>
                  <?php echo form_open('admin/timesheet/set_clocking', $attributes, $hidden);?>
                  <input type="hidden" name="timeshseet" value="<?php echo $user_info[0]->user_id;?>">
                  <?php $attendances = $this->Timesheet_model->attendance_time_checks($user_info[0]->user_id); $dat = $attendances->result();?>
                  <?php if($attendances->num_rows() < 1) {?>
                  <input type="hidden" value="clock_in" name="clock_state" id="clock_state">
                  <input type="hidden" value="" name="time_id" id="time_id">
                  <button class="btn btn-primary btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('dashboard_clock_in');?></button>
                  <?php } else {?>
                  <input type="hidden" value="clock_out" name="clock_state" id="clock_state">
                  <input type="hidden" value="<?php echo $dat[0]->time_attendance_id;?>" name="time_id" id="time_id">
                  <button class="btn btn-warning btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-left"></i> <?php echo $this->lang->line('dashboard_clock_out');?></button>
                  <?php } ?>
                  <?php echo form_close(); ?> </div>
              </div>
              <?php } } else {?>
              <div class="text-xs-center">
                <div class="text-xs-center pb-0-5">
                  <?php $attributes = array('name' => 'set_clocking', 'id' => 'set_clocking', 'autocomplete' => 'off', 'class' => 'form');?>
                  <?php $hidden = array('exuser_id' => $session['user_id']);?>
                  <?php echo form_open('admin/timesheet/set_clocking', $attributes, $hidden);?>
                  <input type="hidden" name="timeshseet" value="<?php echo $user_info[0]->user_id;?>">
                  <?php $attendances = $this->Timesheet_model->attendance_time_checks($user_info[0]->user_id); $dat = $attendances->result();?>
                  <?php if($attendances->num_rows() < 1) {?>
                  <input type="hidden" value="clock_in" name="clock_state" id="clock_state">
                  <input type="hidden" value="" name="time_id" id="time_id">
                  <button class="btn btn-primary btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('dashboard_clock_in');?></button>
                  <?php } else {?>
                  <input type="hidden" value="clock_out" name="clock_state" id="clock_state">
                  <input type="hidden" value="<?php echo $dat[0]->time_attendance_id;?>" name="time_id" id="time_id">
                  <button class="btn btn-warning btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-left"></i> <?php echo $this->lang->line('dashboard_clock_out');?></button>
                  <?php } ?>
                  <?php echo form_close(); ?> </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex col-xl-8 align-items-stretch">
    <div class="card d-flex w-100 mb-4">
      <div class="row no-gutters row-bordered row-border-light h-100">
        <?php if($system[0]->module_awards=='true'){?>
        <div class="d-flex col-sm-6 col-md-4 col-lg-4 align-items-center"> <a href="<?php echo site_url('admin/user/awards');?>" class="card-body media align-items-center text-dark"> <i class="ion ion-md-trophy display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"> <span class="font-weight-bolder"><?php echo $this->Exin_model->total_employee_awards_dash();?></span> <?php echo $this->lang->line('left_awards');?></span></span> </a> </div>
        <?php } else {?>
        <div class="d-flex col-sm-6 col-md-4 col-lg-4 align-items-center"> <a href="<?php echo site_url('admin/user/attendance');?>" class="card-body media align-items-center text-dark"> <i class="fas fa-calendar-check display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"> <span class="font-weight-bolder"><?php echo $this->lang->line('xin_view');?></span> <?php echo $this->lang->line('dashboard_attendance');?></span> </span> </a> </div>
        <?php } ?>
        <div class="d-flex col-sm-6 col-md-4 col-lg-4 align-items-center"> <a href="<?php echo site_url('admin/user/expense_claims');?>" class="card-body media align-items-center text-dark"> <i class="oi oi-dollar display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"> <span class="font-weight-bolder"><?php echo $this->Exin_model->total_employee_expense_dash();?></span> <?php echo $this->lang->line('xin_expense');?></span> </span> </a> </div>
        <div class="d-flex col-sm-6 col-md-4 col-lg-4 align-items-center"> <a href="<?php echo site_url('admin/user/tickets');?>" class="card-body media align-items-center text-dark"> <i class="oi oi-tag display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"> <span class="font-weight-bolder"><?php echo $this->lang->line('xin_view');?></span> <?php echo $this->lang->line('left_tickets');?></span> </span> </a> </div>
        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center"> <a href="<?php echo site_url('admin/user/leave');?>" class="card-body media align-items-center text-dark"> <i class="lnr lnr-calendar-full display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"> <span class="font-weight-bolder"><?php echo $this->lang->line('left_leave');?></span> <?php echo $this->lang->line('xin_performance_management');?></span> <br /> <small class="text-muted"><?php echo $this->lang->line('xin_manage_your_leave');?></small></span> </a> </div>
        <?php if($system[0]->module_travel=='true'){?>
        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center"> <a href="<?php echo site_url('admin/user/travel');?>" class="card-body media align-items-center text-dark"> <i class="ion ion-md-airplane display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"> <span class="font-weight-bolder"><?php echo $this->lang->line('xin_travel');?></span> <?php echo $this->lang->line('xin_requests');?></span> <br /> <small class="text-muted"><?php echo $this->lang->line('xin_manage_your_travels');?></small></span> </a> </div>
        <?php } else {?>
        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center"> <a href="<?php echo site_url('admin/user/payslip');?>" class="card-body media align-items-center text-dark"> <i class="fas fa-money-bill-alt display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big"> <span class="font-weight-bolder"><?php echo $this->lang->line('xin_view');?></span> <?php echo $this->lang->line('left_payslips');?></span> <br /> <small class="text-muted"><?php echo $this->lang->line('xin_manage_your_payslips');?></small></span> </a> </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<hr class="container-m--x mt-0 mb-4">
<?php if($system[0]->module_projects_tasks=='true'){?>
<div class="row">
  <div class="col-xl-8">
    <h6 class="font-weight-semibold mb-4"><?php echo $this->lang->line('dashboard_my_projects');?></h6>
    <div id="project-scrollbar" class="ps ps--active-y" style="height: 300px"> 
      <!-- Tasks -->
      <?php $project = $this->Project_model->get_projects();?>
      <?php $dId = array(); $i=1; foreach($project->result() as $pj):
     // $aw_name = $hrm->e_award_type($emp_award->award_type_id);
     $asd = array($pj->assigned_to);
     $aim = explode(',',$pj->assigned_to);
     foreach($aim as $dIds) {
         if($session['user_id'] === $dIds) {
            $dId[] = $session['user_id'];
        // priority
        if($pj->priority == 1) {
            $priority = '<span class="badge badge-danger">'.$this->lang->line('xin_highest').'</span>';
        } else if($pj->priority ==2){
            $priority = '<span class="badge badge-danger">'.$this->lang->line('xin_high').'</span>';
        } else if($pj->priority ==3){
            $priority = '<span class="badge badge-primary">'.$this->lang->line('xin_normal').'</span>';
        } else {
            $priority = '<span class="badge badge-success">'.$this->lang->line('xin_low').'</span>';
        }
		$pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($pj->end_date);
        ?>
      <div class="card pb-4 mb-2">
        <div class="row no-gutters align-items-center">
          <div class="col-12 col-md-4 px-4 pt-4"> <a href="<?php echo site_url();?>admin/user/project_details/<?php echo $pj->project_id;?>/" class="text-dark font-weight-semibold"><?php echo $pj->title;?></a> <br>
            <small class="text-muted"><?php echo $pj->summary;?></small> </div>
          <div class="col-4 col-md-2 text-muted small px-4 pt-4"> <?php echo $priority;?> </div>
          <div class="col-4 col-md-3 text-muted small px-4 pt-4"> <?php echo $pdate;?> </div>
          <div class="col-4 col-md-3 px-4 pt-4">
            <div class="text-right text-muted small"><?php echo $pj->project_progress;?>%</div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar" style="width: <?php echo $pj->project_progress;?>%;"></div>
            </div>
          </div>
        </div>
      </div>
      <?php }
		} ?>
      <?php $i++; endforeach;?>
    </div>
  </div>
  <script type="text/javascript">
	$(function() {
	  new PerfectScrollbar(document.getElementById('tasks-scrollbar'));
	  new PerfectScrollbar(document.getElementById('project-scrollbar'));
	});
	</script>
  <div class="col-xl-4">
    <h6 class="font-weight-semibold mb-4"><?php echo $this->lang->line('dashboard_my_tasks');?></h6>
    <div class="card mb-4">
      <ul id="tasks-scrollbar" class="list-group list-group-flush ps ps--active-y" style="height: 300px">
        <?php $task = $this->Timesheet_model->get_tasks();?>
        <?php $dId = array(); $i=1; $ct_tasks = 0;
		$ovt_tasks = 0; $tot_tasks=0; foreach($task->result() as $et):
		 // $aw_name = $hrm->e_award_type($emp_award->award_type_id);
		 $asd = array($et->assigned_to);
		 $aim = explode(',',$et->assigned_to);
		 foreach($aim as $dIds) {
			 if($session['user_id'] === $dIds) {
				$dId[] = $session['user_id'];
			// task end date		
			//$tdate = $this->Xin_model->set_date_format($et->end_date);
			// task progress
			if($et->task_progress <= 20) {
				$progress_class = 'progress-danger';
				$tag_class = 'badge badge-danger';
			} else if($et->task_progress > 20 && $et->task_progress <= 50){
				$progress_class = 'progress-warning';
				$tag_class = 'badge badge-warning';
			} else if($et->task_progress > 50 && $et->task_progress <= 75){
				$progress_class = 'progress-info';
				$tag_class = 'badge badge-info';
			} else {
				$progress_class = 'progress-success';
				$tag_class = 'badge badge-success';
			}
			 
			// project progress
			if($et->task_status == 0) {
				$status = $this->lang->line('xin_not_started');
			} else if($et->task_status ==1){
				$status = $this->lang->line('xin_in_progress');
			} else if($et->task_status ==2){
				$status = $this->lang->line('xin_completed');
			} else {
				$status = $this->lang->line('xin_deffered');
			}
			
			$pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($et->end_date);
		
			?>
        <li class="list-group-item py-3">
          <div class="<?php echo $tag_class;?> float-right"><?php echo $status;?></div>
          <div class="font-weight-semibold"> <a href="<?php echo site_url('admin/user/task_details/id/').$et->task_id.'/';?>"> <?php echo $et->task_name;?></a></div>
          <small class="text-muted"><?php echo $pdate;?></small> </li>
        <?php }
							} ?>
        <?php $i++; endforeach;?>
      </ul>
    </div>
  </div>
</div>
<?php } ?>
<hr class="container-m--x mt-0 mb-4">
<?php $this->load->view('admin/calendar/calendar_employee');?>
