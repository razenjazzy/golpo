<?php
/* Job Interview view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('left_job_interview');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-outline-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_interview', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/job_interviews/add_interview', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="job_post"><?php echo $this->lang->line('xin_e_details_jtitle');?></label>
                      <select class="form-control" id="job_id" name="job_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_jtitle');?>">
                        <option value=""></option>
                        <?php foreach($all_interview_jobs as $jobs):?>
                        <option value="<?php echo $jobs->job_id;?>"><?php echo $jobs->job_title;?></option>
                        <?php endforeach?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="interview_date"><?php echo $this->lang->line('xin_interview_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_interview_date');?>" readonly name="interview_date" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group" id="interviewees_ajax">
                      <label for="interviewees"><?php echo $this->lang->line('xin_interviewees_candidates_selected');?></label>
                      <select class="form-control" name="interviewees[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_candidates');?>">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="interview_place"><?php echo $this->lang->line('xin_place_of_interview');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_place_of_interview');?>" name="interview_place" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="interview_time" class="control-label"><?php echo $this->lang->line('xin_interview_time');?></label>
                      <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_interview_time');?>" readonly name="interview_time" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="interviewers"><?php echo $this->lang->line('xin_interviewers_employees');?></label>
                      <select multiple class="form-control" name="interviewers[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_employees');?>">
                        <option value=""></option>
                        <?php foreach($all_employees as $employee) {?>
                        <option value="<?php echo $employee->user_id;?>"><?php echo $employee->first_name. ' ' .$employee->last_name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="description"><?php echo $this->lang->line('xin_job_interview_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_job_interview_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
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
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_job_interviews');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_e_details_jtitle');?></th>
          <th><?php echo $this->lang->line('xin_selected_candidates');?></th>
          <th><?php echo $this->lang->line('xin_interview_place');?></th>
          <th><?php echo $this->lang->line('xin_interview_date_time');?></th>
          <th><?php echo $this->lang->line('xin_interviewers');?></th>
          <th><?php echo $this->lang->line('xin_added_by');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
