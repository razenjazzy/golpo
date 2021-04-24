<section class="section mt-2">
  <div class="section-header p-0 no_shadow bg-light mb-0">
      <?php 
      $currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
      $currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : "$";
      $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
      $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
      $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
      $buy_button_title = isset($ecommerce_config['buy_button_title']) ? $ecommerce_config['buy_button_title'] : $this->lang->line("Buy Now");
      $currency_left = $currency_right = "";
      if($currency_position=='left') $currency_left = $currency_icon;
      if($currency_position=='right') $currency_right = $currency_icon;

      $form_action = base_url('ecommerce/store/'.$store_data['store_unique_id']);
      $subscriber_id=$this->session->userdata($store_data['id']."ecom_session_subscriber_id");
      if($subscriber_id=="")  $subscriber_id = isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : "";
      if($subscriber_id!="") $form_action .= "?subscriber_id=".$subscriber_id;

      $current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
      $cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
      $current_cart_url = base_url("ecommerce/cart/".$current_cart_id); 
      if($subscriber_id!="") $current_cart_url .= "?subscriber_id=".$subscriber_id;

      ?>
      <form class='m-0 mt-2 w-100 search_form'>
        <div class="input-group">
          <?php
          $url_cat =  isset($_GET["category"]) ? $_GET["category"] : "";
          ?>
          <input type="text" onkeyup="search_product(this,'product-container')"  class="form-control" name="search" id="search" value= "<?php echo $this->session->userdata('search_search');?>" 
          placeholder="<?php echo $this->lang->line("Search"); ?>">
        </div>    

      </form>
  </div>

  <div class="section-body">
    <div class="category_container xscroll">
      <?php 
      $active_class = $url_cat=='' ? 'bg-primary text-white' : '';
      echo '<div class="slide"><a class="pointer cat_nav nav-link '.$active_class.'" href="" data-val="">'.$this->lang->line("Any Category").'</a></div>';
      unset($category_list['']);

      foreach ($category_list as $key => $value)
      {
        $active_class2 = ($key==$url_cat) ? 'bg-primary text-white' : '';
        echo '<div class="slide"><a class="pointer cat_nav nav-link '.$active_class2.'" href="" data-val="'.$key.'">'.$value.'</a></div>';
      } ?>
      
    </div>
    <?php
    if(empty($product_list))
    { ?>
      <div class="card no_shadow" id="nodata">
        <div class="card-body">
          <div class="empty-state">
            <img class="img-fluid" style="height: 200px" src="<?php echo base_url('assets/img/drawkit/drawkit-full-stack-man-colour.svg'); ?>" alt="image">
             <h2 class="mt-0"><?php echo $this->lang->line("We could not find any item.");?></h2>
             <?php if($_POST) { ?>
             <a href="<?php echo $_SERVER['QUERY_STRING'] ? current_url().'?'.$_SERVER['QUERY_STRING'] : current_url(); ?>" class="btn btn-outline-primary mt-4"><i class="fas fa-arrow-circle-right"></i> <?php echo $this->lang->line("Search Again");?></a>
             <?php } ?>
          </div>
        </div>
      </div>
    <?php
    }?>
    <div class="row" id="product-container">
      <?php
      foreach ($product_list as $key => $value) 
      {  
        $product_link = base_url("ecommerce/product/".$value['id']); 
        if($subscriber_id!="") $product_link .= "?subscriber_id=".$subscriber_id;
        ?>

        <div class="col-12 col-sm-12 col-md-6 col-lg-4 product-single" data-cat="<?php echo $value['category_id'];?>">
          <ul class="list-unstyled list-unstyled-border bg-white mb-1 mt-2 rounded bordered">
              <li class="media align-items-center">
               <a href="<?php echo $product_link;?>"><img width="110" height="110" class="mr-2 rounded-left bordered-right" src="<?php echo ($value['thumbnail']!='') ? base_url('upload/ecommerce/'.$value['thumbnail']) : base_url('assets/img/products/product-1.jpg'); ?>"/>
               </a>
                <?php echo mec_display_price($value['original_price'],$value['sell_price'],$currency_icon,'4',$currency_position,$decimal_point,$thousand_comma); ?> 
                <div class="media-body pl-0 pr-2">
                  <div class="media-title mb-1">
                    <a href="<?php echo $product_link;?>" class="text-dark text-small"><?php echo $value['product_name'];?></a><br>
                    <span class="mt-1 text-small"><?php echo mec_display_price($value['original_price'],$value['sell_price'],$currency_icon,'1',$currency_position,$decimal_point,$thousand_comma);?></span>
                    <?php 
                    if($this->ecommerce_review_comment_exist && isset($review_data[$value['id']])) : 
                      $rating = mec_average_rating($review_data[$value['id']]['total_point'],$review_data[$value['id']]['total_review']);
                      $review_star = mec_display_rating_starts($rating,'text-small');
                      echo '<span class="float-right">'.$review_star.'</span>';
                    endif; ?>                   
                  </div>
                  <p class="text-small text-muted m-0 mb-1" style="line-height: normal !important"><?php echo strlen(strip_tags($value['product_description']))>30?substr(strip_tags($value['product_description']), 0, 30).'...':strip_tags($value['product_description']); ?></p>
                  <p class="d-none"><?php echo strip_tags($value['product_description']); ?></p>
                  <p class="d-none"><?php echo isset($category_list[$value['category_id']]) ? $category_list[$value['category_id']] : ''; ?></p>
                  <?php if($value['attribute_ids']=='') 
                  {
                    $cart_lang = $cart_count>0 ? $this->lang->line("Add to Cart") : $this->lang->line("Cart");
                    ?>
                    <a href="" class="btn  btn-sm btn-outline-primary add_to_cart" data-attributes="<?php echo $value['attribute_ids'];?>" data-product-id="<?php echo $value['id'];?>" data-action='add'><i class="fas fa-plus-circle"></i> <?php echo $cart_lang; ?></a>
                  <?php 
                  } 
                  else 
                  { ?>
                    <a href="<?php echo $product_link;?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-palette"></i> <?php echo $this->lang->line("Choose Options"); ?></a>
                  <?php 
                  } ?>

                  <?php 
                  if($cart_count==0 && $value['attribute_ids']=='') 
                  {?>
                    <a href="" class="btn btn-sm btn-primary add_to_cart buy_now" data-attributes="<?php echo $value['attribute_ids'];?>" data-product-id="<?php echo $value['id'];?>" data-action='add'><i class="fas fa-credit-card"></i> <?php echo $this->lang->line($buy_button_title); ?></a>
                  <?php 
                  }?>

                </div>
              </li>                
           </ul>
        </div>
      <?php
      } ?>       
    </div>
    <div class="card no_shadow d-none w-100" id="nodata_search">
      <div class="card-body">
        <div class="empty-state">
          <img class="img-fluid" style="height: 200px" src="<?php echo base_url('assets/img/drawkit/drawkit-full-stack-man-colour.svg'); ?>" alt="image">
           <h2 class="mt-0"><?php echo $this->lang->line("We could not find any item.");?></h2>
           <?php if($_POST) { ?>
           <a href="<?php echo $_SERVER['QUERY_STRING'] ? current_url().'?'.$_SERVER['QUERY_STRING'] : current_url(); ?>" class="btn btn-outline-primary mt-4"><i class="fas fa-arrow-circle-right"></i> <?php echo $this->lang->line("Search Again");?></a>
           <?php } ?>
        </div>
      </div>
    </div> 
  </div>

</section>

<script> 
  var url_cat =  '<?php echo $url_cat;?>';
  $("document").ready(function()  {
    if(url_cat!="" )setTimeout(function(){ $(".cat_nav[data-val="+url_cat+"]").click(); }, 500);
    $(document).on('click','.cat_nav',function(e){
      e.preventDefault();
      $('.cat_nav').removeClass('bg-primary');
      $('.cat_nav').removeClass('text-white');
      $(this).addClass('bg-primary');
      $(this).addClass('text-white');
      var cat = $(this).attr('data-val');
      if(cat=='0' || cat=='') $('.product-single').removeClass('d-none');
      else
      {
        $('.product-single').addClass('d-none');
        $('.product-single[data-cat='+cat+']').removeClass('d-none');
      }
      var count = $('.product-single:visible').length;
      if(count==0) $("#nodata_search").removeClass('d-none');
      else $("#nodata_search").addClass('d-none');
    });
  });

  function search_product(obj,div_id){  // obj = 'this' of jquery, div_id = id of the div 
    var filter=$(obj).val().toUpperCase();
    $('#'+div_id+" .col-12").each(function(){
      var content=$(this).text().trim();
      if (content.toUpperCase().indexOf(filter) > -1) {
        $(this).removeClass('d-none');
      }
      else $(this).addClass('d-none');
    });
    var count = $('.product-single:visible').length;
    if(count==0) $("#nodata_search").removeClass('d-none');
    else $("#nodata_search").addClass('d-none');

  }
</script>

<style type="text/css">
  .nav-link{padding: 5px 10px;margin: 5px 0 5px 0;border:.5px solid #e4e6fc;border-radius: 10px !important;margin-right: 5px;white-space: nowrap;}
  .category_container {
    display: inline-flex;
    width: 100%;
    overflow-y: auto;
  }
  .category_container .slide {float: left;}
  .rounded{border-radius: 10px  !important;}
  .rounded-left{border-radius: 10px 0 0 10px  !important;}
</style>



<?php include(APPPATH."views/ecommerce/cart_js.php"); ?>
<?php include(APPPATH."views/ecommerce/cart_style.php"); ?>
<?php include(APPPATH."views/ecommerce/common_style.php"); ?>