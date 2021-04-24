<?php
/* Smarty version 3.1.30, created on 2020-02-10 13:51:57
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/account-profile-alt.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e410b9dec7443_24434707',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd87d39c477569b670ce7dcd786f6ba1f83360663' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/account-profile-alt.tpl',
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
function content_5e410b9dec7443_24434707 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="row">
    <div class="col-md-12 m-t-md">
        <div class="alert alert-danger" id="emsg">
            <span id="emsgbody"></span>
        </div>
    </div>
</div>
<div class="row">
<div class="col-md-3 ib_profile_width">

    <div class="panel panel-default" id="ibox_panel">

            <div class="panel-body">
                <div class="thumb-info mb-md">
                    <?php if ($_smarty_tpl->tpl_vars['d']->value['img'] == 'gravatar') {?>
                        <img src="http://www.gravatar.com/avatar/<?php echo md5(($_smarty_tpl->tpl_vars['d']->value['email']));?>
?s=400" class="img-thumbnail img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['d']->value['fname'];?>
 <?php echo $_smarty_tpl->tpl_vars['d']->value['lname'];?>
">
                    <?php } elseif ($_smarty_tpl->tpl_vars['d']->value['img'] == '') {?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['app_url']->value;?>
application/storage/system/profile-icon.png" class="img-thumbnail img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['d']->value['fname'];?>
 <?php echo $_smarty_tpl->tpl_vars['d']->value['lname'];?>
">
                    <?php } else { ?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['d']->value['img'];?>
" class="img-thumbnail img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['d']->value['account'];?>
">
                    <?php }?>
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner"><?php echo $_smarty_tpl->tpl_vars['d']->value['account'];?>
</span>

                    </div>
                </div>





                <?php if ($_smarty_tpl->tpl_vars['d']->value['email'] != '') {?>
                    <h5 class="text-muted"><?php echo $_smarty_tpl->tpl_vars['d']->value['email'];?>
</h5>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['d']->value['phone'] != '') {?>
                    <h5 class="text-muted"><?php echo $_smarty_tpl->tpl_vars['d']->value['phone'];?>
</h5>
                <?php }?>







            </div>

        <div class="panel-body list-group border-bottom m-t-n-lg">
            <a href="#" id="summary" class="list-group-item active"><span class="fa fa-bar-chart-o"></span> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Summary'];?>
 </a>
            <a href="#" id="activity" class="list-group-item"><span class="fa fa-tasks"></span> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Activity'];?>
</a>
            <a href="#" id="invoices" class="list-group-item"><span class="fa fa-credit-card"></span> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Invoices'];?>
<span class="label label-info pull-right"><?php echo $_smarty_tpl->tpl_vars['inv_count']->value;?>
</span></a>
            <a href="#" id="transactions" class="list-group-item"><span class="fa fa-th-list"></span> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Transactions'];?>
</a>
            <a href="#" id="email" class="list-group-item"><span class="fa fa-envelope-o"></span> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Email'];?>
</a>
            <?php echo $_smarty_tpl->tpl_vars['extra_tab']->value;?>

            <a href="#" id="edit" class="list-group-item"><span class="fa fa-pencil"></span> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Edit'];?>
</a>
            <a href="#" id="more" class="list-group-item"><span class="fa fa-bars"></span> <?php echo $_smarty_tpl->tpl_vars['_L']->value['More'];?>
</a>
        </div>

        <div class="panel-body">






            <h5 class="text-muted"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Contact Notes'];?>
</h5>

            <textarea class="form-control" id="notes" rows="6"><?php echo $_smarty_tpl->tpl_vars['d']->value['notes'];?>
</textarea>
            <input type="hidden" id="cid" value="<?php echo $_smarty_tpl->tpl_vars['d']->value['id'];?>
">
            <button type="button" id="note_update" class="btn btn-primary btn-block mt-sm"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Save'];?>
</button>




        </div>

    </div>

</div>

<div class="col-md-9">

    <!-- START TIMELINE -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $_smarty_tpl->tpl_vars['d']->value['account'];?>
</h5>
        </div>

        <div class="ibox-content" id="ibox_form">
            
            
           <div id="application_ajaxrender" style="min-height: 200px;">

           </div>

        </div>
    </div>
    <!-- END TIMELINE -->

</div>

</div>
<input type="hidden" id="_lan_are_you_sure" value="<?php echo $_smarty_tpl->tpl_vars['_L']->value['are_you_sure'];?>
">
<input type="hidden" id="_active_tab" value="<?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
">
<?php $_smarty_tpl->_subTemplateRender("file:sections/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
