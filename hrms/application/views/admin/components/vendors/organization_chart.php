<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/orgchart/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/orgchart/css/jquery.orgchart.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/orgchart/css/style.css">
<style type="text/css">
.orgchart {
	background: #fff;
}
#chart-container {
 <?php if($theme[0]->org_chart_layout=='t2b' || $theme[0]->org_chart_layout=='b2t'):?>  text-align: center !important;
 <?php elseif($theme[0]->org_chart_layout=='l2r'):?>  text-align: left !important;
 <?php elseif($theme[0]->org_chart_layout=='r2l'):?>  text-align: right !important;
 <?php endif;
?>
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/orgchart/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/orgchart/js/jquery.orgchart.js"></script>
<?php $department = $this->Department_model->get_departments();?>
<script type="text/javascript">
    $(function() {
    var datascource = {
      'name': '<?php echo $company[0]->company_name;?>',
      'title': '<?php echo $this->lang->line('xin_company_administrator');?>',
      'children': [
	  	<?php foreach($department->result() as $r): ?>
		<?php // get user > head
		$head_user = $this->Xin_model->read_user_info($r->employee_id);
		// user full name
		if(!is_null($head_user)){
			$dep_head = $head_user[0]->first_name.' '.$head_user[0]->last_name;
		} else {
			$dep_head = '--';	
		} ?>
		{ 'name': '<?php echo $dep_head;?>', 'title': '<?php echo $r->department_name;?>',
		<?php $dep_des = $this->Xin_model->read_dep_designations($r->department_id);?>
		'children': [
			<?php foreach($dep_des as $des_name): ?>
				<?php $duser = $this->Xin_model->read_designation_employees($des_name->designation_id); ?>
				<?php foreach($duser as $desd): ?>
				<?php $result = $this->Designation_model->read_designation_information($desd->designation_id);?>
				<?php $des_head = $desd->first_name.' '.$desd->last_name;?>
				{ 'name': '<?php echo $des_head;?>', 'title': '<?php echo $result[0]->designation_name;?>'},
				<?php endforeach;
				 endforeach; ?>
			]
		},
		<?php endforeach;?>
	  ]
    };

    $('#chart-container').orgchart({
      'data' : datascource,
      'visibleLevel': 4,
      'nodeContent': 'title',
      'exportButton': <?php echo $theme[0]->export_orgchart;?>,
      'exportFilename': '<?php echo $theme[0]->export_file_title;?>',
	  'pan': <?php echo $theme[0]->org_chart_pan;?>,
      'zoom': <?php echo $theme[0]->org_chart_zoom;?>,
      'direction': '<?php echo $theme[0]->org_chart_layout;?>'
    });

  });
  </script>
