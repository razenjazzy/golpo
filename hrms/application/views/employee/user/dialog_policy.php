<?php
if(isset($_GET['jd']) && isset($_GET['p']) && $_GET['data']=='policy' && $_GET['type']=='policy'){
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_company_policy');?></h4>
</div>
  <div class="modal-body">
      <div class="form-group">
        <div id="accordion" role="tablist" aria-multiselectable="true">
        <?php foreach($this->Xin_model->all_policies() as $_policy):?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $_policy->policy_id;?>" aria-expanded="true" aria-controls="collapseOne">
                         <?php
						 if($_policy->company_id==0){
							 $cname = $this->lang->line('xin_all_companies');
						 } else {
							$company = $this->Xin_model->read_company_info($_policy->company_id);
							$cname = $company[0]->name;
						 }
						 ?>
                            <?php echo $_policy->title;?> (<?php echo $cname;?>)
                        </a>
                    </h4>
                </div>
                <div id="collapse<?php echo $_policy->policy_id;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                   <?php echo html_entity_decode($_policy->description);?>
                </div>
            </div>
           <?php endforeach;?> 
        </div>
      </div>
    </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php }
?>