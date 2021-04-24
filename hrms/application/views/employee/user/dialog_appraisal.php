<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['performance_appraisal_id']) && $_GET['data']=='view_appraisal' && $_GET['type']=='view_appraisal'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_performance_appraisal');?></h4>
</div>
<div class="modal-body">
  <div class="row m-b-1">
    <div class="col-md-12">
      <div class="box box-block bg-white">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="employee"><?php echo $this->lang->line('left_company');?>: </label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
				<?php foreach($get_all_companies as $company) {?>
                <?php if($company_id==$company->company_id):?>
                <?php echo $company->name;?>
                <?php endif;?>
                <?php } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="employee"><?php echo $this->lang->line('dashboard_single_employee');?>: </label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <?php foreach($all_employees as $employee) {?>
                  <?php if($employee_id==$employee->user_id):?>
                  <?php echo $employee->first_name.' '.$employee->last_name;?>
                  <?php endif; } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 control-label">
                <div class="form-group">
                  <label for="month_year"><?php echo $this->lang->line('xin_performance_app_date');?>: </label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group"> <?php echo date("F, Y", strtotime($appraisal_year_month));?> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row m-b-1">
        <div class="col-md-6">
          <div class="box bg-white">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="table table-grey-head m-md-b-0">
                <thead>
                  <tr>
                    <th colspan="5"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2"><?php echo $this->lang->line('xin_indicator');?></th>
                    <th colspan="2"><?php echo $this->lang->line('xin_expected_value');?></th>
                    <th><?php echo $this->lang->line('xin_set_value');?></th>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_customer_experience');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_intermediate');?></td>
                    <td><?php if($customer_experience=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($customer_experience=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($customer_experience=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php elseif($customer_experience=='4'):?>
                      <?php echo $this->lang->line('xin_performance_expert');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('xin_not_set_value');?> </span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_marketing');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_advanced');?></td>
                    <td><?php if($marketing=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($marketing=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($marketing=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php elseif($marketing=='4'):?>
                      <?php echo $this->lang->line('xin_performance_expert');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('xin_not_set_value');?> </span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_management');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_advanced');?></td>
                    <td><?php if($management=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($management=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($management=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php elseif($management=='4'):?>
                      <?php echo $this->lang->line('xin_performance_expert');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('xin_not_set_value');?> </span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_administration');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_advanced');?></td>
                    <td><?php if($administration=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($administration=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($administration=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php elseif($administration=='4'):?>
                      <?php echo $this->lang->line('xin_performance_expert');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('xin_not_set_value');?> </span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_present_skill');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_expert');?></td>
                    <td><?php if($presentation_skill=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($presentation_skill=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($presentation_skill=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php elseif($presentation_skill=='4'):?>
                      <?php echo $this->lang->line('xin_performance_expert');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('xin_not_set_value');?> </span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_quality_work');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_expert');?></td>
                    <td><?php if($quality_of_work=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($quality_of_work=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($quality_of_work=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php elseif($quality_of_work=='4'):?>
                      <?php echo $this->lang->line('xin_performance_expert');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('xin_not_set_value');?> </span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_efficiency');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_expert');?></td>
                    <td><?php if($efficiency=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($efficiency=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($efficiency=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php elseif($efficiency=='4'):?>
                      <?php echo $this->lang->line('xin_performance_expert');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"> <?php echo $this->lang->line('xin_not_set_value');?> </span>
                      <?php endif;?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box bg-white">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="table table-grey-head m-md-b-0">
                <thead>
                  <tr>
                    <th colspan="5"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2"><?php echo $this->lang->line('xin_indicator');?></th>
                    <th colspan="2"><?php echo $this->lang->line('xin_expected_value');?></th>
                    <th><?php echo $this->lang->line('xin_set_value');?></th>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_integrity');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_beginner');?></td>
                    <td><?php if($integrity=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($integrity=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($integrity=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_professionalism');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_beginner');?></td>
                    <td><?php if($professionalism=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($professionalism=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($professionalism=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_team_work');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_intermediate');?></td>
                    <td><?php if($team_work=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($team_work=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($team_work=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_critical_think');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_advanced');?></td>
                    <td><?php if($critical_thinking=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($critical_thinking=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($critical_thinking=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_conflict_manage');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_intermediate');?></td>
                    <td><?php if($conflict_management=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($conflict_management=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($conflict_management=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_attendance');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_intermediate');?></td>
                    <td><?php if($attendance=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($attendance=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($attendance=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                      <?php endif;?></td>
                  </tr>
                  <tr>
                    <td scope="row" colspan="2"><?php echo $this->lang->line('xin_performance_meet_deadline');?></td>
                    <td colspan="2"><?php echo $this->lang->line('xin_performance_advanced');?></td>
                    <td><?php if($ability_to_meet_deadline=='1'):?>
                      <?php echo $this->lang->line('xin_performance_beginner');?>
                      <?php elseif($ability_to_meet_deadline=='2'):?>
                      <?php echo $this->lang->line('xin_performance_intermediate');?>
                      <?php elseif($ability_to_meet_deadline=='3'):?>
                      <?php echo $this->lang->line('xin_performance_advanced');?>
                      <?php else:?>
                      <span style="color:red;font - style: italic;line - height:2.4;"><?php echo $this->lang->line('xin_not_set_value');?></span>
                      <?php endif;?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="m-b-1">
      <div class="col-md-12">
        <div class="box box-block bg-white">
          <div class="form-group">
            <label for="remarks"><strong><?php echo $this->lang->line('xin_remarks');?></strong></label>
            <?php echo htmlspecialchars_decode($remarks);?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
</div>
<?php }
?>
