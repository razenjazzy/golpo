<?php
/* Constants view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $moduleInfo = $this->Xin_model->read_setting_info(1);?>

 <div class="row match-heights">
    <div class="col-lg-3 col-md-3">
      <div class="card">
          <div class="card-blocks">
            <div class="list-group">
            <a class="list-group-item list-group-item-action nav-tabs-link" href="#contract" data-constant="1" data-constant-block="contract" data-toggle="tab" aria-expanded="true" id="constant_1"> <i class="fas fa-pencil-alt"></i> <?php echo $this->lang->line('xin_e_details_contract_type');?> </a>
            <a class="list-group-item list-group-item-action nav-tabs-link" href="#qualification" data-constant="2" data-constant-block="qualification" data-toggle="tab" aria-expanded="true" id="constant_2"> <i class="fa fa-coffee"></i> <?php echo $this->lang->line('xin_e_details_qualification');?> </a>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#document_type" data-constant="3" data-constant-block="document_type" data-toggle="tab" aria-expanded="true" id="constant_3"> <i class="fa fa-file"></i> <?php echo $this->lang->line('xin_e_details_dtype');?> </a>
             <?php if($moduleInfo[0]->module_awards=='true'){?>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#award_type" data-constant="4" data-constant-block="award_type" data-toggle="tab" aria-expanded="true" id="constant_4"> <i class="fa fa-trophy"></i> <?php echo $this->lang->line('xin_award_type');?> </a>
             <?php } ?>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#leave_type" data-constant="5" data-constant-block="leave_type" data-toggle="tab" aria-expanded="true" id="constant_5"> <i class="fa fa-plane"></i> <?php echo $this->lang->line('xin_leave_type');?> </a>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#warning_type" data-constant="6" data-constant-block="warning_type" data-toggle="tab" aria-expanded="true" id="constant_6"> <i class="fa fa-exclamation-triangle"></i> <?php echo $this->lang->line('xin_warning_type');?> </a>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#termination_type" data-constant="7" data-constant-block="termination_type" data-toggle="tab" aria-expanded="true" id="constant_7"> <i class="fas fa-user-times"></i> <?php echo $this->lang->line('xin_termination_type');?> </a>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#expense_type" data-constant="8" data-constant-block="expense_type" data-toggle="tab" aria-expanded="true" id="constant_8"> <i class="fas fa-money-bill-alt"></i> <?php echo $this->lang->line('xin_expense_type');?> </a>
             <?php if($moduleInfo[0]->module_recruitment=='true'){?>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#job_type" data-constant="9" data-constant-block="job_type" data-toggle="tab" aria-expanded="true" id="constant_9"> <i class="fas fa-newspaper"></i> <?php echo $this->lang->line('xin_job_type');?> </a>
             <?php } ?>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#exit_type" data-constant="10" data-constant-block="exit_type" data-toggle="tab" aria-expanded="true" id="constant_10"> <i class="fas fa-sign-out-alt"></i> <?php echo $this->lang->line('xin_employee_exit_type');?> </a>
             
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#travel_arr_type" data-constant="11" data-constant-block="travel_arr_type" data-toggle="tab" aria-expanded="true" id="constant_11"> <i class="fa fa-car"></i> <?php echo $this->lang->line('xin_travel_arrangement_type');?> </a>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#payment_method" data-constant="12" data-constant-block="payment_method" data-toggle="tab" aria-expanded="true" id="constant_12"> <i class="fas fa-money-check-alt"></i> <?php echo $this->lang->line('xin_payment_methods');?> </a>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#currency_type" data-constant="13" data-constant-block="currency_type" data-toggle="tab" aria-expanded="true" id="constant_13"> <i class="fas fa-dollar-sign"></i> <?php echo $this->lang->line('xin_currency_type');?> </a>
             <a class="list-group-item list-group-item-action nav-tabs-link" href="#company_type" data-constant="14" data-constant-block="company_type" data-toggle="tab" aria-expanded="true" id="constant_14"> <i class="fas fa-building"></i> <?php echo $this->lang->line('xin_company_type');?> </a>
            </div>
          </div>
        </div>
    </div>
      
  <div class="col-md-9 current-tab animated fadeInRight" id="contract">
      <div class="row">
        <div class="col-md-5">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_contract_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'contract_type_info', 'id' => 'contract_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_contract_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/contract_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_e_details_contract_type');?></label>
                <input type="text" class="form-control" name="contract_type" placeholder="<?php echo $this->lang->line('xin_e_details_contract_type');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div>
        </div></div>
        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_contract_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_contract_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_contract_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="col-md-9 current-tab animated fadeInRight" id="document_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_dtype');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'document_type_info', 'id' => 'document_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_document_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/document_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_e_details_dtype');?></label>
                <input type="text" class="form-control" name="document_type" placeholder="<?php echo $this->lang->line('xin_e_details_dtype');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>
        <div class="col-md-7">
        <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_dtype');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_document_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  <div class="col-md-9 current-tab animated fadeInRight" id="qualification" style="display:none;">
      <div class="row mb-4">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_edu_level');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'edu_level_info', 'id' => 'edu_level_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_document_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/edu_level_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_e_details_edu_level');?></label>
                <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_e_details_edu_level');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div>
        </div></div>
        
        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_edu_level');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_education_level">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_edu_level');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_e_details_language');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'edu_language_info', 'id' => 'edu_language_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_edu_language' => 'UPDATE');?>
            <?php echo form_open('admin/settings/edu_language_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_e_details_language');?></label>
                <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_e_details_language');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_language');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_qualification_language">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_e_details_language');?></th>
                  </tr>
                </thead>
              </table>
            </div></div></div>
          </div>
        
      <div class="row">
        <div class="col-md-5">
         <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_skill');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'edu_skill_info', 'id' => 'edu_skill_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_edu_skill' => 'UPDATE');?>
            <?php echo form_open('admin/settings/edu_skill_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_skill');?></label>
                <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_skill');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_skill');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_qualification_skill">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_skill');?></th>
                  </tr>
                </thead>
              </table>
            </div></div></div>
          </div>
        </div>
     
  <div class="col-md-9 current-tab animated fadeInRight" id="payment_method" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_payment_method');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'payment_method_info', 'id' => 'payment_method_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_payment_method' => 'UPDATE');?>
            <?php echo form_open('admin/settings/payment_method_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_payment_method');?></label>
                <input type="text" class="form-control" name="payment_method" placeholder="<?php echo $this->lang->line('xin_payment_method');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_payment_method');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_payment_method">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_payment_method');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div></div>
        </div>
      </div>
    
  <?php if($moduleInfo[0]->module_awards=='true'){?>
  <div class="col-md-9 current-tab animated fadeInRight" id="award_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_award_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'award_type_info', 'id' => 'award_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_award_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/award_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_award_type');?></label>
                <input type="text" class="form-control" name="award_type" placeholder="<?php echo $this->lang->line('xin_award_type');?>xin_award_type">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_award_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_award_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_award_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div></div></div>
        </div>
      
  <?php } ?>  
  <div class="col-md-9 current-tab animated fadeInRight" id="leave_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_leave_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'leave_type_info', 'id' => 'leave_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_leave_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/leave_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_leave_type');?></label>
                <input type="text" class="form-control" name="leave_type" placeholder="<?php echo $this->lang->line('xin_leave_type');?>">
              </div>
              <div class="form-group">
                <label for="name"><?php echo $this->lang->line('xin_days_per_year');?></label>
                <input type="text" class="form-control" name="days_per_year" placeholder="<?php echo $this->lang->line('xin_days_per_year');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_leave_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_leave_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_leave_type');?></th>
                    <th><?php echo $this->lang->line('xin_days_per_year');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div></div></div>
        </div>
     
  <div class="col-md-9 current-tab animated fadeInRight" id="warning_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_warning_type');?> </h6>
      <div class="card-body">

            <?php $attributes = array('name' => 'warning_type_info', 'id' => 'warning_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_warning_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/warning_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_warning_type');?></label>
                <input type="text" class="form-control" name="warning_type" placeholder="<?php echo $this->lang->line('xin_warning_type');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div>
        </div></div>
        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_warning_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_warning_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_warning_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div></div>
      </div>
    
  <div class="col-md-9 current-tab animated fadeInRight" id="termination_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_termination_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'termination_type_info', 'id' => 'termination_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_termination_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/termination_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_termination_type');?></label>
                <input type="text" class="form-control" name="termination_type" placeholder="<?php echo $this->lang->line('xin_termination_type');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_termination_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_termination_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_termination_type');?></th>
                  </tr>
                </thead>
              </table>
            </div></div>
          </div>
        </div>
      </div>
   
  <div class="col-md-9 current-tab animated fadeInRight" id="expense_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_expense_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'expense_type_info', 'id' => 'expense_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_expense_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/expense_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_expense_type');?></label>
                <input type="text" class="form-control" name="expense_type" placeholder="<?php echo $this->lang->line('xin_expense_type');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_expense_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_expense_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_expense_type');?></th>
                  </tr>
                </thead>
              </table>
            </div></div>
          </div>
        </div>
      </div>
  <?php if($moduleInfo[0]->module_recruitment=='true'){?>
  <div class="col-md-9 current-tab animated fadeInRight" id="job_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_job_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'job_type_info', 'id' => 'job_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_job_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/job_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_job_type');?></label>
                <input type="text" class="form-control" name="job_type" placeholder="<?php echo $this->lang->line('xin_job_type');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_job_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_job_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_job_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div></div>
        </div>
      </div>
  <?php } ?> 
  <div class="col-md-9 current-tab animated fadeInRight" id="exit_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_exit_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'exit_type_info', 'id' => 'exit_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_exit_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/exit_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_employee_exit_type');?></label>
                <input type="text" class="form-control" name="exit_type" placeholder="<?php echo $this->lang->line('xin_exit_type');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_exit_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_exit_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_employee_exit_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div></div>
        </div>
      </div>
    
  <div class="col-md-9 current-tab animated fadeInRight" id="travel_arr_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_travel_arrangement_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'travel_arr_type_info', 'id' => 'travel_arr_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_travel_arr_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/travel_arr_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_travel_arrangement_type');?></label>
                <input type="text" class="form-control" name="travel_arr_type" placeholder="<?php echo $this->lang->line('xin_travel_arrangement_type');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_travel_arrangement_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_travel_arr_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_travel_arrangement_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div></div>
        </div>
      </div>
   
  <div class="col-md-9 current-tab animated fadeInRight" id="currency_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_currency_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'currency_type_info', 'id' => 'currency_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_currency_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/currency_type_info/', $attributes, $hidden);?>
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
                <label for="name"><?php echo $this->lang->line('xin_currency_name');?></label>
                <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('xin_currency_name');?>">
              </div>
              <div class="form-group">
                <label for="name"><?php echo $this->lang->line('xin_currency_code');?></label>
                <input type="text" class="form-control" name="code" placeholder="<?php echo $this->lang->line('xin_currency_code');?>">
              </div>
              <div class="form-group">
                <label for="name"><?php echo $this->lang->line('xin_currency_symbol');?></label>
                <input type="text" class="form-control" name="symbol" placeholder="<?php echo $this->lang->line('xin_currency_symbol');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_currencies');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_currency_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('left_company');?></th>
                    <th><?php echo $this->lang->line('xin_name');?></th>
                    <th><?php echo $this->lang->line('xin_code');?></th>
                    <th><?php echo $this->lang->line('xin_symbol');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div></div>
        </div>
      </div>
    
  <div class="col-md-9 current-tab animated fadeInRight" id="company_type" style="display:none;">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_company_type');?> </h6>
      <div class="card-body">
            <?php $attributes = array('name' => 'company_type_info', 'id' => 'company_type_info', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
			<?php $hidden = array('set_company_type' => 'UPDATE');?>
            <?php echo form_open('admin/settings/company_type_info/', $attributes, $hidden);?>
              <div class="form-group">
                <label for="name"><?php echo $this->lang->line('xin_company_type');?></label>
                <input type="text" class="form-control" name="company_type" placeholder="<?php echo $this->lang->line('xin_company_type');?>">
              </div>
              <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
            <?php echo form_close(); ?>
          </div></div></div>

        <div class="col-md-7">
          <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_company_type');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table_company_type">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_company_type');?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div></div>
        </div>
      </div>
    
</div>
<div class="modal fade edit_setting_datail" id="edit_setting_datail" tabindex="-1" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_setting_info"></div>
  </div>
</div>
