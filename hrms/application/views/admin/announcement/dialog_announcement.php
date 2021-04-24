<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['announcement_id']) && $_GET['data']=='announcement'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_announcement');?></h4>
</div>
<?php $attributes = array('name' => 'edit_announcement', 'id' => 'edit_announcement', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $announcement_id, 'ext_name' => $title);?>
<?php echo form_open('admin/announcement/update/'.$announcement_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="title"><?php echo $this->lang->line('xin_title');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_title');?>" name="title" type="text" value="<?php echo $title;?>">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
              <input class="form-control d_date" name="start_date_modal" readonly="true" type="text" value="<?php echo $start_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
              <input class="form-control d_date" name="end_date_modal" readonly="true" type="text" value="<?php echo $end_date;?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="designation" class="control-label"><?php echo $this->lang->line('module_company_title');?></label>
              <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id):?> selected <?php endif;?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group" id="department_ajx">
            	<?php $result = $this->Company_model->ajax_company_departments_info($company_id);?>
              <label for="designation" class="control-label"><?php echo $this->lang->line('xin_department');?></label>
              <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_department');?>">
                <option value=""></option>
                <?php foreach($result as $department) {?>
                <option value="<?php echo $department->department_id?>" <?php if($department->department_id==$department_id):?> selected <?php endif;?>><?php echo $department->department_name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description2"><?php echo $description;?></textarea>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="summary"><?php echo $this->lang->line('xin_summary');?></label>
      <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_summary');?>" name="summary" cols="30" rows="3" id="summary"><?php echo $summary;?></textarea>
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
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_departments/"+jQuery(this).val(), function(data, status){
				jQuery('#department_ajx').html(data);
			});
		});	 
		
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
		$("#edit_announcement").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			//var description = $("#description2").code();
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=announcement&form="+action,
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
							url : "<?php echo site_url("admin/announcement/announcement_list") ?>",
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
<?php } else if(isset($_GET['jd']) && isset($_GET['announcement_id']) && $_GET['data']=='view_announcement'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_announcement');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
   <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <th><?php echo $this->lang->line('xin_title');?></th>
        <td style="display: table-cell;"><?php echo $title;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_start_date');?></th>
        <td style="display: table-cell;"><?php echo $start_date;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_end_date');?></th>
        <td style="display: table-cell;"><?php echo $end_date;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('module_company_title');?></th>
        <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?><?php if($company->company_id==$company_id):?> <?php echo $company->name?> <?php endif;?><?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_department');?></th>
        <td style="display: table-cell;"><?php foreach($all_departments as $department) {?><?php if($department->department_id==$department_id):?> <?php echo $department->department_name?> <?php endif;?><?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_summary');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($summary);?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_description');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
      </tr>
    </tbody>
  </table>   
  </div> 
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
