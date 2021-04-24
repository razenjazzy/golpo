<?php
/*
* Tickets view
*/
$session = $this->session->userdata('username');
?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_create_new_ticket');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_ticket', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/tickets/add_ticket', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
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
                  <label for="task_name"><?php echo $this->lang->line('xin_subject');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_subject');?>" name="subject" type="text" value="">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" id="employee_ajax">
                      <label for="employees"><?php echo $this->lang->line('xin_ticket_for_employee');?></label>
                      <select class="form-control" name="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="ticket_priority" class="control-label"><?php echo $this->lang->line('xin_p_priority');?></label>
                      <select name="ticket_priority" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_priority');?>">
                        <option value=""></option>
                        <option value="1"><?php echo $this->lang->line('xin_low');?></option>
                        <option value="2"><?php echo $this->lang->line('xin_medium');?></option>
                        <option value="3"><?php echo $this->lang->line('xin_high');?></option>
                        <option value="4"><?php echo $this->lang->line('xin_critical');?></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_ticket_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_ticket_description');?>" name="description" cols="30" rows="5" id="description"></textarea>
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
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_tickets');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_ticket_code');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
          <th><?php echo $this->lang->line('xin_subject');?></th>
          <th><?php echo $this->lang->line('xin_p_priority');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
