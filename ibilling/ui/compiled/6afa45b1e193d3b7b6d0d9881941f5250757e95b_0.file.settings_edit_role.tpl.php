<?php
/* Smarty version 3.1.30, created on 2020-02-10 01:10:26
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/settings_edit_role.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e40f3d2bdb476_64757856',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6afa45b1e193d3b7b6d0d9881941f5250757e95b' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/settings_edit_role.tpl',
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
function content_5e40f3d2bdb476_64757856 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>




<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo $_smarty_tpl->tpl_vars['_L']->value['New Role'];?>
</h5>

            </div>
            <div class="ibox-content">



                <form action="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
settings/edit_role_post/" method="post" accept-charset="utf-8">
                    <div class="form-group"><label for="rname" class="control-label"> <small class="req text-danger">* </small>Role Name</label><input type="text" id="rname" name="rname" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['role']->value->rname;?>
"></div>

                    <hr>


                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered roles no-margin">
                                <thead>
                                <tr>
                                    <th class="bold"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Permission'];?>
</th>
                                    <th class="text-center bold"><?php echo $_smarty_tpl->tpl_vars['_L']->value['View'];?>
</th>
                                    <th class="text-center bold"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Edit'];?>
</th>
                                    <th class="text-center bold"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Create'];?>
</th>
                                    <th class="text-center text-danger bold"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Delete'];?>
</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['permissions']->value, 'permission');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['permission']->value) {
?>

                                    <tr data-id="<?php echo $_smarty_tpl->tpl_vars['permission']->value['id'];?>
">
                                        <td class="bold"><?php echo $_smarty_tpl->tpl_vars['permission']->value['pname'];?>
</td>
                                        <td class="text-center">
                                            <div class="checkbox">
                                                <div class="i-checks"><label  style="padding-left: 0"> <input name="<?php echo $_smarty_tpl->tpl_vars['permission']->value['shortname'];?>
_view" class="ib_checkbox" type="checkbox" value="yes" <?php if (Misc::check_permission_by_role_id($_smarty_tpl->tpl_vars['role']->value->id,$_smarty_tpl->tpl_vars['permission']->value['id'],'view')) {?>checked<?php }?>></label></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="checkbox">
                                                <div class="i-checks"><label> <input name="<?php echo $_smarty_tpl->tpl_vars['permission']->value['shortname'];?>
_edit" class="ib_checkbox" type="checkbox" value="yes" <?php if (Misc::check_permission_by_role_id($_smarty_tpl->tpl_vars['role']->value->id,$_smarty_tpl->tpl_vars['permission']->value['id'],'edit')) {?>checked<?php }?>></label></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="checkbox">
                                                <div class="i-checks"><label> <input name="<?php echo $_smarty_tpl->tpl_vars['permission']->value['shortname'];?>
_create" class="ib_checkbox" type="checkbox" value="yes" <?php if (Misc::check_permission_by_role_id($_smarty_tpl->tpl_vars['role']->value->id,$_smarty_tpl->tpl_vars['permission']->value['id'],'create')) {?>checked<?php }?>></label></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="checkbox checkbox-danger">
                                                <div class="i-checks"><label> <input name="<?php echo $_smarty_tpl->tpl_vars['permission']->value['shortname'];?>
_delete" class="ib_checkbox" type="checkbox" value="yes" <?php if (Misc::check_permission_by_role_id($_smarty_tpl->tpl_vars['role']->value->id,$_smarty_tpl->tpl_vars['permission']->value['id'],'delete')) {?>checked<?php }?>></label></div>
                                            </div>
                                        </td>
                                    </tr>

                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


                                </tbody>
                            </table>

                            <input type="hidden" name="rid" id="rid" value="<?php echo $_smarty_tpl->tpl_vars['role']->value->id;?>
">

                            <button class="md-btn md-btn-primary" type="submit" id="submit"><i class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Save'];?>
</button>                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>



</div>

<?php $_smarty_tpl->_subTemplateRender("file:sections/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
