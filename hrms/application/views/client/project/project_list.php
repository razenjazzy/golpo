<?php
/* Project list
*/
?>
<?php $session = $this->session->userdata('client_username');?>

<div class="row">
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-logo-buffer display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_not_started');?></div>
            <div class="text-large"><?php echo $this->Project_model->not_started_client_projects($session['client_id']); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-logo-buffer display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_in_progress');?></div>
            <div class="text-large"><?php echo $this->Project_model->inprogress_client_projects($session['client_id']);?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-logo-buffer display-4 text-danger"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_completed');?></div>
            <div class="text-large"><?php echo $this->Project_model->complete_client_projects($session['client_id']); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-logo-buffer display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_deffered');?></div>
            <div class="text-large"><?php echo $this->Project_model->deffered_client_projects($session['client_id']); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_projects');?> </h6>
  <div class="card-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_project_summary');?></th>
          <th><?php echo $this->lang->line('xin_p_priority');?></th>
          <th><?php echo $this->lang->line('xin_p_enddate');?></th>
          <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
          <th><?php echo $this->lang->line('xin_project_users');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
