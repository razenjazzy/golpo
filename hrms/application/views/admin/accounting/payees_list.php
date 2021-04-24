<?php
/*
* Payees - Accounting View
*/
$session = $this->session->userdata('username');
?>

<div class="row m-b-1 animated fadeInRight">
  <div class="col-md-4">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_acc_payee');?> </h6>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_payee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/accounting/add_payee', $attributes, $hidden);?>
        <div class="form-group">
          <label for="account_name"><?php echo $this->lang->line('xin_acc_payee');?></label>
          <input type="text" class="form-control" name="payee_name" placeholder="<?php echo $this->lang->line('xin_acc_payee_name');?>">
        </div>
        <div class="form-group">
          <label for="account_balance"><?php echo $this->lang->line('xin_contact_number');?></label>
          <input type="text" class="form-control" name="contact_number" placeholder="<?php echo $this->lang->line('xin_contact_number');?>">
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card">
      <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_acc_payees');?> </h6>
      <div class="card-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('xin_acc_payee');?></th>
              <th><?php echo $this->lang->line('xin_contact_number');?></th>
              <th><?php echo $this->lang->line('xin_acc_created_at');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
