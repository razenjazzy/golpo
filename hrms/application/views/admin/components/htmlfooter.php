<?php $session = $this->session->userdata('username'); ?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php $this->load->view('admin/components/vendors/del_dialog');?>

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
<?php if($this->router->fetch_class() =='reports'){?>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/tables/datatable/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/tables/datatable/buttons.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/tables/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/tables/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/tables/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/tables/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/tables/buttons.print.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/tables/buttons.colVis.min.js" type="text/javascript"></script>
<?php } ?>
<?php if($this->router->fetch_class() =='dashboard'){?>
<script type="text/javascript" src="<?php echo base_url('skin/hrsale_assets/hrsale_scripts/user/set_clocking.js'); ?>"></script>
<?php } ?>
<?php if($this->router->fetch_class() =='settings'){?>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<?php }?>
<?php if($this->router->fetch_class() =='goal_tracking' || $this->router->fetch_method() =='task_details' || $this->router->fetch_class() =='project' || $this->router->fetch_method() =='project_details'){?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<?php }?>
<?php if($this->router->fetch_class() =='chat'){?>
<script src="<?php echo base_url();?>skin/hrsale_assets/js/pages_chat.js"></script>
<?php }?>
<?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='dashboard'){?>
	<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/moment/moment.js"></script>
	<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
	<?php if($user[0]->user_role_id==1): ?>
		<?php $this->load->view('admin/components/vendors/full_calendar');?>
    <?php else:?>
    	<?php $this->load->view('admin/components/vendors/half_calendar');?>
    <?php endif; ?>
	
<?php }?>

<script type="text/javascript">var user_role = '<?php //echo $user[0]->user_role_id;?>';</script>
<script type="text/javascript">var js_date_format = '<?php echo $this->Xin_model->set_date_format_js();?>';</script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>admin/';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().'admin/'.$this->router->fetch_class(); ?>';</script>
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
function escapeHtmlSecure(str)
{
	var map =
	{
		'alert': '&lt;',
		'313': '&lt;',
		'bzps': '&lt;',
		'<': '&lt;',
		'>': '&gt;',
		'script': '&lt;',
		'html': '&lt;',
		'php': '&lt;',
	};
	return str.replace(/[<>]/g, function(m) {return map[m];});
}	
</script>
<script type="text/javascript">
$(document).ready(function(){
	/*  Toggle Starts   */
	//$('.js-switch:checkbox').checkboxpicker();
	$('.date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1900:' + (new Date().getFullYear() + 15),
	beforeShow: function(input) {
		$(input).datepicker("widget").show();
	}
	});
});
</script>
<?php if($system[0]->module_chat_box=='true'){?>
 <script type="text/javascript">
 $(document).ready(function(){
   setTimeout(refreshChatMsgs, 5000);
});
function refreshChatMsgs() {
	  $.ajax({
		url: site_url + "chat/refresh_chat_users_msg/",
		type: 'GET',
		dataType: 'html',
		success: function(data) {
			setTimeout(refreshChatMsgs, 5000);
		  	jQuery('#msgs_count').html(data);
		},
		error: function() {
		  
		}
	  });
}
</script>
<?php } ?>
<?php if($this->router->fetch_class() =='roles') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/kendo/kendo.all.min.js"></script>
<?php $this->load->view('admin/roles/role_values');?>
<?php } ?>
<?php if($this->router->fetch_class() =='employees' && $this->router->fetch_method() =='hr') { ?>
<script src="<?php echo base_url();?>skin/hrsale_assets/js/pages_contacts.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo base_url().'skin/hrsale_assets/hrsale_scripts/'.$path_url.'.js'; ?>"></script>
<?php if($this->router->fetch_class() =='organization'){?>
<?php $this->load->view('admin/components/vendors/organization_chart');?>
<?php } ?>
<?php if($this->router->fetch_class() =='goal_tracking'  || $this->router->fetch_method() =='task_details' || $this->router->fetch_method() =='project_details'){?>
<script type="text/javascript">
$(document).ready(function(){	
	$("#range_grid").ionRangeSlider({
		type: "single",
		min: 0,
		max: 100,
		from: '<?php echo $progress;?>',
		grid: true,
		force_edges: true,
		onChange: function (data) {
			$('#progres_val').val(data.from);
		}
	});
});
</script>
<?php } ?>
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
<?php if($this->router->fetch_class() =='invoices' && ($this->router->fetch_method() =='create' || $this->router->fetch_method() =='edit')) { ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#add-invoice-item').click(function () {
        var invoice_items = '<div class="row item-row">'
					+'<hr>'
					+'<div class="form-group mb-1 col-sm-12 col-md-3">'
					+'<label for="item_name">Item</label>'
					+'<br>'
					+'<input type="text" class="form-control item_name" name="item_name[]" id="item_name" placeholder="Item Name">'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="tax_type">Tax Type</label>'
					+'<br>'
					+'<select class="form-control tax_type" name="tax_type[]" id="tax_type">'
					<?php foreach($all_taxes as $_tax){?>
					<?php
						if($_tax->type=='percentage') {
							$_tax_type = $_tax->rate.'%';
						} else {
							$_tax_type = $this->Xin_model->currency_sign($_tax->rate);
						}
					?>
					+'<option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>"> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>'
					<?php } ?>
				  	+'</select>'
					+'</div>' 
					+'<div class="form-group mb-1 col-sm-12 col-md-1">'
					+'<label for="tax_type">Tax Rate</label>'
					+'<br>'
					+'<input type="text" readonly="readonly" class="form-control tax-rate-item" name="tax_rate_item[]" value="0" />'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-1">'
					+'<label for="qty_hrs" class="cursor-pointer">Qty/Hrs</label>'
					+'<br>'
					+'<input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">'
					+'</div>'
					+'<div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="unit_price">Unit Price</label>'
					+'<br>'
					+'<input class="form-control unit_price" type="text" name="unit_price[]" value="0" id="unit_price" />'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="profession">Subtotal</label>'
					+'<input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />'
					+'<p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>'
					+'</div>'
					+'<div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">'
					+'<label for="profession">&nbsp;</label><br><button type="button" class="btn icon-btn btn-xs btn-outline-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="far fa-trash-alt"></span></button>'
					+'</div>'
				  	+'</div>'

        $('#item-list').append(invoice_items).fadeIn(500);

    });
});	

</script>
<?php } ?>