<?php 
$session = $this->session->userdata('client_username');
$user_info = $this->Clients_model->read_client_info($session['client_id']);
?>

<h4 class="media align-items-center font-weight-bold py-3 mb-4">
  <?php  if($user_info[0]->client_profile!='' && $user_info[0]->client_profile!='no file') {?>
  <img src="<?php  echo base_url().'uploads/clients/'.$user_info[0]->client_profile;?>" alt="" class="ui-w-50 rounded-circle">
  <?php } else {?>
  <?php  if($user_info[0]->gender=='Male') { ?>
  <?php 	$de_file = base_url().'uploads/clients/default_male.jpg';?>
  <?php } else { ?>
  <?php 	$de_file = base_url().'uploads/clients/default_female.jpg';?>
  <?php } ?>
  <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="ui-w-50 rounded-circle">
  <?php  } ?>
  <!--<img src="<?php echo base_url();?>skin/hrsale_assets/img/avatars/1.png" alt="" class="ui-w-50 rounded-circle">-->
  <div class="media-body ml-3"> Welcome back, <?php echo $user_info[0]->name;?>!
    <div class="text-muted text-tiny mt-1"> <small class="font-weight-normal">Today is <?php echo date('l, j F Y');?></small> </div>
  </div>
</h4>
<hr class="container-m--x mt-0 mb-4">
<h6 class="font-weight-semibold mb-4"><?php echo $this->lang->line('dashboard_my_projects');?></h6>

<!-- Project progress -->
<?php foreach($this->Xin_model->last_five_client_projects($session['client_id']) as $_project) {?>
<?php
	if($_project->priority == 1) {
		$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_highest').'</span>';
	} else if($_project->priority ==2){
		$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_high').'</span>';
	} else if($_project->priority ==3){
		$priority = '<span class="badge badge-primary">'.$this->lang->line('xin_normal').'</span>';
	} else {
		$priority = '<span class="badge badge-success">'.$this->lang->line('xin_low').'</span>';
	}
	$pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($_project->end_date);
    ?>
<div class="card pb-4 mb-4">
  <div class="row no-gutters align-items-center">
    <div class="col-12 col-md-5 px-4 pt-4"> <a href="<?php echo site_url('admin/project/details/').$_project->project_id;?>" class="text-dark font-weight-semibold"><?php echo $_project->title;?></a> <br>
      <small class="text-muted"><?php echo $_project->summary;?></small> </div>
    <div class="col-4 col-md-2 text-muted small px-4 pt-4"> <?php echo $priority;?> </div>
    <div class="col-4 col-md-2 text-muted small px-4 pt-4"> <?php echo $pdate;?></div>
    <div class="col-4 col-md-3 px-4 pt-4">
      <div class="text-right text-muted small"><?php echo $_project->project_progress;?>%</div>
      <div class="progress" style="height: 6px;">
        <div class="progress-bar" style="width: <?php echo $_project->project_progress;?>%;"></div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card pb-4 mb-4">
  <div class="row no-gutters align-items-center">
    <div class="col-md-12"> 
      
      <!-- Sale stats -->
      <div class="card mb-4">
        <h6 class="card-header with-elements">
          <div class="card-header-title"><?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_invoices_title');?></div>
          <div class="card-header-elements ml-auto">
            <button type="button" class="btn btn-default btn-xs md-btn-flat" onclick="window.location='<?php echo site_url('client/invoices/');?>'"><?php echo $this->lang->line('xin_invoices_all');?></button>
          </div>
        </h6>
        <div class="table-responsive">
          <table class="table card-table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th>ID
                  <?php //echo $this->lang->line('xin_client_name');?></th>
                <th>Invoice#
                  <?php //echo $this->lang->line('xin_client_name');?></th>
                <th><?php echo $this->lang->line('xin_project');?></th>
                <th>Total
                  <?php //echo $this->lang->line('xin_email');?></th>
                <th>Invoice Date
                  <?php //echo $this->lang->line('xin_website');?></th>
                <th>Due Date
                  <?php //echo $this->lang->line('xin_city');?></th>
                <th>Status
                  <?php //echo $this->lang->line('xin_country');?></th>
              </tr>
            </thead>
            <tbody>
              <?php $client = $this->Invoices_model->get_invoices();?>
              <?php foreach($client->result() as $r) {?>
              <?php
			   // get country
				 $grand_total = $this->Xin_model->currency_sign($r->grand_total);
				  // get project
				  $project = $this->Project_model->read_project_information($r->project_id); 
				  if(!is_null($project)){
					$project_name = $project[0]->title;
					if($project[0]->client_id==$session['client_id']) {
				 
				  $invoice_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_date);
				  $invoice_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_due_date);
				  //invoice_number
				  $invoice_number = '<a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/">'.$r->invoice_number.'</a>';
				  ?>
              <tr>
                <td><?php echo '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';?></td>
                <td><?php echo $r->invoice_id;?></td>
                <td><?php echo $invoice_number;?></td>
                <td><?php echo $project_name;?></td>
                <td><?php echo $grand_total;?></td>
                <td><?php echo $invoice_date;?></td>
                <td><?php echo $invoice_due_date;?></td>
                <td><?php echo $this->lang->line('xin_payment_paid');?></td>
              </tr>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- / Sale stats --> 
    </div>
  </div>
</div>
