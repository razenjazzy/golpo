"use strict";
function Instagram_activity(){
    var self= this;
    this.init= function(){
        if($(".instagram-activity").length > 0){
            self.action();
            self.comment();
            self.direct();
            self.tag();
            self.location();
            self.username();
            self.blacklist_tag();
            self.blacklist_username();
            self.blacklist_keyword();
            self.schedule();
            self.speed();
            self.log();
            self.stats();
            self.profile();
            self.tooltip();
        }
    };

    this.action = function(){

        //Hide Tab
        self.tab();
        $(document).on("change", ".ig-ac-main .tasks .item-task input", function(){
            self.tab();
        });
        
        //Save action
        $(document).on("change", ".action-save", function(){
            self.save_activity();
        });

        $(document).on("click", ".click-action-save", function(){
            self.save_activity();
        });

        $(document).on("click", ".ig-ac-btn-start", function(e){ 
            e.preventDefault();

            var that = $(this);
            var action = that.attr("href");
            var data = { token: token }; 
            Core.ajax_post(that, action, data, function(result){
                if(result.status == "success"){
                    that.addClass("d-none");
                    $(".ig-ac-btn-stop").removeClass("d-none");
                    that.parents(".ig-ac-basic-info").find(".ig-ac-status").addClass("d-none");
                    that.parents(".ig-ac-basic-info").find(".ig-ac-status.started").removeClass("d-none");

                    that.parents(".ig-ac-main").find(".ig-ac-status").addClass("d-none");
                    that.parents(".ig-ac-main").find(".ig-ac-status.started").removeClass("d-none");
                }
            });

            return false;
        });
        
        $(document).on("click", ".ig-ac-btn-stop", function(e){ 
            e.preventDefault();

            var that = $(this);
            var action = that.attr("href");
            var data = { token: token }; 
            Core.ajax_post(that, action, data, function(result){
                if(result.status == "success"){
                    that.addClass("d-none");
                    $(".ig-ac-btn-start").removeClass("d-none");
                    that.parents(".ig-ac-basic-info").find(".ig-ac-status").addClass("d-none");
                    that.parents(".ig-ac-basic-info").find(".ig-ac-status.stopped").removeClass("d-none");

                    that.parents(".ig-ac-main").find(".ig-ac-status").addClass("d-none");
                    that.parents(".ig-ac-main").find(".ig-ac-status.stopped").removeClass("d-none");
                }
            });

            return false;
        });

        $(document).on("change", ".activityFilterAction", function(){
            _that = $(this);
            _that.parents("form").submit();
        });
    };

    this.tooltip = function(){
        $('[data-toggle="tooltip-custom"]').tooltip({
            template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner text-left"></div></div>'
        });
        $('[data-toggle="tooltip-custom"]').on('click', function () {
            $(this).tooltip('hide')
        });
    };

    this.tab = function(){
        $(".ig-ac-options .ig-ac-tab a").each(function(){
            var tab = $(this);
            var tab_type = tab.data("type");
            if(tab_type != undefined){
                tab.addClass("d-none");
            }
        });

        $(".ig-ac-main .tasks .item-task").each(function(){
            var that = $(this);
            var type = that.find("input:checked").data("type");
            if(type != undefined){
                $(".ig-ac-options .ig-ac-tab a[data-type="+type+"]").removeClass("d-none");
            }
        });
    };

    this.comment = function(){

        $(document).on("click", ".btn-add-comment", function(){
            var that = $(this);
            var content = $(".form-add-comment").val();
            var html = '<div><div class="ig-ac-option-item-comment"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> '+self.nl2br(content)+'<textarea class="d-none" name="comments[]">'+content+'</textarea></div></div>';
            if(content != ""){
                $(".list-add-comment").append(html);
                $(".list-add-comment .empty").remove();
                self.save_activity();
            }
        });

        $(document).on("click", ".ig-ac-option-item-comment .remove", function(){
            $(this).parent().remove();
            if($(".ig-ac-option-item-comment").length == 0){
                $(".list-add-comment").append('<div class="empty small"></div>');
            }
            self.save_activity();
        });

        $(document).on("click", ".list-add-comment .remove-all", function(){
            $(".ig-ac-option-item-comment").remove();
            $(".list-add-comment").append('<div class="empty small"></div>');
            self.save_activity();
        });

    };

    this.direct = function(){

        $(document).on("click", ".btn-add-direct", function(){
            var that = $(this);
            var content = $(".form-add-direct").val();
            var html = '<div><div class="ig-ac-option-item-direct"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> '+self.nl2br(content)+'<textarea class="d-none" name="directs[]">'+content+'</textarea></div></div>';
            if(content != ""){
                $(".list-add-direct").append(html);
                $(".list-add-direct .empty").remove();
                self.save_activity();
            }
        });

        $(document).on("click", ".ig-ac-option-item-direct .remove", function(){
            $(this).parent().remove();
            if($(".ig-ac-option-item-direct").length == 0){
                $(".list-add-direct").append('<div class="empty small"></div>');
            }
            self.save_activity();
        });

        $(document).on("click", ".list-add-direct .remove-all", function(){
            $(".ig-ac-option-item-direct").remove();
            $(".list-add-direct").append('<div class="empty small"></div>');
            self.save_activity();
        });
        
    };

    this.tag = function(){
        $(".form-search-tag").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();

                var that = $(this);
                var keyword = that.val();
                var action = that.data("action");
                var data = { token: token, keyword: keyword }; 
                Core.ajax_post(that, action, data, function(result){

                });

                return false;
            }
        });

        $(document).on("click", ".btn-add-tag", function(result){
            $(".result-search-tag input:checked").each(function(){
                var val = $(this).val();
                var html = '<div class="ig-ac-option-item-tag"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/explore/tags/'+val+'" target="_blank">'+val+'</a><input type="hidden" name="tags[]" value="'+val+'"></div>';
                if(val != ""){
                    $(this).parents(".ig-ac-option-item-list").remove();

                    var check = false;
                    $("[name='tags[]']").each(function(){
                        var val_exist = $(this).val();
                        if(val_exist == val){
                            check = true;
                        }
                    });

                    if(!check){
                        $(".list-add-tag").append(html);
                        $(".list-add-tag .empty").remove();
                    }
                }
            });
            
            self.save_activity();
        });

        $(document).on("click", ".btn-add-tag-list", function(result){
            var that = $(this);
            var content = $(".form-add-tag-list").val();
            var lines = content.split('\n');
            if(lines.length > 0){

                for(var i = 0;i < lines.length ; i++){
                    if(lines[i] != "" && lines[i].indexOf(' ') == -1){
                        var val = lines[i];
                        var check = false;
                        $("[name='tags[]']").each(function(){
                            var val_exist = $(this).val();
                            if(val_exist == val){
                                check = true;
                            }
                        });

                        if(!check){
                            var html = '<div class="ig-ac-option-item-tag"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/explore/tags/'+val+'" target="_blank">'+val+'</a><input type="hidden" name="tags[]" value="'+val+'"></div>';
                            $(".list-add-tag").append(html);
                            $(".list-add-tag .empty").remove();
                            $(".form-add-tag-list").val("");
                        }
                    }
                }
                self.save_activity();
            
            }
        });

        $(document).on("click", ".ig-ac-option-item-tag .remove", function(){
            $(this).parent().remove();
            if($(".ig-ac-option-item-tag").length == 0){
                $(".list-add-tag").append('<div class="empty small"></div>');
            }
            self.save_activity();
        });

        $(document).on("click", ".list-add-tag .remove-all", function(){
            $(this).parents(".list-add-tag").find(".ig-ac-option-item-tag").remove();
            $(".list-add-tag").append('<div class="empty small"></div>');
            self.save_activity();
        });
    };

    this.location = function(){
        $(".form-search-location").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();

                var that = $(this);
                var keyword = that.val();
                var action = that.data("action");
                var data = { token: token, keyword: keyword }; 
                Core.ajax_post(that, action, data, function(result){

                });

                return false;
            }
        });

        $(document).on("click", ".btn-add-location", function(result){
            $(".result-search-location input:checked").each(function(){
                var val = $(this).val();
                var val_params = val.split("|");

                var html = '<div class="ig-ac-option-item-location"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/explore/locations/'+val_params[1]+'" target="_blank">'+val_params[0]+'</a><input type="hidden" name="locations[]" value="'+val+'"></div>';
                if(val != ""){
                    $(this).parents(".ig-ac-option-item-list").remove();

                    var check = false;
                    $("[name='locations[]']").each(function(){
                        var val_exist = $(this).val();
                        if(val_exist == val){
                            check = true;
                        }
                    });

                    if(!check){
                        $(".list-add-location").append(html);
                        $(".list-add-location .empty").remove();
                    }
                }
            });
            
            self.save_activity();
        });

        $(document).on("click", ".ig-ac-option-item-location .remove", function(){
            $(this).parent().remove();
            if($(".ig-ac-option-item-location").length == 0){
                $(".list-add-location").append('<div class="empty small"></div>');
            }
            self.save_activity();
        });

        $(document).on("click", ".list-add-location .remove-all", function(){
            $(".ig-ac-option-item-location").remove();
            $(".list-add-location").append('<div class="empty small"></div>');
            self.save_activity();
        });
    };

    this.username = function(){
        $(".form-search-username").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();

                var that = $(this);
                var keyword = that.val();
                var action = that.data("action");
                var data = { token: token, keyword: keyword }; 
                Core.ajax_post(that, action, data, function(result){

                });

                return false;
            }
        });

        $(document).on("click", ".btn-add-username", function(result){
            $(".result-search-username input:checked").each(function(){
                var val = $(this).val();
                var val_params = val.split("|");

                var html = '<div class="ig-ac-option-item-username"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/'+val_params[1]+'" target="_blank">'+val_params[0]+'</a><input type="hidden" name="usernames[]" value="'+val+'"></div>';
                if(val != ""){
                    $(this).parents(".ig-ac-option-item-list").remove();

                    var check = false;
                    $("[name='usernames[]']").each(function(){
                        var val_exist = $(this).val();
                        if(val_exist == val){
                            check = true;
                        }
                    });

                    if(!check){
                        $(".list-add-username").append(html);
                        $(".list-add-username .empty").remove();
                    }
                }
            });
            
            self.save_activity();
        });

        $(document).on("click", ".ig-ac-option-item-username .remove", function(){
            $(this).parent().remove();
            if($(".ig-ac-option-item-username").length == 0){
                $(".list-add-username").append('<div class="empty small"></div>');
            }
            self.save_activity();
        });

        $(document).on("click", ".list-add-username .remove-all", function(){
            $(this).parents(".list-add-username").find(".ig-ac-option-item-username").remove();
            $(".list-add-username").append('<div class="empty small"></div>');
            self.save_activity();
        });
    };

    this.blacklist_tag = function(){
        $(".form-search-blacklist-tag").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();

                var that = $(this);
                var keyword = that.val();
                var action = that.data("action");
                var data = { token: token, keyword: keyword }; 
                Core.ajax_post(that, action, data, function(result){

                });

                return false;
            }
        });

        $(document).on("click", ".btn-add-blacklist-tag", function(result){
            $(".result-search-blacklist-tag input:checked").each(function(){
                var val = $(this).val();
                var html = '<div class="ig-ac-option-item-tag"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/explore/tags/'+val+'" target="_blank">'+val+'</a><input type="hidden" name="blacklist_tags[]" value="'+val+'"></div>';
                if(val != ""){
                    $(this).parents(".ig-ac-option-item-list").remove();

                    var check = false;
                    $("[name='blacklist_tags[]']").each(function(){
                        var val_exist = $(this).val();
                        if(val_exist == val){
                            check = true;
                        }
                    });

                    if(!check){
                        $(".list-add-blacklist-tag").append(html);
                        $(".list-add-blacklist-tag .empty").remove();
                    }
                }
            });
            
            self.save_activity();
        });

        $(document).on("click", ".btn-add-blacklist-tag-list", function(result){
            var that = $(this);
            var content = $(".form-add-blacklist-tag-list").val();
            var lines = content.split('\n');
            if(lines.length > 0){

                for(var i = 0;i < lines.length ; i++){
                    if(lines[i] != "" && lines[i].indexOf(' ') == -1){
                        var val = lines[i];
                        var check = false;
                        $("[name='blacklist_tags[]']").each(function(){
                            var val_exist = $(this).val();
                            if(val_exist == val){
                                check = true;
                            }
                        });

                        if(!check){
                            var html = '<div class="ig-ac-option-item-tag"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/explore/tags/'+val+'" target="_blank">'+val+'</a><input type="hidden" name="blacklist_tags[]" value="'+val+'"></div>';
                            $(".list-add-blacklist-tag").append(html);
                            $(".list-add-blacklist-tag .empty").remove();
                            $(".form-add-blacklist-tag-list").val("");
                        }
                    }
                }
                self.save_activity();
            
            }
        });

        $(document).on("click", ".ig-ac-option-item-tag .remove", function(){
            $(this).parent().remove();
            if($(".list-add-blacklist-tag .ig-ac-option-item-tag").length == 0){
                $(".list-add-blacklist-tag").append('<div class="empty small"></div>');
            }
            self.save_activity();
        });

        $(document).on("click", ".remove-all-blacklist-tag", function(){
            $(this).parents(".list-add-blacklist-tag").find(".ig-ac-option-item-tag").remove();
            $(".list-add-blacklist-tag .empty").remove();
            $(".list-add-blacklist-tag").append('<div class="empty small"></div>');
            self.save_activity();
        });
    };

    this.blacklist_username = function(){
        $(".form-search-blacklist-username").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();

                var that = $(this);
                var keyword = that.val();
                var action = that.data("action");
                var data = { token: token, keyword: keyword }; 
                Core.ajax_post(that, action, data, function(result){

                });

                return false;
            }
        });

        $(document).on("click", ".btn-add-blacklist-username", function(result){
            $(".result-search-blacklist-username input:checked").each(function(){
                var val = $(this).val();
                var val_params = val.split("|");

                var html = '<div class="ig-ac-option-item-username"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/'+val_params[1]+'" target="_blank">'+val_params[0]+'</a><input type="hidden" name="blacklist_usernames[]" value="'+val+'"></div>';
                if(val != ""){
                    $(this).parents(".ig-ac-option-item-list").remove();

                    var check = false;
                    $("[name='blacklist_usernames[]']").each(function(){
                        var val_exist = $(this).val();
                        if(val_exist == val){
                            check = true;
                        }
                    });

                    if(!check){
                        $(".list-add-blacklist-username").append(html);
                        $(".list-add-blacklist-username .empty").remove();
                    }
                }
            });
            
            self.save_activity();
        });

        $(document).on("click", ".ig-ac-option-item-username .remove", function(){
            $(this).parent().remove();
            if($(".list-add-blacklist-username .ig-ac-option-item-username").length == 0){
                $(".list-add-blacklist-username").append('<div class="empty small"></div>');
            }
            self.save_activity();
        });

        $(document).on("click", ".remove-all-blacklist-username", function(){
            $(this).parents(".list-add-blacklist-username").find(".ig-ac-option-item-username").remove();
            $(".list-add-blacklist-username .empty").remove();
            $(".list-add-blacklist-username").append('<div class="empty small"></div>');
            self.save_activity();
        });
    };

    this.blacklist_keyword = function(){
        $(document).on("click", ".btn-add-blacklist-keyword", function(result){
            var that = $(this);
            var content = $(".form-add-blacklist-keyword").val();
            var lines = content.split('\n');
            if(lines.length > 0){

                for(var i = 0;i < lines.length ; i++){
                    if(lines[i] != "" && lines[i].indexOf(' ') == -1){
                        var val = lines[i];
                        var check = false;
                        $("[name='blacklist_keywords[]']").each(function(){
                            var val_exist = $(this).val();
                            if(val_exist == val){
                                check = true;
                            }
                        });

                        if(!check){
                            var html = '<div class="ig-ac-option-item-keyword"><a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> '+val+'<input type="hidden" name="blacklist_keywords[]" value="'+val+'"></div>';
                            $(".list-add-blacklist-keyword").append(html);
                            $(".list-add-blacklist-keyword .empty").remove();
                            $(".form-add-blacklist-keyword-list").val("");
                        }
                    }
                }
                self.save_activity();
            
            }
        });

        $(document).on("click", ".ig-ac-option-item-keyword .remove", function(){
            $(this).parent().remove();
            if($(".list-add-blacklist-keyword .ig-ac-option-item-keyword").length == 0){
                $(".list-add-blacklist-keyword").append('<div class="empty small"></div>');
            }
            self.save_activity();
        });

        $(document).on("click", ".remove-all-blacklist-keyword", function(){
            $(this).parents(".list-add-blacklist-keyword").find(".ig-ac-option-item-keyword").remove();
            $(".list-add-blacklist-keyword .empty").remove();
            $(".list-add-blacklist-keyword").append('<div class="empty small"></div>');
            self.save_activity();
        });
    };

    this.schedule = function(){
        if($('#schedule_days').length > 0){

            $(document).on("click", ".open_schedule_days", function(){
                $('#schedule_days').modal('show');
            });

            var _type_hour = [" AM", " PM"];
            var _schedule_selector = $(".day-schedule-selector");
            var _days = ["", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
            var _hours = [12,1,2,3,4,5,6,7,8,9,10,11,12,1,2,3,4,5,6,7,8,9,10,11];
            var _schedule_days = $("input[name='schedule_days']").val();
            var _schedule_days = _schedule_days!=""?JSON.parse(_schedule_days):[];

            var _thead_item = "";
            for (var i = 0; i < _days.length; i++) {
                _thead_item += "<th>"+_days[i]+"</th>";
            }
            var _thead = "<tr>"+_thead_item+"</tr>";

            var _row_item = "";
            var _row_item_count = 0;
            for (var i = 0; i < _hours.length; i++) {

                var _row_item_select = "";
                var _row_item_select_full = "";
                for (var j = 0; j < 7; j++) {
                    _row_item_select_full += "<td><a href='javascript:void(0);' data-day='"+j+"' data-hour='"+i+"' class='item "+($.inArray(i, _schedule_days[j]) != -1?"active":"")+"'></a></td>";
                }

                _row_item += "<tr><td class='hour'>"+_hours[i]+(_row_item_count<12?_type_hour[0]:_type_hour[1])+"</td>"+_row_item_select_full+"</tr>";
                _row_item_count++;
            }

            var _table = "<table class='table-day-schedule'>"+_thead+_row_item+"</table>";

            _schedule_selector.html(_table);

            var _noneTime = [[],[],[],[],[],[],[]];

            var _idealTime = [
                [9, 10, 11, 12, 13, 14, 15],
                [8, 9, 10, 11, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                [8, 9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 21],
                [8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20, 21],
                [8, 9, 10, 11, 12, 13, 14, 16, 17, 18, 19, 20, 21],
                [8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19, 20, 21],
                [10, 11, 12, 13, 14, 15, 16, 17],
            ];

            var _oddTime = [
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23]
            ];
            
            var _evenTime = [
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22]
            ];
            
            var _alternate1Time = [
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
            ];
            
            var _alternate2Time = [
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
                [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22],
            ];
            
            var _dayTime = [
                [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]
            ];

            var _nightTime = [
                [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 19, 20, 21, 22, 23]
            ];

            var _allTime = [
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
            ];


            $(document).on("click", ".day-schedule-auto a", function(){
                var _main = $(this);

                $(".day-schedule-selector .item").each(function(index, value){
                    var _that = $(this);
                    var _day = _that.attr("data-day");
                    var _hour = _that.attr("data-hour");
                    var _type = _main.attr("data-type");

                    switch(_type) {
                        case "ideal":
                            var _data = _idealTime;
                            break;
                        
                        case "odd":
                            var _data = _oddTime;
                            break;
                            
                        case "even":
                            var _data = _evenTime;
                            break;

                        case "alternate1":
                            var _data = _alternate1Time;
                            break;
                            
                        case "alternate2":
                            var _data = _alternate2Time;
                            break;
                            
                        case "all":
                            var _data = _allTime;
                            break;

                        case "day":
                            var _data = _dayTime;
                            break;

                        case "night":
                            var _data = _nightTime;
                            break;

                        default:
                            var _data = _noneTime;
                    }
                    $("input[name='schedule_days']").val(JSON.stringify(_data));
                    if($.inArray(parseInt(_hour) , _data[_day]) != -1){
                        _that.addClass("active");
                    }else{
                        _that.removeClass("active");
                    }
                });
            });


            $(document).on("click", ".day-schedule-selector .item", function(){
                var _that = $(this);
                if(_that.hasClass("active")){
                    _that.removeClass("active");
                }else{
                    _that.addClass("active");
                }
                
                var _count = 0;
                var _days_selected = [[],[],[],[],[],[],[]];
                $(".day-schedule-selector .item").each(function(index, value){

                    if($(this).hasClass("active")){
                        var _hour = $(this).attr("data-hour");
                        _days_selected[_count].push(parseInt(_hour));
                    }

                    if(_count >= 6){
                        _count = 0;
                    }else{
                        _count++;
                    }
                });

                $("input[name='schedule_days']").val(JSON.stringify(_days_selected));
            });
        }
    };

    this.speed = function(){
        $(document).on("change", ".speed-level", function(){
            var _that = $(this);
            var _values = _that.children('option:selected').data('speed');
            $("[name='speeds[like]']").val(_values[0]);
            $("[name='speeds[comment]']").val(_values[1]);
            $("[name='speeds[watching_story]']").val(_values[2]);
            $("[name='speeds[follow]']").val(_values[3]);
            $("[name='speeds[unfollow]']").val(_values[4]);
            $("[name='speeds[direct]']").val(_values[5]);
            $("[name='speeds[repost]']").val(_values[6]);
            self.save_activity();
        });

        $(document).on("change", ".item-speed", function(){
            self.load_speed();
        });

        self.load_speed();
    };

    this.load_speed = function(){
        var _check_use_speed_default = false;
        $(".speed-level option").each(function(index, value){
            var _like = $("[name='speeds[like]']").val();
            var _comment = $("[name='speeds[comment]']").val();
            var _watching_story = $("[name='speeds[watching_story]']").val();
            var _follow = $("[name='speeds[follow]']").val();
            var _unfollow = $("[name='speeds[unfollow]']").val();
            var _direct = $("[name='speeds[direct]']").val();
            var _repost = $("[name='speeds[repost]']").val();

            var _speed_default = JSON.stringify($(this).data("speed"));
            var _string_speed = "["+_like+","+_comment+","+_watching_story+","+_follow+","+_unfollow+","+_direct+","+_repost+"]";
            if(_string_speed==_speed_default){
                _check_use_speed_default = true;
            }
        });

        if(!_check_use_speed_default){
            $(".speed-level").val("");
        }
    };

    this.save_activity = function(){
        var form           = $( ".save-action" );
        var action         = form.attr("action");
        var data           = form.serialize();
        var data           = data + '&' + $.param({token:token});
        Core.ajax_post(form, action, data, function(result){
            if(result.status == "error"){
                $(".btnActivityStop").before(result.btnStart).remove();
                $(".activity-proccess").html(result.iconState);
            }
        });
    };

    this.nl2br = function(str, is_xhtml){
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    };

    this.log = function(){
        self.call_load_more_log();
        self.ajax_load_log(0);

        $(document).on("click", ".ig-ac-log-memu a", function(){
            var that = $(this);
            var type = that.data("type");
            var href = that.attr("href");
            $(".ig-ac-log-memu li").removeClass("active");
            that.parents("li").addClass("active");
            $(".ajax-load-log").attr("data-type", type);
            history.pushState(null, '', href);
            self.ajax_load_log(0);
            return false;
        });
    };

    this.call_load_more_log = function(){
        var that = $('.ajax-load-log[data-load-type="scroll"]');
        var scrollDiv = that.data('scroll');
        if ( that.length > 0 )
        {
            $(scrollDiv).bind('scroll',function(){
                var _scrollPadding = 80;
                var _scrollTop = $(scrollDiv).scrollTop();
                var _divHeight = $(scrollDiv).height();
                var _scrollHeight = $(scrollDiv).get(0).scrollHeight;

                $(window).trigger('resize'); 
                if( _scrollTop + _divHeight + _scrollPadding >= _scrollHeight) {
                    self.ajax_load_log();
                }

            });
        }
    };

    this.ajax_load_log = function(page){
        var that = $('.ajax-load-log');
        var type = that.attr('data-type');
        var ids = that.data('id');

        if(type == undefined){
            var type = "";
        }else{
            var type = '/' + type
        }
        
        if(page != undefined){
            that.attr('data-page', 0);
            that.attr('data-loading', 0);
        }

        if ( that.length > 0 )
        {
            var action = PATH + 'instagram_activity/ajax_load_log/' + ids + type;
            var type = that.data('type');
            var page = parseInt(that.attr('data-page'));
            var loading = that.attr('data-loading');
            var data = { token: token, page: page };
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
                    if ( page == 0 )
                    {
                        that.html( result );
                    }
                    else
                    {
                        that.append( result );
                    }

                    if(result != ''){
                        that.attr('data-loading', 0);
                    } 

                    that.attr( 'data-page', page + 1);
                    
                    $(".nicescroll").getNiceScroll().resize();
                });
            }
        }
    };

    this.stats = function(){
        self.ajax_load_stats(0);
    };
    this.ajax_load_stats = function(page){
        var that = $('.ajax-load-stats');
        var ids = that.data('id');

        if(type == undefined){
            var type = "";
        }else{
            var type = '/' + type
        }
        
        if(page != undefined){
            that.attr('data-page', 0);
            that.attr('data-loading', 0);
        }

        if ( that.length > 0 )
        {
            var action = PATH + 'instagram_activity/ajax_load_stats/' + ids;
            var type = that.data('type');
            var page = parseInt(that.attr('data-page'));
            var loading = that.attr('data-loading');
            var data = { token: token, page: page };
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
                    if ( page == 0 )
                    {
                        that.html( result );
                    }
                    else
                    {
                        that.append( result );
                    }

                    if(result != ''){
                        that.attr('data-loading', 0);
                    } 

                    that.attr( 'data-page', page + 1);
                    
                    $(".nicescroll").getNiceScroll().resize();
                });
            }
        }
    };

    this.profile = function(){
        self.call_load_more_profile();
        self.ajax_load_profile(0);
    };

    this.call_load_more_profile = function(){
        var that = $('.ajax-load-profile[data-load-type="scroll"]');
        var scrollDiv = that.data('scroll');
        if ( that.length > 0 )
        {
            $(scrollDiv).bind('scroll',function(){
                var _scrollPadding = 80;
                var _scrollTop = $(scrollDiv).scrollTop();
                var _divHeight = $(scrollDiv).height();
                var _scrollHeight = $(scrollDiv).get(0).scrollHeight;

                $(window).trigger('resize'); 
                if( _scrollTop + _divHeight + _scrollPadding >= _scrollHeight) {
                    self.ajax_load_profile();
                }

            });
        }
    };

    this.ajax_load_profile = function(page){
        var that = $('.ajax-load-profile');
        var ids = that.data('id');

        if(type == undefined){
            var type = "";
        }else{
            var type = '/' + type
        }
        
        if(page != undefined){
            that.attr('data-page', 0);
            that.attr('data-loading', 0);
        }

        var page = that.attr('data-page');
        
        if ( that.length > 0 && page != -1)
        {
            var action = PATH + 'instagram_activity/ajax_load_profile/' + ids;
            var type = that.data('type');
            var loading = that.attr('data-loading');
            var data = { token: token, page: page };
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
                    if ( page == 0 )
                    {
                        that.html( result );
                    }
                    else
                    {
                        that.append( result );
                    }

                    if(result != ''){
                        that.attr('data-loading', 0);
                    } 

                    that.attr( 'data-page', $(".next-page").data("page") );

                    $(".next-page").remove();
                    
                    $(".nicescroll").getNiceScroll().resize();
                });
            }
        }
    };
}

Instagram_activity= new Instagram_activity();
$(function(){
    Instagram_activity.init();
});
