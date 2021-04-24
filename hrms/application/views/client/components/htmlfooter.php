<?php $session = $this->session->userdata('client_username'); ?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $user = $this->Clients_model->read_client_info($session['client_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php //$this->load->view('client/components/vendors/del_dialog');?>
<!-- Vendor JS -->
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/popper/popper.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/sidenav.js"></script>

<!-- Libs -->
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/datatables/datatables.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/Trumbowyg/dist/trumbowyg.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/clockpicker/dist/jquery-clockpicker.min.js"></script>

<script src="<?php echo base_url();?>skin/hrsale_assets/js/demo.js"></script>

<script type="text/javascript">var user_role = '<?php //echo $user[0]->user_role_id;?>';</script>
<script type="text/javascript">var js_date_format = '<?php echo $this->Xin_model->set_date_format_js();?>';</script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>client/';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().'client/'.$this->router->fetch_class(); ?>';</script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.js"></script>
<?php //if($this->router->fetch_class() !='dashboard'){?>
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.showMethod = 'slideDown';
	toastr.options.hideMethod = 'slideUp';
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
   // setTimeout(refreshChatMsgs, 5000);
   $('[data-toggle="popover"]').popover();
});
</script>
<script type="text/javascript" src="<?php echo base_url().'skin/hrsale_assets/hrsale_scripts/'.$path_url.'.js'; ?>"></script>
<?php if($this->router->fetch_class() =='invoices' && $this->router->fetch_method() =='view') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/printThis.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.print-invoice').click(function () {
		$("#print_invoice_hr").printThis();
	});	
});
</script>
<?php } ?>
</body>
</html>