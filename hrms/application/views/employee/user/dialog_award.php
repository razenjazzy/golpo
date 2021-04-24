<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['award_id']) && $_GET['data']=='view_award'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_award');?></h4>
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
          <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
          <td style="display: table-cell;"><?php foreach($all_employees as $employee) {?>
            <?php if($employee_id==$employee->user_id):?>
            <?php echo $employee->first_name.' '.$employee->last_name;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_award_type');?></th>
          <td style="display: table-cell;"><?php foreach($all_award_types as $award_type) {?>
            <?php if($award_type_id==$award_type->award_type_id):?>
            <?php echo $award_type->award_type;?>
            <?php endif;?>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($created_at);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_award_month_year');?></th>
          <td style="display: table-cell;"><?php echo $award_month_year;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_gift');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->currency_sign($gift_item);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_cash');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->currency_sign($cash_price);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_award_photo');?></th>
          <td style="display: table-cell;"><?php if($award_photo!='' && $award_photo!='no file') {?>
            <img src="<?php echo base_url().'uploads/award/'.$award_photo;?>" width="70px" id="u_file">&nbsp; <a href="<?php echo site_url()?>admin/download?type=award&filename=<?php echo $award_photo;?>"><?php echo $this->lang->line('xin_download');?></a>
            <?php } ?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_award_info');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($award_information);?></td>
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
