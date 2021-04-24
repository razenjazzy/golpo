<style type="text/css">
.select2-container--default, .select2-container--open { z-index:1100 !important; }
#ui-datepicker-div { z-index:1100 !important; }
.modal-backdrop { z-index: 1091 !important; }
.modal { z-index: 1100 !important; }
.popover { z-index: 1100 !important; }
</style>
<div class="modal fade delete-modal animated " tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-dark-danger alert-dismissible fade show">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <div class="modal-footer">
        <?php $attributes = array('name' => 'delete_record', 'id' => 'delete_record', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>
        <?php echo form_open('', $attributes, $hidden);?> 
		<?php
		$del_token = array(
			'type'  => 'hidden',
			'id'  => 'token_type',
			'name'  => 'token_type',
			'value' => 0,
		);
		echo form_input($del_token);
		?>
		<?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> 
		<?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="modal fade edit-modal-data animated " id="edit-modal-data" tabindex="-1" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="ajax_modal"></div>
  </div>
</div>
<div class="modal fade view-modal-data-bg animated " id="edit-modal-data" tabindex="-1" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="pajax_modal_view"></div>
  </div>
</div>
<div class="modal fade view-modal-data animated " id="view-modal-data" tabindex="-1" role="dialog" aria-labelledby="view-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_view"></div>
  </div>
</div>
<div class="modal fade view-modal-annoucement animated " id="view-modal-data" tabindex="-1" role="dialog" aria-labelledby="view-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_announcement"></div>
  </div>
</div>

<div class="modal fade payroll_template_modal default-modal animated " id="payroll_template_modal" tabindex="-1" role="dialog" aria-labelledby="detail-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_payroll"></div>
  </div>
</div>
<div class="modal fade hourlywages_template_modal default-modal animated " id="hourlywages_template_modal" tabindex="-1" role="dialog" aria-labelledby="detail-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_hourlywages"></div>
  </div>
</div>
<div class="modal fade detail_modal_data default-modal animated " id="detail_modal_data" tabindex="-1" role="dialog" aria-labelledby="detail-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_details"></div>
  </div>
</div>
<div class="modal fade emo_monthly_pay animated " id="emo_monthly_pay" tabindex="-1" role="dialog" aria-labelledby="emo_monthly_pay" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="emo_monthly_pay_aj"></div>
  </div>
</div>
<div class="modal fade emo_hourly_pay animated " id="emo_hourly_pay" tabindex="-1" role="dialog" aria-labelledby="emo_hourly_pay" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="emo_hourly_pay_aj"></div>
  </div>
</div>
<div class="modal fade policy animated pulse" id="policy" tabindex="-1" role="dialog" aria-labelledby="policy" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="policy_modal"></div>
  </div>
</div>
<div class="modal fade delete-modal-file animated " tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-dark-danger alert-dismissible fade show">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <div class="modal-footer">
        <?php $attributes = array('name' => 'delete_record_f', 'id' => 'delete_record_f', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token_del_file' => '000', 'token_type' => '000');?>
        <?php echo form_open('', $attributes, $hidden);?> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="modal fade abouthr" id="abouthr" tabindex="-1" role="dialog" aria-labelledby="abouthr" aria-hidden="true">
  <div class="modal-dialog modal-xs">
    <div class="modal-content" id="abouthr_modal"></div>
  </div>
</div>
<div class="modal fade add-modal-data animated " id="add-modal-data" tabindex="-1" role="dialog" aria-labelledby="add-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="add_ajax_modal"></div>
  </div>
</div>
<div class="modal fade delete-modal-task animated " tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-dark-danger alert-dismissible fade show">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <div class="modal-footer">
        <?php $attributes = array('name' => 'delete_record_t', 'id' => 'delete_record_t', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token_del_file' => '00', 'token_type' => '00');?>
        <?php echo form_open('', $attributes, $hidden);?> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
