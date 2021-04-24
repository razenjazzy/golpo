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
					<option <?php pinav($a, "unfollows", "source", "all") ?> value="all"><?php _e("All")?></option>
  					<option <?php pinav($a, "unfollows", "source", "db") ?> value="db" selected=""><?php _e("Our source")?></option>
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
					<option <?php pinav($a, "unfollows", "after", "1") ?> value="1"><?php _e("1")?></option>
  					<option <?php pinav($a, "unfollows", "after", "2") ?> value="2"><?php _e("2")?></option>
  					<option <?php pinav($a, "unfollows", "after", "3") ?> value="3"><?php _e("3")?></option>
  					<option <?php pinav($a, "unfollows", "after", "4") ?> value="4"><?php _e("4")?></option>
  					<option <?php pinav($a, "unfollows", "after", "5") ?> value="5"><?php _e("5")?></option>
  					<option <?php pinav($a, "unfollows", "after", "6") ?> value="6"><?php _e("6")?></option>
  					<option <?php pinav($a, "unfollows", "after", "7") ?> value="7"><?php _e("7")?></option>
  				</select>
				</div>

			</div>
		</div>

	</div>

</div>