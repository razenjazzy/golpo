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
<script type="text/javascript">
  $('.cb-body').attr("data-cursor", "<?php _e( $cursor_id ) ?>");
</script>

<?php }?>