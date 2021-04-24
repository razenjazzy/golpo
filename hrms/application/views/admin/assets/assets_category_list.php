<?php
/*
* Languages - View Page
*/
$session = $this->session->userdata('username');
?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-4">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_category');?> </h6>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_asset_category', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/assets/add_category', $attributes, $hidden);?>
        <div class="form-group">
          <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
          <select class="form-control" name="company_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
            <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
            <?php foreach($all_companies as $company) {?>
            <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_name');?></label>
          <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_name');?>">
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_categories');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('xin_name');?></th>
              <th><?php echo $this->lang->line('left_company');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
