<?php
/* Trainers view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_trainer');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_trainer', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/trainers/add_trainer', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_number" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="company_name"><?php echo $this->lang->line('module_company_title');?></label>
                      <select class="form-control" name="company" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <?php foreach($all_companies as $company) {?>
                        <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="expertise"><?php echo $this->lang->line('xin_expertise');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_expertise');?>" name="expertise" cols="30" rows="5" id="expertise"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="address"><?php echo $this->lang->line('xin_address');?></label>
              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_address');?>" name="address" cols="30" rows="3" id="address"></textarea>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_trainers');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('dashboard_fullname');?></th>
          <th><?php echo $this->lang->line('xin_contact_number');?></th>
          <th><?php echo $this->lang->line('dashboard_email');?></th>
          <th><?php echo $this->lang->line('xin_address');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
