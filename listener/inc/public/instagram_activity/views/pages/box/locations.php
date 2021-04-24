<div class="tab-pane fade" id="v-pills-location" role="tabpanel" aria-labelledby="v-pills-location-tab">
	
	<div class="row m-b-25">
		<div class="col-md-12">
			<div class="ig-ac-option">
				<div class="info">
					<div class="input-group box-search-one">
				  	<input class="form-control form-search-location" type="text" value="" autocomplete="off" placeholder="<?php _e("Enter location name")?>" data-action="<?php _e( get_module_url("search/location/".segment(4)) )?>" data-result="html" data-content="result-search-location">
				  	<span class="input-group-append">
					    <button class="btn" type="button">
					        <i class="fa fa-search"></i>
					    </button>
					</span>
				</div>

				<div class="result-search-location"></div>
				</div>
			</div>
		</div>
	</div>	

	<div class="m-b-0 list-add-location">

		<div class="ig-ac-option-title text-info fs-18 m-b-25 wrap-m">
			<div class="wrap-c"><i class="fas fa-map-marker-alt p-r-5"></i> <?php _e("Locations")?></div>
			<div class="wrap-c">
				<a href="javascript:void(0);" class="btn btn-label-danger btn-sm remove-all"><i class="far fa-trash-alt"></i> <?php _e("Delete all")?></a>
			</div>
		</div>

		<?php if(!empty($locations)){
		foreach ($locations as $location) {
			$location_params = explode("|", $location);
		?>
			<div class="ig-ac-option-item-location">
				<a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/explore/locations/<?php echo $location_params[1]?>" target="_blank"><?php echo $location_params[0]?></a>
				<input type="hidden" name="locations[]" value="<?php echo $location?>">
			</div>
		<?php }}else{?>
			<div class="empty small"></div>
		<?php }?>
		
	</div>

</div>