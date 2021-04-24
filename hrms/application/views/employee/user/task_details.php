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
        <div class="col-xs-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><?php echo $this->lang->line('xin_task_detail');?></h4>
            </div>
            <div class="card-body collapse in">
              <div class="card-block card-dashboard">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
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
      </div>
    </section>
    <!--</div>-->
  </div>
  <div class="col-md-8">
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="card-block">
            <ul class="nav nav-tabs nav-top-border no-hover-bg">
              <li class="nav-item"> <a class="nav-link active" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-home"></i> <?php echo $this->lang->line('xin_details');?></a> </li>
              <li class="nav-item"> <a class="nav-link" id="baseIcon-tab12" data-toggle="tab" aria-controls="tabIcon12" href="#tabIcon12" aria-expanded="false"><i class="fa fa-comment"></i> <?php echo $this->lang->line('xin_discussion');?></a> </li>
              <li class="nav-item"> <a class="nav-link" id="baseIcon-tab13" data-toggle="tab" aria-controls="tabIcon13" href="#tabIcon13" aria-expanded="false"><i class="fa fa-pencil"></i> <?php echo $this->lang->line('xin_task_files');?></a> </li>
              <li class="nav-item"> <a class="nav-link" id="baseIcon-tab14" data-toggle="tab" aria-controls="tabIcon14" href="#tabIcon14" aria-expanded="false"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('xin_note');?></a> </li>
            </ul>
            <div class="tab-content px-1 pt-1">
              <div role="tabpanel" class="tab-pane active" id="tabIcon11" aria-expanded="true" aria-labelledby="baseIcon-tab11">
                <div class="info">
                  <blockquote class="blockquote mb-1 mb-md-0"> <?php echo html_entity_decode($description);?> </blockquote>
                </div>
                <div>&nbsp;</div>
              </div>
              <div class="tab-pane" id="tabIcon12" aria-labelledby="baseIcon-tab12" aria-expanded="false">
                  <?php $attributes = array('name' => 'set_comment', 'id' => 'set_comment', 'autocomplete' => 'off');?>
				  <?php $hidden = array('euser_id' => 0,);?>
                  <?php echo form_open('admin/user/set_task_comment', $attributes, $hidden);?>
                  <?php
                        $data = array(
                          'name'        => 'user_id',
                          'value'       => $session['user_id'],
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data);
                    ?>
                    <?php
                        $data1 = array(
                          'name'        => 'comment_task_id',
                          'id'          => 'comment_task_id',
                          'value'       => $task_id,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data1);
                    ?>
                  <div class="box-block">
                    <div class="form-group">
                      <textarea name="xin_comment" id="xin_comment" class="form-control" rows="4" placeholder="<?php echo $this->lang->line('xin_message_here');?>"></textarea>
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
              <div class="tab-pane" id="tabIcon13" aria-labelledby="baseIcon-tab3" aria-expanded="false">
                  <?php $attributes = array('name' => 'add_attachment', 'id' => 'add_attachment', 'autocomplete' => 'off');?>
				  <?php $hidden = array('euser_id' => 0,);?>
                  <?php echo form_open_multipart('admin/user/add_task_attachment', $attributes, $hidden);?>
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
                          'name'        => 'c_task_id',
                          'id'          => 'c_task_id',
                          'value'       => $task_id,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data3);
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
              <div class="tab-pane" id="tabIcon14" aria-labelledby="baseIcon-tab4" aria-expanded="false">
                <?php $attributes = array('name' => 'add_note', 'id' => 'add_note', 'autocomplete' => 'off');?>
				  <?php $hidden = array('_uid' => $session['user_id']);?>
                  <?php echo form_open_multipart('admin/user/add_task_note', $attributes, $hidden);?>
                    <?php
                        $data4 = array(
                          'name'        => 'note_task_id',
                          'id'          => 'note_task_id',
                          'value'       => $task_id,
                          'type'  		=> 'hidden',
                          'class'       => 'form-control',
                        );
                    echo form_input($data4);
                    ?>
                  <div class="box-block">
                    <div class="form-group">
                      <textarea name="task_note" id="task_note" class="form-control" rows="7" placeholder="<?php echo $this->lang->line('xin_task_note');?>"><?php echo $task_note;?></textarea>
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
  </div>
</div>
