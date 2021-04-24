<?php 
$account = $result->account;
$feed = $result->feed;
$activity = $result->activity;

if($account && $activity){
	if( pin_get_setting("save_count", 0, $activity->id) ){
		$media_gained = $account->pin_count - pinac( $activity->settings, "media_count" );
		$follower_gained = $account->follower_count - pinac( $activity->settings, "follower_count" );
		$following_gained = $account->following_count - pinac( $activity->settings, "following_count" );
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
			<div class="fw-6 m-b-5"><?php _e( $account->full_name )?></div>
		</div>
		<div class="col-md-6 ig-ac-profile-info-count">
			<div class="row">
				<div class="col m-b-30">
					<div class="item">
						<div class="num">
							<span class="text-info"><?php _e( $account->pin_count )?></span>
							<span class="small <?php _e( stripos($media_gained, "+") === FALSE?"text-danger":"text-success" )?>"><?php _e( $media_gained )?></span>
						</div>
						<div class="text"><?php _e("Medias")?></div>
					</div>
				</div>
				<div class="col m-b-30">
					<div class="item">
						<div class="num">
							<span class="text-info"><?php _e( $account->follower_count )?></span>
							<span class="small <?php _e( stripos($follower_gained, "+") === FALSE?"text-danger":"text-success" )?>"><?php _e( $follower_gained )?></span>
						</div>
						<div class="text"><?php _e("Followers")?></div>
					</div>
				</div>
				<div class="col m-b-30">
					<div class="item">
						<div class="num">
							<span class="text-info"><?php _e( $account->following_count )?></span>
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
		if($row->type == "pin"){
			switch ( $row->is_video ) {

				case 1:
					$image = $row->images->orig->url;
					$icon = "fas fa-video";
					break;

				default:
					$image = $row->images->orig->url;
					$icon = "far fa-image";
					break;
			}
	?>

		<div class="box-item col-md-3 m-b-30">
			<div class="item">
				<a href="<?php _e( "https://www.pinterest.com/pin/".$row->id )?>" target="_blank" class="img" style="background-image: url('<?php _e( $image )?>');"><i class="<?php _e( $icon )?>"></i></a>
				<div class="info wrap-m">
					<div class="wrap-c">
						<a href="https://www.pinterest.com<?php _e( $row->board->url )?>" target="_blank" class="text-dark"><i class="fas fa-chalkboard text-success"></i> <?php _e( $row->board->name )?></a>
					</div>
					<div class="wrap-c">
						<a href="<?php _e( get_module_url("ajax_delete_media/".segment(3)."/".$row->id ) )?>" class="actionItem" data-remove="box-item"><i class="far fa-trash-alt"></i></a>
					</div>
				</div>

			</div>
		</div>
	<?php }?>
	<?php endforeach ?>

</div>

<?php }else{?>

	<?php if($account && $activity){?>
		<div class="empty m-t-100 m-b-100">
			<div class="icon"></div>
		</div>
	<?php }?>

<?php }?>