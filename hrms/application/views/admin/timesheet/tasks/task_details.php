<?php
/* Task Details view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $u_created = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $assigned_ids = explode(',',$assigned_to);?>

<div class="row m-b-1">
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <h6 class="card-header"><?php echo $this->lang->line('xin_task_detail');?></h6>
            <div class="card-body">
              <div class="table-responsive">
                <table class="datatables-demo table table-striped table-bordered">
                  <tbody>
                    <tr>
                      <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('xin_task_title');?></th>
                      <td class="text-right"><?php echo $task_name;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_project');?></th>
                      <td class="text-right"><?php echo $project_name;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_created_by');?></th>
                      <td class="text-right"><?php echo $created_by;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_start_date');?></th>
                      <td class="text-right"><?php echo $this->Xin_model->set_date_format($start_date);?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_end_date');?></th>
                      <td class="text-right"><?php echo $this->Xin_model->set_date_format($end_date);?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_hours');?></th>
                      <td class="text-right"><?php echo $task_hour;?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--</div>-->
    <?php if($u_created[0]->user_role_id==1){?>
    <!-- assigned to-->
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <h6 class="card-header"><?php echo $this->lang->line('xin_assigned_to');?></h6>
            <div class="card-body">
              <div class="card-block card-dashboard">
                <div class="row">
                  <?php $attributes = array('name' => 'assign_task', 'id' => 'assign_task', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
                  <?php $hidden = array('_method' => 'UPDATE', '_uid' => $session['user_id']);?>
                  <?php echo form_open('admin/timesheet/assign_task/', $attributes, $hidden);?>
                  <?php
                    $data = array(
                      'name'        => 'task_id',
					  'id'          => 'task_id',
                      'type'        => 'hidden',
                      'value'  	   => $task_id,
                      'class'       => 'form-control',
                    );
                    echo form_input($data);
                ?>
                  <div class="box-block">
                    <div class="form-group">
                      <label for="employees" class="control-label"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                      <select multiple class="form-control" name="assigned_to[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
                        <?php foreach($all_employees as $employee) {?>
                        <option value="<?php echo $employee->user_id?>" <?php if(in_array($employee->user_id,$assigned_ids)){?> selected="selected"<?php } ?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>
  </div>
  <div class="col-md-8">
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <ul class="nav nav-tabs nav-topline">
          <li class="nav-item"> <a class="nav-link active" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-home"></i> <?php echo $this->lang->line('xin_details');?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="baseIcon-tab12" data-toggle="tab" aria-controls="tabIcon12" href="#tabIcon12" aria-expanded="false"><i class="fa fa-comment"></i> <?php echo $this->lang->line('xin_discussion');?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="baseIcon-tab13" data-toggle="tab" aria-controls="tabIcon13" href="#tabIcon13" aria-expanded="false"><i class="fa fa-pencil"></i> <?php echo $this->lang->line('xin_task_files');?></a> </li>
          <li class="nav-item"> <a class="nav-link" id="baseIcon-tab14" data-toggle="tab" aria-controls="tabIcon14" href="#tabIcon14" aria-expanded="false"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('xin_note');?></a> </li>
        </ul>
        <div class="tab-content pt-1">
          <div role="tabpanel" class="tab-pane active" id="tabIcon11" aria-expanded="true" aria-labelledby="baseIcon-tab11">
            <div class="card">
              <div class="card-body">
                <p class="mb-1 mt-3 ml-2"><?php echo html_entity_decode($description);?></p>
                <div class="row">
                  <div class="col-md-6">
                    <h6 class="card-header"> <?php echo $this->lang->line('xin_assigned_to');?> </h6>
                    <div class="media-list" id="all_employees_list">
                      <ul class="list-group list-group-flush">
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
                        <li class="list-group-item" style="border:0px;">
                          <div class="media align-items-center"> <img src="<?php echo $u_file;?>" class="d-block ui-w-30 rounded-circle" alt="">
                            <div class="media-body px-2">
                              <?php if($u_created[0]->user_role_id==1):?>
                              <a href="<?php echo site_url()?>admin/employees/detail/<?php echo $e_name[0]->user_id;?>" class="text-dark">
                              <?php endif;?>
                              <?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?>
                              <?php if($u_created[0]->user_role_id==1):?>
                              </a>
                              <?php endif;?>
                              <br>
                              <p class="font-small-2 mb-0 text-muted"><?php echo $designation_name;?></p>
                            </div>
                          </div>
                        </li>
                        <?php } } ?>
                        <?php } else { ?>
                        <li class="list-group-item" style="border:0px;">&nbsp;</li>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
                    <?php $hidden = array('_method' => 'UPDATE', 'task_id' => $task_id);?>
                    <?php echo form_open('admin/timesheet/update_task_status/', $attributes, $hidden);?>
                    <?php
                    $data1 = array(
                      'name'        => 'progres_val',
					  'id'          => 'progres_val',
                      'type'        => 'hidden',
                      'value'  	   => $progress,
                      'class'       => 'form-control',
                    );
                    echo form_input($data1);
                ?>
                    <h6 class="card-header"> <?php echo $this->lang->line('xin_update_status');?> </h6>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="progress"><?php echo $this->lang->line('dashboard_xin_progress');?></label>
                          <input type="text" id="range_grid">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                          <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="Status">
                            <option value="0" <?php if($task_status=='0'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_not_started');?></option>
                            <option value="1" <?php if($task_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_in_progress');?></option>
                            <option value="2" <?php if($task_status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_completed');?></option>
                            <option value="3" <?php if($task_status=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_deffered');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                    <?php echo form_close(); ?> </div>
                </div>
                <div>&nbsp;</div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tabIcon12" aria-labelledby="baseIcon-tab12" aria-expanded="false">
            <div class="card">
              <div class="card-body">
                <?php $attributes = array('name' => 'set_comment', 'id' => 'set_comment', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
                <?php $hidden = array('_method' => 'UPDATE', 'user_id' => $session['user_id']);?>
                <?php echo form_open('admin/timesheet/set_comment/', $attributes, $hidden);?>
                <div class="box-block">
                  <input type="hidden" name="comment_task_id" id="comment_task_id" value="<?php echo $task_id;?>" />
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea name="xin_comment" id="xin_comment" class="form-control" rows="4" placeholder="<?php echo $this->lang->line('xin_message_here');?>"></textarea>
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
                <?php echo form_close(); ?> </div>
              <div class="card">
                <h6 class="card-header"> <?php echo $this->lang->line('xin_all_comments');?> </h6>
                <div class="card-datatable table-responsive">
                  <table class="datatables-demo table table-striped table-bordered" id="xin_comment_table">
                    <thead>
                      <tr>
                        <th><?php echo $this->lang->line('xin_all_comments');?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tabIcon13" aria-labelledby="baseIcon-tab3" aria-expanded="false">
            <div class="card">
              <div class="card-body">
                <?php $attributes = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
                <?php $hidden = array('_method' => 'UPDATE');?>
                <?php echo form_open_multipart('admin/timesheet/add_attachment/', $attributes, $hidden);?>
                <?php
                    $data3 = array(
                      'name'        => 'c_task_id',
					  'id'          => 'c_task_id',
                      'type'        => 'hidden',
                      'value'  	   => $task_id,
                      'class'       => 'form-control',
                    );
                    echo form_input($data3);
                ?>
                <?php
                    $data4 = array(
                      'name'        => 'user_id',
					  'id'          => 'user_id',
                      'type'        => 'hidden',
                      'value'  	   => $session['user_id'],
                      'class'       => 'form-control',
                    );
                    echo form_input($data4);
                ?>
                <div class="bg-white">
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
                <?php echo form_close(); ?> </div>
              <div class="card">
                <div class="card-body">
                  <h6 class="card-header"> <?php echo $this->lang->line('xin_attachment_list');?> </h6>
                  <div class="card-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered table-ajax-load" id="xin_attachment_table">
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
          <div class="tab-pane" id="tabIcon14" aria-labelledby="baseIcon-tab4" aria-expanded="false">
            <div class="card">
              <div class="card-body">
                <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
                <?php $hidden = array('_method' => 'UPDATE');?>
                <?php echo form_open('admin/timesheet/add_note/', $attributes, $hidden);?>
                <?php
                    $data5 = array(
                      'name'        => 'note_task_id',
					  'id'          => 'note_task_id',
                      'type'        => 'hidden',
                      'value'  	   => $task_id,
                      'class'       => 'form-control',
                    );
                    echo form_input($data5);
                ?>
                <?php
                    $data6 = array(
                      'name'        => '_uid',
                      'type'        => 'hidden',
                      'value'  	   => $session['user_id'],
                      'class'       => 'form-control',
                    );
                    echo form_input($data6);
                ?>
                <div class="box-block">
                  <div class="form-group">
                    <textarea name="task_note" id="task_note" class="form-control" rows="5" placeholder="<?php echo $this->lang->line('xin_task_note');?>"><?php echo $task_note;?></textarea>
                  </div>
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
                <?php echo form_close(); ?> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
