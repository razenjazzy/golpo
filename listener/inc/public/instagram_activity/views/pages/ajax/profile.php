<?php 
$account = $result->account;
$feed = $result->feed;
$activity = $result->activity;
$page = $result->maxId;

if($account && $activity){
	if( ig_get_setting("save_count", 0, $activity->id) ){
		$media_gained = $account->getMediaCount() - igac( $activity->settings, "media_count" );
		$follower_gained = $account->getFollowerCount() - igac( $activity->settings, "follower_count" );
		$following_gained = $account->getFollowingCount() - igac( $activity->settings, "following_count" );
	}else{
		$media_gained = 0;
		$follower_gained = 0;
		$following_gained = 0;
	}


	if($media_gained > 0){
		$media_gained = "+".$media_gained;
	}else if($media_gained < 0){
		$media_gained = $media_gained;
	}else{
		$media_gained = "";
	}

	if($follower_gained > 0){
		$follower_gained = "+".$follower_gained;
	}else if($follower_gained < 0){
		$follower_gained = $follower_gained;
	}else{
		$follower_gained = "";
	}

	if($following_gained > 0){
		$following_gained = "+".$following_gained;
	}else if($following_gained < 0){
		$following_gained = $following_gained;
	}else{
		$following_gained = "";
	}
}else{
	$media_gained = "";
	$follower_gained = "";
	$following_gained = "";
}

?>

<?php if($account && $activity){?>
<div class="col-md-12">
	
	<div class="ig-ac-profile-info row">
	
		<div class="col-md-6 m-b-25">
			<div class="fw-6 m-b-5"><?php _e( $account->getFullName() )?></div>
			<div class="m-b-5"><?php _e( $account->getBiography() )?></div>
			<div class=""><a href="<?php _e( $account->getExternalUrl() )?>"><?php _e( $account->getExternalUrl() )?></a></div>
		</div>
		<div class="col-md-6 ig-ac-profile-info-count">
			<div class="row">
				<div class="col m-b-30">
					<div class="item">
						<div class="num">
							<span class="text-info"><?php _e( $account->getMediaCount() )?></span>
							<span class="small <?php _e( stripos($media_gained, "+") === FALSE?"text-danger":"text-success" )?>"><?php _e( $media_gained )?></span>
						</div>
						<div class="text"><?php _e("Medias")?></div>
					</div>
				</div>
				<div class="col m-b-30">
					<div class="item">
						<div class="num">
							<span class="text-info"><?php _e( $account->getFollowerCount() )?></span>
							<span class="small <?php _e( stripos($follower_gained, "+") === FALSE?"text-danger":"text-success" )?>"><?php _e( $follower_gained )?></span>
						</div>
						<div class="text"><?php _e("Followers")?></div>
					</div>
				</div>
				<div class="col m-b-30">
					<div class="item">
						<div class="num">
							<span class="text-info"><?php _e( $account->getFollowingCount() )?></span>
							<span class="small <?php _e( stripos($following_gained, "+") === FALSE?"text-danger":"text-success" )?>"><?php _e( $following_gained )?></span>
						</div>
						<div class="text"><?php _e("Following")?></div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>
<?php }?>

<?php if( !empty($feed) ){ ?>

	<?php foreach ($feed as $row):

		switch ( $row->getMediaType() ) {
			case 2:
				$image = $row->getImageVersions2()->getCandidates()[0]->getUrl();
				$icon = "fas fa-video";
				break;

			case 1:
				$image = $row->getImageVersions2()->getCandidates()[0]->getUrl();
				$icon = "far fa-image";
				break;

			case 8:
				$image = $row->getCarouselMedia()[0]->getImageVersions2()->getCandidates()[0]->getUrl();
				$icon = "fas fa-photo-video";
				break;
			
			default:
				$image = "";
				$icon = "";
				break;
		}

	?>

		<div class="box-item col-md-3 m-b-30">
			<div class="item">
				<a href="<?php _e( "https://instagram.com/p/".$row->getCode() )?>" target="_blank" class="img" style="background-image: url('<?php _e( $image )?>');"><i class="<?php _e( $icon )?>"></i></a>
				<div class="info wrap-m">
					<div class="wrap-c">
						<span><i class="far fa-heart text-danger m-r-5"></i> <?php _e( $row->getLikeCount() )?></span>
						<!-- <span><i class="far fa-comment text-success m-r-5"></i> 1</span> -->
					</div>
					<div class="wrap-c">
						<a href="<?php _e( get_module_url("ajax_delete_media/".segment(3)."/".$row->getPk() ) )?>" class="actionItem" data-remove="box-item"><i class="far fa-trash-alt"></i></a>
					</div>
				</div>

			</div>
		</div>

	<?php endforeach ?>

</div>

<?php }else{?>

	<?php if($account && $activity){?>
		<div class="empty m-t-100 m-b-100">
			<div class="icon"></div>
		</div>
	<?php }?>

<?php }?>

<div class="next-page" data-page="<?php _e( $page )?>" ></div>