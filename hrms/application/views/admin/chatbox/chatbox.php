
<?php $session = $this->session->userdata('username');?>
<?php $fuser_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php
if($fuser_info[0]->online_status==1):
	$stgm = 'avatar-online';
	$status_title = "I'm Available";
elseif($fuser_info[0]->online_status==3):
	$stgm = 'avatar-busy';
	$status_title = "I'm Offline";
else:
	$stgm = 'avatar-away';
	$status_title = "I'm Offline";
endif;
?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $f_name = $fuser_info[0]->first_name.' '.$fuser_info[0]->last_name;?>

<div class="chat-wrapper container-p-x container-p-y">

              <!-- Make card full height of `.chat-wrapper` -->
              <div class="card flex-grow-1 position-relative overflow-hidden">

                <!-- Make row full height of `.card` -->
                <div class="row no-gutters h-100">
                  <div class="chat-sidebox col">

                    <!-- Chat contacts header -->
                    <div class="flex-grow-0 px-4">
                      <div class="media align-items-center">
                        <div class="media-body my-3">
                          
                            <div class="media align-items-center">
                            <?php  if($fuser_info[0]->profile_picture!='' && $fuser_info[0]->profile_picture!='no file') {?>
                            <img src="<?php  echo base_url().'uploads/profile/'.$fuser_info[0]->profile_picture;?>" class="d-block ui-w-40 rounded-circle" alt="">
                
                            <?php } else {?>
                            <?php  if($fuser_info[0]->gender=='Male') { ?>
                            <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                            <?php } else { ?>
                            <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                            <?php } ?>
                            <img src="<?php  echo $de_file;?>" class="d-block ui-w-40 rounded-circle" alt="">
                            <?php  } ?>
                            <div class="media-body flex-basis-auto pl-3">
                              <div><div class="btn-group show">
                                <a class="user-status dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><?php echo $f_name;?></a>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: top, left; top: -177px; left: 0px;">
                                  <a class="dropdown-item online-status" href="#" data-status-id="1" data-status-title="I'm Available" data-avatar-status="avatar-online">Available</a>
                <a class="dropdown-item online-status" href="#" data-status-id="3" data-status-title="I'm Offline" data-avatar-status="avatar-busy">Offline</a>
                                </div>
                              </div>
                              </div>
                              <div class="text-muted small" id="hr_status"><?php echo $status_title;?></div>
                            </div>
                          </div>
            
                        </div>
                        <a href="javascript:void(0)" class="chat-sidebox-toggler d-lg-none d-block text-muted text-large font-weight-light pl-3">&times;</a>
                      </div>
                      <hr class="border-light m-0">
                    </div>

                    <div class="flex-grow-1 position-relative">
                      <div class="chat-contacts list-group chat-scroll py-3 ps ps--active-y" id="chat_users">

                        <?php foreach($all_active_employees as $active_employees):?>
						<?php if($active_employees->user_id!=$session['user_id']):?>
                        <?php if ($active_employees->is_logged_in == 0):?>
                        <?php $bgm = 'offline';?>
                        <?php $bgmTxt = 'Offline';?>
                        <?php else:
                            if($active_employees->online_status==1):
                                $bgm = 'online';
								$bgmTxt = 'Online';
                            elseif($active_employees->online_status==3):
                                $bgm = 'offline';
								$bgmTxt = 'Offline';
                            else:
                                $bgm = 'offline';
								$bgmTxt = 'Offline';
                            endif;	
                        ?>
                        <?php endif;?>
                        <!-- Online -->
                        <button class="all-users list-group-item list-group-item-action media no-border <?php echo $bgm;?>" id="set_box_<?php echo $active_employees->user_id;?>" data-from-id="<?php echo $session['user_id'];?>" data-to-id="<?php echo $active_employees->user_id;?>" data-toggle="modal" data-target=".chatbox-single">
                        <!--<a href="javascript:void(0)" class="list-group-item list-group-item-action online">-->
                           <?php  if($active_employees->profile_picture!='' && $active_employees->profile_picture!='no file') {?>
                           <img src="<?php  echo base_url().'uploads/profile/'.$active_employees->profile_picture;?>" class="d-block ui-w-40 rounded-circle" alt="">
                        <?php } else {?>
                        <?php  if($active_employees->gender=='Male') { ?>
                        <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                        <?php } else { ?>
                        <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                        <?php } ?>
                        <img src="<?php  echo $de_file;?>" class="d-block ui-w-40 rounded-circle" alt="">
                        <?php  } ?>
                        <?php $fname = $active_employees->first_name.' '.$active_employees->last_name;?>
                        <?php $unread_msgs = $this->Chat_model->get_unread_message($active_employees->user_id,$session['user_id']);?>  
						  <?php $last_chat = $this->Chat_model->last_user_message($active_employees->user_id,$session['user_id']);?>
                          <?php 
                            if(!is_null($last_chat)){
                                $last_chat_date = $this->Chat_model->timeAgo($last_chat[0]->message_date);
                                $message_content = $last_chat[0]->message_content;
                            } else {
                                $last_chat_date = '--';
                                $message_content = 'No Message.';
                            }
                            ?>
                          <div class="media-body ml-3">
                            <?php echo $fname;?>
                            <div class="chat-status small">
                              <span class="badge badge-dot"></span>&nbsp; <?php echo $bgmTxt;?></div>
                          </div>
						  <?php
							if($unread_msgs > 0) { ?>
								<div class="badge badge-outline-success">
								<?php echo $unread_msgs;?></div>
							<?php } else {
							}
						  ?>
                        <!--</a>--></button>
                        <?php endif;?>
          				<?php endforeach; ?>

                      </div>
                      <!-- / .chat-contacts -->
                    </div>

                  </div>
                  <div class="d-flex col flex-column">

                    <!-- Wrap `.chat-scroll` to properly position scroll area. Remove this wtapper if you don't need scroll -->
                    <div class="flex-grow-1 position-relative">

                      <!-- Remove `.chat-scroll` and add `.flex-grow-1` if you don't need scroll -->
                      <div class="chat-messages chat-scroll p-4">

                          <div class="flex-shrink-1 rounded py-2 px-3 mr-3">
                            <img src="<?php echo base_url();?>uploads/logo/signin/<?php echo $company[0]->sign_in_logo;?>" />
                            <h4 class="">Welcome To <?php echo $company[0]->company_name;?> Chat Application</h4>
                            <h4 class="">Hello <?php echo $f_name;?>!</h4>
                            <p>&nbsp;</p>
                            <p><?php echo $company[0]->company_name;?> Chat Application is quite hot and easy-to-use for internal communication, at the moment it offers only private messages.</p>
                            <p>To get started, select a user from the left tab.</p>
                            <p>Chat immediately as you start your work day. You can use private messages for direct, one-on-one communication</p>
                          </div>

                      </div>
                      <!-- / .chat-messages -->
                    </div>

                  </div>
                </div>
                <!-- / .row -->

              </div>
              <!-- / .card -->

            </div>
            
            
<div class="modal fade text-xs-left chatbox-single" id="chatbox-single" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content" id="chat_modal">  
</div>
</div>
</div>
<style type="text/css">
.user-status, .all-users { cursor:pointer; }
</style>