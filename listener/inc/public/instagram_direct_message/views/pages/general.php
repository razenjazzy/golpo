<?php 
if(!empty($result)){
$thread_title = $result->getThreadTitle();
$cursor_id = $result->getOldestCursor();
$viewer_id = $result->getViewerId();
$items = $result->getItems();
$items = array_reverse($items);
$change_id = "";
$account_id = segment(3);
$thread_id = segment(4);
$avaliable_type = array("text", "link", "story_share", "media", "like", "animated_media");

$avatars = [ $account->pid => BASE.$account->avatar ];
foreach ($result->getUsers() as $user) {
	$avatars[$user->getPk()] = $user->getProfilePicUrl();
}
?>

<form action="<?php _e( get_module_url("send/".$account_id."/".$thread_id) )?>" method="POST" class="actionFormInbox">
	<div class="chatbox">
		<div class="cb-header">
			<div class="cb-info">
				<div class="avatar"><a href="https://www.instagram.com/<?php _e( $thread_title )?>" target="_blank"><img src="<?php _e( $result->getUsers()[0]->getProfilePicUrl() )?>"></a></div>
				<div class="desc">
					<a href="https://www.instagram.com/<?php _e( $thread_title )?>" target="_blank" class="title"><?php _e( $thread_title )?></a>
					<div class="small"><?php _e("Profile")?></div>
				</div>
			</div>
			<div class="pull-right">
                <div class="btn-group">
                    <a href="<?php _e( get_module_url("hide_thread/".$account_id."/".$thread_id ) )?>" data-id="<?php _e( $thread_id )?>" data-redirect="<?php _e( get_module_url("index/".$account_id) )?>" class="btn btn-default actionItem">
                        <i class="far fa-eye-slash"></i> <?php _e("Hide")?>
                    </a>
                    <a href="<?php _e( get_module_url("create/".$account_id) )?>" class="btn btn-default">
                        <i class="far fa-paper-plane"></i> <?php _e("New message")?>
                    </a>
                </div>
            </div>
		</div>
		<div class="cb-loading">
			<div class="stage">
	      		<div class="dot-elastic"></div>
	        </div>
		</div>
		<div class="cb-body" data-cursor="<?php _e( $cursor_id )?>">
			<div class="cb-wrap-body">
				<?php if(!empty($items)){
				foreach ($items as $item) {
					$check = 0;
				?>

				<?php if(in_array($item->getItemType(), $avaliable_type)){?>
				<div class="cb-item <?php _e ( $viewer_id == $item->getUserId()?"right":"left" )?> thread-item-<?php _e( $item->getItemId() )?>">
					<a href="<?php _e( get_module_url("delete_item/".$account_id."/".$thread_id."/".$item->getItemId() ) )?>" class="cb-remove actionItem"><i class="ft-trash"></i></a>

					<div class="avatar">
						<?php if($change_id != $item->getUserId()){?>
							<img src="<?php _e( $avatars[$item->getUserId()] )?>">
						<?php }?>
					</div>
					<?php if($item->getItemType() == "text"){?>
						<div class="message">
							<?php _e( nl2br($item->getText()) )?>
							<div class="time"><?php _e( datetime_show( $item->getTimestamp()/1000000) )?></div>
						</div>
					<?php }elseif($item->getItemType() == "link"){?>
						<div class="message">
							<?php _e( nl2br($item->getLink()->getText()) )?>
							<div class="time"><?php _e( datetime_show( $item->getTimestamp()/1000000) )?></div>
						</div>
					<?php }elseif($item->getItemType() == "story_share"){?>
						<div class="media">
							<?php _e( $item->getStoryShare()->getMedia()->getUser()->getUsername() )?> <?php _e("Story")?>
							<a href="https://www.instagram.com/stories/<?php _e( $item->getStoryShare()->getMedia()->getUser()->getUsername() )?>" target="_blank"><img src="<?php _e( $item->getStoryShare()->getMedia()->getImageVersions2()->getCandidates()[0]->getUrl() )?>"></a>
							<div class="time"><?php _e( datetime_show( $item->getTimestamp()/1000000) )?></div>
						</div>
					<?php }elseif($item->getItemType() == "media"){?>
						<div class="media">
							<a href="<?php _e( $item->getMedia()->getImageVersions2()->getCandidates()[0]->getUrl() )?>" data-fancybox="group"><img src="<?php _e( $item->getMedia()->getImageVersions2()->getCandidates()[0]->getUrl() )?>"></a>
							<div class="time"><?php _e( datetime_show( $item->getTimestamp()/1000000) )?></div>
						</div>
					<?php }elseif($item->getItemType() == "like"){?>
						<div class="like">
							<?php _e( $item->getLike() )?>
							<div class="time"><?php _e( datetime_show( $item->getTimestamp()/1000000) )?></div>
						</div>
					<?php }elseif($item->getItemType() == "animated_media"){?>
						<div class="media gif">
							<a href="<?php _e( $item->getAnimatedMedia()->getImages()->getFixedHeight()->getUrl() )?>" data-fancybox="group"><img src="<?php _e( $item->getAnimatedMedia()->getImages()->getFixedHeight()->getUrl() )?>"></a>
							<div class="time"><?php _e( datetime_show( $item->getTimestamp()/1000000) )?></div>
						</div>
					<?php }?>
				</div>
				<div class="clearfix"></div>
				<?php $change_id = $item->getUserId(); }}?>
				<?php }?>
			</div>
		</div>
		<div class="cb-footer">
			<div class="input-group">
			    <textarea class="form-control input-message" name="message" placeholder="<?php _e("Message...")?>"></textarea>     
			    <div class="input-group-addon">
			    	<button type="submit" class="btn btn-default btn-send text-info"><i class="fas fa-paper-plane"></i></button>
			    	<input type="hidden" class="form-control" name="ig_send_media" id="ig_send_media" value="">
                    <a class="btn btn-send-media btnOpenFileManager text-success" data-id="ig_send_media" data-select="single" data-type="image" type="button"><i class="fas fa-photo-video"></i></a>
			    </div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
$(function(){
	Instagram_direct_message.chatbox("<?php _e($account_id)?>","<?php _e($thread_id)?>");
});
</script>
<?php }else{?>
<div class="wrap-m h-100">
	<div class="empty">
		<div class="icon"></div>
		<a 
    		class="btn btn-info <?php _e( !segment(3)?"d-none":"" )?>" 
    		data-history="<?php _e( get_module_url('create/'.segment(3)) )?>" 
    		href="<?php _e( get_module_url('create/'.segment(3)) )?>"
    	>
    		<?php _e('New message')?>
    	</a>
	</div>
</div>
<?php }?>


