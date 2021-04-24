<div class="tasks">
	<div class="title fw-6 text-info"><?php _e("Select what you want to do")?></div>
	<div class="item-task wrap-m">
		<div class="wrap-c">
			<label class="i-switch i-switch--outline i-switch--info m-t-6 m-r-6">
				<input type="checkbox" name="todos[comment]" class="action-save" data-type="comment" <?php pinav($a, "todos", "comment") ?> value="1">
				<span></span>
			</label>
			<div class="name fs-16">
				<?php _e("Comment")?>
				<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Turn this switch on to automate your comments activity.<br/><br/> The counter shows how many photos and videos you've commented since your last activity start.", false)?>"></i>
				<?php if( $activity && pin_get_setting("comment_block", "", $activity->id) ){?>
				<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("comment_block", "", $activity->id) )?>"></i>
				<?php }?>
			</div>
		</div>
		<div class="wrap-c fs-18 fw-6">
			<?php _e( pinac( $settings, "comment" ) )?>
		</div>
	</div>
	<div class="item-task wrap-m">
		<div class="wrap-c">
			<label class="i-switch i-switch--outline i-switch--info m-t-6 m-r-6">
				<input type="checkbox" name="todos[follow]" class="action-save" data-type="follow" <?php pinav($a, "todos", "follow") ?> value="1">
				<span></span>
			</label>
			<div class="name fs-16">
				<?php _e("Follow")?>
				<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Turn this switch on to automate your follows activity.<br/><br/> The counter shows how many users you've followed since your last activity start.", false)?>"></i>
				<?php if( $activity && pin_get_setting("follow_block", "", $activity->id) ){?>
				<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("follow_block", "", $activity->id) )?>"></i>
				<?php }?>
			</div>
		</div>
		<div class="wrap-c fs-18 fw-6">
			<?php _e( pinac( $settings, "follow" ) )?>
		</div>
	</div>
	<div class="item-task wrap-m">
		<div class="wrap-c">
			<label class="i-switch i-switch--outline i-switch--info m-t-6 m-r-6">
				<input type="checkbox" name="todos[unfollow]" class="action-save" data-type="unfollow" <?php pinav($a, "todos", "unfollow") ?> value="1">
				<span></span>
			</label>
			<div class="name fs-16">
				<?php _e("Unfollow")?>
				<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Turn this switch on to automate your unfollows activity.<br/><br/> The counter shows how many users you've unfollowed since your last activity start.", false)?>"></i>
				<?php if( $activity && pin_get_setting("unfollow_block", "", $activity->id) ){?>
				<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("unfollow_block", "", $activity->id) )?>"></i>
				<?php }?>
			</div>
		</div>
		<div class="wrap-c fs-18 fw-6">
			<?php _e( pinac( $settings, "unfollow" ) )?>
		</div>
	</div>
	<div class="item-task wrap-m">
		<div class="wrap-c">
			<label class="i-switch i-switch--outline i-switch--info m-t-6 m-r-6">
				<input type="checkbox" name="todos[direct]" class="action-save" data-type="direct" <?php pinav($a, "todos", "direct") ?> value="1">
				<span></span>
			</label>
			<div class="name fs-16">
				<?php _e("Direct message")?>
				<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Turn this switch on to automate your direct messages activity.<br/><br/> The counter shows how many users you've sent direct message since your last activity start.", false)?>"></i>
				<?php if( $activity && pin_get_setting("direct_block", "", $activity->id) ){?>
				<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("direct_block", "", $activity->id) )?>"></i>
				<?php }?>
			</div>
		</div>
		<div class="wrap-c fs-18 fw-6">
			<?php _e( pinac( $settings, "direct" ) )?>
		</div>
	</div>
	<div class="item-task wrap-m">
		<div class="wrap-c">
			<label class="i-switch i-switch--outline i-switch--info m-t-6 m-r-6">
				<input type="checkbox" name="todos[repost]" class="action-save" data-type="repost" <?php pinav($a, "todos", "repost") ?> value="1">
				<span></span>
			</label>
			<div class="name fs-16">
				<?php _e("Repost media")?>
				<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Turn this switch on to automate your repost medias activity.<br/><br/> The counter shows how many medias you've posted since your last activity start.", false)?>"></i>
				<?php if( $activity && pin_get_setting("repost_block", "", $activity->id) ){?>
				<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("repost_block", "", $activity->id) )?>"></i>
				<?php }?>
			</div>
		</div>
		<div class="wrap-c fs-18 fw-6">
			<?php _e( pinac( $settings, "repost" ) )?>
		</div>
	</div>
</div>