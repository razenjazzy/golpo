<div class="ig-ac-settings">
	<?php include "box/menu.php"?>

	<div class="ig-ac-log">
		
		<ul class="ig-ac-log-memu">
			
			<li><?php _e("Show: ")?></li>
			<li class="<?php _e( segment(5)==""?"active":"" )?>" ><a href="<?php _e( get_module_url("page/log/".segment(4)) )?>" class="ig-ac-log-type" data-type=""><?php _e("All")?></a></li>
			<li class="<?php _e( segment(5)=="comment"?"active":"" )?>" ><a href="<?php _e( get_module_url("page/log/".segment(4))."/comment" )?>" class="ig-ac-log-type" data-type="comment"><?php _e("Comments")?></a></li>
			<li class="<?php _e( segment(5)=="follow"?"active":"" )?>" ><a href="<?php _e( get_module_url("page/log/".segment(4))."/follow" )?>" class="ig-ac-log-type" data-type="follow"><?php _e("Follows")?></a></li>
			<li class="<?php _e( segment(5)=="unfollow"?"active":"" )?>" ><a href="<?php _e( get_module_url("page/log/".segment(4))."/unfollow" )?>" class="ig-ac-log-type" data-type="unfollow"><?php _e("Unfollows")?></a></li>
			<li class="<?php _e( segment(5)=="direct"?"active":"" )?>" ><a href="<?php _e( get_module_url("page/log/".segment(4))."/direct" )?>" class="ig-ac-log-type" data-type="direct"><?php _e("Direct messages")?></a></li>
			<li class="<?php _e( segment(5)=="repost"?"active":"" )?>" ><a href="<?php _e( get_module_url("page/log/".segment(4))."/repost" )?>" class="ig-ac-log-type" data-type="repost"><?php _e("Repost medias")?></a></li>

		</ul>

		<div class="ig-ac-log-items row ajax-load-log" data-type="<?php _e( segment(5) )?>" data-id="<?php _e( segment(4) )?>" data-page="0" data-load-type="scroll" data-scroll=".pinterest-activity.content-one-column">

			<div class="fa-5x m-auto m-t-100">
			  <i class="fas fa-spinner fa-spin text-info"></i>
			</div>

		</div>

	</div>


</div>