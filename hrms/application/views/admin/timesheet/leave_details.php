<?php
/* Leave Detail view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>

<div class="row m-b-1">
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_leave_detail');?></span> </div>
            <div class="card-body">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('xin_employee');?></th>
                        <td class="text-right"><?php echo $full_name;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_leave_type');?></th>
                        <td class="text-right"><?php echo $type;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_applied_on');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($created_at);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_start_date');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($from_date);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_end_date');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($to_date);?></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="bs-callout-success callout-border-left callout-square callout-transparent mt-1 p-1"> <?php echo $reason;?> </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php //if($user[0]->user_role_id == 1) {?>
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_update_status');?></span> </div>
            <div class="card-body">
                  <?php $attributes = array('name' => 'update_status', 'id' => 'update_status', 'autocomplete' => 'off');?>
				  <?php $hidden = array('user_id' => $session['user_id'], '_token_status' => $leave_id);?>
                  <?php echo form_open('admin/timesheet/update_leave_status/'.$leave_id, $attributes, $hidden);?>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                        <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                          <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_pending');?></option>
                          <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_approved');?></option>
                          <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_rejected');?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="remarks"><?php echo $this->lang->line('xin_remarks');?></label>
                        <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_remarks');?>" name="remarks" id="remarks" cols="30" rows="5"><?php echo $remarks;?></textarea>
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
    </section>
  </div>
  <?php //} ?>
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_leave_statistics');?></span> </div>
            <div class="card-body">
              <div class="card-block card-dashboard">
                <?php foreach($all_leave_types as $type) {?>
                <?php $count_l = $this->Timesheet_model->count_total_leaves($type->leave_type_id,$employee_id);?>
                <?php
					if($count_l == 0){
						$progress_class = '';
						$count_data = 0;
					} else {
						$count_data = $count_l / $type->days_per_year * 100;
						// progress
						if($count_data <= 20) {
							$progress_class = 'progress-success';
						} else if($count_data > 20 && $count_data <= 50){
							$progress_class = 'progress-info';
						} else if($count_data > 50 && $count_data <= 75){
							$progress_class = 'progress-warning';
						} else {
							$progress_class = 'progress-danger';
						}
					}
				?>
                <div id="leave-statistics">
                  <p><strong><?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $type->days_per_year;?>)</strong></p>
                  <div class="progress" style="height: 6px;">
                  <div class="progress-bar" style="width: <?php echo $count_data;?>%;"></div>
                </div>
                <!--<progress class="progress <?php echo $progress_class;?>" value="<?php echo $count_data;?>" max="100"></progress>-->
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>