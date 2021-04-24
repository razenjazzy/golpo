<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['advance_salary_id']) && $_GET['data']=='view_advance_salary'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_advance_salary');?></h4>
</div>
  <div class="modal-body">
  <div class="table-responsive" data-pattern="priority-columns">
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
          <th><?php echo $this->lang->line('xin_award_month_year');?></th>
          <td style="display: table-cell;"><?php echo $month_year;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_amount');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->currency_sign($advance_amount);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_one_time_deduct');?></th>
          <td style="display: table-cell;"><?php if($one_time_deduct==1): echo $onetime = $this->lang->line('xin_yes'); else: echo $onetime = $this->lang->line('xin_no'); endif;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_emi_salary');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->currency_sign($monthly_installment);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;"><?php if($status==0): echo $status = $this->lang->line('xin_pending'); elseif($status==1): echo $status = $this->lang->line('xin_accepted'); else: echo $status = $this->lang->line('xin_rejected'); endif;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_created_at');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->set_date_format($created_at);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_reason');?></th>
          <td style="display: table-cell;"><?php echo html_entity_decode($reason);?></td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php } else if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='view_advance_salary_report'){
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_advance_salary_report');?></h4>
</div>
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
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
          <th><?php echo $this->lang->line('xin_total_amount');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->currency_sign($advance_amount);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_total_paid_amount');?></th>
          <td style="display: table-cell;"><?php echo $this->Xin_model->currency_sign($total_paid);?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('xin_one_time_deduct');?></th>
          <td style="display: table-cell;">
		  <?php
			$remainig_amount = $advance_amount - $total_paid;
			$ramount = $this->Xin_model->currency_sign($remainig_amount);
			?>
		  <?php echo $ramount;?></td>
        </tr>
        <tr>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <td style="display: table-cell;">
			<?php
            if($advance_amount == $total_paid){
            	$all_paid = '<span class="tag tag-success">'.$this->lang->line('xin_all_paid').'</span>';
            } else {
           		$all_paid = '<span class="tag tag-warning">'.$this->lang->line('xin_remaining').'</span>';
            }
            ?>
		  <?php echo $all_paid;?></td>
        </tr>
        <tr>
          <th colspan="2" style="text-align:center;"><?php echo $this->lang->line('xin_rquested_date_details');?></th>
        </tr>        
      </tbody>
    </table>
    </div>
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="footable-details table table-striped table-hover toggle-circle">
    	<tr>
          <th><?php echo $this->lang->line('xin_amount');?></th>
          <th><?php echo $this->lang->line('xin_award_month_year');?></th>
          <th><?php echo $this->lang->line('xin_one_time_deduct');?></th>
          <th><?php echo $this->lang->line('xin_emi_salary');?></th>
          <th><?php echo $this->lang->line('xin_created_at');?></th>
        </tr>
        <?php $requested_date = $this->Payroll_model->requested_date_details($employee_id);?>
        <?php foreach($requested_date->result() as $r):?>
        <?php
		$d = explode('-',$r->month_year);
		$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
		$month_year = $get_month.', '.$d[0];
		// get onetime deduction value
		if($r->one_time_deduct==1): $onetime = $this->lang->line('xin_yes'); else: $onetime = $this->lang->line('xin_no'); endif;
		?>
        <tr>
          <td><?php echo $this->Xin_model->currency_sign($r->advance_amount)?></td>
          <td><?php echo $month_year;?></td>
          <td><?php echo $onetime;?></td>
          <td><?php echo $this->Xin_model->currency_sign($r->monthly_installment);?></td>
          <td><?php echo '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($r->created_at);?></td>
        </tr>
        <?php endforeach;?>
    </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php }
?>
