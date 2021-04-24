<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['transfer_id']) && $_GET['data']=='view_transfer'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_transfer');?></h4>
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
          <th><?php echo $this->lang->line('xin_employee_transfer');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($employee_id==$employee->user_id):?>
            <?php echo $employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_transfer_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($transfer_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_transfer_to_department');?></th>
          <td style="display: table-cell;"><?php foreach($all_departments as $department) {?>
            <?php if($transfer_department==$department->department_id):?>
            <?php echo $department->department_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_transfer_to_location');?></th>
          <td style="display: table-cell;"><?php foreach($all_locations as $location) {?>
            <?php if($transfer_location==$location->location_id):?>
            <?php echo $location->location_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php if($status=='0'): $t_status = $this->lang->line('xin_pending');?>
            <?php endif; ?>
            <?php if($status=='1'): $t_status = $this->lang->line('xin_accepted');?>
            <?php endif; ?>
            <?php if($status=='2'): $t_status = $this->lang->line('xin_rejected');?>
            <?php endif; ?>
            <?php echo $t_status;?></td>
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
