<?php
$a = false;
$status = 0;
$settings = [];
if($activity){
	$a = $activity->data;
	$settings = $activity->settings;
	$status = $activity->status;
}

$comments = igav($a, "comments");
$directs = igav($a, "directs");
$reposts = igav($a, "reposts");
$tags = igav($a, "tags");
$locations = igav($a, "locations");
$usernames = igav($a, "usernames");
$blacklist_tags = igav($a, "blacklist_tags");
$blacklist_usernames = igav($a, "blacklist_usernames");
$blacklist_keywords = igav($a, "blacklist_keywords");
$schedule_days = igav($a, "schedule_days");
$schedule_default="[
	[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
	[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
	[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
	[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
	[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
	[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
	[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
]";

$slow_level = get_option('igac_speeds_level', 'slow');

$slow_speed = [
	get_option('igac_speeds_slow_like', 2),
	get_option('igac_speeds_slow_comment', 1),
	get_option('igac_speeds_slow_watching_story', 2),
	get_option('igac_speeds_slow_follow', 2),
	get_option('igac_speeds_slow_unfollow', 2),
	get_option('igac_speeds_slow_direct', 1),
	get_option('igac_speeds_slow_repost', 1)
];

$normal_speed = [
	get_option('igac_speeds_normal_like', 4),
	get_option('igac_speeds_normal_comment', 2),
	get_option('igac_speeds_normal_watching_story', 4),
	get_option('igac_speeds_normal_follow', 4),
	get_option('igac_speeds_normal_unfollow', 4),
	get_option('igac_speeds_normal_direct', 2),
	get_option('igac_speeds_normal_repost', 2)
];

$fast_speed = [
	get_option('igac_speeds_fast_like', 6),
	get_option('igac_speeds_fast_comment', 3),
	get_option('igac_speeds_fast_watching_story', 6),
	get_option('igac_speeds_fast_follow', 6),
	get_option('igac_speeds_fast_unfollow', 6),
	get_option('igac_speeds_fast_direct', 3),
	get_option('igac_speeds_fast_repost', 3)
];

?>

<?php if(!$activity){?>
<script type="text/javascript">
$(function(){
	Instagram_activity.save_activity();
});	
</script>
<?php }?>

<div class="ig-ac-settings">
	<?php include "box/menu.php"?>

	<form class="ig-ac-body save-action" action="<?php _e( get_module_url("save/".segment(4)) )?>" data-hide-overplay="false" method="POST">
		
		<div class="ig-ac-main">
			
			<div class="row">
				
				<div class="col-md-4">
					
					<div class="control">
						
						<div class="loading text-center wrap-c">
								<?php if(isset($activity->status) && $activity->status == "1"){?>
								<i class="ig-ac-status started far fa-clock text-info pe-spin m-auto fs-100"></i>
								<i class="ig-ac-status stopped far fa-stop-circle text-danger m-auto fs-100 d-none"></i>
								<?php }else{?>
								<i class="ig-ac-status started far fa-clock text-info pe-spin m-auto fs-100 d-none"></i>
								<i class="ig-ac-status stopped far fa-stop-circle text-danger m-auto fs-100"></i>
								<?php }?>
							
						</div>
						<div class="info">
							<div class="item-info wrap-m">
								<div class="wrap-c"><?php _e("Status")?></div>
								<?php if(isset($activity->status) && $activity->status == "1"){?>
								<span class="ig-ac-status started badge badge-success"><?php _e("Started")?></span>
								<span class="ig-ac-status stopped badge badge-danger d-none"><?php _e("Stopped")?></span>
								<span class="ig-ac-status none badge badge-dark d-none"><?php _e("No time")?></span>
								<?php }else if(isset($activity->status) && $activity->status == "0"){?>
								<span class="ig-ac-status started badge badge-success d-none"><?php _e("Started")?></span>
								<span class="ig-ac-status stopped badge badge-danger"><?php _e("Stopped")?></span>
								<span class="ig-ac-status none badge badge-dark d-none"><?php _e("No time")?></span>
								<?php }else{?>
								<span class="ig-ac-status started badge badge-success d-none"><?php _e("Started")?></span>
								<span class="ig-ac-status stopped badge badge-danger d-none"><?php _e("Stopped")?></span>
								<span class="ig-ac-status none badge badge-dark"><?php _e("No time")?></span>
								<?php }?>
							</div>							
							<div class="item-info wrap-m">
								<div class="wrap-c"><?php _e("Started on")?></div>
								<div class="wrap-c"><?php _e( (isset($activity->changed) && $activity->status != "")?datetime_show( $activity->changed ):_e("--") )?></div>
							</div>							
						</div>

						<div class="action">
							<div class="btn-group btn-group-block" role="group">
							  	<a href="<?php _e( get_module_url("start/".segment("4")) )?>" class="btn btn-secondary ig-ac-btn-start <?php _e($status==1?"d-none":"")?>"><?php _e("Start")?></a>
							  	<a href="<?php _e( get_module_url("stop/".segment("4")) )?>" class="btn btn-label-danger ig-ac-btn-stop <?php _e($status!=1?"d-none":"")?>"><?php _e("Stop")?></a>
							  	<div class="btn-group" role="group">
								    <a href="javascript:void(0);" class="btn btn-secondary open_schedule_days" data-toggle="tooltip" data-target="#schedule_days" data-placement="top" title="" data-original-title="<?php _e('Schedule')?>">
								      	<i class="far fa-calendar-alt"></i>
								    </a>
							  	</div>
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-4">
					<?php include "box/todos.php"?>
				</div>
				<div class="col-md-4 recent-activity-wrap">
					<?php include "box/recent_activity.php"?>
				</div>

			</div>

		</div>

		<div class="ig-ac-options">
			
			<div class="ig-ac-tab nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
			  	<a class="active" id="v-targeting-tab" data-toggle="pill" href="#v-targeting" role="tab" aria-controls="v-targeting" aria-selected="true"><i class="fas fa-bullseye"></i> <?php _e("Targeting")?></a>
			  	<a id="v-speed-tab" data-toggle="pill" href="#v-speed" role="tab" aria-controls="v-speed" aria-selected="false"><i class="fas fa-running"></i> <?php _e("Speed")?></a>
			  	<a id="v-pills-filter-tab"  data-toggle="pill" href="#v-pills-filter" role="tab" aria-controls="v-pills-filter" aria-selected="false"><i class="fas fa-filter"></i> <?php _e("Filters")?></a>
			  	<a id="v-pills-comment-tab" data-type="comment" data-toggle="pill" href="#v-pills-comment" role="tab" aria-controls="v-pills-comment" aria-selected="false"><i class="far fa-comment-alt"></i> <?php _e("Comments")?></a>
			  	<!-- <a id="v-pills-watching-story-tab" data-type="watching_story" data-toggle="pill" href="#v-pills-watching-story" role="tab" aria-controls="v-pills-watching-story" aria-selected="false"><i class="far fa-eye"></i> <?php _e("Watching stories")?></a> -->
			  	<a id="v-pills-follow-tab" data-type="follow" data-toggle="pill" href="#v-pills-follow" role="tab" aria-controls="v-pills-follow" aria-selected="false"><i class="fas fa-user-plus"></i> <?php _e("Follow")?></a>
			  	<a id="v-pills-unfollow-tab" data-type="unfollow" data-toggle="pill" href="#v-pills-unfollow" role="tab" aria-controls="v-pills-unfollow" aria-selected="false"><i class="fas fa-user-minus"></i> <?php _e("Unfollow")?></a>
			  	<a id="v-pills-direct-tab" data-type="direct" data-toggle="pill" href="#v-pills-direct" role="tab" aria-controls="v-pills-direct" aria-selected="false"><i class="fas fa-inbox"></i> <?php _e("Direct message")?></a>
			  	<a id="v-pills-repost-tab" data-type="repost" data-toggle="pill" href="#v-pills-repost" role="tab" aria-controls="v-pills-repost" aria-selected="false"><i class="fas fa-reply-all"></i> <?php _e("Repost medias")?></a>
			  	<a id="v-pills-tag-tab" data-toggle="pill" href="#v-pills-tag" role="tab" aria-controls="v-pills-tag" aria-selected="false"><i class="fas fa-hashtag"></i> <?php _e("Tags")?></a>
			  	<a id="v-pills-location-tab" data-toggle="pill" href="#v-pills-location" role="tab" aria-controls="v-pills-location" aria-selected="false"><i class="fas fa-map-marker-alt"></i> <?php _e("Locations")?></a>
			  	<a id="v-pills-usernames-tb" data-toggle="pill" href="#v-pills-username" role="tab" aria-controls="v-pills-username" aria-selected="false"><i class="fas fa-user"></i> <?php _e("Usernames")?></a>
			  	<a id="v-pills-blacklist-tab" data-toggle="pill" href="#v-pills-blacklist" role="tab" aria-controls="v-pills-blacklist" aria-selected="false"><i class="fas fa-ban"></i> <?php _e("Blacklist")?></a>
			  	<a id="v-pills-auto-stop-tab" data-toggle="pill" href="#v-pills-auto-stop" role="tab" aria-controls="v-pills-auto-stop" aria-selected="false"><i class="far fa-stop-circle"></i> <?php _e("Auto stop")?></a>
			</div>

			<div class="ig-ac-content">
				<div class="tab-content p-t-25" id="v-pills-tabContent">
					<?php include "box/targets.php"?>
					<?php include "box/speeds.php"?>
					<?php include "box/filters.php"?>
					<?php include "box/comments.php"?>
					<?php include "box/watching_stories.php"?>
					<?php include "box/follows.php"?>
					<?php include "box/unfollows.php"?>
					<?php include "box/directs.php"?>
					<?php include "box/reposts.php"?>
					<?php include "box/tags.php"?>
					<?php include "box/locations.php"?>
					<?php include "box/usernames.php"?>
					<?php include "box/blacklists.php"?>
				  	<?php include "box/stops.php"?>
				</div>
			</div>

			<div class="clearfix"></div>
		</div>

		<?php include "box/schedule_days.php"?>

	</form>

</div>