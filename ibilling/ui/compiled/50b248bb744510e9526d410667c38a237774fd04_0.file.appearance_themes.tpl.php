<?php
/* Smarty version 3.1.30, created on 2020-02-09 02:19:21
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/appearance_themes.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e3fb2791503f2_78355662',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '50b248bb744510e9526d410667c38a237774fd04' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/appearance_themes.tpl',
      1 => 1474992670,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sections/header.tpl' => 1,
    'file:sections/footer.tpl' => 1,
  ),
),false)) {
function content_5e3fb2791503f2_78355662 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>




<div class="row">
    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo $_smarty_tpl->tpl_vars['_L']->value['Themes'];?>
</h5>

            </div>
            <div class="ibox-content">

                <form role="form" name="accadd" method="post" action="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
appearance/themes_post/">


                    <div class="form-group">
                        <label for="theme"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Theme'];?>
</label>
                        <select name="theme" id="theme" class="form-control">
                            

                            

                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, (($tmp = @$_smarty_tpl->tpl_vars['themes']->value)===null||$tmp==='' ? array() : $tmp), 'theme');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['theme']->value) {
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['theme']->value;?>
"
                                        <?php if ($_smarty_tpl->tpl_vars['_c']->value['theme'] == $_smarty_tpl->tpl_vars['theme']->value) {?>selected="selected" <?php }?>><?php echo ucfirst($_smarty_tpl->tpl_vars['theme']->value);?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nstyle"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Style'];?>
</label>
                        <select name="nstyle" id="nstyle" class="form-control">
                            <option value="dark" <?php if ($_smarty_tpl->tpl_vars['_c']->value['nstyle'] == 'dark') {?>selected="selected" <?php }?>>Dark</option>
                            <option value="light" <?php if ($_smarty_tpl->tpl_vars['_c']->value['nstyle'] == 'light') {?>selected="selected" <?php }?>>Light</option>
                            <option value="blue" <?php if ($_smarty_tpl->tpl_vars['_c']->value['nstyle'] == 'blue') {?>selected="selected" <?php }?>>Blue</option>
                        </select>
                    </div>




                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Submit'];?>
</button>
                </form>

            </div>
        </div>










    </div>




</div>

<?php $_smarty_tpl->_subTemplateRender("file:sections/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
