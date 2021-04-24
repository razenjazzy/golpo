<select name="ids" class="cd-select ig-dm-select" data-select-account="<?php _e("Select an account")?>"  data-keyword-search="<?php _e("Enter keyword")?>">
    <option value="" selected><?php _e("Select your account")?></option>
    <?php if(!empty($result)){ ?>
        <?php foreach ($result as $key => $row) { ?>
        <option value="<?php _e( $row->ids )?>" data-url="<?php _e( get_module_url("index/".$row->ids) )?>" <?php _e( $row->ids == segment(3)?"selected":"" )?> data-img="<?php _e(BASE.$row->avatar)?>"> <?php _e($row->username)?></option>
        <?php }?>
    <?php }?>   
</select>

<div class="input-group box-search-one">
  	<input class="form-control search-input" type="text" autocomplete="off" placeholder="<?php _e('Search')?>">
  	<span class="input-group-append">
	    <button class="btn" type="button">
	        <i class="fa fa-search"></i>
	    </button>
	</span>
</div>

<div class="widget">
	
	<div class="widget-list search-list ig-dm-list">
		<?php _e( $list, false )?>
	</div>

</div>