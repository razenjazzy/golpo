$(document).ready(function(){
	
	/* Clock In */
	$("#set_clocking").submit(function(e){
		
		e.preventDefault();
		var clock_state = '';
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&type=set_clocking&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
				} else {
					toastr.success(JSON.result);
					window.location = '';
				}
			}
		});
	});
});