<?php
/* Smarty version 3.1.30, created on 2020-02-15 19:22:32
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/statement-view.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e47f098883b80_49824452',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7a4951c9c0336dbde6bc9f802993fadde9a7907a' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/statement-view.tpl',
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
function content_5e47f098883b80_49824452 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="row">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $_smarty_tpl->tpl_vars['account']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['_L']->value['Statement'];?>
 [<?php echo date($_smarty_tpl->tpl_vars['_c']->value['df'],strtotime($_smarty_tpl->tpl_vars['fdate']->value));?>
 - <?php echo date($_smarty_tpl->tpl_vars['_c']->value['df'],strtotime($_smarty_tpl->tpl_vars['tdate']->value));?>
]</h5>

        </div>
        <div class="ibox-content">

            <table class="table table-bordered sys_table">
                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Date'];?>
</th>




                <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Description'];?>
</th>
                <th class="text-right"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Dr'];?>
</th>
                <th class="text-right"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Cr'];?>
</th>
                <th class="text-right"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Balance'];?>
</th>

                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['d']->value, 'ds');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ds']->value) {
?>
                    <tr>
                        <td><?php echo date($_smarty_tpl->tpl_vars['_c']->value['df'],strtotime($_smarty_tpl->tpl_vars['ds']->value['date']));?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['ds']->value['description'];?>
</td>


                        <td class="text-right"><?php echo $_smarty_tpl->tpl_vars['_c']->value['currency_code'];?>
 <?php echo number_format($_smarty_tpl->tpl_vars['ds']->value['dr'],2,$_smarty_tpl->tpl_vars['_c']->value['dec_point'],$_smarty_tpl->tpl_vars['_c']->value['thousands_sep']);?>
</td>
                        <td class="text-right"><?php echo $_smarty_tpl->tpl_vars['_c']->value['currency_code'];?>
 <?php echo number_format($_smarty_tpl->tpl_vars['ds']->value['cr'],2,$_smarty_tpl->tpl_vars['_c']->value['dec_point'],$_smarty_tpl->tpl_vars['_c']->value['thousands_sep']);?>
</td>
                        <td class="text-right"><span <?php if ($_smarty_tpl->tpl_vars['ds']->value['bal'] < 0) {?>class="text-red"<?php }?>><?php echo $_smarty_tpl->tpl_vars['_c']->value['currency_code'];?>
 <?php echo number_format($_smarty_tpl->tpl_vars['ds']->value['bal'],2,$_smarty_tpl->tpl_vars['_c']->value['dec_point'],$_smarty_tpl->tpl_vars['_c']->value['thousands_sep']);?>
</span></td>

                    </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>




            </table>
            <div class="row">
                <div class="col-md-8">
                    &nbsp;
                </div>
                <div class="col-md-2" style="text-align: right"> <form class="form-horizontal" method="post" action="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
export/printable" target="_blank">
                        <input type="hidden" name="fdate" value="<?php echo $_smarty_tpl->tpl_vars['fdate']->value;?>
">
                        <input type="hidden" name="tdate" value="<?php echo $_smarty_tpl->tpl_vars['tdate']->value;?>
">
                        <input type="hidden" name="stype" value="<?php echo $_smarty_tpl->tpl_vars['stype']->value;?>
">
                        <input type="hidden" name="account" value="<?php echo $_smarty_tpl->tpl_vars['account']->value;?>
">
                        <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-print"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Export for Print'];?>
</button>

                    </form></div>
                <div class="col-md-2" style="text-align: right"> <form class="form-horizontal" method="post" action="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
export/pdf">
                        <input type="hidden" name="fdate" value="<?php echo $_smarty_tpl->tpl_vars['fdate']->value;?>
">
                        <input type="hidden" name="tdate" value="<?php echo $_smarty_tpl->tpl_vars['tdate']->value;?>
">
                        <input type="hidden" name="stype" value="<?php echo $_smarty_tpl->tpl_vars['stype']->value;?>
">
                        <input type="hidden" name="account" value="<?php echo $_smarty_tpl->tpl_vars['account']->value;?>
">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Export to PDF'];?>
</button>
                    </form></div>
            </div>
        </div>
    </div>



    <!-- Widget-2 end-->
</div>
 <!-- Row end-->


<!-- Row end-->


<!-- Row end-->

<?php $_smarty_tpl->_subTemplateRender("file:sections/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
