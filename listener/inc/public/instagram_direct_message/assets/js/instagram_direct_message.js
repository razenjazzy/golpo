"use strict";
function Instagram_direct_message(){
    var self= this;
    this.init= function(){

        self.call_load_more();

        if($(".instagram-direct-message").length > 0){

            if($(".ig-dm-select").length > 0){
                $('.ig-dm-select').vtdropdown();
                $(".instagram-direct-message .option-item").each(function(){
                    var that = $(this);
                    var url = that.data("url");
                    var ids = that.data("ids");

                    that.find("a").addClass("actionItem").attr("href", url).attr("data-content", "ig-dm-list").attr("data-result", "html").attr("data-type-message", "text").attr("data-history", url).attr("data-call-after", "Instagram_direct_message.empty('"+ids+"');");
                    that.removeClass("option-item");
                });
            }
        }
    };

    this.empty = function(account_id){
        var action         = PATH+"instagram_direct_message/index/"+account_id+"/null";
        var data           = $.param({token:token});

        $.post(action, data, function(result){
            $(".column-two").html(result);
        });
    };

    this.chatbox = function(account_id, thread_id){
       var  h = $(window).height();
        $(".chatbox").height(h - 121); 
        $(".cb-body").css({"max-height": h - 121 - 70 - 70});

        $(window).resize(function(){
            h = $(window).height();
            $(".chatbox").height(h - 121); 
            $(".cb-body").css({"max-height": h - 121 - 70 - 70});
        });

        setTimeout(function(){
            $('.cb-body').scrollTop($('.cb-body').height());
            $('.cb-body').niceScroll({cursorcolor:"#ddd", cursorwidth: "10px"});

            //Emoji texterea
            if($('.input-message').length > 0){
                var el = $(".input-message").emojioneArea({
                    hideSource: true,
                    useSprite: false,
                    pickerPosition    : "top",
                    filtersPosition   : "top",
                });

                setTimeout(function(){
                    $(".emojionearea-editor").niceScroll({cursorcolor:"#ddd"});
                }, 1000);
            }

        }, 1000);

        $(document).on('submit', ".actionFormInbox", function(event) {
            event.preventDefault();    
            var that           = $(this);
            var action         = that.attr("action");
            var data           = that.serialize();
            var data           = data + '&' + $.param({token:token});
            
            Core.ajax_post(that, action, data, function(result){
                $(".input-message").data("emojioneArea").setText("");


                if(result.status == "success"){

                    if(result.url != undefined){
                        location.assign(result.url);
                        return false;
                    }
                    
                    var img = '<img src="'+result.avatar+'">';
                    var message = '<div class="cb-item right '+result.id+'"><a href="'+result.remove+'" class="cb-remove actionItem"><i class="ft-trash"></i></a><div class="avatar">' + img + '</div><div class="message">' + result.caption + '<div class="time">'+result.time+'</div></div></div><div class="clearfix"></div>';
                    $(".cb-wrap-body").append(message);
                    $('.cb-body').getNiceScroll().resize();
                    setTimeout(function(){
                        $('.cb-body').scrollTop($('.cb-wrap-body').height());
                    }, 50);
                }
            });
        });

        setInterval(function(){
            var media = $("#ig_send_media").val();
            if(media != "" && media != undefined){
                $("#ig_send_media").val("");
                var data = $.param({token:token, photo: media});

                var that           = $("body");
                var action         = PATH+"instagram_direct_message/send/"+account_id+"/"+thread_id;
                var userid         = $(".cb-load-id").val();
                var data           = $.param({token:token, media: media, userid: userid});
                Core.ajax_post(that, action, data, function(result){
                    if(result.status == "success"){

                        if(result.url != undefined){
                            location.assign(result.url);
                            return false;
                        }

                        var img = '<img src="'+result.avatar+'">';

                        if(result.type == "photo"){
                            var message = '<div class="cb-item right '+result.id+'"><a href="'+result.remove+'" class="cb-remove actionItem"><i class="ft-trash"></i></a><div class="avatar">' + img + '</div><div class="media"><img src="' + result.file + '"/><div class="time">'+result.time+'</div></div></div><div class="clearfix"></div>';
                        }else{
                            var message = '<div class="cb-item right '+result.id+'"><a href="'+result.remove+'" class="cb-remove actionItem"><i class="ft-trash"></i></a><div class="avatar">' + img + '</div><div class="media"><video controls width="100%" height="auto"><source src="' +  result.file + '" type="video/mp4"></video><div class="time">'+result.time+'</div></div></div><div class="clearfix"></div>';
                        }

                        $(".cb-wrap-body").append(message);
                        $('.cb-body').getNiceScroll().resize();
                        setTimeout(function(){
                            $('.cb-body').scrollTop($('.cb-wrap-body').height());
                        }, 50);
                    }
                });
                return false;
            }
        }, 1000);

        var loading = 0;
        var wbh = $(".cb-wrap-body").height();
        $(".cb-body").scroll(function() {
            if($(".cb-body").scrollTop() == 0) {
                if(loading == 0){
                    loading = 1;
                    var cursor = $('.cb-body').attr("data-cursor");
                    if(cursor != ""){
                        var data = $.param({token:token, id: cursor});
                        $(".cb-loading").show();
                        $.post(PATH+"instagram_direct_message/get_thread/"+account_id+"/"+thread_id, data, function(result){
                            setTimeout(function(){
                                var wbh_now = $(".cb-wrap-body").height();
                                $('.cb-body').scrollTop(wbh_now - wbh);
                                wbh = wbh_now;
                            }, 2);
                            $(".cb-loading").hide();
                            $(".cb-item:first-child").before(result);
                            loading = 0;
                        });
                        return false;
                    }
                }
            }
        });

        $(document).on('submit', ".FromCBSearch", function(event) {
            var q = $(".cb-search-user").val();
            var that           = $(this);
            var action         = $(this).attr("action");
            var data           = $.param({token:token, q: q});
            if(q != ""){
                Core.ajax_post(that, action, data, function(result){});
            }
            return false;
        });

        $(document).on("click", ".cb-add-user-result .item", function(){
            var id = $(this).data("id");
            var username = $(this).data("username");
            var avatar = $(this).data("avatar");
            $(".cb-load-id").val(id);
            $(".cb-load-username").html(username);
            $(".cb-load-avatar").attr("src", avatar);
            $(".cb-add-user").hide();
        });

        $(document).on("click", ".cb-load-remove", function(){
            $(".cb-load-id").val("");
            $(".cb-load-username").html("{username}");
            $(".cb-load-avatar").attr("src", "");
            $(".cb-add-user").show();
        });
    };

    this.call_load_more = function(){
        var that = $('.instagram-direct-message .column-one');
        var scrollDiv = that;

        if ( that.length > 0 )
        {
            $(scrollDiv).bind('scroll',function(){

                var _scrollPadding = 80;
                var _scrollTop = $(scrollDiv).scrollTop();
                var _divHeight = $(scrollDiv).height();
                var _scrollHeight = $(scrollDiv).get(0).scrollHeight;

                $(window).trigger('resize'); 
                if( _scrollTop + _divHeight + _scrollPadding >= _scrollHeight) {
                    self.ajax_load();
                }

            });
        }
    };

    this.ajax_load = function(page){
        var that = $('.instagram-direct-message .column-one');
        var list = that.find(".ig-dm-list");
        var data = that.find(".ig-dm-list .widget-item").last();
        var account = data.data("account");
        var cursor = data.data("cursor");
        
        if(account == undefined){
            return false;
        }

        if(cursor == undefined){
            return "";
        }

        if(page != undefined){
            that.attr('data-loading', 0);
        }

        if ( that.length > 0 )
        {
            var action = self.path() + 'inbox/' + account;
            var type = that.data('type');
            var loading = that.attr('data-loading');
            var data = { token: token, cursor: cursor };
            var scrollDiv = that.data('scroll');

            if ( loading == undefined || loading == 0 )
            {
                that.attr('data-loading', 1);

                $.ajax({
                    url: action,
                    type: 'POST',
                    dataType: 'html',
                    data: data
                }).done(function(result) {
                    list.append( result );

                    if(result != ''){
                        that.attr('data-loading', 0);
                    }

                    $(".nicescroll").getNiceScroll().resize();
                });
            }
        }
    };

    this.path = function(){
        return PATH+'instagram_direct_message/';
    };
}

Instagram_direct_message= new Instagram_direct_message();
$(function(){
    Instagram_direct_message.init();
});
