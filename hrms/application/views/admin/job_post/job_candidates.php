<?php
/* Job Candidates view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_job_candidates');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_e_details_jtitle');?></th>
          <th><?php echo $this->lang->line('xin_candidate_name');?></th>
          <th><?php echo $this->lang->line('dashboard_email');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
          <th><?php echo $this->lang->line('xin_apply_date');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
