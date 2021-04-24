<?php
/* Employee Details view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php
$ar_sc = explode('- ',$system[0]->default_currency_symbol);
$sc_show = $ar_sc[1];
?>
<div class="card overflow-hidden">
  <div class="row no-gutters row-bordered row-border-light">
    <div class="col-md-3 pt-0">
      <div class="list-group list-group-flush account-settings-links">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#user-basic-info"><?php echo $this->lang->line('xin_e_details_basic');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#profile-picture"><?php echo $this->lang->line('xin_e_details_profile_picture');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#immigration"><?php echo $this->lang->line('xin_employee_immigration');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#contacts"><?php echo $this->lang->line('xin_employee_emergency_contacts');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#social-networking"><?php echo $this->lang->line('xin_e_details_social');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#documents"><?php echo $this->lang->line('xin_e_details_document');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#qualification"><?php echo $this->lang->line('xin_e_details_qualification');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#work-experience"><?php echo $this->lang->line('xin_e_details_w_experience');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#bank-account"><?php echo $this->lang->line('xin_e_details_baccount');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#change-password"><?php echo $this->lang->line('xin_e_details_cpassword');?></a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#leave"><?php echo $this->lang->line('xin_e_details_leave');?></a>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="user-basic-info">
        	<h6 class="card-header">
                <?php echo $this->lang->line('xin_e_details_basic_info');?>
            </h6>
          <div class="card-body">
            <?php $attributes = array('name' => 'basic_info', 'id' => 'basic_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/employees/basic_info', $attributes, $hidden);?>
            <div class="box box-block bg-white">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="employee_id"><?php echo $this->lang->line('dashboard_employee_id');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_employee_id');?>" name="employee_id" type="text" value="<?php echo $employee_id;?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="username"><?php echo $this->lang->line('dashboard_username');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $username;?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="<?php echo $email;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?php echo $company->company_id?>" <?php if($company_id==$company->company_id):?> selected="selected"<?php endif;?>><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group" id="department_ajax">
                    <label for="department"><?php echo $this->lang->line('xin_employee_department');?></label>
                    <select class="form-control" name="department_id" id="aj_department" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
                      <option value=""></option>
                      <?php foreach($all_departments as $department) {?>
                      <option value="<?php echo $department->department_id?>" <?php if($department_id==$department->department_id):?> selected <?php endif;?>><?php echo $department->department_name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group" id="designation_ajax">
                    <label for="designation"><?php echo $this->lang->line('xin_designation');?></label>
                    <select class="form-control" name="designation_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                      <option value=""></option>
                      <?php foreach($all_designations as $designation) {?>
                      <option value="<?php echo $designation->designation_id?>" <?php if($designation_id==$designation->designation_id):?> selected <?php endif;?>><?php echo $designation->designation_name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="date_of_birth"><?php echo $this->lang->line('xin_employee_dob');?></label>
                    <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_dob');?>" name="date_of_birth" type="text" value="<?php echo $date_of_birth;?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="date_of_joining" class="control-label"><?php echo $this->lang->line('xin_employee_doj');?></label>
                    <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="date_of_joining" type="text" value="<?php echo $date_of_joining;?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="date_of_leaving" class="control-label"><?php echo $this->lang->line('xin_employee_dol');?></label>
                    <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_dol');?>" name="date_of_leaving" type="text" value="<?php echo $date_of_leaving;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="role"><?php echo $this->lang->line('xin_employee_role');?></label>
                    <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_role');?>">
                      <option value=""></option>
                      <?php foreach($all_user_roles as $role) {?>
                      <option value="<?php echo $role->role_id?>" <?php if($user_role_id==$role->role_id):?> selected <?php endif;?>><?php echo $role->role_name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                    <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                      <option value="Male" <?php if($gender=='Male'):?> selected <?php endif; ?>>Male</option>
                      <option value="Female" <?php if($gender=='Female'):?> selected <?php endif; ?>>Female</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="marital_status" class="control-label"><?php echo $this->lang->line('xin_employee_mstatus');?></label>
                    <select class="form-control" name="marital_status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_mstatus');?>">
                      <option value="Single" <?php if($marital_status=='Single'):?> selected <?php endif; ?>>Single</option>
                      <option value="Married" <?php if($marital_status=='Married'):?> selected <?php endif; ?>>Married</option>
                      <option value="Widowed" <?php if($marital_status=='Widowed'):?> selected <?php endif; ?>>Widowed</option>
                      <option value="Divorced or Separated" <?php if($marital_status=='Divorced or Separated'):?> selected <?php endif; ?>>Divorced or Separated</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="contact_no" class="control-label"><?php echo $this->lang->line('xin_contact_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_no" type="text" value="<?php echo $contact_no;?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="status" class="control-label"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                    <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
     <option value="0" <?php if($is_active=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_employees_inactive');?></option>
     <option value="1" <?php if($is_active=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_employees_active');?></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="office_shift_id" class="control-label"><?php echo $this->lang->line('xin_employee_office_shift');?></label>
                    <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_office_shift');?>">
                      <?php foreach($all_office_shifts as $shift) {?>
                      <option value="<?php echo $shift->office_shift_id?>" <?php if($office_shift_id == $shift->office_shift_id):?> selected="selected" <?php endif; ?>><?php echo $shift->shift_name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="address"><?php echo $this->lang->line('xin_employee_address');?></label>
                    <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_address');?>" name="address" cols="30" rows="3" id="address"><?php echo $address;?></textarea>
                  </div>
                </div>
              </div>
              <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
            </div>
            <?php echo form_close(); ?> </div>

        </div>
        <div class="tab-pane fade" id="profile-picture">
        	<h6 class="card-header">
                <?php echo $this->lang->line('xin_e_details_profile_picture');?>
            </h6>
          <div class="card-body pb-2">
            <?php $attributes = array('name' => 'profile_picture', 'id' => 'f_profile_picture', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_profile_picture' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/employees/profile_picture', $attributes, $hidden);?>
            <?php
				  $data_usr = array(
						'type'  => 'hidden',
						'name'  => 'user_id',
						'id'    => 'user_id',
						'value' => $user_id,
				 );
				echo form_input($data_usr);
			  ?>
            <?php
				  $data_usr = array(
						'type'  => 'hidden',
						'name'  => 'session_id',
						'id'    => 'session_id',
						'value' => $session['user_id'],
				 );
				echo form_input($data_usr);
			  ?>
            <div class="box box-block bg-white">
              <div class="row">
                <div class="col-md-12">
                  <div class='form-group'>
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_browse');?></label>
                      <input type="file" class="form-control-file" id="p_file" name="p_file">
                      <small><?php echo $this->lang->line('xin_e_details_picture_type');?></small>
                    </fieldset>
                    <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                    <img src="<?php echo base_url().'uploads/profile/'.$profile_picture;?>" width="50px" style="margin-left:20px;" id="u_file">
                    <?php } else {?>
                    <?php if($gender=='Male') { ?>
                    <?php $de_file = base_url().'uploads/profile/default_male.jpg';?>
                    <?php } else { ?>
                    <?php $de_file = base_url().'uploads/profile/default_female.jpg';?>
                    <?php } ?>
                    <img src="<?php echo $de_file;?>" width="50px" style="margin-left:20px;" id="u_file">
                    <?php } ?>
                    <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                    <br />
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="remove_profile_picture" value="1" name="remove_profile_picture">
                      <span class="custom-control-indicator"></span> <span class="custom-control-description"><?php echo $this->lang->line('xin_e_details_remove_pic');?></span> </label>
                    <?php } else {?>
                    <div id="remove_file" style="display:none;">
                      <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remove_profile_picture" value="1" name="remove_profile_picture">
                        <span class="custom-control-indicator"></span> <span class="custom-control-description"><?php echo $this->lang->line('xin_e_details_remove_pic');?></span> </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
        <div class="tab-pane fade" id="immigration">
            <h6 class="card-header">
                <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_employee_immigration');?>
            </h6>
            <div class="card-body pb-2">
            <?php $attributes = array('name' => 'immigration_info', 'id' => 'immigration_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $user_id, 'u_document_info' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/employees/immigration_info', $attributes, $hidden);?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="relation"><?php echo $this->lang->line('xin_e_details_document');?></label>
                  <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                    <option value=""></option>
                    <?php foreach($all_document_types as $document_type) {?>
                    <option value="<?php echo $document_type->document_type_id;?>"> <?php echo $document_type->document_type;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="document_number" class="control-label"><?php echo $this->lang->line('xin_employee_document_number');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_document_number');?>" name="document_number" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="issue_date" class="control-label"><?php echo $this->lang->line('xin_issue_date');?></label>
                  <input class="form-control date" readonly="readonly" placeholder="Issue Date" name="issue_date" type="text">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="expiry_date" class="control-label"><?php echo $this->lang->line('xin_e_details_doe');?></label>
                  <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_e_details_doe');?>" name="expiry_date" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?></label>
                    <input type="file" class="form-control-file" id="p_file2" name="document_file">
                    <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="eligible_review_date" class="control-label"><?php echo $this->lang->line('xin_eligible_review_date');?></label>
                  <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_eligible_review_date');?>" name="eligible_review_date" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="send_mail"><?php echo $this->lang->line('xin_country');?></label>
                  <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <?php foreach($all_countries as $scountry) {?>
                    <option value="<?php echo $scountry->country_id;?>"> <?php echo $scountry->country_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
            <div class="card">
            <h6 class="card-header">
			<?php echo $this->lang->line('xin_assigned_immigration');?> <?php echo $this->lang->line('xin_records');?></h6>
            <div class="card-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_imgdocument" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_document');?></th>
                    <th><?php echo $this->lang->line('xin_issue_date');?></th>
                    <th><?php echo $this->lang->line('xin_expiry_date');?></th>
                    <th><?php echo $this->lang->line('xin_issued_by');?></th>
                    <th><?php echo $this->lang->line('xin_eligible_review_date');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="contacts">
          <h6 class="card-header">
                <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_contact');?>
            </h6>
            <div class="card-body pb-2">
            <?php $attributes = array('name' => 'contact_info', 'id' => 'contact_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_basic_info' => 'ADD');?>
            <?php echo form_open('admin/employees/contact_info', $attributes, $hidden);?>
            <?php
				  $data_usr1 = array(
						'type'  => 'hidden',
						'name'  => 'user_id',
						'id'    => 'user_id',
						'value' => $user_id,
				 );
				echo form_input($data_usr1);
			  ?>
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="relation"><?php echo $this->lang->line('xin_e_details_relation');?></label>
                  <select class="form-control" name="relation" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="Self"><?php echo $this->lang->line('xin_self');?></option>
                    <option value="Parent"><?php echo $this->lang->line('xin_parent');?></option>
                    <option value="Spouse"><?php echo $this->lang->line('xin_spouse');?></option>
                    <option value="Child"><?php echo $this->lang->line('xin_child');?></option>
                    <option value="Sibling"><?php echo $this->lang->line('xin_sibling');?></option>
                    <option value="In Laws"><?php echo $this->lang->line('xin_in_laws');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <label for="work_email" class="control-label"><?php echo $this->lang->line('dashboard_email');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_work');?>" name="work_email" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="is_primary" value="1" name="is_primary">
                      <span class="custom-control-label"><?php echo $this->lang->line('xin_e_details_pcontact');?></span>
                    </label>
                  &nbsp;
                  <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="is_dependent" value="1" name="is_dependent">
                      <span class="custom-control-label"><?php echo $this->lang->line('xin_e_details_dependent');?></span>
                    </label>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_personal');?>" name="personal_email" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="name" class="control-label"><?php echo $this->lang->line('xin_name');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_name');?>" name="contact_name" type="text">
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group" id="designation_ajax">
                  <label for="address_1" class="control-label"><?php echo $this->lang->line('xin_address');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text">

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="work_phone"><?php echo $this->lang->line('xin_phone');?></label>
                  <div class="row">
                    <div class="col-md-8">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_work');?>" name="work_phone" type="text">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_phone_ext');?>" name="work_phone_extension" type="text">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_mobile');?>" name="mobile_phone" type="text">
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-5">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text">
                    </div>
                    <div class="col-md-4">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text">
                    </div>
                    <div class="col-md-3">
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_home');?>" name="home_phone" type="text">
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <select name="country" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                    <option value=""></option>
                    <?php foreach($all_countries as $country) {?>
                    <option value="<?php echo $country->country_id;?>"> <?php echo $country->country_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
            <?php echo form_close(); ?> </div>
            <div class="card">
            <h6 class="card-header">
			<?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_contacts');?></h6>
            <div class="card-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_contact" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_relation');?></th>
                    <th><?php echo $this->lang->line('dashboard_email');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_mobile');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="documents">
          <h6 class="card-header">
                <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_document');?>
            </h6>
            <div class="card-body pb-2">
            <?php $attributes = array('name' => 'document_info', 'id' => 'document_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_document_info' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/employees/document_info', $attributes, $hidden);?>
            <?php
				  $data_usr2 = array(
						'type'  => 'hidden',
						'name'  => 'user_id',
						'value' => $user_id,
				 );
				echo form_input($data_usr2);
			  ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="relation"><?php echo $this->lang->line('xin_e_details_dtype');?></label>
                  <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                    <option value=""></option>
                    <?php foreach($all_document_types as $document_type) {?>
                    <option value="<?php echo $document_type->document_type_id;?>"> <?php echo $document_type->document_type;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="date_of_expiry" class="control-label"><?php echo $this->lang->line('xin_e_details_doe');?></label>
                  <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_e_details_doe');?>" name="date_of_expiry" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="title" class="control-label"><?php echo $this->lang->line('xin_e_details_dtitle');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_dtitle');?>" name="title" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email" class="control-label"><?php echo $this->lang->line('xin_e_details_notifyemail');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_notifyemail');?>" name="email" type="email">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description" class="control-label"><?php echo $this->lang->line('xin_description');?></label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?></label>
                    <input type="file" class="form-control-file" id="document_file" name="document_file">
                    <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="send_mail"><?php echo $this->lang->line('xin_e_details_send_notifyemail');?></label>
                  <select name="send_mail" id="send_mail" class="form-control" data-plugin="select_hrm">
                    <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                    <option value="2"><?php echo $this->lang->line('xin_no');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
            <div class="card">
            <h6 class="card-header">
			<?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_documents');?></h6>
            <div class="card-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                    <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_notifyemail');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_doe');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="qualification">
          <h6 class="card-header">
                <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_qualification');?>
            </h6>
            <div class="card-body pb-2">
            <?php $attributes = array('name' => 'qualification_info', 'id' => 'qualification_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/employees/qualification_info', $attributes, $hidden);?>
            <?php
				  $data_usr3 = array(
						'type'  => 'hidden',
						'name'  => 'user_id',
						'value' => $user_id,
				 );
				echo form_input($data_usr3);
			  ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name"><?php echo $this->lang->line('xin_e_details_inst_name');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_inst_name');?>" name="name" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="education_level" class="control-label"><?php echo $this->lang->line('xin_e_details_edu_level');?></label>
                  <select class="form-control" name="education_level" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_edu_level');?>">
                    <?php foreach($all_education_level as $education_level) {?>
                    <option value="<?php echo $education_level->education_level_id?>"><?php echo $education_level->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="from_year" class="control-label"><?php echo $this->lang->line('xin_e_details_timeperiod');?></label>
                  <div class="row">
                    <div class="col-md-6">
                      <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_e_details_from');?>" name="from_year" type="text">
                    </div>
                    <div class="col-md-6">
                      <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('dashboard_to');?>" name="to_year" type="text">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="language" class="control-label"><?php echo $this->lang->line('xin_e_details_language');?></label>
                  <select class="form-control" name="language" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_language');?>">
                    <?php foreach($all_qualification_language as $qualification_language) {?>
                    <option value="<?php echo $qualification_language->language_id?>"><?php echo $qualification_language->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="skill" class="control-label"><?php echo $this->lang->line('xin_e_details_skill');?></label>
                  <select class="form-control" name="skill" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_skill');?>">
                    <option value=""></option>
                    <?php foreach($all_qualification_skill as $qualification_skill) {?>
                    <option value="<?php echo $qualification_skill->skill_id?>"><?php echo $qualification_skill->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="to_year" class="control-label"><?php echo $this->lang->line('xin_description');?></label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="d_description"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
            <div class="card">
            <h6 class="card-header">
			<?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_qualification');?></h6>
            <div class="card-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_qualification" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_inst_name');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_timeperiod');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_edu_level');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="work-experience">
          <h6 class="card-header">
                <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_w_experience');?>
            </h6>
            <div class="card-body pb-2">
            <?php $attributes = array('name' => 'work_experience_info', 'id' => 'work_experience_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/employees/work_experience_info', $attributes, $hidden);?>
            <?php
				  $data_usr4 = array(
						'type'  => 'hidden',
						'name'  => 'user_id',
						'value' => $user_id,
				 );
				echo form_input($data_usr4);
			  ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="company_name" type="text" value="" id="company_name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="post"><?php echo $this->lang->line('xin_e_details_post');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_post');?>" name="post" type="text" value="" id="post">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="from_year" class="control-label"><?php echo $this->lang->line('xin_e_details_timeperiod');?></label>
                  <div class="row">
                    <div class="col-md-6">
                      <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_e_details_from');?>" name="from_date" type="text">
                    </div>
                    <div class="col-md-6">
                      <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('dashboard_to');?>" name="to_date" type="text">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="4" id="description"></textarea>
                  <span class="countdown"></span> </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
            <div class="card">
            <h6 class="card-header">
			<?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_w_experience');?></h6>
            <div class="card-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_work_experience" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_company_name');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_frm_date');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_to_date');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_post');?></th>
                    <th><?php echo $this->lang->line('xin_description');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="bank-account">
          <h6 class="card-header">
                <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_baccount');?>
            </h6>
            <div class="card-body pb-2">
            <?php $attributes = array('name' => 'bank_account_info', 'id' => 'bank_account_info', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/employees/bank_account_info', $attributes, $hidden);?>
            <?php
				  $data_usr4 = array(
						'type'  => 'hidden',
						'name'  => 'user_id',
						'value' => $user_id,
				 );
				echo form_input($data_usr4);
			  ?>
           <div class="row">   
            <div class="col-md-6">
              <div class="form-group">
                <label for="account_title"><?php echo $this->lang->line('xin_e_details_acc_title');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_title');?>" name="account_title" type="text" value="" id="account_name">
              </div>
            </div>
            <div class="col-md-6">  
              <div class="form-group">
                <label for="account_number"><?php echo $this->lang->line('xin_e_details_acc_number');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_number');?>" name="account_number" type="text" value="" id="account_number">
              </div>
            </div>
           </div> 
          <div class="row">  
            <div class="col-md-6">
              <div class="form-group">
                <label for="bank_name"><?php echo $this->lang->line('xin_e_details_bank_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_name');?>" name="bank_name" type="text" value="" id="bank_name">
              </div>
             </div>
           <div class="col-md-6">   
              <div class="form-group">
                <label for="bank_code"><?php echo $this->lang->line('xin_e_details_bank_code');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_code');?>" name="bank_code" type="text" value="" id="bank_code">
              </div>
            </div>
          </div>  
           <div class="row"> 
            <div class="col-md-12">
              <div class="form-group">
                <label for="bank_branch"><?php echo $this->lang->line('xin_e_details_bank_branch');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_branch');?>" name="bank_branch" type="text" value="" id="bank_branch">
              </div>
            </div>
           </div> 
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
            <div class="card">
            <h6 class="card-header">
			<?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_baccount');?></h6>
            <div class="card-datatable table-responsive">
              <table class="table table-striped table-bordered dataTable" id="xin_table_bank_account" style="width:100%;">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_acc_title');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_acc_number');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_bank_name');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_bank_code');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_bank_branch');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="social-networking">
          <h6 class="card-header">
                <?php echo $this->lang->line('xin_e_details_social');?>
            </h6>
            <div class="card-body pb-2">
            <?php $attributes = array('name' => 'social_networking', 'id' => 'f_social_networking', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/employees/social_info', $attributes, $hidden);?>
            <div class="box box-block bg-white">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="facebook_profile"><?php echo $this->lang->line('xin_e_details_fb_profile');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_fb_profile');?>" name="facebook_link" type="text" value="<?php echo $facebook_link;?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="facebook_profile"><?php echo $this->lang->line('xin_e_details_twit_profile');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_twit_profile');?>" name="twitter_link" type="text" value="<?php echo $twitter_link;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="twitter_profile"><?php echo $this->lang->line('xin_e_details_blogr_profile');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_blogr_profile');?>" name="blogger_link" type="text" value="<?php echo $blogger_link;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="blogger_profile"><?php echo $this->lang->line('xin_e_details_linkd_profile');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_linkd_profile');?>" name="linkdedin_link" type="text" value="<?php echo $linkdedin_link;?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="blogger_profile"><?php echo $this->lang->line('xin_e_details_gplus_profile');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_gplus_profile');?>" name="google_plus_link" type="text" value="<?php echo $google_plus_link;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_insta_profile');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_insta_profile');?>" name="instagram_link" type="text" value="<?php echo $instagram_link;?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_pintrst_profile');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_pintrst_profile');?>" name="pinterest_link" type="text" value="<?php echo $pinterest_link;?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_utube_profile');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_utube_profile');?>" name="youtube_link" type="text" value="<?php echo $youtube_link;?>">
                  </div>
                </div>
              </div>
              <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
        <div class="tab-pane fade" id="change-password">
          <h6 class="card-header">
                <?php echo $this->lang->line('header_change_password');?>
            </h6>
            <div class="card-body pb-2">
          <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
            <?php echo form_open('admin/employees/change_password', $attributes, $hidden);?>
            <?php
				  $data_usr5 = array(
						'type'  => 'hidden',
						'name'  => 'user_id',
						'value' => $user_id,
				 );
				echo form_input($data_usr5);
			  ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="new_password"><?php echo $this->lang->line('xin_e_details_enpassword');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_enpassword');?>" name="new_password" type="text">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="new_password_confirm" class="control-label"><?php echo $this->lang->line('xin_e_details_ecnpassword');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_ecnpassword');?>" name="new_password_confirm" type="text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
        <div class="tab-pane fade" id="leave">
          <h6 class="card-header">
                <?php echo $this->lang->line('xin_e_details_leave');?>
            </h6>
            <div class="card-body pb-2">
            <div class="row">
              <?php foreach($all_leave_types as $type) {?>
				  <?php $count_l = $this->Timesheet_model->count_total_leaves($type->leave_type_id,$this->uri->segment(4));?>
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
                        <div class="text-muted small">
						<?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $type->days_per_year;?>)</div>
                        <div class="text-large"><div class="progress" style="height: 6px;">
                        <div class="progress-bar" style="width: <?php echo $count_data;?>%;"></div>
                      </div></div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <?php
				}
				?>              
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
