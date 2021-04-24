<?php
/* Performance Indicator view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_role_set');?> <?php echo $this->lang->line('xin_indicator');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_performance_indicator', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/performance_indicator/add_indicator', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="left_company"><?php echo $this->lang->line('left_company');?></label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
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
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="designation"><?php echo $this->lang->line('dashboard_designation');?></label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group" id="designation_ajax">
                  <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_designation');?>" name="designation_id">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          <div class="row">  
            <div class="col-md-6">
              <h4 class="form-section"><?php echo $this->lang->line('xin_performance_technical_competencies');?></h4>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_customer_experience');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="customer_experience" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"><?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4"> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_marketing');?> </label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="marketing" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4"> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_management');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="management" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4"> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_administration');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="administration" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4"> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_present_skill');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="presentation_skill" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4"> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_quality_work');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="quality_of_work" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4"> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_efficiency');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="efficiency" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                      <option value="4"> <?php echo $this->lang->line('xin_performance_expert');?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="form-section"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></h4>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_integrity');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="integrity" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_professionalism');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="professionalism" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_team_work');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="team_work" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_critical_think');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="critical_thinking" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_conflict_manage');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="conflict_management" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_attendance');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="attendance" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 control-label">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('xin_performance_meet_deadline');?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <select name="ability_to_meet_deadline" class="form-control">
                      <option value=""><?php echo $this->lang->line('xin_performance_none');?></option>
                      <option value="1"> <?php echo $this->lang->line('xin_performance_beginner');?></option>
                      <option value="2"> <?php echo $this->lang->line('xin_performance_intermediate');?></option>
                      <option value="3"> <?php echo $this->lang->line('xin_performance_advanced');?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>  
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
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
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_performance_indicators');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('dashboard_designation');?></th>
          <th><?php echo $this->lang->line('left_company');?></th>
          <th><?php echo $this->lang->line('left_department');?></th>
          <th><?php echo $this->lang->line('xin_added_by');?></th>
          <th><?php echo $this->lang->line('xin_created_at');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
