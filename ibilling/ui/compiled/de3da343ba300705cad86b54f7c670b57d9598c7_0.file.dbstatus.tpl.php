<?php
/* Smarty version 3.1.30, created on 2020-02-09 02:18:37
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/dbstatus.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e3fb24deff879_79905433',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'de3da343ba300705cad86b54f7c670b57d9598c7' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/dbstatus.tpl',
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
function content_5e3fb24deff879_79905433 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo $_smarty_tpl->tpl_vars['_L']->value['Total Database Size'];?>
: <?php echo $_smarty_tpl->tpl_vars['dbsize']->value;?>
  MB </h5>
        <div class="ibox-tools">
            <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
util/dbbackup/" class="btn btn-primary btn-xs"><i class="fa fa-download"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Download Database Backup'];?>
</a>
        </div>
    </div>
    <div class="ibox-content">

        <table class="table table-bordered table-hover sys_table">
            <thead>
            <tr>
                <th width="50%"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Table Name'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Rows'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Size'];?>
</th>

            </tr>
            </thead>
            <tbody>

            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tables']->value, 'tbl');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tbl']->value) {
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['tbl']->value['name'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['tbl']->value['rows'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['tbl']->value['size'];?>
 Kb</td>

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
