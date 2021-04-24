{include file="sections/header.tpl"}



<div class="row">
    <div class="col-md-6">
        <div class="ibox float-e-margins" id="ui_settings">
            <div class="ibox-title">
                <h5>{$_L['User Interface']}</h5>


            </div>
            <div class="ibox-content">
                <table class="table table-hover">
                    <tbody>

                    <tr>
                        <td width="80%"><label for="config_animate">{$_L['Enable Page Loading Animation']} </label></td>
                        <td><input type="checkbox" {if get_option('animate') eq '1'}checked{/if} data-toggle="toggle"
                                   data-size="small" data-on="{$_L['Yes']}" data-off="{$_L['No']}" id="config_animate">
                        </td>
                    </tr>

                    <tr>
                        <td width="80%"><label for="config_rtl">{$_L['Enable RTL']} </label></td>
                        <td><input type="checkbox" {if get_option('rtl') eq '1'}checked{/if} data-toggle="toggle"
                                   data-size="small" data-on="{$_L['Yes']}" data-off="{$_L['No']}" id="config_rtl"></td>
                    </tr>


                    <tr>
                        <td width="80%"><label for="config_mininav">{$_L['Fold Sidebar Default']} </label></td>
                        <td><input type="checkbox" {if get_option('mininav') eq '1'}checked{/if} data-toggle="toggle"
                                   data-size="small" data-on="{$_L['Yes']}" data-off="{$_L['No']}" id="config_mininav">
                        </td>
                    </tr>

                    <tr>
                        <td width="80%"><label for="config_hide_footer">{$_L['Hide Footer Copyright']} </label></td>
                        <td><input type="checkbox" {if get_option('hide_footer') eq '1'}checked{/if}
                                   data-toggle="toggle" data-size="small" data-on="{$_L['Yes']}" data-off="{$_L['No']}"
                                   id="config_hide_footer"></td>
                    </tr>


                    </tbody>
                </table>

                <hr>

                <div class="form-group">
                    <label for="contentAnimation">{$_L['Content Animation']}</label>
                    <select name="contentAnimation" id="contentAnimation" class="form-control">

                        <option value="" {if $_c['contentAnimation'] eq ''}selected{/if}>{$_L['None']}</option>

                        {$ca_options}

                    </select>
                </div>


            </div>
        </div>
    </div>



</div>

{include file="sections/footer.tpl"}
