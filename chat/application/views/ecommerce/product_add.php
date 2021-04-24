<section class="section section_custom pt-1">
  <div class="section-header d-none">
    <h1><i class="fas fa-plus-circle"></i> <?php echo $page_title; ?></h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="<?php echo base_url('messenger_bot'); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a></div>
      <div class="breadcrumb-item"><a href="<?php echo base_url('ecommerce'); ?>"><?php echo $this->lang->line("E-commerce"); ?></a></div>
      <div class="breadcrumb-item"><a href="<?php echo base_url('ecommerce/product_list'); ?>"><?php echo $this->lang->line("Product");?></a></div>
      <div class="breadcrumb-item"><?php echo $this->lang->line("Add Product"); ?></div>
    </div>
  </div>

  <?php $this->load->view('admin/theme/message'); ?>

  <?php 
  $config_currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
  $config_currency_icon = isset($this->currency_icon[$config_currency]) ? $this->currency_icon[$config_currency] : "$";
  ?>

  <div class="row">
    <div class="col-12">

      <form class="form-horizontal" action="<?php echo site_url().'ecommerce/add_product_action';?>" method="POST">
        <input type="hidden" id="store_id" name="store_id" value="<?php echo $this->session->userdata("ecommerce_selected_store"); ?>">
        <div class="card no_shadow">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label for="name"> <?php echo $this->lang->line("Store")?> *</label>
                  <?php echo form_dropdown('', $store_list,$this->session->userdata("ecommerce_selected_store"),'disabled class="form-control select2"'); ?>
                  <span class="red"><?php echo form_error('store_id'); ?></span>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label for="name"> <?php echo $this->lang->line("Category")?></label>
                    <?php echo form_dropdown('category_id',$category_list,  set_value('category_id'),'class="form-control select2" id="category_id"'); ?>
                  </div>
                  <span class="red"><?php echo form_error('category_id');?></span>
              </div>
              <div class="col-6 col-md-4">
                <div class="form-group">
                  <label><?php echo $this->lang->line('Attributes'); ?></label>
                  <?php echo form_dropdown('attribute_ids[]', $attribute_list, set_value('attribute_ids'),'class="form-control select2" id="attribute_ids" multiple'); ?>
                  <span class="red"><?php echo form_error('attribute_ids'); ?></span>               
                </div>
              </div>
            </div>  

            
            <div class="row">
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label for="product_name"> <?php echo $this->lang->line("Product name")?> *</label>
                  <input name="product_name" value="<?php echo set_value('product_name');?>"  class="form-control" type="text">
                  <span class="red"><?php echo form_error('product_name'); ?></span>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="form-group">                  
                  <label for="original_price"> <?php echo $this->lang->line("Original price")?> *</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><?php echo $config_currency_icon; ?></span>
                    </div>
                    <input name="original_price" value="<?php echo set_value('original_price');?>"  class="form-control" type="text">
                  </div>                  
                  <span class="red"><?php echo form_error('original_price'); ?></span>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="form-group">                  
                  <label for="sell_price"> <?php echo $this->lang->line("Sell price")?>
                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Sell Price"); ?>" data-content="<?php echo $this->lang->line("Put offer price if it is on sale"); ?>"><i class='fa fa-info-circle'></i> </a>
                  </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><?php echo $config_currency_icon; ?></span>
                    </div>
                    <input name="sell_price" value="<?php echo set_value('sell_price');?>"  class="form-control" type="text">
                  </div>                  
                  <span class="red"><?php echo form_error('sell_price'); ?></span>
                </div>
              </div>
            </div>

            <div class="row" id="attribute_values">
              <?php echo $x_attribute_values; ?>
            </div>
          

            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label for="product_description"> <?php echo $this->lang->line("Product description")?></label>
                  <textarea name="product_description"  class="form-control visual_editor"><?php echo set_value('product_description');?></textarea>
                  <span class="red"><?php echo form_error('product_description'); ?></span>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label for="purchase_note"> <?php echo $this->lang->line("Purchase note")?></label>
                  <textarea name="purchase_note"  class="form-control visual_editor"><?php echo set_value('purchase_note');?></textarea>
                  <span class="red"><?php echo form_error('purchase_note'); ?></span>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label><?php echo $this->lang->line('Thumbnail'); ?> 
                   <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Thumbnail"); ?>" data-content="<?php echo $this->lang->line("Maximum: 1MB, Format: JPG/PNG, Preference: Square image, Recommended dimension : 500x500"); ?>"><i class='fa fa-info-circle'></i> </a>
                  </label>
                  <div id="thumb-dropzone" class="dropzone mb-1">
                    <div class="dz-default dz-message">
                      <input class="form-control" name="thumbnail" id="uploaded-file" type="hidden">
                      <span style="font-size: 20px;"><i class="fas fa-cloud-upload-alt" style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                    </div>
                  </div>
                  <span class="red"><?php echo form_error('thumbnail'); ?></span>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label><?php echo $this->lang->line('Featured  Images'); ?> 
                   <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Featured  Images"); ?>" data-content="<?php echo $this->lang->line("Upto 3 images, Maximum: 1MB each, Format: JPG/PNG, Preference: Square image, Recommended dimension : 500x500"); ?>"><i class='fa fa-info-circle'></i> </a>
                  </label>
                  <div id="feature-dropzone" class="dropzone mb-1">
                    <div class="dz-default dz-message">
                      <input class="form-control" name="featured_images" id="featured-uploaded-file" type="hidden">
                      <span style="font-size: 20px;"><i class="fas fa-cloud-upload-alt" style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                    </div>
                  </div>
                  <span class="red"><?php echo form_error('featured_images'); ?></span>
                </div>
              </div>
            </div>

            <?php 

            $checked2="checked";
            if(validation_errors())
            {
              if(set_value('status')=='1') $checked2="checked";
              else $checked2="";
            }
            $checked3="checked";
            if(validation_errors())
            {
              if(set_value('taxable')=='1') $checked3="checked";
              else $checked3="";
            }
            $checked4="";
            if(validation_errors())
            {
              if(set_value('stock_display')=='1') $checked4="checked";
              else $checked4="";
            }
            $checked5="";
            if(validation_errors())
            {
              if(set_value('stock_prevent_purchase')=='1') $checked5="checked";
              else $checked5="";
            }
            ?>

            <div class="row">             
              <div class="col-6 col-md-4">
                <div class="form-group">
                  <?php $default_stock_item =  set_value('stock_item')!='' ? set_value('stock_item') : 0; ?>
                  <label for="status" > <?php echo $this->lang->line('Item in stock');?> *</label><br>
                  <input name="stock_item" value="<?php echo $default_stock_item;?>"  class="form-control" type="number" min="0">
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="form-group">
                  <label for="stock_display"> <?php echo $this->lang->line('Display stock');?> *</label><br>
                  <label class="custom-switch mt-2">
                    <input type="checkbox" name="stock_display" value="1" class="custom-switch-input" <?php echo $checked4; ?>>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description"><?php echo $this->lang->line('Yes');?></span>
                    <span class="red"><?php echo form_error('stock_display'); ?></span>
                  </label>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="form-group">
                  <label for="stock_prevent_purchase"> <?php echo $this->lang->line('Prevent purchase if out of stock');?> *</label><br>
                  <label class="custom-switch mt-2">
                    <input type="checkbox" name="stock_prevent_purchase" value="1" class="custom-switch-input" <?php echo $checked5; ?>>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description"><?php echo $this->lang->line('Yes');?></span>
                    <span class="red"><?php echo form_error('stock_prevent_purchase'); ?></span>
                  </label>
                </div>
              </div>
            </div>


            <div class="row">             
              <div class="col-6 col-md-4">
                <div class="form-group">
                  <label for="status" > <?php echo $this->lang->line('Status');?> *</label><br>
                  <label class="custom-switch mt-2">
                    <input type="checkbox" name="status" value="1" class="custom-switch-input" <?php echo $checked2;?>>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description"><?php echo $this->lang->line('Online');?></span>
                    <span class="red"><?php echo form_error('status'); ?></span>
                  </label>
                </div>
              </div>
               <div class="col-6 col-md-4">
                <div class="form-group">
                  <label for="taxable"> <?php echo $this->lang->line('Taxable');?> *</label><br>
                  <label class="custom-switch mt-2">
                    <input type="checkbox" name="taxable" value="1" class="custom-switch-input" <?php echo $checked3; ?>>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description"><?php echo $this->lang->line('Yes');?></span>
                    <span class="red"><?php echo form_error('taxable'); ?></span>
                  </label>
                </div>
              </div>
            </div>           


          </div>

          <div class="card-footer p-0" style="margin-bottom: 200px">
            <button name="submit" type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> <?php echo $this->lang->line("Save");?></button>
            <button  type="button" class="btn btn-secondary btn-lg float-right" onclick='goBack("ecommerce/product_list",0)'><i class="fa fa-remove"></i> <?php echo $this->lang->line("Cancel");?></button>
          </div>
        </div>
      </form>  
    </div>
  </div>
</section>

<?php include(APPPATH.'views/ecommerce/product_js.php'); ?>

<style type="text/css">
  .dropzone{min-height: 150px !important;}
  .dropzone .dz-message{margin:2em !important;}
</style>

<?php include(APPPATH.'views/ecommerce/editor_js.php'); ?>

<script>
  $(document).ready(function() {
    $('#attribute_ids').on('select2:select', function (e) {
      var id = e.params.data.id;
      $.ajax({
        context: this,
        type:'POST',
        // dataType:'JSON',
        url:"<?php echo site_url();?>ecommerce/get_attribute_values",
        data:{id:id},
        success:function(response){
          $("#attribute_values").append(response);
        }
      });
    });

    $('#attribute_ids').on('select2:unselect', function (e) {
      var id = e.params.data.id;
      $("#attribute_values_"+id).remove();
    });
  });
</script>
<style type="text/css">

  .card .card-header {
    line-height: 30px;
    min-height: 0px; 
    padding: 5px 25px;
  }
  .card .card-header h4{
    font-size: 13px;
  }
  .attribute_values_body{
    padding-bottom: 0px;
  }
</style>