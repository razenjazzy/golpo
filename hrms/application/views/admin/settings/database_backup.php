<?php
/* Database Backup Log view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_backup_log');?></span>
    <div class="card-header-elements ml-md-auto"> <span class="badge">
      <?php $attributes = array('name' => 'del_backup', 'id' => 'del_backup', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/settings/delete_db_backup', $attributes, $hidden);?>
      <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_delete_old_backup');?></button>
      <?php echo form_close(); ?></span> <span class="badge">
      <?php $attributes = array('name' => 'db_backup', 'id' => 'db_backup', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/settings/create_database_backup', $attributes, $hidden);?>
      <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_create_backup');?></button>
      <?php echo form_close(); ?></span> </div>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_database_file');?></th>
          <th><?php echo $this->lang->line('xin_e_details_date');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
