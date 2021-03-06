<?php
/* Office Shift view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('left_office_shift');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_office_shift', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/add_office_shift', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-10">
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('left_company');?></label>
                  <div class="col-md-4">
                    <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_shift_name');?></label>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_shift_name');?>" name="shift_name" type="text" value="" id="name">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_monday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-1" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="monday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-1" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="monday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="1"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_tuesday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-2" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="tuesday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-2" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="tuesday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="2"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_wednesday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-3" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="wednesday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-3" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="wednesday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="3"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_thursday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-4" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="thursday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-4" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="thursday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="4"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_friday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-5" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="friday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-5" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="friday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="5"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_saturday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-6" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="saturday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-6" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="saturday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="6"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time" class="col-md-2"><?php echo $this->lang->line('xin_sunday');?></label>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-7" placeholder="<?php echo $this->lang->line('xin_in_time');?>" readonly name="sunday_in_time" type="text" value="">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control timepicker clear-7" placeholder="<?php echo $this->lang->line('xin_out_time');?>" readonly name="sunday_out_time" type="text" value="">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary clear-time" data-clear-id="7"><?php echo $this->lang->line('xin_clear');?></button>
                  </div>
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
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_office_shift');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_option');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('xin_day');?></th>
          <th><?php echo $this->lang->line('xin_monday');?></th>
          <th><?php echo $this->lang->line('xin_tuesday');?></th>
          <th><?php echo $this->lang->line('xin_wednesday');?></th>
          <th><?php echo $this->lang->line('xin_thursday');?></th>
          <th><?php echo $this->lang->line('xin_friday');?></th>
          <th><?php echo $this->lang->line('xin_saturday');?></th>
          <th><?php echo $this->lang->line('xin_sunday');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
