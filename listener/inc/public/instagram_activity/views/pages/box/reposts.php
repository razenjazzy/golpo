<div class="tab-pane fade" id="v-pills-repost" role="tabpanel" aria-labelledby="v-pills-repost-tab">
	
	<div class="row">

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Repost by")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Which users to direct message?<br/><br/><b>New followers</b> — select this option if you want to direct message only your new followers<br/><br/><b>Target</b> — select this option if you want to direct message by target settings", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="op_reposts[by]">
  					<option <?php igav($a, "op_reposts", "by", "all") ?> value="all"><?php _e("All")?></option>
					<option <?php igav($a, "op_reposts", "by", "tag") ?> value="tag"><?php _e("Tags")?></option>
					<option <?php igav($a, "op_reposts", "by", "username") ?> value="username"><?php _e("Usernames")?></option>
					<option <?php igav($a, "op_reposts", "by", "location") ?> value="location"><?php _e("Locations")?></option>
  				</select>
				</div>
			</div>
		</div>

	</div>

	<div class="row m-b-25">

		<div class="col-md-12">
			<div class="ig-ac-option">
				<div class="info">
					<span class="p-r-5"><?php _e("Caption")?> </span>
					<div class="form-group">
						<textarea class="form-control post-message action-save" name="reposts"><?php _e( $reposts )?></textarea>
  					<ul class="ig-ac-note">
	      				<li><?php _e("Leave empty to repost without a caption.")?></li>
	      				<li>
	      					<?php _e("You can use following variables in the caption:<br><strong>{{caption}}</strong> Original caption<br><strong>{{username}}</strong> Media owner's username<br><strong>{{full_name}}</strong> Media owner's full name. If user's full name is not set, username will be used."
	      					, false)?>
	      				</li>
	      			</ul>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>