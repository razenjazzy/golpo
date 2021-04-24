<div class="tab-pane fade" id="v-pills-unfollow" role="tabpanel" aria-labelledby="v-pills-unfollow-tab">
	
	<div class="row">

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Unfollow source")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Which users to unfollow?<br/><br/><b>Our source</b> — select this option if you want to unfollow only users that were followed by our service.<br/>This option should be used in most cases, especially if you use Follow and Unfollow actions at the same time.<br/><br/><b>All</b> — select this option if you want to unfollow all users that you follow.", false)?>"></i>

				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="unfollows[source]">
					<option <?php igav($a, "unfollows", "source", "all") ?> value="all"><?php _e("All")?></option>
  					<option <?php igav($a, "unfollows", "source", "db") ?> value="db" selected=""><?php _e("Our source")?></option>
  				</select>
				</div>

			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Unfollow user after (day)")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("System will start unfollow users after 3/5/7 days after follow action.<br/><br/><span class='text-info'>NOTE:</span> Just support for unfollow by our source", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="unfollows[after]">
					<option <?php igav($a, "unfollows", "after", "1") ?> value="1"><?php _e("1")?></option>
  					<option <?php igav($a, "unfollows", "after", "2") ?> value="2"><?php _e("2")?></option>
  					<option <?php igav($a, "unfollows", "after", "3") ?> value="3"><?php _e("3")?></option>
  					<option <?php igav($a, "unfollows", "after", "4") ?> value="4"><?php _e("4")?></option>
  					<option <?php igav($a, "unfollows", "after", "5") ?> value="5"><?php _e("5")?></option>
  					<option <?php igav($a, "unfollows", "after", "6") ?> value="6"><?php _e("6")?></option>
  					<option <?php igav($a, "unfollows", "after", "7") ?> value="7"><?php _e("7")?></option>
  				</select>
				</div>

			</div>
		</div>
		
		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Don't unfollow my followers")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-html="true" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("When checking this box you will not unfollow users who follow you back.<br><br><span class='warning'>WARNING:</span> If you use this setting, please expect that your Unfollow activity may be stuck at zero for a while. Our service may take some time to find the users who don't follow you back, and it depends on the number of the users you follow and selected unfollow source.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<label class="i-checkbox i-checkbox--tick i-checkbox--brand p-l-17">
					<input type="checkbox" class="action-save" name="unfollows[dont_follower]" <?php igav($a, "unfollows", "dont_follower") ?> value="1"><span></span>
				</label>
				</div>
			</div>
		</div>

	</div>

</div>