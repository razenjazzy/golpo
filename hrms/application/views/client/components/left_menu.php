<?php
$session = $this->session->userdata('client_username');
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
if($theme[0]->right_side_icons=='true') {
	$icons_right = 'expanded menu-icon-right';
} else {
	$icons_right = '';
}
if($theme[0]->bordered_menu=='true') {
	$menu_bordered = 'menu-bordered';
} else {
	$menu_bordered = '';
}
$user_info = $this->Clients_model->read_client_info($session['client_id']);
if($user_info[0]->is_active!=1) {
	redirect('client/auth/');
}

?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $arr_mod = $this->Xin_model->select_module_class($this->router->fetch_class(),$this->router->fetch_method()); ?>
<!-- menu start-->

<ul class="sidenav-inner py-1">
  <!-- Dashboards -->
  <li class="sidenav-item <?php if(!empty($arr_mod['active']))echo $arr_mod['active'];?>">
    <a href="<?php echo site_url('client/dashboard');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-md-speedometer"></i>
      <div><?php echo $this->lang->line('dashboard_title');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_client_project_active']))echo $arr_mod['hr_client_project_active'];?>">
    <a href="<?php echo site_url('client/projects');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-logo-buffer"></i>
      <div><?php echo $this->lang->line('left_projects');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_client_invoices_active']))echo $arr_mod['hr_client_invoices_active'];?>">
    <a href="<?php echo site_url('client/invoices');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-md-switch"></i>
      <div><?php echo $this->lang->line('xin_invoices_title');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_client_invoices_active']))echo $arr_mod['hr_client_invoices_active'];?>">
    <a href="<?php echo site_url('client/profile');?>" class="sidenav-link">
      <i class="sidenav-icon fas fa-user-edit"></i>
      <div><?php echo $this->lang->line('header_my_profile');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_client_invoices_active']))echo $arr_mod['hr_client_invoices_active'];?>">
    <a href="<?php echo site_url('client/profile?change_password=true');?>" class="sidenav-link">
      <i class="sidenav-icon fas fa-user-lock"></i>
      <div><?php echo $this->lang->line('header_change_password');?></div>
    </a>
  </li>
  <!--<li class="sidenav-item <?php if(!empty($arr_mod['hr_client_invoices_active']))echo $arr_mod['hr_client_invoices_active'];?>">
    <a href="<?php echo site_url('client/profile');?>" class="sidenav-link">
      <i class="sidenav-item ion ion-ios-person"></i>
      <div><?php echo $this->lang->line('header_my_profile');?></div>
    </a>
  </li>
  <li class="sidenav-item <?php if(!empty($arr_mod['hr_client_invoices_active']))echo $arr_mod['hr_client_invoices_active'];?>">
    <a href="<?php echo site_url('client/profile?change_password=true');?>" class="sidenav-link">
      <i class="sidenav-item ion ion-ios-unlock"></i>
      <div><?php echo $this->lang->line('header_change_password');?></div>
    </a>
  </li>-->
<li class="sidenav-item">
    <a href="<?php echo site_url('client/logout');?>" class="sidenav-link">
      <i class="sidenav-icon ion ion-md-log-out"></i>
      <div><?php echo $this->lang->line('left_logout');?></div>
    </a>
  </li>
</ul>