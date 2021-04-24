<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['hourly_rate_id']) && $_GET['data']=='payroll'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_hourly_wage');?></h4>
</div>
<?php $attributes = array('name' => 'update_hourly_wages', 'id' => 'update_hourly_wages', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $hourly_rate_id, 'ext_name' => $hourly_grade);?>
<?php echo form_open('admin/payroll/update_hourly_wages/'.$hourly_rate_id, $attributes, $hidden);?>
<div class="modal-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
            <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
              <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
              <?php foreach($all_companies as $company) {?>
              <option value="<?php echo $company->company_id;?>" <?php if($company_id==$company->company_id):?> selected="selected"<?php endif;?>> <?php echo $company->name;?></option>
              <?php } ?>
            </select>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="hourly_grade"><?php echo $this->lang->line('xin_payroll_hourly_wage_title_single');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_payroll_hourly_wage_title');?>" name="hourly_grade" type="text" value="<?php echo $hourly_grade;?>">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <input type="hidden" name="_token" value="<?php echo $hourly_rate_id;?>">
          <input name="_method" type="hidden" value="EDIT">
          <label for="hourly_rate"><?php echo $this->lang->line('xin_payroll_hourly_rate');?></label>
          <input class="form-control" placeholder="<?php echo $this->lang->line('xin_payroll_hourly_rate');?>" name="hourly_rate" type="number" value="<?php echo $hourly_rate;?>">
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

		/* Edit data */
		$("#update_hourly_wages").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=payroll&form="+action,
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
								url : "<?php echo site_url("admin/payroll/hourly_list") ?>",
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
