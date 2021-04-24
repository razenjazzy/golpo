<?php
/* Smarty version 3.1.30, created on 2020-02-15 15:30:48
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/list-recurring-invoices.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e47ba48249479_13658651',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7b583713b8a80270a4d0b8ae2a068e646a38e30a' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/list-recurring-invoices.tpl',
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
function content_5e47ba48249479_13658651 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo $_smarty_tpl->tpl_vars['_L']->value['List Invoices'];?>
 </h5>
        <div class="ibox-tools">
            <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
invoices/add/recurring/" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Add Recurring Invoice'];?>
</a>
        </div>
    </div>
    <div class="ibox-content">

        <table class="table table-bordered table-hover sys_table">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Account'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Amount'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Invoice'];?>
 <?php echo $_smarty_tpl->tpl_vars['_L']->value['Date'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Due'];?>
 <?php echo $_smarty_tpl->tpl_vars['_L']->value['Date'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Next Invoice'];?>
</th>
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Status'];?>
</th>
                <th class="text-right"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Manage'];?>
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
                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
invoices/view/<?php echo $_smarty_tpl->tpl_vars['ds']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['ds']->value['id'];?>
</a></td>
                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
contacts/view/<?php echo $_smarty_tpl->tpl_vars['ds']->value['userid'];?>
"><?php echo $_smarty_tpl->tpl_vars['ds']->value['account'];?>
</a> </td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ds']->value['total'];?>
</td>
                    <td><?php echo date($_smarty_tpl->tpl_vars['_c']->value['df'],strtotime($_smarty_tpl->tpl_vars['ds']->value['date']));?>
</td>
                    <td><?php echo date($_smarty_tpl->tpl_vars['_c']->value['df'],strtotime($_smarty_tpl->tpl_vars['ds']->value['duedate']));?>
</td>
                    <td><?php echo date($_smarty_tpl->tpl_vars['_c']->value['df'],strtotime($_smarty_tpl->tpl_vars['ds']->value['nd']));?>
</td>
                    <td> <?php if ($_smarty_tpl->tpl_vars['ds']->value['status'] == 'Unpaid') {?>
                            <span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Unpaid'];?>
</span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['ds']->value['status'] == 'Paid') {?>
                            <span class="label label-success"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Paid'];?>
</span>
                        <?php } elseif ($_smarty_tpl->tpl_vars['ds']->value['status'] == 'Cancelled') {?>
                            <span class="label label-default"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Cancelled'];?>
</span>
                        <?php } else { ?>
                            <span class="label label-info"><?php echo $_smarty_tpl->tpl_vars['ds']->value['status'];?>
</span>
                        <?php }?></td>
                    <td class="text-right">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
invoices/view/<?php echo $_smarty_tpl->tpl_vars['ds']->value['id'];?>
" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['View'];?>
</a>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
invoices/edit/<?php echo $_smarty_tpl->tpl_vars['ds']->value['id'];?>
" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Edit'];?>
</a>
                        <a href="#" class="btn btn-warning btn-xs cstop" id="sid<?php echo $_smarty_tpl->tpl_vars['ds']->value['id'];?>
"><i class="fa fa-stop"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Stop Recurring'];?>
</a>
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
