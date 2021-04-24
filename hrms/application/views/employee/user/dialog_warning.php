<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['warning_id']) && $_GET['data']=='view_warning'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_warning_view');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('module_company_title');?></th>
          <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?>
            <?php if($company_id==$company->company_id):?>
            <?php echo $company->name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_warning_to');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($warning_to==$employee->user_id):?>
            <?php echo $employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_warning_type');?></th>
          <td style="display: table-cell;"><?php foreach($all_warning_types as $warning_type) {?>
            <?php if($warning_type_id==$warning_type->warning_type_id):?>
            <?php echo $warning_type->type;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_subject');?></th>
          <td style="display: table-cell;"><?php echo $subject;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_warning_by');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($warning_by==$employee->user_id):?>
            <?php echo $employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_warning_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($warning_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php if($status=='0'): $w_status = $this->lang->line('xin_pending');?>
            <?php endif; ?>
            <?php if($status=='1'): $w_status = $this->lang->line('xin_accepted');?>
            <?php endif; ?>
            <?php if($status=='2'): $w_status = $this->lang->line('xin_rejected');?>
            <?php endif; ?>
            <?php echo $w_status;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_description');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
