<?php
/* Project view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_project = $this->Project_model->get_projects();?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-3">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_hr_report_filters');?> </h6>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'projects_reports', 'id' => 'projects_reports', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('euser_id' => $session['user_id']);?>
            <?php echo form_open('admin/reports/projects_reports', $attributes, $hidden);?>
            <?php
                    $data = array(
                      'name'        => 'user_id',
                      'id'          => 'user_id',
                      'type'        => 'hidden',
                      'value'   	   => $session['user_id'],
                      'class'       => 'form-control',
                    );
                
                echo form_input($data);
                ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_projects');?></label>
                  <select class="form-control" name="project_id" id="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>" required>
                    <option value="0"><?php echo $this->lang->line('xin_hr_reports_projects_all');?></option>
                    <?php foreach($_project->result() as $projects) {?>
                    <option value="<?php echo $projects->project_id?>"><?php echo $projects->title?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                  <select name="status" id="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                    <option value="4"><?php echo $this->lang->line('xin_acc_all');?></option>
                    <option value="0"><?php echo $this->lang->line('xin_not_started');?></option>
                    <option value="1"><?php echo $this->lang->line('xin_in_progress');?></option>
                    <option value="2"><?php echo $this->lang->line('xin_completed');?></option>
                    <option value="3"><?php echo $this->lang->line('xin_deffered');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_get');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_hr_reports_projects');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_project_title');?></th>
              <th><?php echo $this->lang->line('xin_p_priority');?></th>
              <th><?php echo $this->lang->line('xin_start_date');?></th>
              <th><?php echo $this->lang->line('xin_p_enddate');?></th>
              <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
              <th><?php echo $this->lang->line('xin_project_users');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
