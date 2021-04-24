<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_asset');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_assets', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/assets/add_asset', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('xin_acc_category');?></label>
                    <select class="form-control" name="category_id" id="category_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($all_assets_categories as $assets_category) {?>
                      <option value="<?php echo $assets_category->assets_category_id?>"><?php echo $assets_category->category_name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="asset_name" class="control-label"><?php echo $this->lang->line('xin_asset_name');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_asset_name');?>" name="asset_name" type="text" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="company_id"><?php echo $this->lang->line('left_company');?></label>
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($all_companies as $company) {?>
                      <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group" id="employee_ajax">
                    <label for="first_name"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                    <select class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="manufacturer"><?php echo $this->lang->line('xin_manufacturer');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_manufacturer');?>" name="manufacturer" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="xin_serial_number" class="control-label"><?php echo $this->lang->line('xin_serial_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_serial_number');?>" name="serial_number" type="text" value="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="company_asset_code"><?php echo $this->lang->line('xin_company_asset_code');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_asset_code');?>" name="company_asset_code" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="is_working" class="control-label"><?php echo $this->lang->line('xin_is_working');?></label>
                    <select class="form-control" name="is_working" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_is_working');?>">
                      <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                      <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="purchase_date"><?php echo $this->lang->line('xin_purchase_date');?></label>
                    <input class="form-control asset_date" placeholder="<?php echo $this->lang->line('xin_purchase_date');?>" name="purchase_date" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="role"><?php echo $this->lang->line('xin_invoice_number');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_invoice_number');?>" name="invoice_number" type="text" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="warranty_end_date" class="control-label"><?php echo $this->lang->line('xin_warranty_end_date');?></label>
                    <input class="form-control asset_date" placeholder="<?php echo $this->lang->line('xin_warranty_end_date');?>" name="warranty_end_date" type="text" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <fieldset class="form-group">
                      <label for="asset_image"><?php echo $this->lang->line('xin_asset_image');?></label>
                      <input type="file" class="form-control-file" id="asset_image" name="asset_image">
                      <small><?php echo $this->lang->line('xin_asset_allowed_image_formats');?></small>
                    </fieldset>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="award_information"><?php echo $this->lang->line('xin_asset_note');?></label>
            <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_asset_note');?>" name="asset_note" cols="30" rows="3" id="asset_note"></textarea>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_assets');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_asset_name');?></th>
          <th><?php echo $this->lang->line('xin_acc_category');?></th>
          <th><?php echo $this->lang->line('xin_company_asset_code');?></th>
          <th><?php echo $this->lang->line('xin_is_working');?></th>
          <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
