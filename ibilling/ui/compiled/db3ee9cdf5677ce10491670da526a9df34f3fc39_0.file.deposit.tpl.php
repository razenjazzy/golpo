<?php
/* Smarty version 3.1.30, created on 2020-02-10 02:40:42
  from "/home4/dccket/public_html/ibilling/ui/theme/ibilling/deposit.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5e4108fa154db6_47952899',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db3ee9cdf5677ce10491670da526a9df34f3fc39' => 
    array (
      0 => '/home4/dccket/public_html/ibilling/ui/theme/ibilling/deposit.tpl',
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
function content_5e4108fa154db6_47952899 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sections/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="row">
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $_smarty_tpl->tpl_vars['_L']->value['Add Deposit'];?>
</h5>

        </div>
        <div class="ibox-content" id="ibox_form">
            <div class="alert alert-danger" id="emsg">
                <span id="emsgbody"></span>
            </div>
            <form class="form-horizontal" method="post" id="tform" role="form">
                <div class="form-group">
                    <label for="account" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Account'];?>
</label>
                    <div class="col-sm-9">
                        <select id="account" name="account" class="form-control">
                            <option value=""><?php echo $_smarty_tpl->tpl_vars['_L']->value['Choose an Account'];?>
</option>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['d']->value, 'ds');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ds']->value) {
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['ds']->value['account'];?>
"><?php echo $_smarty_tpl->tpl_vars['ds']->value['account'];?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>



                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="date" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Date'];?>
</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  value="<?php echo $_smarty_tpl->tpl_vars['mdate']->value;?>
" name="date" id="date" datepicker data-date-format="yyyy-mm-dd" data-auto-close="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Description'];?>
</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="description" name="description">
                        <div class="help-block"><a data-toggle="modal" href="#modal_add_item"><i class="fa fa-paperclip"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Attach File'];?>
</a> </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="amount" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Amount'];?>
</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control amount" id="amount" name="amount">
                    </div>
                </div>






                <div class="form-group">
                    <div class="col-sm-3">
                        &nbsp;
                    </div>
                    <div class="col-sm-9">
                        <h4><a href="#" id="a_toggle"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Advanced'];?>
</a> </h4>
                    </div>
                </div>
                <div id="a_hide" class="form-horizontal" >
                    <div class="form-group">
                        <label for="cats" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Category'];?>
</label>
                        <div class="col-sm-9">
                            <select id="cats" name="cats" class="form-control">
                                <option value="Uncategorized"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Uncategorized'];?>
</option>

                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cats']->value, 'cat');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>



                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tags" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Tags'];?>
</label>
                        <div class="col-sm-9">
                            <select name="tags[]" id="tags"  class="form-control" multiple="multiple">
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
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Payer'];?>
</label>
                        <div class="col-sm-9">
                            <select id="payer" name="payer" class="form-control">
                                <option value=""><?php echo $_smarty_tpl->tpl_vars['_L']->value['Choose Contact'];?>
</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['p']->value, 'ps');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ps']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['ps']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['ps']->value['account'];?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>



                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Method'];?>
</label>
                        <div class="col-sm-9">
                            <select id="pmethod" name="pmethod" class="form-control">
                                <option value=""><?php echo $_smarty_tpl->tpl_vars['_L']->value['Select Payment Method'];?>
</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pms']->value, 'pm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['pm']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['pm']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['pm']->value['name'];?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>



                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ref" class="col-sm-3 control-label"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Ref'];?>
#</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ref" name="ref">
                            <span class="help-block"><?php echo $_smarty_tpl->tpl_vars['_L']->value['ref_example'];?>
</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input type="hidden" name="attachments" id="attachments" value="">
                        <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['_L']->value['Submit'];?>
</button>
                    </div>
                </div>
            </form>

        </div>
    </div>




</div>

<div class="col-lg-8 col-md-6 col-sm-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $_smarty_tpl->tpl_vars['_L']->value['Recent Deposits'];?>
</h5>

        </div>
        <div class="ibox-content">

            <table class="table table-bordered sys_table">
                <thead>
                <tr>
                    <th width="80%"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Description'];?>
</th>
                    <th><?php echo $_smarty_tpl->tpl_vars['_L']->value['Amount'];?>
</th>

                </tr>
                </thead>
                <tbody>

                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tr']->value, 'trs');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['trs']->value) {
?>
                    <tr>
                        <td><a href="<?php echo $_smarty_tpl->tpl_vars['_url']->value;?>
transactions/manage/<?php echo $_smarty_tpl->tpl_vars['trs']->value['id'];?>
/">
                                <?php if ($_smarty_tpl->tpl_vars['trs']->value['attachments'] != '') {?>
                                    <i class="fa fa-paperclip"></i>
                                <?php }?>
                                <?php echo $_smarty_tpl->tpl_vars['trs']->value['description'];?>




                            </a> </td>
                        <td class="amount"><?php echo $_smarty_tpl->tpl_vars['trs']->value['amount'];?>
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


<input type="hidden" id="_lan_no_results_found" value="<?php echo $_smarty_tpl->tpl_vars['_L']->value['No results found'];?>
">

<div id="modal_add_item" class="modal fade" tabindex="-1" data-width="600" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Attach File'];?>
</h4>
    </div>
    <div class="modal-body">
        <div class="row">



            <div class="col-md-12">
                <form action="" class="dropzone" id="upload_container">

                    <div class="dz-message">
                        <h3> <i class="fa fa-cloud-upload"></i>  <?php echo $_smarty_tpl->tpl_vars['_L']->value['Drop File Here'];?>
</h3>
                        <br />
                        <span class="note"><?php echo $_smarty_tpl->tpl_vars['_L']->value['Click to Upload'];?>
</span>
                    </div>

                </form>


            </div>




        </div>
    </div>
    <div class="modal-footer">

        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>

    </div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:sections/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
