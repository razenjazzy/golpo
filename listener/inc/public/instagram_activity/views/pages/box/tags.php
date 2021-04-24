<div class="tab-pane fade" id="v-pills-tag" role="tabpanel" aria-labelledby="v-pills-tag-tab">
	
	<div class="row m-b-25">
		<div class="col-md-12">
			<div class="ig-ac-tab-full">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
			  	<li class="nav-item">
			    	<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?php _e("Search tags")?></a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php _e("Add list tags")?></a>
			  	</li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  	<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			  		
			  		<div class="input-group box-search-one">
					  	<input class="form-control form-search-tag" type="text" value="" autocomplete="off" placeholder="<?php _e("Enter keyword")?>" data-action="<?php _e( get_module_url("search/tag/".segment(4)) )?>" data-result="html" data-content="result-search-tag">
					  	<span class="input-group-append">
						    <button class="btn" type="button">
						        <i class="fa fa-search"></i>
						    </button>
						</span>
					</div>

					<div class="result-search-tag"></div>

			  	</div>
			  	<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			  		<div class="form-group">
			  			<textarea class="form-control form-add-tag-list"></textarea>
			  		</div>
			  		<button type="button" class="btn btn-info btn-add-tag-list"><?php _e("Add")?></button>
			  	</div>
			</div>
		</div>
		</div>
	</div>	

	<div class="m-b-0 list-add-tag">

		<div class="ig-ac-option-title text-info fs-18 m-b-25 wrap-m">
			<div class="wrap-c"><i class="fas fa-hashtag p-r-5"></i> <?php _e("Tags")?></div>
			<div class="wrap-c">
				<a href="javascript:void(0);" class="btn btn-label-danger btn-sm remove-all"><i class="far fa-trash-alt"></i> <?php _e("Delete all")?></a>
			</div>
		</div>

		<?php if(!empty($tags)){
		foreach ($tags as $tag) {
		?>
			<div class="ig-ac-option-item-tag">
				<a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/explore/tags/<?php echo $tag?>" target="_blank"><?php echo $tag?></a>
				<input type="hidden" name="tags[]" value="<?php echo $tag?>">
			</div>
		<?php }}else{?>
			<div class="empty small"></div>
		<?php }?>

	</div>

</div>