<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['designation_id']) && $_GET['data']=='designation'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_designation_edit');?></h4>
</div>
<?php $attributes = array('name' => 'edit_designation', 'id' => 'edit_designation', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $designation_id, 'ext_name' => $designation_name);?>
<?php echo form_open('admin/designation/update/'.$designation_id, $attributes, $hidden);?>
  <div class="modal-body">
     <div class="row">
      <div class="col-md-6">
        <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="ajx_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id) {?> selected="selected" <?php } ?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
      </div>
      <div class="col-md-6">
        <div class="form-group" id="ajx_department">
          <label for="name"><?php echo $this->lang->line('xin_department');?></label>
          <?php $result = $this->Company_model->ajax_company_departments_info($company_id);?>
          <select name="department_id" id="aj_departments" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>">
            <option value=""></option>
            <?php foreach($result as $deparment) {?>
            <option value="<?php echo $deparment->department_id?>" <?php if($deparment->department_id==$department_id) {?> selected="selected" <?php } ?>><?php echo $deparment->department_name?></option>
            <?php } ?>
          </select>
        </div>
       </div>
     <div class="col-md-6">   
        <div class="form-group">
        <label for="designation"><?php echo $this->lang->line('xin_designation');?></label>
        <input type="text" class="form-control" name="designation_name" value="<?php echo $designation_name;?>">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/select2/dist/css/select2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_departments/"+jQuery(this).val(), function(data, status){
				jQuery('#department_ajx').html(data);
			});
		});	
		
		/* Edit data */
		$("#edit_designation").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=designation&form="+action,
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
								url : "<?php echo site_url("admin/designation/designation_list") ?>",
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
<?php }
?>
