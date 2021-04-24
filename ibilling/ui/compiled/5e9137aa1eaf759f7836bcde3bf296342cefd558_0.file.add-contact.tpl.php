<?php
/* Smarty version 3.1.30, created on 2020-02-10 02:29:41
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/add-contact.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e410665f3b2b4_85881775',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e9137aa1eaf759f7836bcde3bf296342cefd558' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/add-contact.tpl',
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
function content_5e410665f3b2b4_85881775 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="wrapper wrapper-content">
<div class="row">

    <div class="col-md-12">



        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo $_smarty_tpl->tpl_vars['_L']->value['Add Contact'];?>
</h5>

                <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
contacts/import_csv/" class="btn btn-xs btn-primary btn-rounded pull-right"><i class="fa fa-bars"></i> Import Contacts</a>

            </div>
            <div class="ibox-content" id="ibox_form">
                <div class="alert alert-danger" id="emsg">
                    <span id="emsgbody"></span>
                </div>

                <form class="form-horizontal" id="rform">

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group"><label class="col-md-4 control-label" for="account"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Full Name'];?>
<small class="red">*</small> </label>

                                <div class="col-lg-8"><input type="text" id="account" name="account" class="form-control" autofocus>

                                </div>
                            </div>

                            <div class="form-group"><label class="col-md-4 control-label" for="company"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Company Name'];?>
</label>

                                <div class="col-lg-8"><input type="text" id="company" name="company" class="form-control">

                                </div>
                            </div>

                            <div class="form-group"><label class="col-md-4 control-label" for="email"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Email'];?>
</label>

                                <div class="col-lg-8"><input type="text" id="email" name="email" class="form-control">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-md-4 control-label" for="phone"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Phone'];?>
</label>

                                <div class="col-lg-8"><input type="text" id="phone" name="phone" class="form-control">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-md-4 control-label" for="address"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Address'];?>
</label>

                                <div class="col-lg-8"><input type="text" id="address" name="address" class="form-control">

                                </div>
                            </div>


                            <div class="form-group"><label class="col-md-4 control-label" for="city"><?php echo $_smarty_tpl->tpl_vars['_L']->value['City'];?>
</label>

                                <div class="col-lg-8"><input type="text" id="city" name="city" class="form-control">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-md-4 control-label" for="state"><?php echo $_smarty_tpl->tpl_vars['_L']->value['State Region'];?>
</label>

                                <div class="col-lg-8"><input type="text" id="state" name="state" class="form-control">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-md-4 control-label" for="zip"><?php echo $_smarty_tpl->tpl_vars['_L']->value['ZIP Postal Code'];?>
 </label>

                                <div class="col-lg-8"><input type="text" id="zip" name="zip" class="form-control">

                                </div>
                            </div>
                            <div class="form-group"><label class="col-md-4 control-label" for="country"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Country'];?>
</label>

                                <div class="col-lg-8">

                                    <select name="country" id="country" class="form-control">
                                        <option value=""><?php echo $_smarty_tpl->tpl_vars['_L']->value['Select Country'];?>
</option>
                                        <?php echo $_smarty_tpl->tpl_vars['countries']->value;?>

                                    </select>

                                </div>
                            </div>

                            

                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fs']->value, 'f');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['f']->value) {
?>
                                <div class="form-group"><label class="col-md-4 control-label" for="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['f']->value['fieldname'];?>
</label>
                                    <?php if (($_smarty_tpl->tpl_vars['f']->value['fieldtype']) == 'text') {?>


                                        <div class="col-lg-8">
                                            <input type="text" id="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
" name="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
" class="form-control">
                                            <?php if (($_smarty_tpl->tpl_vars['f']->value['description']) != '') {?>
                                                <span class="help-block"><?php echo $_smarty_tpl->tpl_vars['f']->value['description'];?>
</span>
                                            <?php }?>

                                        </div>

                                    <?php } elseif (($_smarty_tpl->tpl_vars['f']->value['fieldtype']) == 'password') {?>

                                        <div class="col-lg-8">
                                            <input type="password" id="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
" name="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
" class="form-control">
                                            <?php if (($_smarty_tpl->tpl_vars['f']->value['description']) != '') {?>
                                                <span class="help-block"><?php echo $_smarty_tpl->tpl_vars['f']->value['description'];?>
</span>
                                            <?php }?>
                                        </div>

                                    <?php } elseif (($_smarty_tpl->tpl_vars['f']->value['fieldtype']) == 'dropdown') {?>
                                        <div class="col-lg-8">
                                            <select id="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
" name="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
" class="form-control">
                                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, explode(',',$_smarty_tpl->tpl_vars['f']->value['fieldoptions']), 'fo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['fo']->value) {
?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['fo']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['fo']->value;?>
</option>
                                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                            </select>
                                            <?php if (($_smarty_tpl->tpl_vars['f']->value['description']) != '') {?>
                                                <span class="help-block"><?php echo $_smarty_tpl->tpl_vars['f']->value['description'];?>
</span>
                                            <?php }?>
                                        </div>


                                    <?php } elseif (($_smarty_tpl->tpl_vars['f']->value['fieldtype']) == 'textarea') {?>

                                        <div class="col-lg-8">
                                            <textarea id="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
" name="cf<?php echo $_smarty_tpl->tpl_vars['f']->value['id'];?>
" class="form-control" rows="3"></textarea>
                                            <?php if (($_smarty_tpl->tpl_vars['f']->value['description']) != '') {?>
                                                <span class="help-block"><?php echo $_smarty_tpl->tpl_vars['f']->value['description'];?>
</span>
                                            <?php }?>
                                        </div>

                                    <?php } else { ?>
                                    <?php }?>
                                </div>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


                            <div class="form-group"><label class="col-md-4 control-label" for="tags"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Tags'];?>
</label>

                                <div class="col-lg-8">
                                    
                                    <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tags']->value, 'tag');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->value) {
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['tag']->value['text'];?>
"><?php echo $_smarty_tpl->tpl_vars['tag']->value['text'];?>
</option>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">


                            <div class="form-group"><label class="col-md-4 control-label" for="currency"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Currency'];?>
</label>

                                <div class="col-lg-8">
                                    <select id="currency" name="currency" class="form-control">

                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['currencies']->value, 'currency');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->value) {
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['currency']->value['id'];?>
"
                                                    <?php if ($_smarty_tpl->tpl_vars['_c']->value['home_currency'] == ($_smarty_tpl->tpl_vars['currency']->value['cname'])) {?>selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['currency']->value['cname'];?>
</option>
                                            <?php
}
} else {
?>

                                            <option value="0"><?php echo $_smarty_tpl->tpl_vars['_c']->value['home_currency'];?>
</option>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-md-4 control-label" for="group"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Group'];?>
</label>

                                <div class="col-lg-8">
                                    <select class="form-control" name="group" id="group">
                                        <option value="0"><?php echo $_smarty_tpl->tpl_vars['_L']->value['None'];?>
</option>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['gs']->value, 'g');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['g']->value) {
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['g']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['g_selected_id']->value == ($_smarty_tpl->tpl_vars['g']->value['id'])) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['g']->value['gname'];?>
</option>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                    </select>
                                    <span class="help-block"><a href="#" id="add_new_group"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Add New Group'];?>
</a> </span>
                                </div>
                            </div>


                            <div class="form-group"><label class="col-md-4 control-label" for="password"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Password'];?>
</label>

                                <div class="col-lg-8"><input type="password" id="password" name="password" class="form-control">

                                </div>
                            </div>

                            <div class="form-group"><label class="col-md-4 control-label" for="cpassword"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Confirm Password'];?>
</label>

                                <div class="col-lg-8"><input type="password" id="cpassword" name="cpassword" class="form-control">

                                </div>
                            </div>


                            <div class="form-group"><label class="col-md-4 control-label" for="send_client_signup_email"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Welcome Email'];?>
</label>

                                <div class="col-lg-8">


                                    <input type="checkbox" checked data-toggle="toggle" data-size="small" data-on="<?php echo $_smarty_tpl->tpl_vars['_L']->value['Yes'];?>
" data-off="<?php echo $_smarty_tpl->tpl_vars['_L']->value['No'];?>
" id="send_client_signup_email" name="send_client_signup_email" value="Yes">


                                    <span class="help-block"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Send Client Signup Email'];?>
</span>

                                </div>
                            </div>



                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-lg-10">

                                    <button class="md-btn md-btn-primary waves-effect waves-light" type="submit" id="submit"><i class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Save'];?>
</button> | <a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
contacts/list/"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Or Cancel'];?>
</a>


                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


</div>

<input type="hidden" name="_msg_add_new_group" id="_msg_add_new_group" value="<?php echo $_smarty_tpl->tpl_vars['_L']->value['Add New Group'];?>
">
<input type="hidden" name="_msg_group_name" id="_msg_group_name" value="<?php echo $_smarty_tpl->tpl_vars['_L']->value['Group Name'];?>
">

<?php $_smarty_tpl->_subTemplateRender("file:sections/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
