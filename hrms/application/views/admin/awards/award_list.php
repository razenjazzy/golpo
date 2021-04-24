<?php
/* Awards view
*/
?>
<?php $session = $this->session->userdata('username');?>
<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_award');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
          <?php $attributes = array('name' => 'add_award', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/awards/add_award', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-6">
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
                      <label for="employee"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                      <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                        <option value=""></option>
                      </select>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="award_type"><?php echo $this->lang->line('xin_award_type');?></label>
                          <select name="award_type_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_award_type');?>">
                            <option value=""></option>
                            <?php foreach($all_award_types as $award_type) {?>
                            <option value="<?php echo $award_type->award_type_id;?>"><?php echo $award_type->award_type;?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="award_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_award_date');?>" readonly name="award_date" type="text" value="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="month_year"><?php echo $this->lang->line('xin_award_month_year');?></label>
                          <input class="form-control d_month_year" placeholder="<?php echo $this->lang->line('xin_award_month_year');?>" readonly name="month_year" type="text">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                      <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="gift"><?php echo $this->lang->line('xin_gift');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_gift');?>" name="gift" type="text">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="cash"><?php echo $this->lang->line('xin_cash');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_cash');?>" name="cash" type="number">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="logo"><?php echo $this->lang->line('xin_award_photo');?></label>
                        <input type="file" class="form-control-file" id="award_picture" name="award_picture">
                        <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                      </fieldset>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="award_information"><?php echo $this->lang->line('xin_award_info');?></label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_award_info');?>" name="award_information" cols="30" rows="3" id="award_information"></textarea>
                </div>
                <div class="form-actions">
                  <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?>
                </div>
              </div>
            </div>
          <?php echo form_close(); ?>
      </div>
    </div>
   </div>
 </div>
 <div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_awards');?> </h6>
  <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th style="width:120px;"><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><?php echo $this->lang->line('xin_employee_name');?></th>
            <th><?php echo $this->lang->line('xin_award_name');?></th>
            <th><?php echo $this->lang->line('xin_gift');?></th>
            <th><?php echo $this->lang->line('xin_cash_price');?></th>
            <th><?php echo $this->lang->line('xin_award_month_year');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
