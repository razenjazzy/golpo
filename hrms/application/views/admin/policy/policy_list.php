<?php
/* Policy view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="row m-b-1 animated fadeInRight">

      
  <div class="col-md-4">
  <div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_policy');?> </h6>
        <div class="card-body">
          <?php $attributes = array('name' => 'add_policy', 'id' => 'xin-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/policy/add_policy', $attributes, $hidden);?>
            <div class="form-body">
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">
                <label for="company"><?php echo $this->lang->line('module_company_title');?></label>
                <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_company');?>..." name="company">
                  <option value="0"><?php echo $this->lang->line('xin_all_companies');?></option>
                  <?php foreach($all_companies as $company) {?>
                  <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="title"><?php echo $this->lang->line('xin_title');?></label>
                <input type="text" class="form-control" name="title" placeholder="<?php echo $this->lang->line('xin_title');?>">
              </div>
              <div class="form-group">
                <label for="message"><?php echo $this->lang->line('xin_description');?></label>
                <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description"></textarea>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
 <!-- </div>-->
  <div class="col-md-8">
    <div class="card">
  <h6 class="card-header"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_policies');?> </h6>
  <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
                    <thead>
                      <tr>
                        <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
                        <th><?php echo $this->lang->line('xin_title');?></th>
                        <th><?php echo $this->lang->line('module_company_title');?></th>
                        <th><?php echo $this->lang->line('xin_created_at');?></th>
                        <th><?php echo $this->lang->line('xin_added_by');?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          
  
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>