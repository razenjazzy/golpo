<div class="tab-pane fade show active" id="v-targeting" role="tabpanel" aria-labelledby="v-targeting-tab">
	
	<div class="row">

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Tags")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can like and/or comment on media posted under <b>Tags</b> added in your settings, and/or follow users who posted those media.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you should add at least 1 tags in the <b>Tags</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<label class="i-checkbox i-checkbox--tick i-checkbox--brand p-l-17">
					<input type="checkbox" class="action-save" name="targets[tag]" <?php igav($a, "targets", "tag") ?> value="1"><span></span>
				</label>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Locations")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can like and/or comment on media posted under <b>Locations</b> added in your settings, and/or follow users who posted those media.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you should add at least 1 locations in the <b>Locations</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<label class="i-checkbox i-checkbox--tick i-checkbox--brand p-l-17">
					<input type="checkbox" class="action-save" name="targets[location]" <?php igav($a, "targets", "location") ?> value="1"><span></span>
				</label>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Followers")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can follow users who follow <b>Usernames</b> added in your settings (Followers of Usernames), and/or like or comment on 1-3 most recent media posted by those users.<br/> You can also target your own Followers (users who follow your account) by selecting <b>My Account</b> or <b>All</b>.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you may need to add at least 2 usernames in the <b>Usernames</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="targets[follower]">
						<option <?php igav($a, "targets", "follower", "") ?> value=""><?php _e("-")?></option>
					<option <?php igav($a, "targets", "follower", "user") ?> value="user"><?php _e("Usernames")?></option>
					<option <?php igav($a, "targets", "follower", "me") ?> value="me"><?php _e("My account")?></option>
					<option <?php igav($a, "targets", "follower", "all") ?> value="all"><?php _e("All")?></option>
					</select>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Followings")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can follow users followed by <b>Usernames</b> added in your settings (Followings of Usernames), and/or like or comment on 1-3 most recent media posted by those users.<br/> You can also target your own Followings (users you follow) by selecting <b>My Feed</b> or <b>All</b>.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you may need to add at least 2 usernames in the <b>Usernames</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="targets[following]">
						<option <?php igav($a, "targets", "following", "") ?> value=""><?php _e("-")?></option>
					<option <?php igav($a, "targets", "following", "user") ?> value="user"><?php _e("Usernames")?></option>
					<option <?php igav($a, "targets", "following", "me") ?> value="me"><?php _e("My Feed")?></option>
					<option <?php igav($a, "targets", "following", "all") ?> value="all"><?php _e("All")?></option>
					</select>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Likers")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can follow users who have liked the media posted by the <b>Usernames</b> added in your settings, and/or like or comment on 1-3 most recent media posted by those users.<br/> You can also target your own Likers (users who have liked your media) by selecting <b>My posts</b> or <b>All</b>.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you may need to add at least 2 usernames in the <b>Usernames</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="targets[liker]">
						<option <?php igav($a, "targets", "liker", "") ?> value=""><?php _e("-")?></option>
					<option <?php igav($a, "targets", "liker", "user") ?> value="user"><?php _e("Usernames posts")?></option>
					<option <?php igav($a, "targets", "liker", "me") ?> value="me"><?php _e("My posts")?></option>
					<option <?php igav($a, "targets", "liker", "all") ?> value="all"><?php _e("All")?></option>
					</select>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Commenters")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Based on selected Activity Actions, you can follow users who have commented on the media posted by <b>Usernames</b> added in your settings, and/or like or comment on 1-3 most recent media posted by those users.<br/> You can also target your own Commenters (users who have commented on your media) by selecting <b>My posts</b> or <b>All</b>.<br/><br/> <span class='text-info'>INFO:</span> This targeting source works independently of all other targeting sources that you can select.<br/><br/> <span class='text-warning'>IMPORTANT:</span> To use this source you may need to add at least 2 usernames in the <b>Usernames</b> list.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="targets[commenter]">
						<option <?php igav($a, "targets", "commenter", "") ?> value=""><?php _e("-")?></option>
					<option <?php igav($a, "targets", "commenter", "user") ?> value="user"><?php _e("Usernames posts")?></option>
					<option <?php igav($a, "targets", "commenter", "me") ?> value="me"><?php _e("My posts")?></option>
					<option <?php igav($a, "targets", "commenter", "all") ?> value="all"><?php _e("All")?></option>
					</select>
				</div>
			</div>
		</div>

	</div>

</div>