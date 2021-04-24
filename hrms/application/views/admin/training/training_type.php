<?php
/* Training Type view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-4">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_type');?> </h6>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_type', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/training_type/add_type', $attributes, $hidden);?>
        <div class="form-group">
          <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
          <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
            <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
            <?php foreach($all_companies as $company) {?>
            <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="type_name"><?php echo $this->lang->line('left_training_type');?></label>
          <input type="text" class="form-control" name="type_name" placeholder="<?php echo $this->lang->line('left_training_type');?>">
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_training_types');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('left_company');?></th>
              <th><?php echo $this->lang->line('xin_type');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
