<div class="tab-pane fade show active" id="v-targeting" role="tabpanel" aria-labelledby="v-targeting-tab">
	
	<div class="row">

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Tags")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can comment on media posted under <b>Tags</b> added in your settings, and/or follow users who posted those media.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you should add at least 1 tags in the <b>Tags</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<label class="i-checkbox i-checkbox--tick i-checkbox--brand p-l-17">
					<input type="checkbox" class="action-save" name="targets[tag]" <?php pinav($a, "targets", "tag") ?> value="1"><span></span>
				</label>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Keywords")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can comment on media posted under <b>Keywords</b> added in your settings, and/or follow users who posted those media.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you should add at least 1 keyword in the <b>Keywords</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<label class="i-checkbox i-checkbox--tick i-checkbox--brand p-l-17">
					<input type="checkbox" class="action-save" name="targets[keyword]" <?php pinav($a, "targets", "keyword") ?> value="1"><span></span>
				</label>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Followers")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can follow users who follow <b>Usernames</b> added in your settings (Followers of Usernames), comment on 1-3 most recent media posted by those users.<br/> You can also target your own Followers (users who follow your account) by selecting <b>My Account</b> or <b>All</b>.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you may need to add at least 2 usernames in the <b>Usernames</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="targets[follower]">
						<option <?php pinav($a, "targets", "follower", "") ?> value=""><?php _e("-")?></option>
					<option <?php pinav($a, "targets", "follower", "user") ?> value="user"><?php _e("Usernames")?></option>
					<option <?php pinav($a, "targets", "follower", "me") ?> value="me"><?php _e("My account")?></option>
					<option <?php pinav($a, "targets", "follower", "all") ?> value="all"><?php _e("All")?></option>
					</select>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Followings")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can follow users followed by <b>Usernames</b> added in your settings (Followings of Usernames), comment on 1-3 most recent media posted by those users.<br/> You can also target your own Followings (users you follow) by selecting <b>My Feed</b> or <b>All</b>.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you may need to add at least 2 usernames in the <b>Usernames</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="targets[following]">
						<option <?php pinav($a, "targets", "following", "") ?> value=""><?php _e("-")?></option>
					<option <?php pinav($a, "targets", "following", "user") ?> value="user"><?php _e("Usernames")?></option>
					<option <?php pinav($a, "targets", "following", "me") ?> value="me"><?php _e("My Feed")?></option>
					<option <?php pinav($a, "targets", "following", "all") ?> value="all"><?php _e("All")?></option>
					</select>
				</div>
			</div>
		</div>

	</div>

</div>