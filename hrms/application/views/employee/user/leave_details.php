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
        <div class="col-xs-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><?php echo $this->lang->line('xin_leave_detail');?></h4>
            </div>
            <div class="card-body collapse in">
              <div class="card-block card-dashboard">
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
      </div>
    </section>
  </div>
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-xs-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><?php echo $this->lang->line('xin_leave_statistics');?></h4>
            </div>
            <div class="card-body collapse in">
              <div class="card-block card-dashboard">
                <?php foreach($all_leave_types as $type) {?>
                <?php $count_l = $this->Timesheet_model->count_total_leaves($type->leave_type_id,$employee_id);?>
                <?php
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
				?>
                <div id="leave-statistics">
                  <p><strong><?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $type->days_per_year;?>)</strong></p>
                  <progress class="progress <?php echo $progress_class;?>" value="<?php echo $count_data;?>" max="100"></progress>
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
</div>
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>