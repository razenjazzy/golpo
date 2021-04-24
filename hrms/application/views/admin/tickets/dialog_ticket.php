<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['ticket_id']) && $_GET['data']=='ticket'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('xin_close');?>"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_ticket').' #'.$ticket_code;?></h4>
</div>
<?php $attributes = array('name' => 'edit_ticket', 'id' => 'edit_ticket', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $ticket_id, 'ext_name' => $ticket_id);?>
<?php echo form_open('admin/tickets/update/'.$ticket_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
            <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
            <select class="form-control" name="company" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
              <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
              <?php foreach($all_companies as $company) {?>
              <option value="<?php echo $company->company_id;?>" <?php if($company->company_id==$company_id):?> selected="selected"<?php endif;?>> <?php echo $company->name;?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
          <label for="task_name"><?php echo $this->lang->line('xin_subject');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_subject');?>" name="subject" type="text" value="<?php echo $subject;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" id="employee_ajx">
             <?php $result = $this->Department_model->ajax_company_employee_info($company_id);?>
              <label for="employees"><?php echo $this->lang->line('xin_ticket_for_employee');?></label>
              <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
                <option value=""></option>
                <?php foreach($result as $employee) {?>
                <option value="<?php echo $employee->user_id?>" <?php if($employee->user_id==$employee_id):?> selected <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="ticket_priority" class="control-label"><?php echo $this->lang->line('xin_p_priority');?></label>
              <select name="ticket_priority" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_priority');?>">
                <option value=""></option>
                <option value="1" <?php if($ticket_priority==1):?> selected <?php endif;?>><?php echo $this->lang->line('xin_low');?></option>
                <option value="2" <?php if($ticket_priority==2):?> selected <?php endif;?>><?php echo $this->lang->line('xin_medium');?></option>
                <option value="3" <?php if($ticket_priority==3):?> selected <?php endif;?>><?php echo $this->lang->line('xin_high');?></option>
                <option value="4" <?php if($ticket_priority==4):?> selected <?php endif;?>><?php echo $this->lang->line('xin_critical');?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_ticket_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_ticket_description');?>" name="description" cols="30" rows="15" id="description2"><?php echo $description;?></textarea>
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
					
		$('#description2').trumbowyg();
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
		});
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 	

		/* Edit data */
		$("#edit_ticket").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=ticket&form="+action,
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
							url : "<?php echo site_url("admin/tickets/ticket_list") ?>",
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
