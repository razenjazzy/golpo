<?php
/* Departments view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-4">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_department');?> </h6>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_department', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/department/add_department', $attributes, $hidden);?>
        <div class="form-body">
          <div class="form-group">
            <label for="name"><?php echo $this->lang->line('xin_name');?></label>
            <?php
					$data = array(
					  'name'        => 'department_name',
					  'id'          => 'department_name',
					  'value'       => '',
					  'placeholder'   => $this->lang->line('xin_name'),
					  'class'       => 'form-control',
					);
				
				echo form_input($data);
				?>
          </div>
          <div class="form-group">
            <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
              <option value=""></option>
              <?php foreach($get_all_companies as $company) {?>
              <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group" id="employee_ajax">
            <label for="name"><?php echo $this->lang->line('xin_department_head');?></label>
            <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_department_head');?>">
              <option value=""></option>
            </select>
          </div>
        </div>
        <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_departments');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('xin_department_name');?></th>
              <th><?php echo $this->lang->line('xin_department_head');?></th>
              <th><?php echo $this->lang->line('left_company');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
