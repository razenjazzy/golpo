<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['training_id']) && $_GET['data']=='view_training'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_training');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?php echo $company->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('left_training_type');?></th>
          <td style="display: table-cell;"><?php foreach($all_training_types as $training_type) {?>
		<?php if($training_type_id==$training_type->training_type_id):?> <?php echo $training_type->type?> <?php endif;?>
        <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_trainer');?></th>
          <td style="display: table-cell;"><?php foreach($all_trainers as $trainer) {?>
			<?php if($trainer_id==$trainer->trainer_id):?> <?php echo $trainer->first_name.' '.$trainer->last_name;?> <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_training_cost');?></th>
          <td style="display: table-cell;"><?php echo $training_cost;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_start_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($start_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_end_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($finish_date);?></td>
        </tr>
        <?php $assigned_ids = explode(',',$employee_id); ?>
        <tr>
          <th><?php echo $this->lang->line('xin_employee');?></th>
          <td style="display: table-cell;"><ol><?php foreach($all_employees as $employee) {?>
		 <?php if(in_array($employee->user_id,$assigned_ids)):?> <li>
		 <?php echo $employee->first_name.' '.$employee->last_name;?></li> <?php endif; ?>
         <?php } ?></ol></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_description');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php } else if(isset($_GET['jd']) && isset($_GET['training_id']) && $_GET['data']=='training'){
	$assigned_ids = explode(',',$employee_id);
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_training');?></h4>
</div>
<?php $attributes = array('name' => 'edit_training', 'id' => 'edit_training', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $training_id, 'ext_name' => $training_id);?>
<?php echo form_open('admin/training/update/'.$training_id, $attributes, $hidden);?>
<div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
            <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
            <select class="form-control" name="company" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
              <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
              <?php foreach($all_companies as $company) {?>
              <option value="<?php echo $company->company_id;?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>> <?php echo $company->name;?></option>
              <?php } ?>
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="training_type"><?php echo $this->lang->line('left_training_type');?></label>
              <select class="form-control" name="training_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_training_type');?>">
                <option value=""></option>
                <?php foreach($all_training_types as $training_type) {?>
                <option value="<?php echo $training_type->training_type_id?>" <?php if($training_type_id==$training_type->training_type_id):?> selected="selected" <?php endif;?>><?php echo $training_type->type?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="trainer"><?php echo $this->lang->line('xin_trainer');?></label>
              <select class="form-control" name="trainer" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_trainer');?>">
                <option value=""></option>
                <?php foreach($all_trainers as $trainer) {?>
                <option value="<?php echo $trainer->trainer_id?>" <?php if($trainer_id==$trainer->trainer_id):?> selected="selected" <?php endif;?>><?php echo $trainer->first_name.' '.$trainer->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="training_cost"><?php echo $this->lang->line('xin_training_cost');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_training_cost');?>" name="training_cost" type="text" value="<?php echo $training_cost;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly="true" name="start_date" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
              <input class="form-control d_date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly="true" name="end_date" type="text" value="<?php echo $finish_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group" id="employee_ajx">
              <label for="employee" class="control-label"><?php echo $this->lang->line('xin_employee');?></label>
              <select multiple class="form-control" name="employee_id[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee');?>">
                <option value=""></option>
                <?php foreach($all_employees as $employee) {?>
                <option value="<?php echo $employee->user_id;?>" <?php if(in_array($employee->user_id,$assigned_ids)):?> selected <?php endif; ?>><?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
						
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
	jQuery("#ajx_company").change(function(){
		jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
			jQuery('#employee_ajx').html(data);
		});
	});
	$('#description2').trumbowyg();
	$('.d_date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1900:' + (new Date().getFullYear() + 10),
	beforeShow: function(input) {
		$(input).datepicker("widget").show();
	}
	});

	/* Edit data */
	$("#edit_training").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&edit_type=training&form="+action,
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
						url : "<?php echo site_url("admin/training/training_list") ?>",
						type : 'GET'
					},
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
<?php }
?>
