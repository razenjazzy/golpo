<?php if( $result && !empty( $result->getUsers() ) ){
foreach ($result->getUsers() as $key => $row) {
?>
<a class="item" href="javascript:void(0);" data-username="<?php _e($row->getUsername())?>" data-avatar="<?php _e($row->getProfilePicUrl())?>" data-name="<?php _e($row->getFullName())?>" data-id="<?php _e($row->getPk())?>">
  <div class="avatar"><img src="<?php _e($row->getProfilePicUrl())?>"></div>
  <div class="desc">
    <div class="title"><?php _e($row->getFullName())?></div>
    <div class="small"><?php _e($row->getUsername())?></div>
  </div>
</a>
<?php }}?>