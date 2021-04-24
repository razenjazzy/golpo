<?php
/* Settings view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $file_setting = $this->Xin_model->read_file_setting_info(1);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<section id="basic-listgroup">
  <div class="row match-heights">
    <div class="col-lg-3 col-md-3">
      <div class="card">
          <div class="card-blocks">
            <div class="list-group"> <a class="list-group-item list-group-item-action nav-tabs-link" href="#page_layout" data-profile="1" data-profile-block="page_layout" data-toggle="tab" aria-expanded="true" id="setting_1"> <i class="ion ion-logo-buffer"></i> <?php echo $this->lang->line('xin_page_layouts');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#notification" data-profile="4" data-profile-block="notification" data-toggle="tab" aria-expanded="true" id="setting_4"> <i class="fas fa-exclamation-circle"></i> <?php echo $this->lang->line('xin_notification_position');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#company_logo" data-profile="6" data-profile-block="company_logo" data-toggle="tab" aria-expanded="true" id="setting_6"> <i class="far fa-images"></i> <?php echo $this->lang->line('xin_system_logos');?> </a> <?php if($system[0]->module_orgchart=='true'){?><a class="list-group-item list-group-item-action nav-tabs-link" href="#org_chart" data-profile="7" data-profile-block="org_chart" data-toggle="tab" aria-expanded="true" id="setting_7"> <i class="fa fa-sitemap"></i> <?php echo $this->lang->line('xin_org_chart_title');?> </a><?php } ?> </div>
          </div>
        </div>
      </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="page_layout">
      <div class="card">
        <h6 class="card-header"> <?php echo $this->lang->line('xin_page_layouts');?></h6>
        <div class="card-body">
          <div class="card-block">
            <?php $attributes = array('name' => 'page_layouts_info', 'id' => 'page_layouts_info', 'autocomplete' => 'off');?>
			<?php $hidden = array('theme_info' => 'UPDATE');?>
            <?php echo form_open('admin/theme/page_layouts/', $attributes, $hidden);?>
              <div class="box box-block bg-white">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="notification_position"><?php echo $this->lang->line('xin_theme_show_dashboard_cards');?></label>
                      <select class="form-control" name="statistics_cards" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_theme_show_dashboard_cards');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="0" <?php if($statistics_cards=='0'){?> selected <?php }?>>0</option>
                        <option value="4" <?php if($statistics_cards=='4'){?> selected <?php }?>>4</option>
                        <option value="8" <?php if($statistics_cards=='8'){?> selected <?php }?>>8</option>
                        <option value="12" <?php if($statistics_cards=='12'){?> selected <?php }?>>12</option>
                      </select>
                      <br />
                      <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_theme_set_statistics_cards');?></small> </div>
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
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="notification" style="display:none;">
      <div class="card">
        <h6 class="card-header"> <?php echo $this->lang->line('xin_notification_position');?></h6>
        <div class="card-body">
          <div class="card-block">
            <?php $attributes = array('name' => 'notification_position_info', 'id' => 'notification_position_info', 'autocomplete' => 'off');?>
			<?php $hidden = array('theme_info' => 'UPDATE');?>
            <?php echo form_open('admin/theme/notification_position_info/', $attributes, $hidden);?>
              <div class="box box-block bg-white">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="notification_position"><?php echo $this->lang->line('dashboard_position');?></label>
                      <select class="form-control" name="notification_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_position');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="toast-top-right" <?php if($notification_position=='toast-top-right'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_right');?></option>
                        <option value="toast-bottom-right" <?php if($notification_position=='toast-bottom-right'){?> selected <?php }?>><?php echo $this->lang->line('xin_bottom_right');?></option>
                        <option value="toast-bottom-left" <?php if($notification_position=='toast-bottom-left'){?> selected <?php }?>><?php echo $this->lang->line('xin_bottom_left');?></option>
                        <option value="toast-top-left" <?php if($notification_position=='toast-top-left'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_left');?></option>
                        <option value="toast-top-center" <?php if($notification_position=='toast-top-center'){?> selected <?php }?>><?php echo $this->lang->line('xin_top_center');?></option>
                      </select>
                      <br />
                      <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_set_position_for_notifications');?></small> </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="company_name"><?php echo $this->lang->line('xin_close_button');?></label>
                      <br>
                      <div class="pull-xs-left m-r-1">
                      <label class="switcher">
                        <input type="checkbox" class="switcher-input js-switch switch" id="sclose_btn" <?php if($notification_close_btn=='true'):?> checked="checked" <?php endif;?> value="true">
                      <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                      </span>
                    </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="company_name"><?php echo $this->lang->line('xin_progress_bar');?></label>
                      <br>
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher">
                        <input type="checkbox" class="switcher-input js-switch switch" id="snotification_bar" <?php if($notification_bar=='true'):?> checked="checked" <?php endif;?> value="true">
                      <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                      </span>
                    </label>
                      </div>
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
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9 current-tab animated fadeInRight" id="company_logo" style="display:none;">
      <div class="card mb-4">
        <h6 class="card-header"> <?php echo $this->lang->line('xin_system_logos');?></h6>
        <div id="hrsale_1" class="card-body">
            <?php $attributes = array('name' => 'logo_info', 'id' => 'logo_info', 'autocomplete' => 'off');?>
			<?php $hidden = array('company_logo' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/settings/logo_info/'.$company_info_id, $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-6">
                  <div class='form-group'>
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_first_logo');?></label>
                      <input type="file" class="form-control-file" id="p_file" name="p_file">
                    </fieldset>
                    <?php if($logo!='' && $logo!='no file') {?>
                    <img src="<?php echo base_url().'uploads/logo/'.$logo;?>" width="70px" style="margin-left:30px;" id="u_file">
                    <?php } else {?>
                    <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file">
                    <?php } ?>
                    <br>
                    <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                    <small>- <?php echo $this->lang->line('xin_best_main_logo_size');?></small><br />
                    <small>- <?php echo $this->lang->line('xin_logo_whit_background_light_text');?></small> </div>
                </div>
                <div class="col-md-6">
                  <div class='form-group'>
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_favicon');?></label>
                      <input type="file" class="form-control-file" id="favicon" name="favicon">
                    </fieldset>
                    <?php if($favicon!='' && $favicon!='no file') {?>
                    <img src="<?php echo base_url().'uploads/logo/favicon/'.$favicon;?>" width="16px" style="margin-left:30px;" id="favicon1">
                    <?php } else {?>
                    <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="16px" style="margin-left:30px;" id="favicon1">
                    <?php } ?>
                    <br>
                    <small>- <?php echo $this->lang->line('xin_logo_files_only_favicon');?></small><br />
                    <small>- <?php echo $this->lang->line('xin_best_logo_size_favicon');?></small></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
      </div>
      <div class="card mb-4">
        <h6 class="card-header"> <?php echo $this->lang->line('xin_theme_signin_page_logo_title');?></h6>
        <div id="hrsale_2" class="card-body">
            <?php $attributes = array('name' => 'singin_logo', 'id' => 'singin_logo', 'autocomplete' => 'off');?>
			<?php $hidden = array('company_logo' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/admin/singin_logo/', $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-6">
                  <div class='form-group'>
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_logo');?></label>
                      <input type="file" class="form-control-file" id="p_file3" name="p_file3">
                    </fieldset>
                    <?php if($sign_in_logo!='' && $sign_in_logo!='no file') {?>
                    <img src="<?php echo base_url().'uploads/logo/signin/'.$sign_in_logo;?>" width="70px" style="margin-left:30px;" id="u_file3">
                    <?php } else {?>
                    <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file3">
                    <?php } ?>
                    <br>
                    <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                    <small>- <?php echo $this->lang->line('xin_best_signlogo_size');?></small></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
      </div>
      <div class="card mb-4">
        <h6 class="card-header"> <?php echo $this->lang->line('xin_theme_job_page_logo_title');?> <small>(<?php echo $this->lang->line('left_frontend');?>)</small></h6>
        <div id="hrsale_3" class="card-body">
            <?php $attributes = array('name' => 'job_logo', 'id' => 'job_logo', 'autocomplete' => 'off');?>
			<?php $hidden = array('job_logo' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/settings/job_logo/', $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-6">
                  <div class='form-group'>
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_logo');?></label>
                      <input type="file" class="form-control-file" id="p_file4" name="p_file4">
                    </fieldset>
                    <?php if($job_logo!='' && $job_logo!='no file') {?>
                    <img src="<?php echo base_url().'uploads/logo/job/'.$job_logo;?>" width="70px" style="margin-left:30px;" id="u_file4">
                    <?php } else {?>
                    <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file4">
                    <?php } ?>
                    <br>
                    <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                    <small>- <?php echo $this->lang->line('xin_best_signlogo_size');?> </small></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
      </div>
      <div class="card">
        <h6 class="card-header"> ><?php echo $this->lang->line('xin_theme_payroll_logo_title');?> <small>(<?php echo $this->lang->line('xin_for_pdf');?>)</small></h6>
        <div id="hrsale_4" class="card-body">
            <?php $attributes = array('name' => 'payroll_logo', 'id' => 'payroll_logo_info', 'autocomplete' => 'off');?>
			<?php $hidden = array('payroll_logo' => 'UPDATE');?>
            <?php echo form_open_multipart('admin/settings/payroll_logo/', $attributes, $hidden);?>
              <div class="row">
                <div class="col-md-6">
                  <div class='form-group'>
                    <fieldset class="form-group">
                      <label for="logo"><?php echo $this->lang->line('xin_logo');?></label>
                      <input type="file" class="form-control-file" id="p_file5" name="p_file5">
                    </fieldset>
                    <?php if($payroll_logo!='' && $payroll_logo!='no file') {?>
                    <img src="<?php echo base_url().'uploads/logo/payroll/'.$payroll_logo;?>" width="70px" style="margin-left:30px;" id="u_file5">
                    <?php } else {?>
                    <img src="<?php echo base_url().'uploads/logo/no_logo.png';?>" width="70px" style="margin-left:30px;" id="u_file5">
                    <?php } ?>
                    <br>
                    <small>- <?php echo $this->lang->line('xin_logo_files_only');?></small><br />
                    <small>- <?php echo $this->lang->line('xin_best_signlogo_size');?></small></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
           <?php echo form_close(); ?>
          </div>
      </div>
    </div>
    <?php if($system[0]->module_orgchart=='true'){?>
    <div class="col-md-9 current-tab animated fadeInRight" id="org_chart" style="display:none;">
      <div class="card">
        <h6 class="card-header"><?php echo $this->lang->line('xin_org_chart_title');?></h6>
        <div class="card-body">
          <div class="card-block">
            <?php $attributes = array('name' => 'orgchart_info', 'id' => 'orgchart_info', 'autocomplete' => 'off');?>
			<?php $hidden = array('iorgchart_info' => 'UPDATE');?>
            <?php echo form_open('admin/theme/orgchart/', $attributes, $hidden);?>
              <div class="box box-block bg-white">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="notification_position"><?php echo $this->lang->line('xin_org_chart_layout');?></label>
                      <select class="form-control" name="org_chart_layout" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_org_chart_layout');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        <option value="r2l" <?php if($org_chart_layout=='r2l'){?> selected <?php }?>><?php echo $this->lang->line('xin_org_chart_r2l');?></option>
                        <option value="l2r" <?php if($org_chart_layout=='l2r'){?> selected <?php }?>><?php echo $this->lang->line('xin_org_chart_l2r');?></option>
                        <option value="t2b" <?php if($org_chart_layout=='t2b'){?> selected <?php }?>><?php echo $this->lang->line('xin_org_chart_t2b');?></option>
                        <option value="b2t" <?php if($org_chart_layout=='b2t'){?> selected <?php }?>><?php echo $this->lang->line('xin_org_chart_b2t');?></option>
                      </select>
                      <br />
                      <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_org_chart_set_layout');?></small> </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                    <label for="export_file_title"><?php echo $this->lang->line('xin_org_chart_export_file_title');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_org_chart_export_file_title');?>" name="export_file_title" type="text" value="<?php echo $export_file_title;?>">
                      <small class="text-muted"><i class="ft-arrow-up"></i> <?php echo $this->lang->line('xin_org_chart_export_file_title_details');?>
                      </small>
                  </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="export_orgchart" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_export');?>
                        <button type="button" class="btn icon-btn btn-xs btn-outline-info itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_export_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_export');?>"><span class="far fa-question-circle"></span></button>
                      </label>
                      
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher">
                        <input type="checkbox" class="switcher-input js-switch switch" id="export_orgchart" <?php if($export_orgchart=='true'):?> checked="checked" <?php endif;?> value="true">
                      <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                      </span>
                    </label>
                      </div>
                  </div>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="export_orgchart" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_zoom');?>
                        <button type="button" class="btn icon-btn btn-xs btn-outline-info itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_zoom_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_zoom');?>"><span class="far fa-question-circle"></span></button>
                      </label>
                      
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher">
                        <input type="checkbox" class="switcher-input js-switch switch" id="org_chart_zoom" <?php if($org_chart_zoom=='true'):?> checked="checked" <?php endif;?> value="true">
                      <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                      </span>
                    </label>
                      </div>
                  </div>
                  </div>   
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="export_orgchart" data-trigger="hover"> <?php echo $this->lang->line('xin_org_chart_pan');?>
                        <button type="button" class="btn icon-btn btn-xs btn-outline-info itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_org_chart_pan_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_org_chart_pan');?>"><span class="far fa-question-circle"></span></button>
                      </label>
                      
                      <div class="pull-xs-left m-r-1">
                        <label class="switcher">
                        <input type="checkbox" class="switcher-input js-switch switch" id="org_chart_pan" <?php if($org_chart_pan=='true'):?> checked="checked" <?php endif;?> value="true" >
                      <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                      </span>
                    </label>
                      </div>
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
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</section>
