<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['announcement_id']) && $_GET['data']=='view_announcement'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_announcement');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
   <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
    <tbody>
      <tr>
        <th><?php echo $this->lang->line('xin_title');?></th>
        <td style="display: table-cell;"><?php echo $title;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_start_date');?></th>
        <td style="display: table-cell;"><?php echo $start_date;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_end_date');?></th>
        <td style="display: table-cell;"><?php echo $end_date;?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('module_company_title');?></th>
        <td style="display: table-cell;"><?php foreach($get_all_companies as $company) {?><?php if($company->company_id==$company_id):?> <?php echo $company->name?> <?php endif;?><?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_department');?></th>
        <td style="display: table-cell;"><?php foreach($all_departments as $department) {?><?php if($department->department_id==$department_id):?> <?php echo $department->department_name?> <?php endif;?><?php } ?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_summary');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($summary);?></td>
      </tr>
      <tr>
        <th><?php echo $this->lang->line('xin_description');?></th>
        <td style="display: table-cell;"><?php echo html_entity_decode($description);?></td>
      </tr>
    </tbody>
  </table>   
  </div> 
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>
<?php }
?>
