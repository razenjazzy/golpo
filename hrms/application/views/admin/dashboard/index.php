<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
?>
<?php if($user_info[0]->user_role_id==1): ?>
<?php $this->load->view('admin/dashboard/administrator_dashboard');?>
<?php else:?>
<?php $this->load->view('admin/dashboard/employee_dashboard');?>
<?php endif;?>