<?php
/*
* Training Detail view
*/
$session = $this->session->userdata('username');
?>

<div class="row m-b-1">
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-xs-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><?php echo $this->lang->line('xin_training_details');?></h4>
            </div>
            <div class="card-body collapse in">
              <div class="card-block card-dashboard">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row" style="border-top: 0px;"><?php echo $this->lang->line('left_training_type');?></th>
                        <td class="text-right"><?php echo $type;?></td>
                      </tr>
                      <?php $user = $this->Xin_model->read_user_info($session['user_id']);
				  	if($user[0]->user_role_id==1){?>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_trainer');?></th>
                        <td class="text-right"><?php echo $trainer_name;?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_training_cost');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->currency_sign($training_cost);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_start_date');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($start_date);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_end_date');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($finish_date);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_e_details_date');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($created_at);?></td>
                      </tr>
                    </tbody>
                  </table>
                  <?php if($description!='' && $description!='<p><br></p>'):?>
                  <div class="bs-callout-success callout-border-left callout-square callout-transparent mt-1 p-1"> <?php echo $description;?> </div>
                  <?php endif;?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-8">
    <section id="decimal">
      <div class="row">
        <div class="col-xs-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><?php echo $this->lang->line('xin_details');?></h4>
            </div>
            <div class="card-body collapse in">
              <div class="card-block card-dashboard">
                <div class="col-md-6">
                  <form>
                    <h4 class="form-section"><?php echo $this->lang->line('xin_training_employees_s');?></h4>
                  </form>
                  <div class="media-list" id="all_employees_list">
                    <?php if($employee_id!='') {?>
                    <?php $employee_ids = explode(',',$employee_id); foreach($employee_ids as $assign_id) {?>
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
                    <div class="media">
                      <a class="media-left" href="javascript:void();">
                      <img class="media-object rounded-circle" src="<?php echo $u_file;?>" alt="<?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?>" style="width: 64px;height: 64px;">
                      </a>
                      <div class="media-body">
                        <h6 class="media-heading"><?php echo $e_name[0]->first_name.' '.$e_name[0]->last_name;?></h6>
                        <?php echo $designation_name;?> </div>
                    </div>
                    <?php } }?>
                    <?php } else { ?>
                    <span>&nbsp;</span>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <form>
                    <input type="hidden" name="_token_status" value="<?php echo $training_id;?>">
                    <h4 class="form-section"><?php echo $this->lang->line('xin_trainer');?></h4>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="status"><?php echo $trainer_name;?></label>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div>&nbsp;</div>
              </div>
              <!-- tab --> 
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
