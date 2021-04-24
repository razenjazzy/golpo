<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['complaint_id']) && $_GET['data']=='view_complaint'){
$assigned_ids = explode(',',$complaint_against);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_complaint');?></h4>
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
          <th><?php echo $this->lang->line('xin_complaint_from');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($complaint_from==$employee->user_id):?>
            <?php echo $employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_complaint_title');?></th>
          <td style="display: table-cell;"><?php echo $title;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_complaint_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($complaint_date);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_complaint_against');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if(in_array($employee->user_id,$assigned_ids)):?>
           <?php echo $employee->first_name.' '.$employee->last_name;?><br />
            <?php endif;?>
            <?php } ?></td>
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
