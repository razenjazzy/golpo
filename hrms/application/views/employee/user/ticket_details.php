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
        <div class="col-xs-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><?php echo $this->lang->line('xin_ticket');?> <?php echo $this->lang->line('xin_details');?></h4>
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                  <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="card-body collapse in">
              <div class="card-block card-dashboard">
                <div class="table-responsive" data-pattern="priority-columns">
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
  </div>
  <div class="col-md-8">
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="card-block">
            <ul class="nav nav-tabs nav-top-border no-hover-bg">
              <li class="nav-item"> <a class="nav-link active" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-home"></i> <?php echo $this->lang->line('xin_details');?></a> </li>
              <li class="nav-item"> <a class="nav-link" id="baseIcon-tab12" data-toggle="tab" aria-controls="tabIcon12" href="#tabIcon12" aria-expanded="false"><i class="fa fa-comment"></i> <?php echo $this->lang->line('xin_payment_comment');?></a> </li>
              <li class="nav-item"> <a class="nav-link" id="baseIcon-tab13" data-toggle="tab" aria-controls="tabIcon13" href="#tabIcon13" aria-expanded="false"><i class="fa fa-pencil"></i> <?php echo $this->lang->line('xin_ticket_files');?></a> </li>
              <li class="nav-item"> <a class="nav-link" id="baseIcon-tab14" data-toggle="tab" aria-controls="tabIcon14" href="#tabIcon14" aria-expanded="false"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('xin_note');?></a> </li>
            </ul>
            <div class="tab-content px-1 pt-1">
              <div role="tabpanel" class="tab-pane active" id="tabIcon11" aria-expanded="true" aria-labelledby="baseIcon-tab11">
                <div class="info">
                  <blockquote class="blockquote mb-1 mb-md-0"> <?php echo html_entity_decode($description);?> </blockquote>
                </div>
                <div class="col-md-6">
                  <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
				  <?php $hidden = array('euser_id' => 0,);?>
                  <?php echo form_open('admin/user/update_ticket_status', $attributes, $hidden);?>
                  <?php
                        $data = array(
                          'name'        => 'user_id',
                          'id'          => 'user_id',
                          'value'       => $session['user_id'],
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data);
                    ?>
                    <?php
                        $data1 = array(
                          'name'        => 'status_ticket_id',
                          'id'          => 'status_ticket_id',
                          'value'       => $ticket_id,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data1);
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
                <div>&nbsp;</div>
              </div>
              <div class="tab-pane" id="tabIcon12" aria-labelledby="baseIcon-tab12" aria-expanded="false">
                  <?php $attributes = array('name' => 'set_comment', 'id' => 'set_comment', 'autocomplete' => 'off');?>
				  <?php $hidden = array('euser_id' => 0,);?>
                  <?php echo form_open('admin/user/set_ticket_comment', $attributes, $hidden);?>
                  <?php
                        $data2 = array(
                          'name'        => 'user_id',
                          'id'          => 'user_id',
                          'value'       => $session['user_id'],
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data2);
                    ?>
                    <?php
                        $data3 = array(
                          'name'        => 'comment_ticket_id',
                          'id'          => 'comment_ticket_id',
                          'value'       => $ticket_id,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data3);
                    ?>
                  <div class="box-block">
                    <div class="form-group">
                      <textarea name="xin_comment" id="xin_comment" class="form-control" rows="4" placeholder="<?php echo $this->lang->line('xin_comment');?>"></textarea>
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
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
              <div class="tab-pane" id="tabIcon13" aria-labelledby="baseIcon-tab13" aria-expanded="false">
                  <?php $attributes = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off');?>
				  <?php $hidden = array('euser_id' => 0,);?>
                  <?php echo form_open_multipart('admin/user/add_ticket_attachment', $attributes, $hidden);?>
                  <?php
                        $data4 = array(
                          'name'        => 'user_file_id',
                          'id'          => 'user_file_id',
                          'value'       => $session['user_id'],
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data4);
                    ?>
                    <?php
                        $data5 = array(
                          'name'        => '_token_file',
                          'id'          => '_token_file',
                          'value'       => $ticket_id,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data5);
                    ?>
                    <?php
                        $data6 = array(
                          'name'        => 'c_ticket_id',
                          'id'          => 'c_ticket_id',
                          'value'       => $ticket_id,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data6);
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
                <form>
                  <h4 class="form-section"><?php echo $this->lang->line('xin_attachment_list');?></h4>
                </form>
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
              <div class="tab-pane" id="tabIcon14" aria-labelledby="baseIcon-tab14" aria-expanded="false">
                <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
				  <?php $hidden = array('_uid' => $session['user_id']);?>
                  <?php echo form_open_multipart('admin/user/add_ticket_note', $attributes, $hidden);?>
                  <?php
                        $data7 = array(
                          'name'        => 'user_file_id',
                          'id'          => 'user_file_id',
                          'value'       => $session['user_id'],
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data7);
                    ?>
                    <?php
                        $data8 = array(
                          'name'        => 'token_note_id',
                          'id'          => 'token_note_id',
                          'value'       => $ticket_id,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data8);
                    ?>
                  <div class="box-block">
                    <div class="form-group">
                      <textarea name="ticket_note" id="ticket_note" class="form-control" rows="7" placeholder="<?php echo $this->lang->line('xin_ticket_note');?>"><?php echo $ticket_note;?></textarea>
                    </div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                    </div>
                  </div>
                <?php echo form_close(); ?>
              </div>
              <!-- tab --> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
