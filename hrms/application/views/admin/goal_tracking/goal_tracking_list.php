<?php
/* Training view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_role_set');?> <?php echo $this->lang->line('xin_hr_goal_title');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_tracking', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/goal_tracking/add_tracking', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
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
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="tracking_type"><?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?></label>
                      <select class="form-control" name="tracking_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?>">
                        <option value=""></option>
                        <?php foreach($all_tracking_types as $tracking_type) {?>
                        <option value="<?php echo $tracking_type->tracking_type_id?>"><?php echo $tracking_type->type_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="xin_subject"><?php echo $this->lang->line('xin_subject');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_subject');?>" name="subject" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="target_achiement"><?php echo $this->lang->line('xin_hr_target_achiement');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_hr_target_achiement');?>" name="target_achiement" type="number" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description"></textarea>
                </div>
              </div>
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
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_hr_goal_tracking');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('xin_hr_goal_tracking_type_se');?></th>
          <th><?php echo $this->lang->line('xin_subject');?></th>
          <th><?php echo $this->lang->line('xin_hr_target_achiement');?></th>
          <th><?php echo $this->lang->line('xin_start_date');?></th>
          <th><?php echo $this->lang->line('xin_end_date');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
