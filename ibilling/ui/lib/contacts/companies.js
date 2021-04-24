$(function() {

    var _url = $("#_url").val();

    $.fn.modal.defaults.width = '700px';

    var $modal = $('#ajax-modal');

    $('[data-toggle="tooltip"]').tooltip();

    $('.add_company').on('click', function(e){

        e.preventDefault();

        $('body').modalmanager('loading');

        $modal.load( _url + 'contacts/modal_add_company/', '', function(){

            $modal.modal();

        });
    });


    $modal.on('click', '.modal_submit', function(e){

        e.preventDefault();

        $modal.modal('loading');

        $.post( _url + "contacts/add_company_post/", $("#ib_modal_form").serialize())
            .done(function( data ) {

                if ($.isNumeric(data)) {

                    location.reload();

                }

                else {
                    $modal.modal('loading');
                    toastr.error(data);
                }

            });

    });


    $(".cdelete").click(function (e) {
        e.preventDefault();
        var id = this.id;
        bootbox.confirm(_L['are_you_sure'], function(result) {
            if(result){
                var _url = $("#_url").val();
                window.location.href = _url + "delete/company/" + id + '/';
            }
        });
    });


    $(".cedit").click(function (e) {
        e.preventDefault();
        var id = this.id;

        $('body').modalmanager('loading');

        $modal.load( _url + 'contacts/modal_add_company/'+ id + '/', '', function(){

            $modal.modal();

        });

    });




});