(function($, window, document){
    var debugScr;
    var terminal;
    var inputBox;
    var fakeInputBox;
    var cheat=false;
    var toggleFix=0;
    var cmdList = [];
    var cmdHistory = [""];
    var historyPt = 0;
    var cacheToggleKey;
    var cacheResizeKey;
    var _clamp = function(number, min, max) {
        return Math.max(min, Math.min(number, max));
    };
    var _debug = {
        init : function(_full){
            if( typeof(_full)==='undefined' ) _full=false;
            if( $("#debugScr").length===0){
                // create
                debugScr = $("<div>", {id:"debugScr",class:"fixed "+((_full)?"full":"small")});
                debugScr.html("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" height=\"100%\">"+
                    "<tbody><tr class=\"dsheader\" ><td>DEBUG :</td></tr>"+
                    "<tr valign=\"top\" height='100%'><td>"+
                    "<div id=\"terminal\"></div>"+
                    "</td></tr><tr height=\"50px\">"+
                    "<td class=\"inputArea\">"+
                    "<span class=\"fakeInput\" ></span><span class=\"blinkCursor\">_</span>"+
                    "<input type=\"text\" value=\"\" placeholder=\"Waiting command.\" >"+
                    "</td></tr></tbody></table>");
                $("body").append( debugScr );
            }
            terminal=$("#debugScr #terminal");
            inputBox=$("#debugScr .inputArea input:first");
            fakeInputBox=$("#debugScr .inputArea .fakeInput");
            // function method
            debugScr.dblclick(function(){ $.debug.hide(); });
            debugScr.click(function(){ inputBox.focus(); });
            // run input command.
            inputBox.keydown(function(event){
                fakeInputBox.text( inputBox.val() );
            });
            inputBox.keyup(function(event){
                if( event.keyCode==13 ){// Enter
                    var runCmd = $(this).val();
                    $(this).val("");
                    $.debug.run(runCmd);
                }
                else if( event.keyCode==38 || event.keyCode==33){	// Up
                    historyPt = $.clamp(--historyPt,0,cmdHistory.length);
                    inputBox.val((cmdHistory.length>0)?cmdHistory[historyPt]:"");
                }
                else if( event.keyCode==40 || event.keyCode==34){	// Down
                    historyPt = $.clamp(++historyPt,0,cmdHistory.length);
                    inputBox.val((historyPt<cmdHistory.length)?cmdHistory[historyPt]:"");
                }
                fakeInputBox.text( inputBox.val() );
            });
            // link up debug panel.
            $(window).error(function(msg,url,line){
                try{
                    $.debug.Error("[System Error]\n\t url : "+url+"\n\t line : "+line+"\n\t msg : "+msg+"\n");
                }catch(e){}
                return true;
            });
            // toggleByKey function
            $(document).keydown(function(e){
                $.debug._toggleByKey(e);
                $.debug._resizeByKey(e);
            });

            // last status of debug window.
            if( typeof($.loadCache)!="undefined" && $.loadCache("CFDebug",false) )
                $.debug.show();
            else
                $.debug.hide();
        },
        log : function (_str,_html){
            if( typeof(_html)==='undefined' | !_html )
                terminal.append( $("<div>", {text:_str}) );
            else
                terminal.append( $("<div>", {html:_str}) );
            terminal.scrollTop( terminal.get(0).scrollHeight );
        },
        warning : function (_str){
            terminal.append( $("<div>", {class:"warning", text:_str}) );
            terminal.scrollTop( terminal.get(0).scrollHeight );
        },
        error : function (_str){
            terminal.append( $("<div>", {class:"error", text:_str}) );
            terminal.scrollTop( terminal.get(0).scrollHeight );
        },
        isShow : function(){
            return debugScr.hasClass("debuging");
        },
        show : function(){
            debugScr.show();
            setTimeout(function(){debugScr.addClass("debuging");},0);
            inputBox.focus();
            clearTimeout(toggleFix);
            toggleFix=setTimeout(function(){
                inputBox.focus(); // hotfix for keyboard shortcut call
            }, 1000);
            if( typeof($.saveCache)!="undefined" ) $.saveCache("CFDebug", true, 5); // within 5min refresh, will remind display this screen
        },
        hide : function(){
            debugScr.removeClass("debuging");
            inputBox.blur();
            clearTimeout(toggleFix);
            toggleFix=setTimeout(function(){
                debugScr.hide();	// fix hidden too early. :)
            }, 1000);
            if( typeof($.delCache)!="undefined" ) $.delCache("CFDebug");
        },
        toggle : function(){
            if( debugScr.hasClass("debuging") )
                $.debug.hide();
            else
                $.debug.show();
        },
        toggleByKey : function(ctrl,alt,shift,keyCode)
        {
            cacheToggleKey = { ctrl:ctrl, alt:alt, shift:shift, keyCode:keyCode };
        },
        _toggleByKey : function(e)
        {
            if( typeof(cacheToggleKey)!='undefined' )
            {
                if( e.ctrlKey==cacheToggleKey.ctrl &&
                    e.altKey==cacheToggleKey.alt &&
                    e.shiftKey==cacheToggleKey.shift &&
                    e.which==cacheToggleKey.keyCode )
                {
                    $.debug.toggle();
                    e.preventDefault();
                }
            }
        },
        resizeByKey : function(ctrl,alt,shift,keyCode)
        {
            resizeToggleKey = { ctrl:ctrl, alt:alt, shift:shift, keyCode:keyCode };
        },
        _resizeByKey : function(e)
        {
            if( typeof(resizeToggleKey)!='undefined' )
            {
                if( $.debug.isShow() &&
                    e.ctrlKey==resizeToggleKey.ctrl &&
                    e.altKey==resizeToggleKey.alt &&
                    e.shiftKey==resizeToggleKey.shift &&
                    e.which==resizeToggleKey.keyCode )
                    if( debugScr.hasClass("full") )
                    {
                        debugScr.removeClass("full").addClass("small");
                    }
                    else
                    {
                        debugScr.removeClass("small").addClass("full");
                    }
            }
        },
        addCmd : function(_obj){
            if( arguments.length>1 ){						// this is multi command in list.
                for(var i=0;i<arguments.length;i++){
                    $.debug.addCmd( arguments[i] );
                }//for
                return true;
            }else{
                var _add = new ai.cmdClass();
                if( typeof _obj.tag!=="undefined" && typeof _obj.fn!=="undefined" )
                {
                    _add.tag = $.trim(_obj.tag.toLowerCase());
                    _add.info = (typeof _obj.info!=="undefined")?_obj.info:_add.info;
                    _add.fn = (typeof _obj.fn!=="undefined")?_obj.fn:function(){};
                }
                cmdList.push(_add);
            }
        },
        run : function(_str){
            _str = $.trim(_str);
            cmdHistory.push(_str);
            if(cmdHistory.length>100)
                cmdHistory.shift();
            historyPt = cmdHistory.length;
            for(var i=0; i<cmdList.length;i++)
            {
                var _len = cmdList[i].tag.length;
                if( _str == cmdList[i].tag )
                {
                    cmdList[i].fn();	// run that function.
                    return true;	// command run finish.
                }
                else if( _str.match("^"+cmdList[i].tag+" ") )
                {
                    var _param = $.trim(_str.substr(_len));
                    cmdList[i].fn(_param);
                    return true;
                }
            }
            if( _str.length>0 )
            {
                $.debug.log("> "+_str);
                switch(_str.toLowerCase()){
                    case "cls": case "clear": terminal.text(""); break;
                    case "exit": case "quit": $.debug.hide(); break;
                    case "reload": case "refresh": $.debug.log("reloading..."); window.location.reload(true); break;
                    case "screen big":
                        debugScr.removeClass("small").addClass("full");
                        break;
                    case "screen small":
                        debugScr.removeClass("full").addClass("small");
                        break;
                    case "screen":
                    case "screen toggle":
                        if( debugScr.hasClass("full") )
                        {
                            debugScr.removeClass("full").addClass("small");
                        }
                        else
                        {
                            debugScr.removeClass("small").addClass("full");
                        }
                        break;
                    case "help": case "?":
                {
                    $.debug.log("//******************************************************************");
                    $.debug.log("   Debug window basic command");
                    $.debug.log("//******************************************************************");
                    $.debug.log("\thelp                         - this command");
                    $.debug.log("\tcls                          - clear up this debug console");
                    $.debug.log("\tscreen [big/small/toggle]    - switch debug screen size");
                    $.debug.log("\treload/refresh               - to reload the page");
                    $.debug.log("\texit/quit                    - to exit debug window");
                    $.debug.log("");
                    $.debug.log("// Addon command ***************************************************");
                    for(i=0; i<cmdList.length;i++)
                    {
                        var _tmp = Math.ceil( Math.ceil((5*4)-cmdList[i].tag.length) / 4);
                        var _space = "";
                        for(var j=0; j<_tmp; j++)
                        {
                            _space+="\t";
                        }
                        $.debug.log("\t"+cmdList[i].tag + _space+"- "+ cmdList[i].info);
                    }
                    $.debug.log("//------------------------------------------------------------------");
                    $.debug.log("// Please contact <a href=\"mailto:canis@clonefactor.com\">canis@clonefactor.com</a> to report error. m(_ _)m",true);
                    $.debug.log("//******************************************************************");
                }
                    break;
                    case "iseedeadpeople":
                        cheat=!cheat;
                        $.debug.warning("Cheat : "+ ((cheat)?"Enable":"Disable") );
                        break;
                    //
                    // Command Line
                    //
                    default:
                        if( cheat )
                        {
                            try{
                                if($.trim(_str)!=="" && _str.match("^eval ") )
                                {
                                    $.globalEval( _str.substr(5) );
                                    $.debug.warning(" = success");
                                }
                                else throw "?";
                            }catch(e){ $.debug.error("= command fail, type \"help\" for more information."); }
                        }
                        else
                        {
                            $.debug.error("- command fail, type \"help\" for more information.");
                        }
                        break;
                }//case
            }
        }
    };

    // addCmd() structure sample.
    var ai = {
        cmdClass : function(){
            this.tag		= "none";	// Ä²µoªº cmd
            this.fn			= {};		// ¦Û­qªº¥\¯à
            this.info		= "No description info."; // ¥\¯àªºÂ²¤¶.
        }
    };

    window.onerror = function(message,url,lineNumber){
        $.debug.error("Message : "+message+"\n"+
            "Url : "+url+"\n"+
            "Line : "+lineNumber);
    }

    $.extend({
        debug : _debug,
        clamp : _clamp
    });
})($, window, document);

$(document).ready(function(){
    // VarInfo
    if( $.VarInfo )
    {
        $.debug.addCmd({
            tag : "var",
            info : "Check variable info of target value",
            fn : function(_param){
                var _obj;
                try{
                    _obj = $.globalEval(_param);
                    if( typeof(_obj)==="undefined" )
                    {
                        try{
                            $.debug.warning("EVAL!");
                            _obj = eval(_param);
                        }
                        catch(e){

                        }
                    }
                    $.debug.log($.VarInfo(_obj));
                }
                catch(e)
                {
                    $.debug.warning("Get VarInfo("+_param+") fail.");
                }
            }
        });
    }
    // Open url
    $.debug.addCmd({
        tag : "url",
        info : "open hyperlink.",
        fn : function(_param){
            var _url = $.trim(_param);
            var _id = "link_"+(new Date).getTime();
            try{
                if(_url.match(/(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/gi))
                {
                    $.debug.log("<a id='"+_id+"' href=\""+_url+"\" target=\"blank\">"+_url+"</a>",true);
                }
                else
                {
                    $.debug.log("invaild address : "+_param);
                }
                setTimeout(function(){ $("#"+_id).click(); },1);
            }
            catch(e)
            {
                $.debug.warning("Get VarInfo("+_param+") fail.");
            }
        }
    });
});