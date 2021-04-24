<?php 
if(!empty($result)){
	$account_data = $result->data;
	$top_hashtags = $account_data->top_hashtags;
	$top_mentions = $account_data->top_mentions;
	$profile_info = $account_data->profile_info;
	$feeds = $account_data->feeds;
	$follower_count = $profile_info->follower_count;
	$media_count = $profile_info->media_count;
	$total_days = $result->total_days;
?>

<div class="headline">
	<div class="title"><i class="far fa-chart-bar text-info"></i> <?php _e( sprintf( __("Analytic for  %s") , $profile_info->username) )?></div>
</div>

<div class="wrap-analytics" id="wrap-analytics">
	<div class="profile-info m-t-25">
	
		<div class="avatar">
			<img src="<?php _e($profile_info->profile_pic_url)?>">
		</div>
		<div class="info">
			<div class="name"><?php _e($profile_info->username)?></div>
			<ul class="stats">
				<li><?php _e( sprintf( __("%s posts") , number_format($profile_info->media_count)) )?></li>
				<li><?php _e( sprintf( __("%s followers") , number_format($profile_info->follower_count)) )?></li>
				<li><?php _e( sprintf( __("%s following") , number_format($profile_info->following_count)) )?></li>
			</ul>
			<div class="fullname"><?php _e($profile_info->full_name)?></div>
			<div class="description"><?php _e($profile_info->biography)?></div>
			<div class="website"><a class="text-info" href="<?php _e($profile_info->external_url)?>" target="_blank"><?php _e($profile_info->external_url)?></a></div>
		</div>
	</div>

	<ul class="box-sumary m-t-25">
		<li>
			<div>
				<span><?php _e($account_data->engagement)?>%</span><?php _e("Engagement")?>
				<i class="activity-option-help webuiPopover fa fa-question-circle" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("The engagement rate is the number of active likes / comments on each post")?>"></i>
			</div>
		</li>
		<li>
			<div>
				<span><?php _e($account_data->average_likes)?></span><?php _e("Average Likes")?>
				<i class="activity-option-help webuiPopover fa fa-question-circle" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Average likes based on the last 10 posts")?>"></i>
			</div>
		</li>
		<li>
			<div>
				<span><?php _e($account_data->average_comments)?></span><?php _e("Average Comments")?>
				<i class="activity-option-help webuiPopover fa fa-question-circle" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e("Average comments based on the last 10 posts")?>"></i>
			</div>
		</li>
		<span class="clearfix"></span>
	</ul>

	<div class="box-analytics">
		<div class="box-head">
			<h3 class="text-info title"><?php _e("Profile Growth & Discovery")?></h3>
			<div class="description"><?php _e("See insights on how your profile has grown and changed over time.")?></div>
		</div>

		<div class="row">
	    	<div class="col-md-12">
				<div class="card-body box-analytic">
		            <canvas id="ig-analytics-followers-line-stacked-area" height="300"></canvas>
		        </div>
		    </div>
		</div>
	    <div class="title-chart text-info"><?php _e("Followers evolution chart")?></div>

	    <div class="row">
	    	<div class="col-md-12">
	    		<div class="card-body box-analytic">
		            <canvas id="ig-analytics-following-line-stacked-area" height="300"></canvas>
		        </div>
	    	</div>
	    </div>	
	    <div class="title-chart text-info"><?php _e("Following evolution chart")?></div>
	</div>

	<div class="box-analytics">
		
		<div class="box-head">
			<h3 class="text-info title"><?php _e("Account Stats Summary")?></h3>
			<div class="description"><?php _e("Showing last 15 entries.")?></div>
		</div>
		<div class="table_sumary">
			<?php
			$total_followers_summany = 0;
			$total_following_summany = 0;
			$total_posts_summany = 0;
			$compare_new_followers_value_string = "";
			$compare_new_following_value_string = "";
			$compare_total_followers_value_string = "";
			$compare_total_following_value_string = "";
			?>

			<table class="table">
				<thead>
					<tr>
						<td><?php _e("Date")?></td>
						<td colspan="2"><?php _e("Followes")?></td>
						<td colspan="2"><?php _e("Following")?></td>
						<td colspan="2"><?php _e("Posts")?></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($result->list_summary as $key => $row){
						$followers_status = "text-default";
						$followers_sumary = "-";
						$total_followers_summany += (int)$row->followers_sumary;
						if($row->followers_sumary > 0){
							$followers_sumary = "+".$row->followers_sumary;
							$followers_status = "text-success";
						}else if($row->followers_sumary < 0){
							$followers_sumary = $row->followers_sumary;
							$followers_status = "text-danger";
						}

						$following_status = "text-default";
						$following_sumary = "-";
						$total_following_summany += (int)$row->following_sumary;
						if($row->following_sumary > 0){
							$following_sumary = "+".$row->following_sumary;
							$following_status = "text-success";
						}else if($row->following_sumary < 0){
							$following_sumary = $row->following_sumary;
							$following_status = "text-danger";
						}

						$posts_status = "text-default";
						$posts_sumary = "-";
						$total_posts_summany += (int)$row->posts_sumary;
						if($row->posts_sumary > 0){
							$posts_sumary = "+".$row->posts_sumary;
							$posts_status = "text-success";
						}else if($row->posts_sumary < 0){
							$posts_sumary = $row->posts_sumary;
							$posts_status = "text-danger";
						}

						$compare_new_followers_value_string .= (int)$followers_sumary.",";
						$compare_new_following_value_string .= (int)$following_sumary.",";
						$compare_total_followers_value_string .= (int)$row->followers.",";
						$compare_total_following_value_string .= (int)$row->following.",";
					?>
					<tr>
						<td><?php _e(date("D, d M, Y", strtotime($row->date)))?></td>
						<td><?php _e($row->followers)?></td>
						<td><span class="<?php _e($followers_status)?>"><?php _e($followers_sumary)?></span></td>
						<td><?php _e($row->following)?></td>
						<td><span class="<?php _e($following_status)?>"><?php _e($following_sumary)?></span></td>
						<td><?php _e($row->posts)?></td>
						<td><span class="<?php _e($posts_sumary)?>"><?php _e($posts_sumary)?></span></td>
					</tr>
					<?php }?>
				</tbody>
				<tfoot>
					<?php 
					$total_followers_status = "text-default";
					if($total_followers_summany > 0){
						$total_followers_summany = "+".$total_followers_summany;
						$total_followers_status = "text-success";
					}else if($total_followers_summany < 0){
						$total_followers_status = "text-danger";
					}

					$total_following_status = "text-default";
					if($total_following_summany > 0){
						$total_following_summany = "+".$total_following_summany;
						$total_following_status = "text-success";
					}else if($total_following_summany < 0){
						$total_following_status = "text-danger";
					}

					$total_posts_status = "text-default";
					if($total_posts_summany > 0){
						$total_posts_summany = "+".$total_posts_summany;
						$total_posts_status = "text-success";
					}else if($total_posts_summany < 0){
						$total_posts_status = "text-danger";
					}
					?>

					<tr>
						<td><i class="ft-crosshair"></i> <?php _e("Total Summary")?></td>
						<td colspan="2"><span class="<?php _e($total_followers_status)?>"><?php _e(($total_followers_summany!=0)?$total_followers_summany:"-")?></span></td>
						<td colspan="2"><span class="<?php _e($total_following_status)?>"><?php _e(($total_following_summany!=0)?$total_following_summany:"-")?></span></td>
						<td colspan="2"><span class="<?php _e($total_posts_status)?>"><?php _e(($total_posts_summany!=0)?$total_posts_summany:"-")?></span></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<?php 
		$compare_new_followers_value_string = "[".substr($compare_new_followers_value_string, 0, -1)."]";
		$compare_new_following_value_string = "[".substr($compare_new_following_value_string, 0, -1)."]";
		$compare_total_followers_value_string = "[".substr($compare_total_followers_value_string, 0, -1)."]";
		$compare_total_following_value_string = "[".substr($compare_total_following_value_string, 0, -1)."]";
		?>
	</div>
	<div class="box-analytics">

		<div class="row">
			<div class="col-md-6">
				<div class="card-body box-analytic">
		            <canvas id="ig-analytics-get-followers-following-line-stacked-area" height="300"></canvas>
		        </div>
		        <div class="title-chart text-info"><?php _e("Compare new Followers and Following evolution chart")?></div>
			</div>
			<div class="col-md-6">
				<div class="card-body box-analytic">
		            <canvas id="ig-analytics-total-followers-following-line-stacked-area" height="300"></canvas>
		        </div>
		        <div class="title-chart text-info"><?php _e("Compare total Followers and Following evolution chart")?></div>
			</div>
		</div>	

		<div class="box-head">
			<h3 class="text-info title"><?php _e("Average Engagement Rate")?></h3>
			<div class="description"><?php _e("Each value in this chart is equal to the Average Engagement Rate of the account in that specific day.")?></div>
		</div>
		<div class="row">
	    	<div class="col-md-12">
				<div class="card-body box-analytic">
		            <canvas id="ig-analytics-engagement-line-stacked-area" height="300"></canvas>
		        </div>
		    </div>
		</div>
	    <div class="title-chart text-info"><?php _e("Average Engagement Rate Chart")?></div>

	    <div class="box-head">
			<h3 class="text-info title"><?php _e("Future Projections")?></h3>
			<div class="description"><?php _e("Here you can see the approximated future projections based on your previous days averages")?></div>
		</div>

		<?php 
		$average_followers = $total_days>0?(int)ceil($total_followers_summany/$total_days):0;
		$average_posts = $total_days>0?(int)ceil($total_posts_summany/$total_days):0;
		?>
		<div class="table_sumary">
			<table class="table">
				<thead>
					<tr>
						<td><?php _e("Time Until")?></td>
						<td><?php _e("Date")?></td>
						<td><?php _e("Followes")?></td>
						<td><?php _e("Posts")?></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e("Current Stats")?></td>
						<td><?php _(date("d M, Y", strtotime(reset($result->list_summary)->date)))?></td>
						<td><?php _(number_format(reset($result->list_summary)->followers))?></td>
						<td><?php _(number_format(reset($result->list_summary)->posts))?></td>
					</tr>
					<?php if($total_days > 0){ ?>
					<tr>
	                    <td>30 <?php _e("days")?></td>
	                    <td><?php _e((new \DateTime())->modify('+30 day')->format('Y-m-d')) ?></td>
	                    <td><?php _e(number_format($follower_count + ($average_followers * 30))) ?></td>
	                    <td><?php _e(number_format($media_count + ($average_posts * 30))) ?></td>
	                </tr>
	                <tr>
	                    <td>60 <?php _e("days")?></td>
	                    <td><?php _e((new \DateTime())->modify('+60 day')->format('Y-m-d')) ?></td>
	                    <td><?php _e(number_format($follower_count + ($average_followers * 60))) ?></td>
	                    <td><?php _e(number_format($media_count + ($average_posts * 60))) ?></td>
	                </tr>
	                <tr>
	                    <td>3 <?php _e("months")?></td>
	                    <td><?php _e((new \DateTime())->modify('+90 day')->format('Y-m-d')) ?></td>
	                    <td><?php _e(number_format($follower_count + ($average_followers * 90))) ?></td>
	                    <td><?php _e(number_format($media_count + ($average_posts * 90))) ?></td>
	                </tr>
	                <tr>
	                    <td>6 <?php _e("months")?></td>
	                    <td><?php _e((new \DateTime())->modify('+180 day')->format('Y-m-d')) ?></td>
	                    <td><?php _e(number_format($follower_count + ($average_followers * 180))) ?></td>
	                    <td><?php _e(number_format($media_count + ($average_posts * 180))) ?></td>
	                </tr>
	                <tr>
	                    <td>9 <?php _e("months")?></td>
	                    <td><?php _e((new \DateTime())->modify('+279 day')->format('Y-m-d')) ?></td>
	                    <td><?php _e(number_format($follower_count + ($average_followers * 279))) ?></td>
	                    <td><?php _e(number_format($media_count + ($average_posts * 279))) ?></td>
	                </tr>
	                <tr>
	                    <td>1 <?php _e("year")?></td>
	                    <td><?php _e((new \DateTime())->modify('+365 day')->format('Y-m-d')) ?></td>
	                    <td><?php _e(number_format($follower_count + ($average_followers * 365))) ?></td>
	                    <td><?php _e(number_format($media_count + ($average_posts * 365))) ?></td>
	                </tr>
	                <tr>
	                    <td>1 <?php _e("year and half")?></td>
	                    <td><?php _e((new \DateTime())->modify('+547 day')->format('Y-m-d')) ?></td>
	                    <td><?php _e(number_format($follower_count + ($average_followers * 547))) ?></td>
	                    <td><?php _e(number_format($media_count + ($average_posts * 547))) ?></td>
	                </tr>
	                <tr>
	                    <td>2 <?php _e("years")?></td>
	                    <td><?php _e((new \DateTime())->modify('+730 day')->format('Y-m-d')) ?></td>
	                    <td><?php _e(number_format($follower_count + ($average_followers * 730))) ?></td>
	                    <td><?php _e(number_format($media_count + ($average_posts * 730))) ?></td>
	                </tr>
	                <?php }?>
				</tbody>
				<tfoot>
					<?php if($total_days > 0){ ?>
					<tr>

						<?php 
						$average_followers = "-";
						if($average_followers > 0){
							$average_followers = "<span class='text-success'>+".number_format($average_followers)."<span>";
						}else if($average_followers < 0){
							$average_followers = "<span class='text-danger'>".number_format($average_followers)."<span>";
						}

						$average_posts = "-";
						if($average_posts > 0){
							$average_posts = "<span class='text-success'>+".number_format($average_posts)."<span>";
						}else if($average_posts < 0){
							$average_posts = "<span class='text-danger'>".number_format($average_posts)."<span>";
						}
						?>

	                    <td colspan="2"><i class="ft-crosshair"></i> <?php _e("Based on an average of")?></td>
	                    <td><?php _e(sprintf(__("%s followers/day"), $average_followers)) ?></td>
	                    <td><?php _e(sprintf(__("%s posts/day"), $average_posts)) ?></td>
	                </tr>
					<?php }else{?>
					<tr>
						<td colspan="4" style="font-weight: 400"><?php _e("There is not enough data to generate future projections, please come back tomorrow.")?></td>
					</tr>
					<?php }?>
				</tfoot>
			</table>
		</div>

	</div>

	<div class="box-analytics">
		<div class="box-head none-export">
			<h3 class="text-info title"><?php _e("Top Posts")?></h3>
			<div class="description"><?php _e("Top posts from the last 10 posts")?></div>
		</div>

		<div class="row none-export">
			<div class="owl-carousel">
				<?php if(!empty($feeds)){
				foreach ($feeds as $key => $row) {
					$row = (object)$row;
				?>
			  	<div class="item">
			  		<?php _e(get_embed_html($row->media_id), false)?>
				</div>
				<?php }}?>
			</div>
		</div>

		<div class="row">
			<?php if(!empty($top_mentions)){?>
			<div class="col-md-6">
				<div class="box-head">
					<h3 class="text-info title"><?php _e("Top mentions")?></h3>
					<div class="description"><?php _e("Top mentions from the last 10 posts")?></div>

				</div>
				<ul class="summary-list-group">
					<?php 
					$count = 1;
					foreach ($top_mentions as $key => $value) {
					?>
					<li class="item"><div class="num"><?php _e($count)?></div> <a href="https://www.instagram.com/<?php _e($key)?>" target="_blank">@<?php _e($key)?></a> (<span class="text-info"><?php _e($value)?></span>)</li>
					<?php $count++; }?>
				</ul>
			</div>
			<?php }?>
			<?php if(!empty($top_hashtags)){?>
			<div class="col-md-6">
				<div class="box-head">
					<h3 class="text-info title"><?php _e("Top hashtags")?></h3>
					<div class="description"><?php _e("Top hashtags from the last 10 posts")?></div>

				</div>
				<ul class="summary-list-group">
					<?php 
					$count = 1;
					foreach ($top_hashtags as $key => $value) {
					?>
					<li class="item"><div class="num"><?php _e($count)?></div> <a href="https://www.instagram.com/explore/tags/<?php _e($key)?>" target="_blank">#<?php _e($key)?></a> (<span class="text-info"><?php _e($value)?></span>)</li>
					<?php $count++; }?>
				</ul>
			</div>
			<?php }?>
		</div>	
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		<?php if(!empty($result)){?>
		Instagram_analytics.lineChart(
            "ig-analytics-followers-line-stacked-area",
            <?php _e($result->date_chart)?>, 
            [
                <?php _e($result->followers_chart)?>,
            ],
            [
                "<?php _e('Followers')?>"
            ],
            "line",
            ["#fd397a"]
        );

        Instagram_analytics.lineChart(
            "ig-analytics-following-line-stacked-area",
            <?php _e($result->date_chart)?>, 
            [
                <?php _e($result->following_chart)?>,
            ],
            [
                "<?php _e('Following')?>"
            ],
            "line",
            ["#5578eb"]
        );

        Instagram_analytics.lineChart(
            "ig-analytics-engagement-line-stacked-area",
            <?php _e($result->date_chart)?>, 
            [
                <?php _e($result->engagement_chart)?>,
            ],
            [
                "<?php _e("Average Engagement Rate")?>"
            ],
            "line",
            ["#0abb87"]
        );

        Instagram_analytics.lineChart(
            "ig-analytics-get-followers-following-line-stacked-area",
            <?php _e($result->date_chart)?>, 
            [
                <?php _e($compare_new_followers_value_string!="-"?$compare_new_followers_value_string:"[]")?>,
                <?php _e($compare_new_following_value_string!="-"?$compare_new_following_value_string:"[]")?>,
            ],
            [
                "<?php _e('Followers')?>",
                "<?php _e('Following')?>"
            ],
            "line",
            ["#fd397a", "#5578eb"]
        );

        Instagram_analytics.lineChart(
            "ig-analytics-total-followers-following-line-stacked-area",
            <?php _e($result->date_chart)?>, 
            [
                <?php _e($compare_total_followers_value_string)?>,
                <?php _e($compare_total_following_value_string)?>
            ],
            [
                "<?php _e('Followers')?>",
                "<?php _e('Following')?>"
            ],
            "line",
            ["#fd397a", "#5578eb"]
        );
        <?php }?>

	  	$(".owl-carousel").owlCarousel({
	  		nav: true,
	  		responsiveClass:true,
    		responsive:{
    			0:{
	            	items:1
	        	},

	        	600:{
	            	items:1
	        	},

		        1024:{
		            items:3
		        }
		    }		
	  	});
	});

	if ( typeof window.instgrm !== 'undefined' ) {
	    window.instgrm.Embeds.process();
	}
</script>

<?php }else{?>
<div class="wrap-m h-100">
	<div class="empty">
		<div class="icon"></div>
	</div>
</div>
<?php }?>