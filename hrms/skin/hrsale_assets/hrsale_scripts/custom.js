$(document).ready(function(){
	
	$('[data-toggle-tooltip="tooltip"]').tooltip();
	
	jQuery("#layout_skin_info").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = jQuery(this), action = obj.attr('name');
		jQuery('.save').prop('disabled', true);
		jQuery.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=27&data=layout_skin_info&type=layout_skin_info&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					jQuery('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					jQuery('.save').prop('disabled', false);
				}
			}
		});
	});
	
	
	$('.policy').on('show.bs.modal', function (event) {
	$.ajax({
		url: site_url+'settings/policy_read/',
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=policy&type=policy&p=1',
		success: function (response) {
			if(response) {
				$("#policy_modal").html(response);
			}
		}
		});
	});
	
jQuery("#sidebar_setting_info").submit(function(e){
/*Form Submit*/
e.preventDefault();
	var obj = jQuery(this), action = obj.attr('name');
	jQuery('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	if($('#enable_attendance').is(':checked')){
		var enable_attendance = $("#enable_attendance").val();
	} else {
		var enable_attendance = '';
	}
	if($('#enable_job').is(':checked')){
		var enable_job = $("#enable_job").val();
	} else {
		var enable_job = '';
	}
	if($('#enable_profile_background').is(':checked')){
		var enable_profile_background = $("#enable_profile_background").val();
	} else {
		var enable_profile_background = '';
	}
	if($('#role_email_notification').is(':checked')){
		var role_email_notification = $("#role_email_notification").val();
	} else {
		var role_email_notification = '';
	}
	if($('#close_btn').is(':checked')){
		var close_btn = $("#close_btn").val();
	} else {
		var close_btn = '';
	}
	if($('#notification_bar').is(':checked')){
		var notification_bar = $("#notification_bar").val();
	} else {
		var notification_bar = '';
	}
	if($('#role_policy_link').is(':checked')){
		var role_policy_link = $("#role_policy_link").val();
	} else {
		var role_policy_link = '';
	}
	if($('#enable_layout').is(':checked')){
		var enable_layout = $("#enable_layout").val();
	} else {
		var enable_layout = '';
	}
	jQuery.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=4&data=other_settings&type=other_settings&form="+action+'&enable_attendance='+enable_attendance+'&enable_job='+enable_job+'&enable_profile_background='+enable_profile_background+'&close_btn='+close_btn+'&notification_bar='+notification_bar+'&role_policy_link='+role_policy_link+'&enable_layout='+enable_layout+'&role_email_notification='+role_email_notification,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				jQuery('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
			} else {
				toastr.success(JSON.result);
				jQuery('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
			}
		}
	});
});
});