<?php
/* Accounting > Transfer Report view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card mb-4">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_acc_transfer_report');?> </h6>
  <div class="card-body">
    <?php $attributes = array('name' => 'report_accounting', 'id' => 'hrm-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('re_user_id' => $session['user_id']);?>
    <?php echo form_open('admin/accounting/report_accounting', $attributes, $hidden);?>
    <?php
				$data = array(
				  'name'        => 'user_id',
				  'id'          => 'user_id',
				  'type'        => 'hidden',
				  'value' => $session['user_id'],
				  'class'       => 'form-control',
				);
			
			echo form_input($data);
			?>
    <!--<form class="add form-hrm report-params" method="post" name="report_accounting" id="hrm-form" action="report_accounting">-->
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $session['user_id'];?>">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_frm_date');?>" readonly id="from_date" name="from_date" type="text" value="<?php echo date('Y-m-d')?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_to_date');?>" readonly id="to_date" name="to_date" type="text" value="<?php echo date('Y-m-d')?>">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_get');?></button>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_acc_transfer_report');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
          <th><?php echo $this->lang->line('xin_acc_from_account');?></th>
          <th><?php echo $this->lang->line('xin_acc_to_account');?></th>
          <th><?php echo $this->lang->line('xin_acc_ref_no');?></th>
          <th><?php echo $this->lang->line('xin_acc_payment');?></th>
          <th><?php echo $this->lang->line('xin_amount');?></th>
        </tr>
      </thead>
      <tfoot id="get_footer">
      </tfoot>
    </table>
  </div>
</div>
