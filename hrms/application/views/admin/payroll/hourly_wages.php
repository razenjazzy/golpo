<?php
/* Hourly Wage/Rate view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-4">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_payroll_hourly_rate');?> </h6>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_hourly_rate', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/payroll/add_hourly_rate', $attributes, $hidden);?>
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
              <label for="hourly_grade"><?php echo $this->lang->line('xin_payroll_hourly_wage_title_single');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_payroll_hourly_wage_title');?>" name="hourly_grade" type="text">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="hourly_rate"><?php echo $this->lang->line('xin_payroll_hourly_rate');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_payroll_hourly_rate');?>" name="hourly_rate" type="number">
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
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_payroll_hourly_wages');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th style="width:76px;"><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('left_company');?></th>
              <th><?php echo $this->lang->line('xin_payroll_hourly_wage_title');?></th>
              <th><?php echo $this->lang->line('xin_payroll_hourly_rate');?></th>
              <th><?php echo $this->lang->line('xin_created_date');?></th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- responsive --> 
    </div>
  </div>
</div>
