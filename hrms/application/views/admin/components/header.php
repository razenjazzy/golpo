<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php
if(empty($wz_lang)):
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';
elseif($wz_lang == 'english'):
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
else:
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
endif;
?>
<?php
$role_user = $this->Xin_model->read_user_role_info($user[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
//$designation_info = $this->Xin_model->read_designation_info($user_info[0]->designation_id);
// set color
if($theme[0]->is_semi_dark==1):
	$light_cls = 'navbar-semi-dark navbar-shadow';
	$ext_clr = '';
else:
	$light_cls = 'navbar-dark';
	$ext_clr = $theme[0]->top_nav_dark_color;
endif;
// set layout / fixed or static
if($theme[0]->boxed_layout=='true'){
	$lay_fixed = 'container boxed-layout';
} else {
	$lay_fixed = '';
}
?>
<nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center container-p-x bg-dark" id="layout-navbar"> 
  
  <a href="<?php echo site_url('admin/dashboard');?>" class="navbar-brand app-brand demo d-lg-none py-0 mr-4"> <span class="app-brand-logo1 demo bg-primary"> <img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo" style="width:32px;"> </span> <span class="app-brand-text demo font-weight-normal ml-2"><?php echo $system[0]->application_name;?></span> </a> 
  
  <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto"> <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:void(0)"> <i class="ion ion-md-menu text-large align-middle"></i> </a> </div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse"> <span class="navbar-toggler-icon"></span> </button>
  <div class="navbar-collapse collapse" id="layout-navbar-collapse"> 
    <!-- Divider -->
    <hr class="d-lg-none w-100 my-2">
    <div class="navbar-nav align-items-lg-center"> 
		  <?php  if(in_array('95',$role_resources_ids)) { ?>
          <a href="<?php echo site_url('admin/theme/');?>" class="nav-link">
          <i class="fas fa-columns"></i></a>
          <?php } ?>
    </div>
    <div class="navbar-nav align-items-lg-center"> 
      <?php if($system[0]->module_recruitment=='true'){?>
		  <?php if($system[0]->enable_job_application_candidates=='yes'){?>
		  <?php  if(in_array('50',$role_resources_ids)) { ?>
          <a href="<?php echo site_url();?>frontend/jobs/" target="_blank" class="nav-link">
          <?php echo $this->lang->line('header_apply_jobs');?> <span class="fa fa-arrow-circle-right"></span></a>
          <?php } } } ?>
    </div>
    <div class="navbar-nav align-items-lg-center ml-auto">
      <div class="demo-navbar-user nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle"> <?php echo $flg_icn;?> </span> <span class="d-lg-none align-middle">
          &nbsp; <?php echo $this->lang->line('xin_languages');?></span> </a>
        <div class="dropdown-menu dropdown-menu-right">
        	<?php $languages = $this->Xin_model->all_languages();?>
            <?php foreach($languages as $lang):?>
            <?php $flag = '<img src="'.base_url().'uploads/languages_flag/'.$lang->language_flag.'">';?>
            <a href="<?php echo site_url('admin/dashboard/set_language/').$lang->language_code;?>" class="dropdown-item">
            <i class="flag-icon"><?php echo $flag;?></i> &nbsp; <?php echo $lang->language_name;?></a>
            <?php endforeach;?>
            <?php if($system[0]->module_language=='true'){?>
            <?php  if(in_array('89',$role_resources_ids)) { ?>
            <div class="dropdown-divider"></div>
            <a href="<?php echo site_url('admin/languages')?>" class="dropdown-item"><i class="fa fa-cog text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_settings');?></a>
            <?php } ?>
            <?php } ?>
        </div>
      </div>
      <?php  if(in_array('61',$role_resources_ids) || in_array('93',$role_resources_ids) || in_array('63',$role_resources_ids) || in_array('92',$role_resources_ids) || in_array('62',$role_resources_ids) || in_array('94',$role_resources_ids) || in_array('96',$role_resources_ids) || in_array('60',$role_resources_ids) || $user[0]->user_role_id==1) { ?>
      <div class="demo-navbar-user nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle"> <i class="ion ion-md-settings"></i> </span> <span class="d-lg-none align-middle">
          &nbsp; <?php echo $this->lang->line('header_configuration');?></span> </a>
        <div class="dropdown-menu dropdown-menu-right">
        <?php  if(in_array('61',$role_resources_ids)) { ?>
            <a href="<?php echo site_url('admin/settings/constants')?>" class="dropdown-item">
            <i class="fas fa-align-justify text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_constants');?></a>
            <?php } ?>
            <?php  if($user[0]->user_role_id==1) { ?>
            <a href="<?php echo site_url('admin/roles')?>" class="dropdown-item">
            <i class="fas fa-user-cog text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_role_urole');?></a>
            <?php } ?>
            <?php  if(in_array('93',$role_resources_ids)) { ?>
            <a href="<?php echo site_url('admin/settings/modules')?>" class="dropdown-item">
            <i class="fas fa-life-ring text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_setup_modules');?></a>
            <?php } ?>
            <?php  if(in_array('63',$role_resources_ids)) { ?>
            <a href="<?php echo site_url('admin/settings/email_template')?>" class="dropdown-item">
            <i class="fas fa-envelope text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_email_templates');?></a>
            <?php } ?>
            <?php  if(in_array('92',$role_resources_ids)) { ?>
            <a href="<?php echo site_url('admin/employees/import')?>" class="dropdown-item">
            <i class="fas fa-user text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_import_employees');?></a>
            <?php } ?>
            <?php  if(in_array('62',$role_resources_ids)) { ?>
            <a href="<?php echo site_url('admin/settings/database_backup')?>" class="dropdown-item">
            <i class="fa fa-database text-lightest"></i> &nbsp; <?php echo $this->lang->line('header_db_log');?></a>
            <?php } ?>
            <?php  if(in_array('94',$role_resources_ids)) { ?>
            <a href="<?php echo site_url('admin/theme')?>" class="dropdown-item">
            <i class="fas fa-columns text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_theme_settings');?></a>
            <?php } ?>
            <?php if($system[0]->module_orgchart=='true'){?>
            <?php  if(in_array('96',$role_resources_ids)) { ?>
            <a href="<?php echo site_url('admin/organization/chart')?>" class="dropdown-item">
            <i class="fas fa-sitemap text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_org_chart_title');?></a>
            <?php } ?>
            <?php } ?>
            <?php  if(in_array('60',$role_resources_ids)) { ?>
            <div class="dropdown-divider"></div>
            <a href="<?php echo site_url('admin/settings')?>" class="dropdown-item"><i class="fas fa-cog text-lightest"></i> &nbsp; <?php echo $this->lang->line('header_configuration');?></a>
            <?php } ?>
        </div>
      </div>
      <?php } ?>
	  <?php  if($user[0]->user_role_id==1) { ?>
      <div class="demo-navbar-notifications nav-item dropdown mr-lg-3"> <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown"> <i class="ion ion-md-notifications-outline navbar-icon align-middle"></i> <span class="d-lg-none align-middle">&nbsp; <?php echo $this->lang->line('header_notifications');?></span> </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="bg-primary text-center text-white font-weight-bold p-3"> <?php echo $this->lang->line('xin_leave_app');?> </div>
          <div class="list-group list-group-flush"> 
          	<?php foreach($this->Xin_model->get_last_leave_applications() as $leave_notify){?>
                <?php $employee_info = $this->Xin_model->read_user_info($leave_notify->employee_id);?>
                <?php
					if(!is_null($employee_info)){
						$emp_name = $employee_info[0]->first_name. ' '.$employee_info[0]->last_name;
					} else {
						$emp_name = '--';	
					}
                ?>
             <a href="<?php echo site_url('admin/timesheet/leave_details/id')?>/<?php echo $leave_notify->leave_id;?>/" class="list-group-item list-group-item-action media d-flex align-items-center">
            <div class="ui-icon ui-icon-sm ion ion-md-calendar bg-warning border-0 text-dark"></div>
            <div class="media-body line-height-condenced ml-3">
              <div class="text-dark"><?php echo $emp_name;?></div>
              <div class="text-light small mt-1"> <?php echo $this->lang->line('header_has_applied_for_leave');?> </div>
              <div class="text-light small mt-1"> <?php echo $this->Xin_model->set_date_format($leave_notify->applied_on);?> </div>
            </div>
            </a>
            <?php } ?>
            </div>
          <a href="<?php echo site_url('admin/timesheet/leave');?>" class="d-block text-center text-light small p-2 my-1"><?php echo $this->lang->line('xin_read_all');?></a> </div>
      </div>
      <?php } ?>
      <?php $unread_msgs = $this->Xin_model->get_single_unread_message($session['user_id']);?>
      <?php if($system[0]->module_chat_box=='true'){?>
      <div class="demo-navbar-messages nav-item dropdown mr-lg-3"> <a class="nav-link dropdown-toggle hide-arrow" href="<?php echo site_url('admin/chat');?>"> <i class="ion ion-ios-chatbubbles navbar-icon align-middle"></i>
      <?php if($unread_msgs > 0) {?>
      <span id="msgs_count">
          <span class="badge badge-pill badge-primary float-right"><?php echo $unread_msgs;?></span></span>
          <?php } ?>
          <span class="d-lg-none align-middle">
          &nbsp; <?php echo $this->lang->line('xin_hr_chat_box');?></span> </a>
      </div>
      <?php } ?>
      <!-- Divider -->
      <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
      <div class="demo-navbar-user nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle"> 
      		<?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
            <img src="<?php  echo base_url().'uploads/profile/'.$user[0]->profile_picture;?>" alt="" id="user_avatar" 
            class="d-block ui-w-30 rounded-circle user_profile_avatar">
            <?php } else {?>
            <?php  if($user[0]->gender=='Male') { ?>
            <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
            <?php } else { ?>
            <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
            <?php } ?>
            <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="d-block ui-w-30 rounded-circle user_profile_avatar">
            <?php  } ?>
        <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?php echo $user[0]->first_name.' '.$user[0]->last_name;?></span> </span> </a>
        <div class="dropdown-menu dropdown-menu-right">
        <a href="<?php echo site_url('admin/profile');?>" class="dropdown-item"> <i class="ion ion-ios-person text-lightest"></i> &nbsp; <?php echo $this->lang->line('header_my_profile');?></a>
        <?php if(in_array('60',$role_resources_ids)) { ?>
        <a href="<?php echo site_url('admin/settings');?>" class="dropdown-item"> <i class="ion ion-md-settings text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_settings');?></a>
        <?php } ?>
        <a href="<?php echo site_url('admin/auth/lock')?>" class="dropdown-item"> <i class="fas fa-lock text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_lock_user');?></a>
        <?php if(in_array('87',$role_resources_ids)) { ?>
        <a href="<?php echo site_url('admin/log/changelog')?>" class="dropdown-item"><i class="fas fa-file text-lightest"></i> &nbsp; <?php echo $this->lang->line('hd_changelog');?></a>
            <?php } ?>
        <a href="<?php echo site_url('admin/profile?change_password=true')?>" class="dropdown-item"><i class="fas fa-key text-lightest"></i> &nbsp; <?php echo $this->lang->line('header_change_password');?></a>
        <div class="dropdown-divider"></div>
        <a href="<?php echo site_url('admin/logout');?>" class="dropdown-item"> <i class="ion ion-md-log-out text-danger"></i> &nbsp; <?php echo $this->lang->line('header_sign_out');?></a> </div>
      </div>
    </div>
  </div>
</nav>
