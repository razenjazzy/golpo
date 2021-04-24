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
          <div class="col-md-3">
            <div class="list-group">
            <span class="list-group-item calendar-options" style="background:#1fffac;"> <?php echo $this->lang->line('left_holidays');?></span>
              <?php if($system[0]->module_events=='true'){?>
              <span class="list-group-item calendar-options" style="background:#ffaddf;"> <?php echo $this->lang->line('xin_hr_events');?></span> <span class="list-group-item calendar-options" style="background:#ccf9ff;"> <?php echo $this->lang->line('xin_hr_meetings');?></span>
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
