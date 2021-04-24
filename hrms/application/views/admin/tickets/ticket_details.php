<?php
/*
* Ticket Detail view
*/
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
?>

<div class="row m-b-1">
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
              <h6 class="card-header"><?php echo $this->lang->line('xin_ticket');?> <?php echo $this->lang->line('xin_details');?></h6>
            <div class="card-body">
              <div class="table-responsive">
                <div class="datatables-demo table table-striped table-bordered" data-pattern="priority-columns">
                  <?php
				if($ticket_priority==1): $priority = $this->lang->line('xin_low'); elseif($ticket_priority==2): $priority = $this->lang->line('xin_medium'); elseif($ticket_priority==3): $priority = $this->lang->line('xin_high'); elseif($ticket_priority==4): $priority = $this->lang->line('xin_critical');  endif;
				?>
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('xin_subject');?></th>
                        <td class="text-right"><?php echo $subject;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('dashboard_single_employee');?></th>
                        <td class="text-right"><?php echo $full_name;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_p_priority');?></th>
                        <td class="text-right"><?php echo $priority;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_e_details_date');?></th>
                        <td class="text-right"><?php
						$created_at = date('h:i A', strtotime($created_at));
						$_date = explode(' ',$created_at);
						$edate = $this->Xin_model->set_date_format($_date[0]);
						echo $_created_at = $edate. ' '. $created_at;?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php if($user_info[0]->user_role_id==1) {?>
    <!-- assigned to-->
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <h6 class="card-header"><?php echo $this->lang->line('xin_assigned_to');?></h6>
            <div class="card-body">
              <div class="card-block card-dashboard">
                <div class="row">
                  <?php $assigned_ids = explode(',',$assigned_to);?>
                  <?php $attributes = array('name' => 'assign_ticket', 'id' => 'assign_ticket', 'autocomplete' => 'off');?>
				  <?php $hidden = array('user_id' => $session['user_id']);?>
                  <?php echo form_open('admin/tickets/assign_ticket', $attributes, $hidden);?>
                  <?php
					$data = array(
					  'name'        => 'ticket_id',
					  'id'          => 'ticket_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
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
                  <?php echo form_close(); ?>
                </div>
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
          <div class="card-block">
            <ul class="nav nav-tabs nav-top-border no-hover-bg">
              <li class="nav-item"> <a class="nav-link active" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-home"></i> <?php echo $this->lang->line('xin_details');?></a> </li>
              <li class="nav-item"> <a class="nav-link" id="baseIcon-tab12" data-toggle="tab" aria-controls="tabIcon12" href="#tabIcon12" aria-expanded="false"><i class="fa fa-comment"></i> <?php echo $this->lang->line('xin_payment_comment');?></a> </li>
              <li class="nav-item"> <a class="nav-link" id="baseIcon-tab13" data-toggle="tab" aria-controls="tabIcon13" href="#tabIcon13" aria-expanded="false"><i class="fa fa-pencil"></i> <?php echo $this->lang->line('xin_ticket_files');?></a> </li>
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
                    <?php if($assigned_to!='') {?>
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
                              <?php if($user_info[0]->user_role_id==1):?>
                              <a href="<?php echo site_url()?>admin/employees/detail/<?php echo $e_name[0]->user_id;?>" class="text-dark">
                              <?php endif;?>
                              <?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?>
                              <?php if($user_info[0]->user_role_id==1):?>
                              </a>
                              <?php endif;?>
                              <br>
                              <p class="font-small-2 mb-0 text-muted"><?php echo $designation_name;?></p>
                            </div>
                          </div>
                        </li>
                        
                        <!--<div class="media">
                      <?php if($user_info[0]->user_role_id==1):?>
                      <a class="media-left" href="<?php echo site_url()?>admin/employees/detail/<?php echo $e_name[0]->user_id;?>">
                      <?php endif;?>
                      <img class="media-object rounded-circle" src="<?php echo $u_file;?>" style="width: 64px;height: 64px;">
                      <?php if($user_info[0]->user_role_id==1):?>
                      </a>
                      <?php endif;?>
                      <div class="media-body">
                        <h6 class="media-heading"><?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?></h6>
                        <?php echo $designation_name;?> </div>
                    </div>-->
                    <?php } }?>
                    <?php } else { ?>
                    <li class="list-group-item" style="border:0px;">&nbsp;</li>
                    <?php } ?>
                    </ul>
                  </div>
                </div>
                <div class="col-md-6">
                  <?php $attributes2 = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
				  <?php $hidden2 = array('user_id' => $session['user_id']);?>
                  <?php echo form_open('admin/tickets/update_status', $attributes2, $hidden2);?>
                  <?php
					$data2 = array(
					  'name'        => 'status_ticket_id',
					  'id'          => 'status_ticket_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
				
					echo form_input($data2);
					?>
                    <h4 class="form-section"><?php echo $this->lang->line('xin_update_status');?></h4>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                          <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                            <option value="1" <?php if($ticket_status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_open');?></option>
                            <option value="2" <?php if($ticket_status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_closed');?></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status"><?php echo $this->lang->line('xin_remarks');?></label>
                          <textarea class="form-control" name="remarks" rows="4" cols="15" placeholder="<?php echo $this->lang->line('xin_remarks');?>"><?php echo $ticket_remarks;?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  <?php echo form_close(); ?>
                </div>
               </div> 
                </div></div>
              </div>
              <div class="tab-pane" id="tabIcon12" aria-labelledby="baseIcon-tab12" aria-expanded="false">
                  <div class="card">
              <div class="card-body">
			  <?php $attributes3 = array('name' => 'set_comment', 'id' => 'set_comment', 'autocomplete' => 'off');?>
				  <?php $hidden3 = array('user_id' => $session['user_id']);?>
                  <?php echo form_open('admin/tickets/set_comment', $attributes3, $hidden3);?>
                  <?php
					$data2 = array(
					  'name'        => 'comment_ticket_id',
					  'id'          => 'comment_ticket_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
				
					echo form_input($data2);
					?>
                    <?php
					$data3 = array(
					  'name'        => 'user_id',
					  'id'          => 'user_id',
					  'type'        => 'hidden',
					  'value'   	   => $session['user_id'],
					  'class'       => 'form-control',
					);
				
					echo form_input($data3);
					?>
                  <div class="box-block">
                    <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                      <textarea name="xin_comment" id="xin_comment" class="form-control" rows="4" placeholder="<?php echo $this->lang->line('xin_comment');?>"></textarea>
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
               <?php echo form_close(); ?>
                <div class="clear"></div>
                <div class="table-responsive">
                  <table class="table table-hover mb-md-0" id="xin_comment_table" style="width:100%;">
                    <thead>
                      <tr>
                        <th><?php echo $this->lang->line('xin_all_comments');?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              </div></div>
              <div class="tab-pane" id="tabIcon13" aria-labelledby="baseIcon-tab13" aria-expanded="false">
              	<div class="card">
              <div class="card-body">
                  <?php $attributes4 = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off');?>
				  <?php $hidden4 = array('user_id' => $session['user_id']);?>
                  <?php echo form_open_multipart('admin/tickets/add_attachment', $attributes4, $hidden4);?>
                  <?php
					$data4 = array(
					  'name'        => 'user_file_id',
					  'id'          => 'user_file_id',
					  'type'        => 'hidden',
					  'value'   	   => $session['user_id'],
					  'class'       => 'form-control',
					);
					echo form_input($data4);
					?>
                    <?php
					$data5 = array(
					  'name'        => '_token_file',
					  'id'          => '_token_file',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
					echo form_input($data5);
					?>
                    <?php
					$data6 = array(
					  'name'        => 'c_ticket_id',
					  'id'          => 'c_ticket_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
					echo form_input($data6);
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
                <?php echo form_close(); ?>
                <div class="card">
                <div class="card-body">
                  <h6 class="card-header"> <?php echo $this->lang->line('xin_attachment_list');?> </h6>
                  <div class="card-datatable table-responsive">
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
              </div></div></div>
              </div></div>
              <div class="tab-pane" id="tabIcon14" aria-labelledby="baseIcon-tab14" aria-expanded="false">
                <div class="card">
              <div class="card-body">
			  <?php $attributes3 = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
				  <?php $hidden3 = array('user_id' => $session['user_id']);?>
                  <?php echo form_open('admin/tickets/add_note', $attributes3, $hidden3);?>
                  <?php
					$data7 = array(
					  'name'        => 'token_note_id',
					  'id'          => 'token_note_id',
					  'type'        => 'hidden',
					  'value'   	   => $ticket_id,
					  'class'       => 'form-control',
					);
				
					echo form_input($data7);
					?>
                    <?php
					$data8 = array(
					  'name'        => '_uid',
					  'id'          => '_uid',
					  'type'        => 'hidden',
					  'value'   	   => $session['user_id'],
					  'class'       => 'form-control',
					);
				
					echo form_input($data8);
					?>
                  <div class="box-block">
                    <div class="form-group">
                      <textarea name="ticket_note" id="ticket_note" class="form-control" rows="5" placeholder="<?php echo $this->lang->line('xin_ticket_note');?>"><?php echo $ticket_note;?></textarea>
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                <?php echo form_close(); ?>
              </div>
              </div></div>
              <!-- tab --> 
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
