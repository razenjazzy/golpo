<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
            
<h4 class="media align-items-center font-weight-bold py-3 mb-4"> 
<?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
    <img src="<?php  echo base_url().'uploads/profile/'.$user[0]->profile_picture;?>" alt="" class="ui-w-50 rounded-circle">
    <?php } else {?>
    <?php  if($user[0]->gender=='Male') { ?>
    <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
    <?php } else { ?>
    <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
    <?php } ?>
    <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="ui-w-50 rounded-circle">
    <?php  } ?>
    <!--<img src="<?php echo base_url();?>skin/hrsale_assets/img/avatars/1.png" alt="" class="ui-w-50 rounded-circle">-->
  <div class="media-body ml-3"> Welcome back, <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>!
    <div class="text-muted text-tiny mt-1"> <small class="font-weight-normal">Today is <?php echo date('l, j F Y');?></small> </div>
  </div>
</h4>
<hr class="container-m--x mt-0 mb-4">
<?php if($theme[0]->statistics_cards=='4' || $theme[0]->statistics_cards=='8' || $theme[0]->statistics_cards=='12'){?>
<div class="row">
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-users display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_people');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/employees');?>"><i class="ft-arrow-up"></i><?php echo $this->Employees_model->get_total_employees();?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-business display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('module_company_title');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/company');?>"><i class="ft-arrow-up"></i><?php echo $this->Xin_model->get_all_companies();?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-calendar-full display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('left_leave');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/timesheet/leave');?>"> <?php echo $this->lang->line('xin_performance_management');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-cog display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_configure_hr');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/settings');?>"> <?php echo $this->lang->line('left_settings');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if($theme[0]->statistics_cards=='8' || $theme[0]->statistics_cards=='12'){?>
<div class="row">
  <?php if($system[0]->module_files=='true'){?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="lnr lnr-file-add display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_e_details_document');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/files');?>"> <?php echo $this->lang->line('xin_performance_management');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } else {?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-airplane display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_view');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/timesheet/holidays');?>"> <?php echo $this->lang->line('left_holidays');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-grid display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_theme_title');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/theme');?>"> <?php echo $this->lang->line('left_settings');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php if($system[0]->module_projects_tasks=='true'){?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-logo-buffer display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('dashboard_projects');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/project');?>"><i class="ft-arrow-up"></i><?php echo $this->Xin_model->get_all_projects();?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="oi oi-task display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_tasks');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/timesheet/tasks');?>"><i class="ft-arrow-up"></i><?php echo $this->Xin_model->get_all_tasks();?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } else {?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-list display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_view');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/designation');?>"> <?php echo $this->lang->line('left_designation');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-calendar display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_view');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/timesheet/office_shift');?>"> <?php echo $this->lang->line('left_office_shifts');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php } ?>
<?php if($theme[0]->statistics_cards=='12'){?>
<div class="row">
  <?php if($system[0]->module_training=='true'){?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-school display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('left_training');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/training');?>"><i class="ft-arrow-up"></i><?php echo $this->lang->line('xin_performance_management');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } else {?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-help-buoy display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_setup');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/settings/modules');?>"><i class="ft-arrow-up"></i><?php echo $this->lang->line('xin_modules');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php }?>
  <?php if($system[0]->module_travel=='true'){?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-airplane display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_travel');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/travel');?>"> <?php echo $this->lang->line('xin_requests');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } else {?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="fas fa-calendar-check display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_view');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/timesheet/attendance');?>"> <?php echo $this->lang->line('dashboard_attendance');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if($system[0]->module_inquiry=='true'){?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="oi oi-tag display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('left_tickets');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/tickets');?>"> <?php echo $this->Xin_model->get_all_tickets();?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } else {?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="far fa-building display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_view');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/department');?>"> <?php echo $this->lang->line('left_department');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-lock display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_permission');?></div>
            <div class="text-large"><a class="text-muted" href="<?php echo site_url('admin/roles');?>"> <?php echo $this->lang->line('xin_roles');?></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<hr class="container-m--x mt-0 mb-4">
<?php $this->load->view('admin/calendar/calendar_hr');?>
<hr class="container-m--x mt-0 mb-4">
<div class="row">
  <div class="col-sm-6 col-xl-6">
    <?php $exp_am = $this->Expense_model->get_total_expenses();?>
    <div class="card mb-4">
      <div class="card-body">
        <div class="float-right text-success"> <?php echo $this->Xin_model->currency_sign($exp_am[0]->exp_amount);?> </div>
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-large"><?php echo $this->lang->line('dashboard_total_expenses');?></div>
            <div class="text-muted small"><a class="text-muted" href="<?php echo site_url('admin/expense');?>"> <?php echo $this->lang->line('xin_view');?> <small class="ion ion-md-arrow-round-forward text-tiny"></small></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-6">
    <?php $all_sal = $this->Xin_model->get_total_salaries_paid();?>
    <div class="card mb-4">
      <div class="card-body">
        <div class="float-right text-success"> <?php echo $this->Xin_model->currency_sign($all_sal[0]->paid_amount);?> </div>
        <div class="d-flex align-items-center">
          <div class="lnr lnr-gift display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-large"><?php echo $this->lang->line('dashboard_total_salaries');?></div>
            <div class="text-muted small"><a class="text-muted" href="<?php echo site_url('admin/payroll/payment_history');?>"> <?php echo $this->lang->line('xin_view');?> <small class="ion ion-md-arrow-round-forward text-tiny"></small></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr class="container-m--x mt-0 mb-4">
<h6 class="font-weight-semibold mb-4"><?php echo $this->lang->line('dashboard_my_projects');?></h6>

<!-- Project progress -->
<?php foreach($this->Xin_model->last_four_projects() as $_project) {?>
<?php
	if($_project->priority == 1) {
		$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_highest').'</span>';
	} else if($_project->priority ==2){
		$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_high').'</span>';
	} else if($_project->priority ==3){
		$priority = '<span class="badge badge-primary">'.$this->lang->line('xin_normal').'</span>';
	} else {
		$priority = '<span class="badge badge-success">'.$this->lang->line('xin_low').'</span>';
	}
	$pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($_project->end_date);
    ?>
<div class="card pb-4 mb-4">
  <div class="row no-gutters align-items-center">
    <div class="col-12 col-md-5 px-4 pt-4"> <a href="<?php echo site_url('admin/project/details/').$_project->project_id;?>" class="text-dark font-weight-semibold"><?php echo $_project->title;?></a> <br>
      <small class="text-muted"><?php echo $_project->summary;?></small> </div>
    <div class="col-4 col-md-2 text-muted small px-4 pt-4"> <?php echo $priority;?> </div>
    <div class="col-4 col-md-2 text-muted small px-4 pt-4"> <?php echo $pdate;?></div>
    <div class="col-4 col-md-3 px-4 pt-4">
      <div class="text-right text-muted small"><?php echo $_project->project_progress;?>%</div>
      <div class="progress" style="height: 6px;">
        <div class="progress-bar" style="width: <?php echo $_project->project_progress;?>%;"></div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<!-- / Project progress -->

<hr class="container-m--x mt-0 mb-4">
<div class="row">
  <div class="col-sm-6 col-xl-8">
    <div class="card mb-4">
      <h6 class="card-header with-elements">
        <div class="card-header-title"><?php echo $this->lang->line('left_payment_history');?></div>
        <div class="card-header-elements ml-auto"> <a href="<?php echo site_url('admin/payroll/payment_history');?>" target="_blank">
          <button type="button" class="btn btn-default btn-xs md-btn-flat"><?php echo $this->lang->line('xin_all_payslips');?> <i class="ion ion-md-arrow-round-forward text-tiny"></i></button>
          </a> </div>
      </h6>
      <div class="table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_employee_name');?></th>
              <th><?php echo $this->lang->line('xin_paid_amount');?></th>
              <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
              <th><?php echo $this->lang->line('xin_payment_month');?></th>
              <th><?php echo $this->lang->line('xin_payslip');?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($get_last_payment_history as $last_payments):?>
            <?php $user = $this->Xin_model->read_user_info($last_payments->employee_id);?>
            <?php if(!is_null($user)){?>
            <?php $full_name = $user[0]->first_name.' '.$user[0]->last_name;?>
            <?php
                             $month_payment = date("F, Y", strtotime($last_payments->payment_date));
                             $p_amount = $this->Xin_model->currency_sign($last_payments->payment_amount);
                             ?>
            <tr>
              <td class="text-truncate"><a target="_blank" href="<?php echo site_url().'admin/employees/detail/'.$last_payments->employee_id;?>/"><?php echo $full_name;?></a></td>
              <td class="text-truncate"><?php echo $p_amount;?></td>
              <td class="text-truncate"><span class="tag tag-success"><?php echo $this->lang->line('xin_payment_paid');?></span></td>
              <td class="text-truncate"><?php echo $month_payment;?></td>
              <td class="text-truncate"><a target="_blank" href="<?php echo site_url().'admin/payroll/payslip/id/'.$last_payments->make_payment_id;?>/"><?php echo $this->lang->line('xin_payslip');?></a></td>
            </tr>
            <?php } ?>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <a href="<?php echo site_url('admin/payroll/payment_history/');?>" class="card-footer d-block text-center text-dark small font-weight-semibold">SHOW MORE</a> </div>
  </div>
  <div class="col-sm-4 col-xl-4">
    <div class="card mb-4">
      <div class="card-header with-elements"> <span class="card-header-title"><?php echo $this->lang->line('dashboard_new');?> <?php echo $this->lang->line('dashboard_employees');?> &nbsp; </span>
        <div class="card-header-elements ml-md-auto"> <a href="javascript:void(0)" class="btn btn-default md-btn-flat btn-xs">Show Alls</a> </div>
      </div>
      <div class="row no-gutters row-bordered row-border-light">
        <?php foreach($last_four_employees as $employee) {?>
        <?php 
                    if($employee->profile_picture!='' && $employee->profile_picture!='no file') {
                        $de_file = base_url().'uploads/profile/'.$employee->profile_picture;
                    } else { 
                        if($employee->gender=='Male') {  
                        $de_file = base_url().'uploads/profile/default_male.jpg'; 
                        } else {  
                        $de_file = base_url().'uploads/profile/default_female.jpg';
                        }
                    }
                    $fname = $employee->first_name.' '.$employee->last_name;
                    ?>
        <a href="<?php echo site_url();?>admin/employees/detail/<?php echo $employee->user_id;?>/" class="d-flex col-4 col-sm-3 col-md-4 flex-column align-items-center text-dark py-3 px-2"> <img src="<?php  echo $de_file;?>" alt="" class="d-block ui-w-40 rounded-circle mb-2">
        <div class="text-center small"><?php echo $fname;?></div>
        </a>
        <?php } ?>
      </div>
      <a href="<?php echo site_url('admin/employees/');?>" class="card-footer d-block text-center text-dark small font-weight-semibold">SHOW MORE</a> </div>
  </div>
</div>
