<?php 
if(!empty( $result->getUsers() )){
?>

	<?php 
		foreach ($result->getUsers() as $row) {
	?>
	<div class="ig-ac-option-item-list">
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-b-0">
			<input type="checkbox" value="<?php _e($row->getUsername())?>|<?php _e($row->getPk())?>"> <a href="https://www.instagram.com/<?php _e($row->getUsername())?>" target="_blank"><img src="<?php _e( $row->getProfilePicUrl() )?>">  <?php _e($row->getUsername())?></a><span></span>
		</label>
	</div>
	<?php }?>

	<div class="m-t-15">
		<button type="button" class="btn btn-info btn-add-username"><?php _e("Add")?></button>
	</div>

<?php }?>
