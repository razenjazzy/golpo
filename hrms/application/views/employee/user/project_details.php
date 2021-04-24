<?php
/* Project Details view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $u_created = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $assigned_ids = explode(',',$assigned_to);?>
<?php
//status
if($status == 0) {
	$nstatus = $this->lang->line('xin_not_started');
} else if($status ==1){
	$nstatus = $this->lang->line('xin_in_progress');
} else if($status ==2){
	$nstatus = $this->lang->line('xin_completed');
} else {
	$nstatus = $this->lang->line('xin_deffered');
}
//priority
if($priority == 1) {
	$epriority = '<span class="tag tag-default tag-danger">'.$this->lang->line('xin_highest').'</span>';
} else if($priority ==2){
	$epriority = '<span class="tag tag-default tag-warning">'.$this->lang->line('xin_high').'</span>';
} else if($priority ==3){
	$epriority = '<span class="tag tag-default tag-primary">'.$this->lang->line('xin_normal').'</span>';
} else {
	$epriority = '<span class="tag tag-default tag-success">'.$this->lang->line('xin_low').'</span>';
}
if($progress <= 20) {
	$progress_class = 'progress-danger';
	$txt_class = 'text-danger';
} else if($progress > 20 && $progress <= 50){
	$progress_class = 'progress-warning';
	$txt_class = 'text-warning';
} else if($progress > 50 && $progress <= 75){
	$progress_class = 'progress-info';
	$txt_class = 'text-info';
} else {
	$progress_class = 'progress-success';
	$txt_class = 'text-success';
}
$projectTasks = $this->Project_model->completed_project_tasks($project_id);
$projectBugs = $this->Project_model->completed_project_bugs($project_id); 
?>

<?php // get company name by project id ?>
<?php $co_info  = $this->Project_model->read_project_information($project_id); ?>
<?php $eresult = $this->Department_model->ajax_company_employee_info($co_info[0]->company_id);?>
<section id="basic-tabs-components">
<div class="row match-height">
  <div class="col-xl-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="card-block">
          <ul class="nav nav-tabs nav-topline">
            <li class="nav-item"> <a class="nav-link active list-group-item-action nav-tabs-link" href="#overview" data-config="1" data-config-block="overview" data-toggle="tab" aria-expanded="true" id="pj_data_1"> <i class="ft-home"></i> <?php echo $this->lang->line('xin_overview');?></a> </li>
            <li class="nav-item"> <a class="nav-link list-group-item-action nav-tabs-link" href="#progress" data-config="3" data-config-block="progress" data-toggle="tab" aria-expanded="true" id="pj_data_3"><i class="fa fa-envira"></i> <?php echo $this->lang->line('dashboard_xin_progress');?></a> </li>
            <li class="nav-item"> <a class="nav-link list-group-item-action nav-tabs-link" href="#discussion" data-config="4" data-config-block="discussion" data-toggle="tab" aria-expanded="true" id="pj_data_4"><i class="fa fa-wechat"></i> <?php echo $this->lang->line('xin_discussion');?></a> </li>
            <li class="nav-item"> <a class="nav-link list-group-item-action nav-tabs-link" href="#bugs" data-config="5" data-config-block="bugs" data-toggle="tab" aria-expanded="true" id="pj_data_5"><i class="fa fa-cogs"></i> <?php echo $this->lang->line('xin_bugs_issues');?></a> </li>
            <li class="nav-item"> <a class="nav-link list-group-item-action nav-tabs-link" href="#tasks" data-config="6" data-config-block="tasks" data-toggle="tab" aria-expanded="true" id="pj_data_6"><i class="fa fa-key"></i> <?php echo $this->lang->line('xin_tasks');?></a> </li>
            <li class="nav-item"> <a class="nav-link list-group-item-action nav-tabs-link" href="#files" data-config="7" data-config-block="files" data-toggle="tab" aria-expanded="true" id="pj_data_7"><i class="fa fa-book"></i> <?php echo $this->lang->line('xin_files');?></a> </li>
            <li class="nav-item"> <a class="nav-link list-group-item-action nav-tabs-link" href="#note" data-config="8" data-config-block="note" data-toggle="tab" aria-expanded="true" id="pj_data_8"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('xin_note');?> </a> </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</div></section>

<div class="content-detached content-left">
  <div class="content-body">
    <section class="row">
      <div class="col-md-12 current-tab" id="overview">
        <div class="card">
          <div class="card-head">
            <div class="card-header">
              <h4 class="card-title"><?php echo $title;?></h4>
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements"> <?php echo $this->lang->line('xin_p_priority');?>: <?php echo $epriority;?> </div>
            </div>
            <div class="px-1">
              <ul class="list-inline list-inline-pipe text-xs-center p-1 border-bottom-grey border-bottom-lighten-3">
                <li><?php echo $this->lang->line('xin_client_name');?>: <span class="text-muted"><?php echo $client_name;?></span></li>
                <li><?php echo $this->lang->line('xin_start_date');?>: <span class="text-muted"><?php echo $this->Xin_model->set_date_format($start_date);?></span></li>
                <li><?php echo $this->lang->line('xin_end_date');?>: <span class="text-muted"><?php echo $this->Xin_model->set_date_format($end_date);?></span></li>
              </ul>
            </div>
          </div>
          <!-- project-info -->
          <div id="project-info" class="card-block row">
            <div class="project-info-count col-lg-4 col-md-12">
              <div class="project-info-icon">
                <h2><?php echo count($assigned_ids);?></h2>
                <div class="project-info-sub-icon"> <span class="fa fa-user-o"></span> </div>
              </div>
              <div class="project-info-text pt-1">
                <h5><?php echo $this->lang->line('xin_project_users');?></h5>
              </div>
            </div>
            <div class="project-info-count col-lg-4 col-md-12">
              <div class="project-info-icon">
                <h2><?php echo $this->Project_model->total_project_tasks($project_id);?></h2>
                <div class="project-info-sub-icon"> <span class="fa fa-calendar-check-o"></span> </div>
              </div>
              <div class="project-info-text pt-1">
                <h5><a class="nav-link nav-tabs-link" href="#tasks" data-config="6" data-config-block="tasks" data-toggle="tab" aria-expanded="true" id="pj_data_6"><?php echo $this->lang->line('xin_project_task');?></a></h5>
              </div>
            </div>
            <div class="project-info-count col-lg-4 col-md-12">
              <div class="project-info-icon">
                <h2><?php echo $this->Project_model->total_project_bugs($project_id);?></h2>
                <div class="project-info-sub-icon"> <span class="fa fa-bug"></span> </div>
              </div>
              <div class="project-info-text pt-1">
                <h5><a class="nav-link nav-tabs-link" href="#bugs" data-config="5" data-config-block="bugs" data-toggle="tab" aria-expanded="true" id="pj_data_5"><?php echo $this->lang->line('xin_project_bug');?></a></h5>
              </div>
            </div>
          </div>
          <!-- project-info -->
          <div class="card-block">
            <div class="card-subtitle line-on-side text-muted text-xs-center font-small-3 mx-2 my-1"> <span><?php echo $this->lang->line('xin_prjct_detail_eagle_eye_view');?></span> </div>
            <div class="row py-2">
              <div class="col-lg-6 col-md-12">
                <div class="insights px-2">
                  <div><span class="text-info h3"><?php echo $projectTasks;?>%</span> <span class="float-xs-right"><?php echo $this->lang->line('xin_tasks');?></span></div>
                  <progress value="<?php echo $projectTasks;?>" max="100" class="progress progress-md progress-info"><?php echo $projectTasks;?>%</progress>
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="insights px-2">
                  <div><span class="text-danger h3"><?php echo $projectBugs;?>%</span> <span class="float-xs-right"><?php echo $this->lang->line('xin_bugs_issues');?></span></div>
                  <progress value="<?php echo $projectBugs;?>" max="100" class="progress progress-md progress-danger"><?php echo $projectBugs;?>%</progress>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 current-tab" id="progress"  aria-expanded="false" style="display:none;">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('dashboard_xin_progress');?></h4>
          </div>
          <input type="hidden" id="dtproject_id" value="<?php echo $project_id;?>" />
          <div class="card-body collapse in">
            <div class="card-block">
                  <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
				  <?php $hidden = array('project_id' => $project_id);?>
                  <?php echo form_open('admin/project/update_status', $attributes, $hidden);?>
                    <?php
                        $data = array(
                          'name'        => 'progres_val',
                          'id'          => 'progres_val',
                          'value'       => $progress,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data);
                    ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="progress"><?php echo $this->lang->line('dashboard_xin_progress');?></label>
                          <input type="text" id="range_grid">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                          <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="Status">
                            <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_not_started');?></option>
                            <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_in_progress');?></option>
                            <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_completed');?></option>
                            <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_deffered');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status"><?php echo $this->lang->line('xin_p_priority');?></label>
                          <select class="form-control" name="priority" data-plugin="select_hrm" data-placeholder="Priority">
                            <option value="1" <?php if($priority=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_highest');?></option>
                            <option value="2" <?php if($priority=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_high');?></option>
                            <option value="3" <?php if($priority=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_normal');?></option>
                            <option value="4" <?php if($priority=='4'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_low');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 current-tab" id="discussion"  aria-expanded="false" style="display:none;">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_discussion');?></h4>
          </div>
          <div class="card-body collapse in">
            <div class="card-block">
              <?php $attributes = array('name' => 'set_discussion', 'id' => 'set_discussion', 'autocomplete' => 'off');?>
			  <?php $hidden = array('user_id' => $session['user_id']);?>
              <?php echo form_open_multipart('admin/project/set_discussion', $attributes, $hidden);?>
                <?php
                    $data1 = array(
                      'name'        => 'discussion_project_id',
                      'id'          => 'discussion_project_id',
                      'value'       => $project_id,
                      'type'  		=> 'hidden',
                      'class'       => 'form-control',
                    );
                echo form_input($data1);
                ?>
                <div class="box-block">
                  <div class="form-group">
                    <textarea name="xin_message" id="xin_message" class="form-control" rows="4" placeholder="<?php echo $this->lang->line('xin_message');?>"></textarea>
                  </div>
                  <div class="form-group">
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_attachment');?></label>
                      <input type="file" class="form-control-file" id="attachment_discussion" name="attachment_discussion">
                    </fieldset>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php echo form_close(); ?>
              <div class="clear"></div>
              <div class="table-responsive">
                <table class="table table-hover mb-md-0" id="xin_discussion_table" style="width:100%;">
                  <thead>
                    <tr>
                      <th><?php echo $this->lang->line('xin_all_discussions');?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 current-tab" id="bugs"  aria-expanded="false" style="display:none;">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_bugs_issues');?></h4>            
          </div>
          <div class="card-body collapse in">
            <div class="card-block">
              <?php $attributes = array('name' => 'set_bug', 'id' => 'set_bug', 'autocomplete' => 'off');?>
			  <?php $hidden = array('user_id' => $session['user_id']);?>
              <?php echo form_open_multipart('admin/project/set_bug', $attributes, $hidden);?>
                <?php
                    $data2 = array(
                      'name'        => 'bug_project_id',
                      'id'          => 'bug_project_id',
                      'value'       => $project_id,
                      'type'  		=> 'hidden',
                      'class'       => 'form-control',
                    );
                echo form_input($data2);
                ?>
                <div class="box-block">
                  <div class="form-group">
                    <input type="text" name="title" id="title" class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>">
                  </div>
                  <div class="form-group">
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_attachment');?></label>
                      <input type="file" class="form-control-file" id="attachment" name="attachment">
                    </fieldset>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php echo form_close(); ?>
              <div class="clear"></div>
              <div class="table-responsive">
                <table class="table table-hover mb-md-0" id="xin_bug_table" style="width:100%;">
                  <thead>
                    <tr>
                      <th><?php echo $this->lang->line('xin_all_bugs_issues');?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 current-tab" id="tasks"  aria-expanded="false" style="display:none;">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_tasks');?></h4>
          </div>
          <div class="card-body collapse in">
            <div class="card-block">
              <div class="clear"></div>
              <div class="table-responsive">
                <table class="table table-striped table-bordered dataTable" id="xin_table" style="width:100%;">
                  <thead>
                    <tr>
                      <th><?php echo $this->lang->line('xin_action');?></th>
                      <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                      <th><?php echo $this->lang->line('xin_end_date');?></th>
                      <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                      <th><?php echo $this->lang->line('xin_assigned_to');?></th>
                      <th><?php echo $this->lang->line('xin_created_by');?></th>
                      <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-23 current-tab" id="files"  aria-expanded="false" style="display:none;">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_files');?></h4>            
          </div>
          <div class="card-body collapse in">
            <div class="card-block">
              <?php $attributes = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off');?>
			  <?php $hidden = array('type' => '2');?>
              <?php echo form_open_multipart('admin/project/add_attachment', $attributes, $hidden);?>
                <?php
                    $data3 = array(
                      'name'        => 'project_id',
                      'id'          => 'f_project_id',
                      'value'       => $project_id,
                      'type'  		=> 'hidden',
                      'class'       => 'form-control',
                    );
                echo form_input($data3);
                ?>
                <?php
                    $data4 = array(
                      'name'        => 'user_id',
                      'id'          => 'user_id',
                      'value'       => $session['user_id'],
                      'type'  		=> 'hidden',
                      'class'       => 'form-control',
                    );
                echo form_input($data4);
                ?>                
                <div class="bg-white">
                  <div class="box-block">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="task_name"><?php echo $this->lang->line('dashboard_xin_title');?></label>
                          <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="file_name" type="text" value="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class='form-group'>
                          <fieldset class="form-group">
                            <label for="logo"><?php echo $this->lang->line('xin_attachment_file');?></label>
                            <input type="file" class="form-control-file" id="attachment_file" name="attachment_file">
                            <small><?php echo $this->lang->line('xin_project_files_upload');?></small>
                          </fieldset>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                          <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="file_description" rows="4" id="file_description"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                </div>
              <?php echo form_close(); ?>
              <div class="clear"></div>
              <h2><strong><?php echo $this->lang->line('xin_attachment_list');?></strong></h2>
              <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered table-ajax-load" id="xin_attachment_table" style="width:100%;">
                  <thead>
                    <tr>
                      <th><?php echo $this->lang->line('xin_option');?></th>
                      <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                      <th><?php echo $this->lang->line('xin_description');?></th>
                      <th><?php echo $this->lang->line('xin_date_and_time');?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 current-tab" id="note"  aria-expanded="false" style="display:none;">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('xin_project');?> <?php echo $this->lang->line('xin_note');?></h4>
          </div>
          <div class="card-body collapse in">
            <div class="card-block">
              <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
			  <?php $hidden = array('type' => '1');?>
              <?php echo form_open_multipart('admin/user/add_project_note', $attributes, $hidden);?>
                <?php
                    $data3 = array(
                      'name'        => 'note_project_id',
                      'id'          => 'note_project_id',
                      'value'       => $project_id,
                      'type'  		=> 'hidden',
                      'class'       => 'form-control',
                    );
                echo form_input($data3);
                ?>
                <?php
                    $data4 = array(
                      'name'        => '_uid',
                      'value'       => $session['user_id'],
                      'type'  		=> 'hidden',
                      'class'       => 'form-control',
                    );
                echo form_input($data4);
                ?>
                <div class="box-block">
                  <div class="form-group">
                    <textarea name="project_note" id="project_note" class="form-control" rows="8" placeholder="<?php echo $this->lang->line('xin_project_note');?>"><?php echo $project_note;?></textarea>
                  </div>
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<div ,="," class="sidebar-detached sidebar-right">
  <div class="sidebar">
    <div class="project-sidebar-content">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?php echo $this->lang->line('xin_project_detail');?></h4>
        </div>
        <div class="card-body collapse in"> 
          <!-- project progress -->
          <div class="card-block">
            <div class="insights">
              <p><?php echo $this->lang->line('xin_prjct_detail_overall_progress');?> <span class="float-xs-right <?php echo $txt_class;?> h3"><?php echo $progress;?>%</span></p>
              <progress value="<?php echo $progress;?>" max="100" class="progress progress-xs <?php echo $progress_class;?>"><?php echo $progress;?>%</progress>
            </div>
          </div>
          <!-- project progress --> 
        </div>
      </div>
      <!-- Project Overview -->
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?php echo $this->lang->line('xin_project_overview');?></h4>
        </div>
        <div class="card-body collapse in">
          <div class="card-block"> <?php echo html_entity_decode($description);?> </div>
        </div>
      </div>
      <!--/ Project Overview --> 
      <!-- Project Users -->
      <div class="card">
        <div class="card-header mb-0">
          <h4 class="card-title"><?php echo $this->lang->line('xin_project_users');?></h4>
        </div>
        <div class="card-body collapse in">
          <div class="card-body collapse in">
            <div class="card-block  py-0 px-0">
              <div class="list-group">
                <?php if($assigned_to!='' && $assigned_to!='None') {?>
                <?php $employee_ids = explode(',',$assigned_to); foreach($employee_ids as $assign_id) {?>
                <?php $e_name = $this->Xin_model->read_user_info($assign_id);?>
                <?php if(!is_null($e_name)){ ?>
                <?php $_designation = $this->Designation_model->read_designation_information($e_name[0]->designation_id);?>
                <?php
				  if(!is_null($_designation)){
					$designation_name = $_designation[0]->designation_name;
				  } else {
					$designation_name = '--';	
				  }
				  ?>
                <?php
				if($e_name[0]->profile_picture!='' && $e_name[0]->profile_picture!='no file') {
					$u_file = base_url().'uploads/profile/'.$e_name[0]->profile_picture;
				} else {
					if($e_name[0]->gender=='Male') { 
						$u_file = base_url().'uploads/profile/default_male.jpg';
					} else {
						$u_file = base_url().'uploads/profile/default_female.jpg';
					}
				} ?>
                <a href="<?php echo site_url('admin/employees/detail/');?><?php echo $e_name[0]->user_id;?>" class="list-group-item">
                <div class="media">
                  <div class="media-left"><span class="avatar avatar-sm rounded-circle"><img src="<?php echo $u_file;?>" alt=""><i></i></span></div>
                  <div class="media-body">
                    <h6 class="media-heading mb-0"><?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?></h6>
                    <p class="font-small-2 mb-0 text-muted"><?php echo $designation_name;?></p>
                  </div>
                </div>
                </a>
                <?php } } ?>
                <?php } else { ?>
                <span>&nbsp;</span>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Project Users --> 
    </div>
  </div>
</div>
