<?php
/* Holidays view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-4">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_hr_event');?> </h6>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_event', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/events/add_event', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group" id="employee_ajax">
              <label for="first_name"><?php echo $this->lang->line('dashboard_single_employee');?></label>
              <select class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="event_title"><?php echo $this->lang->line('xin_hr_event_title');?></label>
              <input type="text" class="form-control" name="event_title" placeholder="<?php echo $this->lang->line('xin_hr_event_title');?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="start_date"><?php echo $this->lang->line('xin_hr_event_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_hr_event_date');?>" readonly name="event_date" type="text">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="event_time"><?php echo $this->lang->line('xin_hr_event_time');?></label>
              <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_hr_event_time');?>" readonly name="event_time" type="text">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="event_note"><?php echo $this->lang->line('xin_hr_event_note');?></label>
              <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_hr_event_note');?>" name="event_note" id="event_note"></textarea>
            </div>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_hr_events');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('left_company');?></th>
              <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
              <th><?php echo $this->lang->line('xin_hr_event_title');?></th>
              <th><?php echo $this->lang->line('xin_hr_event_date');?></th>
              <th><?php echo $this->lang->line('xin_hr_event_time');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>
