<?php
/* Smarty version 3.1.30, created on 2020-02-10 02:33:02
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/settings_currencies.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e41072e612f88_40085494',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e03a513ae73eb32007b6523d85b5d7a14f74b788' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/settings_currencies.tpl',
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
function content_5e41072e612f88_40085494 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="row">



    <div class="col-md-12">



        <div class="panel panel-default">
            <div class="panel-body">

                <a href="#" class="btn btn-primary" id="add_currency"><i class="fa fa-plus"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['New Currency'];?>
</a>


            </div>

        </div>
    </div>



</div>

<div class="row">



    <div class="col-md-12">



        <div class="panel panel-default">

            <div class="panel-body">



                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="bold"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Currency Code'];?>
</th>
                            <th class="bold"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Currency Symbol'];?>
</th>
                            <th class="text-center bold"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Manage'];?>
</th>
                        </tr>
                        </thead>
                        <tbody>


                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['currencies']->value, 'currency');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->value) {
?>
                            <tr data-id="<?php echo $_smarty_tpl->tpl_vars['currency']->value['id'];?>
">
                                <td> <a class="cedit" id="ae<?php echo $_smarty_tpl->tpl_vars['currency']->value['id'];?>
" href="#"><?php echo $_smarty_tpl->tpl_vars['currency']->value['cname'];?>
</a>
                                    <?php if ($_smarty_tpl->tpl_vars['_c']->value['home_currency'] == $_smarty_tpl->tpl_vars['currency']->value['cname']) {?>
                                        <br>
                                        <?php echo $_smarty_tpl->tpl_vars['_L']->value['Base Currency'];?>

                                    <?php }?>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['currency']->value['symbol'];?>
</td>
                                <td class="text-right">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
" id="be<?php echo $_smarty_tpl->tpl_vars['currency']->value['id'];?>
" class="btn btn-inverse btn-xs cedit" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['_L']->value['Edit'];?>
"><i class="fa fa-pencil"></i> </a>
                                    <?php if ($_smarty_tpl->tpl_vars['_c']->value['home_currency'] != $_smarty_tpl->tpl_vars['currency']->value['cname']) {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
settings/make_base_currency/<?php echo $_smarty_tpl->tpl_vars['currency']->value['id'];?>
/" class="btn btn-primary btn-xs" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['_L']->value['Make Base Currency'];?>
"><i class="fa fa-star"></i> </a>
                                    <?php }?>

                                    <a href="#" class="btn btn-danger btn-xs cdelete" id="c<?php echo $_smarty_tpl->tpl_vars['currency']->value['id'];?>
" data-toggle="tooltip" title="<?php echo $_smarty_tpl->tpl_vars['_L']->value['Delete'];?>
"><i class="fa fa-trash"></i> </a>
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
        </div>
    </div>



</div>

<?php $_smarty_tpl->_subTemplateRender("file:sections/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
