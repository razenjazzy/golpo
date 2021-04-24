<?php
/* Smarty version 3.1.30, created on 2020-02-09 02:14:55
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/sections/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e3fb16fadc0f8_69128396',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8ad76ac36e2d647f25b4625f0df434c01802b710' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/sections/header.tpl',
      1 => 1474992670,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e3fb16fadc0f8_69128396 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tplheader']->value).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php if ($_smarty_tpl->tpl_vars['content_inner']->value != '') {?>
    <?php echo $_smarty_tpl->tpl_vars['content_inner']->value;?>

<?php }
}
}
