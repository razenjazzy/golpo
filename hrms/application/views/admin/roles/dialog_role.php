<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['role_id']) && $_GET['data']=='role'){
$role_resources_ids = explode(',',$role_resources);
?>

<div class="modal-header">
  <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_role_editrole');?></h4>
</div>
<?php $attributes = array('name' => 'edit_role', 'id' => 'edit_role', 'autocomplete' => 'off','class' => '"m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'ext_name' => $role_name, '_token' => $role_id);?>
<?php echo form_open('admin/roles/update/'.$role_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_name"><?php echo $this->lang->line('xin_role_name');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_role_name');?>" name="role_name" type="text" value="<?php echo $role_name;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          </div>
        <div class="row">
        	<input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_access"><?php echo $this->lang->line('xin_role_access');?></label>
              <select class="form-control custom-select" id="role_access_modal" name="role_access" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_role_access');?>">
                <option value="">&nbsp;</option>
                <option value="1" <?php if($role_access==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('xin_role_all_menu');?></option>
                <option value="2" <?php if($role_access==2):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('xin_role_cmenu');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="resources"><?php echo $this->lang->line('xin_role_resource');?></label>
              <div id="all_resources">
                <div class="demo-section k-content">
                  <div>
                    <div id="treeview_m1"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div id="all_resources">
                <div class="demo-section k-content">
                  <div>
                    <div id="treeview_m2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_update'))); ?> 
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 

		/* Edit data */
		$("#edit_role").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=role&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
					} else {
						// On page load: datatable
						var xin_table = $('#xin_table').dataTable({
							"bDestroy": true,
							"ajax": {
								url : "<?php echo site_url("admin/roles/role_list") ?>",
								type : 'GET'
							},
							dom: 'lBfrtip',
							"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
					}
				}
			});
		});
	});	
  </script>
  <script>

jQuery("#treeview_m1").kendoTreeView({
checkboxes: {
checkChildren: true,
//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
},
check: onCheck,
dataSource: [

{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('let_staff');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('103',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "103",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('dashboard_employees');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "13", check: "<?php if(isset($_GET['role_id'])) { if(in_array('13',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_import_employees');?>",  add_info: "<?php echo $this->lang->line('xin_import_employees');?>", value: "92", check: "<?php if(isset($_GET['role_id'])) { if(in_array('92',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_employees_directory');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "88", check: "<?php if(isset($_GET['role_id'])) { if(in_array('88',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	//
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('12',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "12",  items: [
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_awards');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "14", check: "<?php if(isset($_GET['role_id'])) { if(in_array('14',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_transfers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "15", check: "<?php if(isset($_GET['role_id'])) { if(in_array('15',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_resignations');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "16", check: "<?php if(isset($_GET['role_id'])) { if(in_array('16',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_travels');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "17", check: "<?php if(isset($_GET['role_id'])) { if(in_array('17',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_promotions');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "18", check: "<?php if(isset($_GET['role_id'])) { if(in_array('18',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_complaints');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "19", check: "<?php if(isset($_GET['role_id'])) { if(in_array('19',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_warnings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "20", check: "<?php if(isset($_GET['role_id'])) { if(in_array('20',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_terminations');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "21", check: "<?php if(isset($_GET['role_id'])) { if(in_array('21',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_employees_last_login');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "22", check: "<?php if(isset($_GET['role_id'])) { if(in_array('22',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_employees_exit');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "23", check: "<?php if(isset($_GET['role_id'])) { if(in_array('23',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_organization');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "", value:"2", items: [
	// sub 1
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_announcements');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "11", check: "<?php if(isset($_GET['role_id'])) { if(in_array('11',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_policies');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "9", check: "<?php if(isset($_GET['role_id'])) { if(in_array('9',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_org_chart_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "96", check: "<?php if(isset($_GET['role_id'])) { if(in_array('96',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_department');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "3", check: "<?php if(isset($_GET['role_id'])) { if(in_array('3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_designation');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "4", check: "<?php if(isset($_GET['role_id'])) { if(in_array('4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_company');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "5", check: "<?php if(isset($_GET['role_id'])) { if(in_array('5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_location');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "6", check: "<?php if(isset($_GET['role_id'])) { if(in_array('6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_office_shifts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "7", check: "<?php if(isset($_GET['role_id'])) { if(in_array('7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_holidays');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "8", check: "<?php if(isset($_GET['role_id'])) { if(in_array('8',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_expense');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "10", check: "<?php if(isset($_GET['role_id'])) { if(in_array('10',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	
	]}, // sub 1 end
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('24',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "24",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "25", check: "<?php if(isset($_GET['role_id'])) { if(in_array('25',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_category');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "26", check: "<?php if(isset($_GET['role_id'])) { if(in_array('26',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_events_meetings');?>",  check: "<?php if(isset($_GET['role_id'])) { if(in_array('97',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "", value: "97",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_events');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "98", check: "<?php if(isset($_GET['role_id'])) { if(in_array('98',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_meetings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "99", check: "<?php if(isset($_GET['role_id'])) { if(in_array('99',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_timesheet');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('27',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "27",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "28", check: "<?php if(isset($_GET['role_id'])) { if(in_array('28',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_date_wise_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "29", check: "<?php if(isset($_GET['role_id'])) { if(in_array('29',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_update_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "30", check: "<?php if(isset($_GET['role_id'])) { if(in_array('30',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_import_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_attendance_import');?>", value: "31", check: "<?php if(isset($_GET['role_id'])) { if(in_array('31',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_recruitment');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('48',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "48",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_job_posts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "49", check: "<?php if(isset($_GET['role_id'])) { if(in_array('49',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_jobs_listing');?> <small><?php echo $this->lang->line('left_frontend');?></small>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "50", check: "<?php if(isset($_GET['role_id'])) { if(in_array('50',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_job_candidates');?>",  add_info: "<?php echo $this->lang->line('xin_update_status_delete');?>", value: "51", check: "<?php if(isset($_GET['role_id'])) { if(in_array('51',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_job_interviews');?>",  add_info: "<?php echo $this->lang->line('xin_add_delete');?>", value: "52", check: "<?php if(isset($_GET['role_id'])) { if(in_array('52',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_payroll');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('32',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "32",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_hourly_wages');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "33", check: "<?php if(isset($_GET['role_id'])) { if(in_array('33',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_payroll_templates');?>",  add_info: "<?php echo $this->lang->line('xin_create_edit_delete_role');?>", value: "34", check: "<?php if(isset($_GET['role_id'])) { if(in_array('34',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_manage_salary');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "35", check: "<?php if(isset($_GET['role_id'])) { if(in_array('35',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_generate_payslip');?>",  add_info: "<?php echo $this->lang->line('xin_generate_view');?>", value: "36", check: "<?php if(isset($_GET['role_id'])) { if(in_array('36',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_payment_history');?>",  add_info: "<?php echo $this->lang->line('xin_view_payslip');?>", value: "37", check: "<?php if(isset($_GET['role_id'])) { if(in_array('37',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_advance_salary');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "38", check: "<?php if(isset($_GET['role_id'])) { if(in_array('38',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_advance_salary_report');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "39", check: "<?php if(isset($_GET['role_id'])) { if(in_array('39',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_performance');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('40',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "40",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_performance_indicator');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "41", check: "<?php if(isset($_GET['role_id'])) { if(in_array('41',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_performance_appraisal');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "42",check: "<?php if(isset($_GET['role_id'])) { if(in_array('42',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_tickets');?>",  check: "<?php if(isset($_GET['role_id'])) { if(in_array('43',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", value: "43",},
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_leaves');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "46", check: "<?php if(isset($_GET['role_id'])) { if(in_array('46',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_projects');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('104',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "104",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_projects');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "44", check: "<?php if(isset($_GET['role_id'])) { if(in_array('44',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_tasks');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "45", check: "<?php if(isset($_GET['role_id'])) { if(in_array('45',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_project_clients');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "119", check: "<?php if(isset($_GET['role_id'])) { if(in_array('119',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_invoice_create');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "120", check: "<?php if(isset($_GET['role_id'])) { if(in_array('120',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_invoices_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "121", check: "<?php if(isset($_GET['role_id'])) { if(in_array('121',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_invoice_tax_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "122", check: "<?php if(isset($_GET['role_id'])) { if(in_array('122',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking');?>",  check: "<?php if(isset($_GET['role_id'])) { if(in_array('106',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "", value: "106",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "107", check: "<?php if(isset($_GET['role_id'])) { if(in_array('107',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "108", check: "<?php if(isset($_GET['role_id'])) { if(in_array('108',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_files_manager');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "47", check: "<?php if(isset($_GET['role_id'])) { if(in_array('47',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	
]
});

jQuery("#treeview_m2").kendoTreeView({
checkboxes: {
checkChildren: true,
//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
},
check: onCheck,
dataSource: [
//
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_training');?>",  add_info: "", value: "53", check: "<?php if(isset($_GET['role_id'])) { if(in_array('53',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_training_list');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('54',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "54"},
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_training_type');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('55',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "55",},
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_trainers_list');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('56',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "56",},
]},
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('57',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",value: "57",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_settings');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "60", check: "<?php if(isset($_GET['role_id'])) { if(in_array('60',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "61", check: "<?php if(isset($_GET['role_id'])) { if(in_array('61',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_db_backup');?>",  add_info: "<?php echo $this->lang->line('xin_create_delete_download');?>", value: "62", check: "<?php if(isset($_GET['role_id'])) { if(in_array('62',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_email_templates');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "63", check: "<?php if(isset($_GET['role_id'])) { if(in_array('63',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_setup_modules');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "93", check: "<?php if(isset($_GET['role_id'])) { if(in_array('93',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	
{ id: "", class: "role-checkbox-modal custom-control-input",text: "<?php echo $this->lang->line('xin_acc_accounts');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('71',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "",value: "71",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_list');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('72',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "72"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_balances');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('73',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "73",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input",text: "<?php echo $this->lang->line('xin_acc_transactions');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('74',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "",value: "74",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_deposit');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('75',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "75"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_expense');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('76',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "76",},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_transfer');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('77',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "77",},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_view_transactions');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('78',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_view');?>", value: "78",},
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input",text: "<?php echo $this->lang->line('xin_acc_payees_payers');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('79',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "",value: "79",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_payees');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('80',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "80"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_payers');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('81',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "81",},
	]},
	
	{ id: "", class: "role-checkbox-modal custom-control-input",text: "<?php echo $this->lang->line('xin_acc_reports');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('82',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "",value: "82",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_statement');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('83',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_view');?>", value: "83"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_expense_reports');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('84',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_view');?>", value: "84",},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_income_reports');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('85',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_view');?>", value: "85",},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_transfer_report');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('86',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "86",},
	]},
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('hd_changelog');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "87", check: "<?php if(isset($_GET['role_id'])) { if(in_array('87',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_lang_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "89", check: "<?php if(isset($_GET['role_id'])) { if(in_array('89',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_notify_top');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "90", check: "<?php if(isset($_GET['role_id'])) { if(in_array('90',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('header_apply_jobs');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "91", check: "<?php if(isset($_GET['role_id'])) { if(in_array('91',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_theme_settings');?>",  add_info: "<?php echo $this->lang->line('xin_theme_settings');?>", value: "94", check: "<?php if(isset($_GET['role_id'])) { if(in_array('94',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_calendar_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "95", check: "<?php if(isset($_GET['role_id'])) { if(in_array('95',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input",text: "<?php echo $this->lang->line('xin_hr_report_title');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('110',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "",value: "110", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_payslip');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "111", check: "<?php if(isset($_GET['role_id'])) { if(in_array('111',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_attendance_employee');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "112", check: "<?php if(isset($_GET['role_id'])) { if(in_array('112',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_training');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "113", check: "<?php if(isset($_GET['role_id'])) { if(in_array('113',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_projects');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "114", check: "<?php if(isset($_GET['role_id'])) { if(in_array('114',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_tasks');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "115", check: "<?php if(isset($_GET['role_id'])) { if(in_array('115',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_report_user_roles');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "116", check: "<?php if(isset($_GET['role_id'])) { if(in_array('116',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_report_employees');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "117", check: "<?php if(isset($_GET['role_id'])) { if(in_array('117',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_hr_chat_box');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "118", check: "<?php if(isset($_GET['role_id'])) { if(in_array('118',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
]
});
		
// show checked node IDs on datasource change
function onCheck() {
var checkedNodes = [],
treeView = jQuery("#treeview").data("kendoTreeView"),
message;
//checkedNodeIds(treeView.dataSource.view(), checkedNodes);
jQuery("#result").html(message);
}
$(document).ready(function(){
	$("#role_access_modal").change(function(){
		var sel_val = $(this).val();
		if(sel_val=='1') {
			$('.role-checkbox-modal').prop('checked', true);
		} else {
			$('.role-checkbox-modal').attr("checked", false);
		}
	});
});
</script>
<?php }
?>
