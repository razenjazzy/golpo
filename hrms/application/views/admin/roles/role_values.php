<script type="text/javascript">
//$(document).ready(function(){
	jQuery("#treeview_r1").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
	template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
	},
	//<label class='custom-control custom-checkbox'><input type='checkbox' class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>
	
	//template: "<label class="custom-control custom-checkbox"><input type="checkbox" #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class="custom-control-label">#= item.add_info #</span></label>"
	check: onCheck,
	dataSource: [
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('let_staff');?>",  add_info: "", value: "103",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('dashboard_employees');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "13",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_import_employees');?>",  add_info: "<?php echo $this->lang->line('xin_import_employees');?>", value: "92",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_employees_directory');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "88",},
	]},
	//
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr');?>",  add_info: "", value: "12",  items: [
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_awards');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "14",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_transfers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "15",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_resignations');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "16",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_travels');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "17",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_promotions');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "18",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_complaints');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "19",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_warnings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "20",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_terminations');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "21",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_employees_last_login');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "22",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_employees_exit');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "23",}
	]},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_organization');?>", add_info: "", value:"2", items: [
	// sub 1
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_announcements');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "11",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_policies');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "9",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_org_chart_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "96",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_department');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "3",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_designation');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "4",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_company');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "5",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_location');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "6",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_office_shifts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "7",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_holidays');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "8",},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_expense');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "10",},
	
	]}, // sub 1 end
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "", value: "24",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "25",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_category');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "26",},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_events_meetings');?>",  add_info: "", value: "97",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_events');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "98",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_meetings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "99",},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_timesheet');?>",  add_info: "", value: "27",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "28"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_date_wise_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "29",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_update_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "30",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_import_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_attendance_import');?>", value: "31",}
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_recruitment');?>",  add_info: "", value: "48",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_job_posts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "49"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_jobs_listing');?> <small><?php echo $this->lang->line('left_frontend');?></small>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "50"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_job_candidates');?>",  add_info: "<?php echo $this->lang->line('xin_update_status_delete');?>", value: "51"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_job_interviews');?>",  add_info: "<?php echo $this->lang->line('xin_add_delete');?>", value: "52"},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_payroll');?>",  add_info: "", value: "32",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_hourly_wages');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "33",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_payroll_templates');?>",  add_info: "<?php echo $this->lang->line('xin_create_edit_delete_role');?>", value: "34",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_manage_salary');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "35",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_generate_payslip');?>",  add_info: "<?php echo $this->lang->line('xin_generate_view');?>", value: "36",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_payment_history');?>",  add_info: "<?php echo $this->lang->line('xin_view_payslip');?>", value: "37",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_advance_salary');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "38",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_advance_salary_report');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "39",},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_performance');?>",  add_info: "", value: "40",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_performance_indicator');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "41",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_performance_appraisal');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "42",},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_tickets');?>",  add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", value: "43",},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_leaves');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "46",},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_projects');?>",  add_info: "", value: "104",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_projects');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "44",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_tasks');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "45",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_project_clients');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "119",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_invoice_create');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "120",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_invoices_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "121",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_invoice_tax_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "122",},
	]},
		
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking');?>",  add_info: "", value: "106",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "107",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_goal_tracking_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "108",},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_files_manager');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "47",},

	]
	});
	
	jQuery("#treeview_r2").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
	template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
	},
	check: onCheck,
	dataSource: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_training');?>",  add_info: "", value: "53",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_training_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "54"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_training_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "55",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_trainers_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "56",},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "", value: "57",  items: [
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_settings');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "60",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "61",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_db_backup');?>",  add_info: "<?php echo $this->lang->line('xin_create_delete_download');?>", value: "62",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('left_email_templates');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "63",},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_setup_modules');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "93",}
	]},
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_acc_accounts');?>", add_info: "",value: "71",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "72"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_balances');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "73",},
	]},
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_acc_transactions');?>", add_info: "",value: "74",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_deposit');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "75"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_expense');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "76",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_transfer');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "77",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_view_transactions');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "78",},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_acc_payees_payers');?>", add_info: "",value: "79",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_payees');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "80"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_payers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "81",},
	]},
	
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_acc_reports');?>", add_info: "",value: "82",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_statement');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "83"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_expense_reports');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "84",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_income_reports');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "85",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_acc_transfer_report');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "86",},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('hd_changelog');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "87",},
	
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_lang_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "89",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_notify_top');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "90",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('header_apply_jobs');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "91",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_theme_settings');?>",  add_info: "<?php echo $this->lang->line('xin_theme_settings');?>", value: "94",},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_calendar_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "95",},
	
	{ id: "", class: "role-checkbox custom-control-input",text: "<?php echo $this->lang->line('xin_hr_report_title');?>", add_info: "",value: "110",  items: [
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_payslip');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "111"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_attendance_employee');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "112"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_training');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "113"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_projects');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "114"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_reports_tasks');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "115"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_report_user_roles');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "116"},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_report_employees');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "117"},
	]},
	{ id: "", class: "role-checkbox custom-control-input", text: "<?php echo $this->lang->line('xin_hr_chat_box');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "118",},
	//
	]
	});
//});
// show checked node IDs on datasource change
function onCheck() {
var checkedNodes = [],
		treeView = jQuery("#treeview2").data("kendoTreeView"),
		message;
		jQuery("#result").html(message);
}
</script>