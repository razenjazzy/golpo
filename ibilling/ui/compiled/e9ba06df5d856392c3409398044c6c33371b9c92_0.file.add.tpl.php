<?php
/* Smarty version 3.1.30, created on 2020-10-17 01:33:50
  from "/home4/dccket/public_html/ibilling/application/plugins/notes/views/add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f89f59ecb9486_27292140',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9ba06df5d856392c3409398044c6c33371b9c92' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/application/plugins/notes/views/add.tpl',
      1 => 1474992670,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f89f59ecb9486_27292140 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="row">

    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-body">

                <form class="form-horizontal" action="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
notes/init/add_post/" method="post">

                    <div class="form-group"><label class="col-lg-2 control-label">Title </label>

                        <div class="col-lg-10"><input type="text" name="title" class="form-control">

                        </div>
                    </div>


                    <div class="form-group"><label class="col-lg-2 control-label">Contents </label>

                        <div class="col-lg-10">

                            <textarea class="form-control" name="contents" rows="15"></textarea>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-primary" type="submit" id="submit"><i
                                        class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Submit'];?>
</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


</div><?php }
}
