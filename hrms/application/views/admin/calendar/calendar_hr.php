<?php $system = $this->Xin_model->read_setting_info(1); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h6 class="card-header with-elements">
        <div class="card-header-title"><?php echo $this->lang->line('xin_hr_calendar_options');?></div>
      </h6>
      <input type="hidden" id="exact_date" value="" />
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 md-4">
            <div class="list-group"> <span class="list-group-item calendar-options" style="background:#1fffac;"> <?php echo $this->lang->line('left_holidays');?></span> <span class="list-group-item calendar-options" style="background:#edeff2;"> <?php echo $this->lang->line('xin_hr_calendar_lv_request');?></span>
              <?php if($system[0]->module_travel=='true'){?>
              <span class="list-group-item calendar-options" style="background:#d9f5eb;"> <?php echo $this->lang->line('xin_hr_calendar_trvl_request');?></span>
              <?php } ?>
              <span class="list-group-item calendar-options" style="background:#f9e5e5;"> <?php echo $this->lang->line('xin_hr_calendar_upc_birthday');?></span>
              <?php if($system[0]->module_training=='true'){?>
              <span class="list-group-item calendar-options" style="background:#fff9e5;"> <?php echo $this->lang->line('xin_hr_calendar_tranings');?></span>
              <?php } ?>
              <?php if($system[0]->module_projects_tasks=='true'){?>
              <span class="list-group-item calendar-options" style="background:#dff6f9;"> <?php echo $this->lang->line('left_projects');?></span> <span class="list-group-item" style="background:#dcddde;"> <?php echo $this->lang->line('left_tasks');?></span>
              <?php } ?>
              <?php if($system[0]->module_events=='true'){?>
              <span class="list-group-item calendar-options" style="background:#ffaddf;"> <?php echo $this->lang->line('xin_hr_events');?></span> <span class="list-group-item" style="background:#ccf9ff;"> <?php echo $this->lang->line('xin_hr_meetings');?></span>
              <?php } ?>
              <?php if($system[0]->module_goal_tracking=='true'){?>
              <span class="list-group-item calendar-options" style="background:#fde797;"> <?php echo $this->lang->line('xin_hr_goals_title');?></span>
              <?php } ?>
            </div>
          </div>
          <div class="col-md-9">
            <div id='calendar_hr'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.calendar-options { padding: .3rem 0.4rem !important;}
</style>