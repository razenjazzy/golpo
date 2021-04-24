<div class="tab-pane fade" id="v-pills-auto-stop" role="tabpanel" aria-labelledby="v-pills-auto-stop-tab">
	
	<div class="row">
		
		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Likes counter")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("When this number of likes will be done your activity will be stopped automatically. Set to zero to disable the limit.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<input type="number" class="form-control action-save" name="stops[like]" value="<?php igav($a, "stops", "like")?>">
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Comments counter")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("When this number of comments will be done your activity will be stopped automatically. Set to zero to disable the limit.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<input type="number" class="form-control action-save" name="stops[comment]" value="<?php igav($a, "stops", "comment")?>">
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Watching stories counter")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("When this number of watching stories will be done your activity will be stopped automatically. Set to zero to disable the limit.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<input type="number" class="form-control action-save" name="stops[watching_story]" value="<?php igav($a, "stops", "watching_story")?>">
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Follows counter")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("When this number of follows will be done your activity will be stopped automatically. Set to zero to disable the limit.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<input type="number" class="form-control action-save" name="stops[follow]" value="<?php igav($a, "stops", "follow")?>">
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Unfollows counter")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("When this number of unfollows will be done your activity will be stopped automatically. Set to zero to disable the limit.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<input type="number" class="form-control action-save" name="stops[unfollow]" value="<?php igav($a, "stops", "unfollow")?>">
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Direct messages counter")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("When this number of Direct messages will be done your activity will be stopped automatically. Set to zero to disable the limit.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<input type="number" class="form-control action-save" name="stops[direct]" value="<?php igav($a, "stops", "direct")?>">
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Repost medias counter")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("When this number of Repost media will be done your activity will be stopped automatically. Set to zero to disable the limit.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<input type="number" class="form-control action-save" name="stops[repost]" value="<?php igav($a, "stops", "repost")?>">
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Timer")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Format: HH:MM. For example, if you set it to <b>01:00</b>, then your activity will stop automatically after one hour. If you leave it empty, then activity will work infinite or while Instagram limits for your account not will be reached.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<input type="text" class="form-control action-save" name="stops[timer]" placeholder="00:00" value="<?php igav($a, "stops", "timer")?>">
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Stop if no activity")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Automatically stops after a while without any activity.", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="stops[no_activity]">
  					<option <?php igav($a, "stops", "no_activity", "no") ?> value="no"><?php _e("Never")?></option>
  					<option <?php igav($a, "stops", "no_activity", "1h") ?> value="1h"><?php _e("1 hour")?></option>
					<option <?php igav($a, "stops", "no_activity", "3h") ?> value="3h"><?php _e("3 hours")?></option>
					<option <?php igav($a, "stops", "no_activity", "12h") ?> value="12h"><?php _e("12 hours")?></option>
					<option <?php igav($a, "stops", "no_activity", "1d") ?> value="1d"><?php _e("1 day")?></option>
					<option <?php igav($a, "stops", "no_activity", "3d") ?> value="3d"><?php _e("3 days")?></option>
					<option <?php igav($a, "stops", "no_activity", "1w") ?> value="1w"><?php _e("1 week")?></option>
  				</select>
				</div>
			</div>
		</div>

	</div>

</div>