<?php
/* Smarty version 3.1.30, created on 2020-02-15 20:12:15
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/tags.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e47fc3f3c2c73_67757590',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1bcf6e992299f8225e157ae6263612d34506070b' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/tags.tpl',
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
function content_5e47fc3f3c2c73_67757590 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo $_smarty_tpl->tpl_vars['_L']->value['Manage Tags'];?>
 </h5>
    </div>
    <div class="ibox-content">

        <table class="table table-bordered table-hover sys_table">
            <thead>
            <tr>

                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Tag'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Type'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Delete'];?>
</th>

            </tr>
            </thead>
            <tbody>

            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['d']->value, 'ds');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ds']->value) {
?>
                <tr>

                    <td><?php echo $_smarty_tpl->tpl_vars['ds']->value['text'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ds']->value['type'];?>
</td>
                    <td>
                        <a href="#" class="btn btn-danger btn-xs cdelete" id="iid<?php echo $_smarty_tpl->tpl_vars['ds']->value['id'];?>
"><i class="fa fa-trash"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Delete'];?>
</a>
                    </td>
                </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


            </tbody>
        </table>

    </div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:sections/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
