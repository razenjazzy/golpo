<?php
/* Location view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_location');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
          <?php $attributes = array('name' => 'add_location', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/location/add_location', $attributes, $hidden);?>
            <div class="form-body">
              <div class="row">
                <div class="col-sm-6">
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
                    <label for="name"><?php echo $this->lang->line('xin_location_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_location_name');?>" name="name" type="text">
                  </div>
                  <div class="form-group">
                    <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="phone"><?php echo $this->lang->line('xin_phone');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_phone');?>" name="phone" type="number">
                      </div>
                      <div class="col-md-6">
                        <label for="xin_faxn"><?php echo $this->lang->line('xin_faxn');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_faxn');?>" name="fax" type="number">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group" id="employee_ajax">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="email"><?php echo $this->lang->line('xin_view_locationh');?></label>
                        <select class="form-control" name="location_head" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_view_locationh');?>">
                          <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text">
                    <br>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text">
                    <br>
                    <div class="row">
                      <div class="col-xs-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text">
                      </div>
                      <div class="col-xs-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text">
                      </div>
                      <div class="col-xs-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text">
                      </div>
                    </div>
                    <br>
                    <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                      <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                      <?php foreach($all_countries as $country) {?>
                      <option value="<?php echo $country->country_id;?>"> <?php echo $country->country_name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
 <div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_locations');?> </h6>
  <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">

                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_location_name');?></th>
                    <th><?php echo $this->lang->line('module_company_title');?></th>
                    <th><?php echo $this->lang->line('xin_view_locationh');?></th>
                    <th><?php echo $this->lang->line('xin_city');?></th>
                    <th><?php echo $this->lang->line('xin_country');?></th>
                    <th><?php echo $this->lang->line('xin_added_by');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>