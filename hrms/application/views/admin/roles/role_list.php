<?php
/* User Roles view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_employee_role');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'add_role', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('_user' => $session['user_id']);?>
            <?php echo form_open('admin/roles/add_role', $attributes, $hidden);?>
            <div class="form-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="role_name"><?php echo $this->lang->line('xin_role_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_role_name');?>" name="role_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                        <select class="form-control" name="company_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                          <option value=""></option>
                          <?php foreach($get_all_companies as $company) {?>
                          <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="role_access"><?php echo $this->lang->line('xin_role_access');?></label>
                        <select class="form-control custom-select" id="role_access" data-plugin="select_hrm" name="role_access"  data-placeholder="<?php echo $this->lang->line('xin_role_access');?>">
                          <option value="">&nbsp;</option>
                          <option value="1"><?php echo $this->lang->line('xin_role_all_menu');?></option>
                          <option value="2"><?php echo $this->lang->line('xin_role_cmenu');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="form-actions"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="resources"><?php echo $this->lang->line('xin_role_resource');?></label>
                        <div id="all_resources">
                          <div class="demo-section k-content">
                            <div>
                              <div id="treeview_r1"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div id="all_resources">
                          <div class="demo-section k-content">
                            <div>
                              <div id="treeview_r2"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_roles');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_role_rid');?></th>
          <th><?php echo $this->lang->line('xin_role_name');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('xin_role_menu_per');?></th>
          <th><?php echo $this->lang->line('xin_role_added_date');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<style type="text/css">
.k-in { display:none !important; }
</style>
