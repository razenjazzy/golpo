$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+'/transfer_list/',
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 
	
	$('#description').trumbowyg();
	
	/* Delete data */
	$("#delete_record").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=2&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					$('.delete-modal').modal('toggle');
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);	
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);						
				}
			}
		});
	});
	
	// edit
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var transfer_id = button.data('transfer_id');
		var modal = $(this);
	$.ajax({
		url :  base_url+"/read_transfer/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=transfer&transfer_id='+transfer_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
	
	$(".from-account").change(function(){
		var ac_balance = $(this).find('option:selected').attr('account-balance');
		$('#acc_balance').html(' Available Balance: '+ac_balance);
		$('#account_balance').val(ac_balance);
		$('#acc_balance').show();
	});
			
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=transfer&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.save').prop('disabled', false);
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
					$('.add-form').removeClass('show');
					$('#xin-form')[0].reset(); // To reset form fields
					$('#acc_balance').html('');
					$('#acc_balance').hide();
					$('.save').prop('disabled', false);
				}
			}
		});
	});

/* Add data */ /*Form Submit*/
//	$("#xin-form").submit(function(e){});
});
$( document ).on( "click", ".delete", function() {
	$('input[name=_token]').val($(this).data('record-id'));
	$('#delete_record').attr('action',base_url+'/delete_transfer/'+$(this).data('record-id'));
});