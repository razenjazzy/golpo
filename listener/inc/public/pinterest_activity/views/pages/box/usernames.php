<div class="tab-pane fade" id="v-pills-username" role="tabpanel" aria-labelledby="v-pills-username-tab">
	
	<div class="row m-b-25">
		<div class="col-md-12">
			<div class="ig-ac-option">
				<div class="info">
					<div class="input-group box-search-one">
					  	<input class="form-control form-search-username" type="text" value="" autocomplete="off" placeholder="<?php _e("Enter keyword")?>" data-action="<?php _e( get_module_url("search/username/".segment(4)) )?>" data-result="html" data-content="result-search-username">
					  	<span class="input-group-append">
						    <button class="btn" type="button">
						        <i class="fa fa-search"></i>
						    </button>
						</span>
					</div>

					<div class="result-search-username"></div>
				</div>
			</div>
		</div>
	</div>	

	<div class="m-b-0 list-add-username">

		<div class="ig-ac-option-title text-info fs-18 m-b-25 wrap-m">
			<div class="wrap-c"><i class="fas fa-user p-r-5"></i> <?php _e("Usernames")?></div>
			<div class="wrap-c">
				<a href="javascript:void(0);" class="btn btn-label-danger btn-sm remove-all"><i class="far fa-trash-alt"></i> <?php _e("Delete all")?></a>
			</div>
		</div>

		<?php if(!empty($usernames)){
		foreach ($usernames as $username) {
		?>
			<div class="ig-ac-option-item-username">
				<a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.pinterest.com/<?php _e( $username) ?>" target="_blank"><?php _e( $username )?></a>
				<input type="hidden" name="usernames[]" value="<?php _e( $username )?>">
			</div>
		<?php }}else{?>
			<div class="empty small"></div>
		<?php }?>
		
	</div>

</div>