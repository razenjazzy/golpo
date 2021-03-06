<?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
<div class="form-group">
   <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
   <select name="employee_id" id="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
    <option value=""></option>
    <?php foreach($result as $employee) {?>
    <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
    <?php } ?>
  </select>     
  <span id="remaining_leave" style="display:none; font-weight:600; color:#F00;">&nbsp;</span>           
</div>
<?php
//}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
	jQuery("#employee_id").change(function(){
		var leave_type_id = jQuery('#leave_type').val();
		var employee_id = jQuery(this).val();
		if(leave_type_id == '' || leave_type_id == 0) {
			jQuery('#remaining_leave').show();
			jQuery('#remaining_leave').html('<?php echo $this->lang->line('xin_error_leave_type_field');?>');
		} else {
			jQuery.get(base_url+"/get_employees_leave/"+leave_type_id+"/"+employee_id, function(data, status){
				jQuery('#remaining_leave').show();
				jQuery('#remaining_leave').html(data);
			});
		}
		
	});
});
</script>