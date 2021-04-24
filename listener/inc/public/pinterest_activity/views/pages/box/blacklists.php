<div class="tab-pane fade" id="v-pills-blacklist" role="tabpanel" aria-labelledby="v-pills-blacklist-tab">
	
	<div class="m-b-25">
		<div class="list-add-blacklist-tag">
			<div class="ig-ac-option-title text-info fs-18 m-b-25 wrap-m">
				<div class="wrap-c"><i class="fas fa-hashtag p-r-5"></i> <?php _e("Tags blacklist")?></div>
				<div class="wrap-c">
					<a href="javascript:void(0);" class="btn btn-label-danger btn-sm remove-all-blacklist-tag"><i class="far fa-trash-alt"></i> <?php _e("Delete all")?></a>
				</div>
			</div>

			<div class="ig-ac-tab-full m-b-25">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
				  	<li class="nav-item">
				    	<a class="nav-link active" id="blacklist-tag-tab" data-toggle="tab" href="#blacklist-tag" role="tab" aria-controls="blacklist-tag" aria-selected="true"><?php _e("Search tags")?></a>
				  	</li>
				  	<li class="nav-item">
				    	<a class="nav-link" id="blacklist-tag-list-tab" data-toggle="tab" href="#blacklist-tag-list" role="tab" aria-controls="blacklist-tag-list" aria-selected="false"><?php _e("Add list tags")?></a>
				  	</li>
				</ul>
				<div class="tab-content" id="myTabContent">
				  	<div class="tab-pane fade show active" id="blacklist-tag" role="tabpanel" aria-labelledby="blacklist-tag-tab">
				  		
				  		<div class="input-group box-search-one">
						  	<input class="form-control form-search-blacklist-tag" type="text" value="" autocomplete="off" placeholder="<?php _e("Enter keyword")?>" data-action="<?php _e( get_module_url("search/blacklist_tag/".segment(4)) )?>" data-result="html" data-content="result-search-blacklist-tag">
						  	<span class="input-group-append">
							    <button class="btn" type="button">
							        <i class="fa fa-search"></i>
							    </button>
							</span>
						</div>

						<div class="result-search-blacklist-tag"></div>

				  	</div>
				  	<div class="tab-pane fade" id="blacklist-tag-list" role="tabpanel" aria-labelledby="blacklist-tag-list-tab">
				  		<div class="form-group">
				  			<textarea class="form-control form-add-blacklist-tag-list"></textarea>
				  		</div>
				  		<button type="button" class="btn btn-info btn-add-blacklist-tag-list"><?php _e("Add")?></button>
				  	</div>
				</div>
			</div>

			<?php if(!empty($blacklist_tags)){
			foreach ($blacklist_tags as $tag) {
			?>
				<div class="ig-ac-option-item-tag">
					<a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.instagram.com/explore/tags/<?php echo $tag?>" target="_blank"><?php echo $tag?></a>
					<input type="hidden" name="blacklist_tags[]" value="<?php echo $tag?>">
				</div>
			<?php }}else{?>
				<div class="empty small"></div>
			<?php }?>
		</div>
	</div>	

	<div class="m-b-25">
		<div class="list-add-blacklist-username">
			<div class="ig-ac-option-title text-info fs-18 m-b-25 wrap-m">
				<div class="wrap-c"><i class="fas fa-user p-r-5"></i> <?php _e("Username blacklist")?></div>
				<div class="wrap-c">
					<a href="javascript:void(0);" class="btn btn-label-danger btn-sm remove-all-blacklist-username"><i class="far fa-trash-alt"></i> <?php _e("Delete all")?></a>
				</div>
			</div>
			<div class="ig-ac-option m-b-25">
				<div class="info m-b-15">
					<div class="input-group box-search-one">
					  	<input class="form-control form-search-blacklist-username" type="text" value="" autocomplete="off" placeholder="<?php _e("Enter keyword")?>" data-action="<?php _e( get_module_url("search/blacklist_username/".segment(4)) )?>" data-result="html" data-content="result-search-blacklist-username">
					  	<span class="input-group-append">
						    <button class="btn" type="button">
						        <i class="fa fa-search"></i>
						    </button>
						</span>
					</div>
				</div>
				<div class="result-search-blacklist-username"></div>
			</div>

			<?php if(!empty($blacklist_usernames)){
			foreach ($blacklist_usernames as $username) {
			?>
				<div class="ig-ac-option-item-username">
					<a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.pinterest.com/<?php _e($username)?>" target="_blank"><?php _e($username)?></a>
					<input type="hidden" name="blacklist_usernames[]" value="<?php echo $username?>">
				</div>
			<?php }}else{?>
				<div class="empty small"></div>
			<?php }?>
		</div>
	</div>	

	<div class="m-b-25">

		<div class="list-add-blacklist-keyword">
			<div class="ig-ac-option-title text-info fs-18 m-b-25 wrap-m">
				<div class="wrap-c"><i class="far fa-file-alt p-r-5"></i> <?php _e("Keyword blacklist")?></div>
				<div class="wrap-c">
					<a href="javascript:void(0);" class="btn btn-label-danger btn-sm remove-all-blacklist-keyword"><i class="far fa-trash-alt"></i> <?php _e("Delete all")?></a>
				</div>
			</div>

			<div class="ig-ac-option m-b-25">
				<div class="info m-b-15">
					<span class="p-r-5"><?php _e("Enter keywords")?> </span>
					<div class="form-group">
						<textarea class="form-control form-add-blacklist-keyword"></textarea>
					</div>
					<button type="button" class="btn btn-info btn-add-blacklist-keyword"><?php _e("Add new")?></button>
				</div>
				<div class="result-search-blacklist-keyword"></div>
			</div>

			<?php if(!empty($blacklist_keywords)){
			foreach ($blacklist_keywords as $keyword) {
			?>
			<div class="ig-ac-option-item-keyword">
				<a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <?php echo $keyword?>
				<textarea class="d-none" name="blacklist_keywords[]"><?php echo $keyword?></textarea>
			</div>
			<?php }}else{?>
				<div class="empty small"></div>
			<?php }?>
		</div>

	</div>

</div>