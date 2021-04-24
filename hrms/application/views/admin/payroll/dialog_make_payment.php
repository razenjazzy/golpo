<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='payment' && $_GET['type']=='monthly_payment'){ ?>
<?php
$payment_month = strtotime($this->input->get('pay_date'));
$p_month = date('F Y',$payment_month);
//$company_id = $company_id;
?>
<?php
// get monthly installment
//$user = $this->Xin_model->read_user_info($_GET['employee_id']);


// get advance salary
$advance_salary = $this->Payroll_model->advance_salary_by_employee_id($_GET['employee_id']);
$emp_value = $this->Payroll_model->get_paid_salary_by_employee_id($_GET['employee_id']);

if(!is_null($advance_salary)){
	$monthly_installment = $advance_salary[0]->monthly_installment;
	$advance_amount = $advance_salary[0]->advance_amount;
	$total_paid = $advance_salary[0]->total_paid;
	//check ifpaid
	$em_advance_amount = $advance_salary[0]->advance_amount;
	$em_total_paid = $advance_salary[0]->total_paid;
	
	if($em_advance_amount > $em_total_paid){
		if($monthly_installment=='' || $monthly_installment==0) {
			
			$ntotal_paid = $emp_value[0]->total_paid;
			$nadvance = $emp_value[0]->advance_amount;
			$total_net_salary = $nadvance - $ntotal_paid;
			$pay_amount = $net_salary - $total_net_salary;
			$advance_amount = $total_net_salary;
		} else {
			//
			$re_amount = $em_advance_amount - $em_total_paid;
			if($monthly_installment > $re_amount){
				$advance_amount = $re_amount;
				$total_net_salary = $net_salary - $re_amount;
				$pay_amount = $net_salary - $re_amount;
			} else {
				$advance_amount = $monthly_installment;
				$total_net_salary = $net_salary - $monthly_installment;
				$pay_amount = $net_salary - $monthly_installment;
			}
		}
		
	} else {
		$total_net_salary = $net_salary - 0;
		$pay_amount = $net_salary - 0;
		$advance_amount = 0;
	}
} else {
	$pay_amount = $net_salary - 0;
	$total_net_salary = $net_salary - 0;	
	$advance_amount = 0;
}
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><strong><?php echo $this->lang->line('xin_payment_for');?></strong> <?php echo $p_month;?></h4>
</div>
<div class="modal-body">
<?php $attributes = array('name' => 'pay_monthly', 'id' => 'pay_monthly', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'ADD');?>
<?php echo form_open('admin/payroll/add_pay_monthly/', $attributes, $hidden);?>
   <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <input type="hidden" name="department_id" value="<?php echo $department_id;?>" />
          <input type="hidden" name="designation_id" value="<?php echo $designation_id;?>" />
          <input type="hidden" name="company_id" value="<?php echo $company_id;?>" />
          <label for="name"><?php echo $this->lang->line('xin_payroll_basic_salary');?></label>
          <input type="text" name="gross_salary" class="form-control" value="<?php echo $basic_salary;?>" readonly>
          <input type="hidden" id="emp_id" value="<?php echo $user_id?>" name="emp_id">
          <input type="hidden" value="<?php echo $user_id;?>" name="u_id">
          <input type="hidden" value="<?php echo $basic_salary;?>" name="basic_salary">
          <input type="hidden" value="<?php echo $this->input->get('pay_date');?>" name="pay_date" id="pay_date">
        </div>
      </div>
    </div>
    <?php if($overtime_rate!=''): ?>
    <input type="hidden" name="overtime_rate" value="<?php echo $overtime_rate;?>">
    <?php else:?>
    <input type="hidden" name="overtime_rate" class="form-control" value="0">
    <?php endif;?>
    <?php if($house_rent_allowance!=''): ?>
    <input type="hidden" name="house_rent_allowance" value="<?php echo $house_rent_allowance;?>">
    <?php else:?>
    <input type="hidden" name="house_rent_allowance" class="form-control" value="0">
    <?php endif;?>
    <?php if($medical_allowance!=''): ?>
    <input type="hidden" name="medical_allowance" value="<?php echo $medical_allowance;?>">
    <?php else:?>
    <input type="hidden" name="medical_allowance" class="form-control" value="0">
    <?php endif;?>
    <?php if($travelling_allowance!=''): ?>
    <input type="hidden" name="travelling_allowance" value="<?php echo $travelling_allowance;?>">
    <?php else:?>
    <input type="hidden" name="travelling_allowance" class="form-control" value="0">
    <?php endif;?>
    <?php if($dearness_allowance!=''): ?>
    <input type="hidden" name="dearness_allowance" value="<?php echo $dearness_allowance;?>">
    <?php else:?>
    <input type="hidden" name="dearness_allowance" class="form-control" value="0">
    <?php endif;?>
    <?php if($provident_fund!=''): ?>
    <input type="hidden" name="provident_fund" value="<?php echo $provident_fund;?>">
    <?php else:?>
    <input type="hidden" name="provident_fund" class="form-control" value="0">
    <?php endif;?>
    <?php if($tax_deduction!=''): ?>
    <input type="hidden" name="tax_deduction" value="<?php echo $tax_deduction;?>">
    <?php else:?>
    <input type="hidden" name="tax_deduction" class="form-control" value="0">
    <?php endif;?>
    <?php if($security_deposit!=''): ?>
    <input type="hidden" name="security_deposit" value="<?php echo $security_deposit;?>">
    <?php else:?>
    <input type="hidden" name="security_deposit" class="form-control" value="0">
    <?php endif;?>
    <?php if($house_rent_allowance!='' || $medical_allowance!='' || $travelling_allowance!='' || $dearness_allowance!=''): ?>
    <?php if($house_rent_allowance==0): $house_rent_allowance = 0; endif;?>
    <?php if($medical_allowance==0): $medical_allowance = 0; endif;?>
    <?php if($travelling_allowance==0): $travelling_allowance = 0; endif;?>
    <?php if($dearness_allowance==0): $dearness_allowance = 0; endif;?>
    <?php $total_allow= $house_rent_allowance + $medical_allowance + $travelling_allowance + $dearness_allowance;?>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_total_allowance');?></label>
          <input type="text" name="total_allowances" class="form-control" value="<?php echo $total_allow;?>" readonly>
        </div>
      </div>
    </div>
    <?php else:?>
    <input type="hidden" name="total_allowances" class="form-control" value="0">
    <?php endif;?>
    <?php if($provident_fund!='' || $tax_deduction!='' || $security_deposit!=''): ?>
    <?php $total_de= $provident_fund + $tax_deduction + $security_deposit;?>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_total_deduction');?></label>
          <input type="text" name="total_deductions" class="form-control" value="<?php echo $total_de;?>" readonly>
        </div>
      </div>
    </div>
    <?php else:?>
    <input type="hidden" name="total_deductions" class="form-control" value="0">
    <?php endif;?>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_net_salary');?></label>
          <input type="text" name="net_salary" class="form-control" value="<?php echo $net_salary;?>" readonly>
        </div>
      </div>
    </div>
    <?php if($advance_amount!=0):?>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_advance_deducted_salary');?></label>
          <input type="text" class="form-control" name="advance_amount" value="<?php echo $advance_amount;?>" readonly>
        </div>
      </div>
    </div>
    <?php endif;?>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_payment_amount');?></label>
          <input type="text" name="payment_amount" class="form-control" value="<?php echo $pay_amount;?>" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
          <select name="payment_method" class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_payment_method');?>">
            <option value="">&nbsp;</option>
            <option value="1">Online</option>
            <option value="2">PayPal</option>
            <option value="3">Payoneer</option>
            <option value="4">Bank Transfer</option>
            <option value="5">Cheque</option>
            <option value="6">Cash</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payment_comment');?></label>
          <input type="text" class="form-control" name="comments">
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_pay');?></button>
  <?php echo form_close(); ?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	// On page load: datatable					
	$("#pay_monthly").submit(function(e){
	
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=11&data=monthly&add_type=add_monthly_payment&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.emo_monthly_pay').modal('toggle');
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/payroll/payslip_list") ?>?employee_id=0&company_id=<?php echo $company_id;?>&month_year=<?php echo $this->input->get('pay_date');?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php } else if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='payment' && $_GET['type']=='hourly_payment'){ ?>
<?php
$payment_month = strtotime($_GET['pay_date']);
$p_month = date('F Y',$payment_month);
$company_id = $_GET['company_id'];
//
$result = $this->Payroll_model->total_hours_worked($_GET['employee_id'],$_GET['pay_date']);

/* total work clock-in > clock-out  */
/*$sql_tw = "SELECT * FROM hrm_attendance_time where `employee_id` = '".$_GET['emp_id']."' and attendance_date like '%".$_GET['pay_date']."%'";
$results_tw = mysqli_query($db_connection, $sql_tw);*/
$hrs_old_int1 = 0;
$Total = '';
$Trest = '';
$total_time_rs = '';
$hrs_old_int_res1 = '';
foreach ($result->result() as $hour_work){
	// total work			
	$clock_in =  new DateTime($hour_work->clock_in);
	$clock_out =  new DateTime($hour_work->clock_out);
	$interval_late = $clock_in->diff($clock_out);
	$hours_r  = $interval_late->format('%h');
	$minutes_r = $interval_late->format('%i');			
	$total_time = $hours_r .":".$minutes_r.":".'00';
	
	$str_time = $total_time;

	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
	
	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
	
	$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
	
	$hrs_old_int1 += $hrs_old_seconds;
	
	$Total = gmdate("H", $hrs_old_int1);			
}

?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><strong><?php echo $this->lang->line('xin_payment_for');?></strong> <?php echo $p_month;?></h4>
</div>
<div class="modal-body">
<?php $attributes = array('name' => 'pay_hourly', 'id' => 'pay_hourly', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'ADD');?>
<?php echo form_open('admin/payroll/add_pay_hourly/', $attributes, $hidden);?>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payroll_hourly_rate');?></label>
          <input type="text" name="hourly_rate" class="form-control" value="<?php echo $hourly_rate;?>" readonly>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <input type="hidden" id="emp_id" name="emp_id" value="<?php echo $user_id?>">
          <input type="hidden" value="<?php echo $user_id;?>" name="u_id">
          <input type="hidden" value="<?php echo $_GET['pay_date'];?>" name="pay_date" id="pay_date">
          <label for="name"><?php echo $this->lang->line('xin_total_hours_worked');?></label>
          <input type="text" name="total_hours_work" class="form-control" value="<?php echo $Total;?>" readonly>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <input type="hidden" name="department_id" value="<?php echo $department_id;?>" />
          <input type="hidden" name="company_id" value="<?php echo $company_id;?>" />
          <input type="hidden" name="designation_id" value="<?php echo $designation_id;?>" />
          <label for="name"><?php echo $this->lang->line('xin_payroll_payment_amount');?></label>
          <input type="text" name="payment_amount" class="form-control" value="<?php echo (int)$Total * (int)$hourly_rate;?>" readonly>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="payment_method"><?php echo $this->lang->line('xin_payment_method');?></label>
          <select name="payment_method" class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_payment_method');?>">
            <option value="">&nbsp;</option>
            <option value="1">Online</option>
            <option value="2">PayPal</option>
            <option value="3">Payoneer</option>
            <option value="4">Bank Transfer</option>
            <option value="5">Cheque</option>
            <option value="6">Cash</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="name"><?php echo $this->lang->line('xin_payment_comment');?></label>
          <input type="text" class="form-control" name="comments">
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_pay');?></button>
  <?php echo form_close(); ?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
		
	$("#pay_hourly").submit(function(e){
	
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=12&data=hourly&add_type=pay_hourly&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					$('.emo_hourly_pay').modal('toggle');
					// On page load: datatable
					var xin_table = $('#xin_table').dataTable({
						"bDestroy": true,
						"ajax": {
							url : "<?php echo site_url("admin/payroll/payslip_list") ?>?employee_id=0&company_id=<?php echo $company_id;?>&month_year=<?php echo $this->input->get('pay_date');?>",
							type : 'GET'
						},
						"fnDrawCallback": function(settings){
						$('[data-toggle="tooltip"]').tooltip();          
						}
					});
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});	
</script>
<?php }
?>
