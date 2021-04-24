<?php
/* Smarty version 3.1.30, created on 2020-02-09 02:14:55
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/sections/footer_default.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e3fb16fd14e38_32478961',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e945c875b6ec768bd3521e2626be2a2b4ece8ea6' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/sections/footer_default.tpl',
      1 => 1474992670,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e3fb16fd14e38_32478961 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="ajax-modal" class="modal container fade-scale" tabindex="-1" style="display: none;"></div>
</div>

<?php if ($_smarty_tpl->tpl_vars['tpl_footer']->value) {?>
    <?php if ($_smarty_tpl->tpl_vars['_c']->value['hide_footer']) {?>

        <?php } else { ?>
        <div class="footer">
            <div>
                <strong><?php echo $_smarty_tpl->tpl_vars['_L']->value['Copyright'];?>
</strong> &copy; <?php echo $_smarty_tpl->tpl_vars['_c']->value['CompanyName'];?>

            </div>
        </div>
    <?php }
}?>

</div>

<div id="right-sidebar">
    <div class="sidebar-container">

        <ul class="nav nav-tabs navs-3">

            <li class="active"><a data-toggle="tab" href="#tab-1">
                    <?php echo $_smarty_tpl->tpl_vars['_L']->value['Notes'];?>

                </a></li>
            
                    
                
            <li class=""><a data-toggle="tab" href="#tab-3">
                    <i class="fa fa-gear"></i>
                </a></li>
        </ul>

        <div class="tab-content">


            <div id="tab-1" class="tab-pane active">

                <div class="sidebar-title">
                    <h3> <i class="fa fa-file-text-o"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Quick Notes'];?>
</h3>

                </div>

                <div style="padding: 10px">

                    <form class="form-horizontal push-10-t push-10" method="post" onsubmit="return false;">

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material floating">
                                    <textarea class="form-control" id="ib_admin_notes" name="ib_admin_notes" rows="10"><?php echo $_smarty_tpl->tpl_vars['user']->value->notes;?>
</textarea>
                                    <label for="ib_admin_notes"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Whats on your mind'];?>
</label>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-sm btn-success" type="submit" id="ib_admin_notes_save"><i class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Save'];?>
</button>
                            </div>
                        </div>
                    </form>
                    </div>




            </div>

            

                
                    
                    
                

                
                    
                    
                        
                            
                            
                            

                            
                            
                                
                            
                            
                        
                    

                

            

            <div id="tab-3" class="tab-pane">

                <div class="sidebar-title">
                    <h3><i class="fa fa-gears"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Settings'];?>
</h3>

                </div>

                <div class="setings-item">
                    <h4>Theme Color</h4>

                    <ul id="ib_theme_color" class="ib_theme_color">

                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
settings/set_color/light/"><span class="light"></span></a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
settings/set_color/blue/"><span class="blue"></span></a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
settings/set_color/dark/"><span class="dark"></span></a></li>
                    </ul>


                </div>
                <div class="setings-item">
                    <span>
                        <?php echo $_smarty_tpl->tpl_vars['_L']->value['Fold Sidebar Default'];?>

                    </span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="r_fold_sidebar" <?php if (get_option('mininav') == '1') {?>checked<?php }?> class="onoffswitch-checkbox" id="r_fold_sidebar">
                            <label class="onoffswitch-label" for="r_fold_sidebar">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>



</div>

</div>
</section>
<!-- BEGIN PRELOADER -->
<?php if (($_smarty_tpl->tpl_vars['_c']->value['animate']) == '1') {?>
    <div class="loader-overlay">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>
<?php }?>
<input type="hidden" id="_url" name="_url" value="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
">
<input type="hidden" id="_df" name="_df" value="<?php echo $_smarty_tpl->tpl_vars['_c']->value['df'];?>
">
<input type="hidden" id="_lan" name="_lan" value="<?php echo $_smarty_tpl->tpl_vars['_c']->value['language'];?>
">
<!-- END PRELOADER -->
<!-- Mainly scripts -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/js/jquery-1.10.2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/js/jquery-ui-1.10.4.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    var _L = [];


    var base_url = '<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
';

    <?php if (($_smarty_tpl->tpl_vars['_c']->value['animate']) == '1') {?>
    var config_animate = 'Yes';
    <?php } else { ?>
    var config_animate = 'No';
    <?php }?>
    <?php echo $_smarty_tpl->tpl_vars['jsvar']->value;?>

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/js/jquery.metisMenu.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/js/jquery.slimscroll.min.js"><?php echo '</script'; ?>
>

<?php if ($_smarty_tpl->tpl_vars['_c']->value['language'] != 'en-us') {?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
ui/lib/moment/moment-with-locales.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
>
        moment.locale('<?php echo $_smarty_tpl->tpl_vars['_c']->value['momentLocale'];?>
');
    <?php echo '</script'; ?>
>

    <?php } else { ?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
ui/lib/moment/moment.min.js"><?php echo '</script'; ?>
>

<?php }?>


<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
ui/lib/blockui.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
ui/lib/app.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
ui/lib/toggle/bootstrap-toggle.min.js"><?php echo '</script'; ?>
>
<?php if (($_smarty_tpl->tpl_vars['_c']->value['animate']) == '1') {?>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/js/pace.min.js"><?php echo '</script'; ?>
>
<?php }?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/lib/progress.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/lib/bootbox.min.js"><?php echo '</script'; ?>
>
<!-- iCheck -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/lib/icheck/icheck.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_theme']->value;?>
/js/theme.js"><?php echo '</script'; ?>
>
<?php if (isset($_smarty_tpl->tpl_vars['xfooter']->value)) {?>
    <?php echo $_smarty_tpl->tpl_vars['xfooter']->value;?>

<?php }
echo '<script'; ?>
>
    jQuery(document).ready(function() {
        // initiate layout and plugins

        matForms();



        <?php if (isset($_smarty_tpl->tpl_vars['xjq']->value)) {?>
        <?php echo $_smarty_tpl->tpl_vars['xjq']->value;?>

        <?php }?>

    });

<?php echo '</script'; ?>
>
</body>

</html>
<?php }
}
