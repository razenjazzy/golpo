<?php 
if(!empty( $result )){
?>

	<?php 
		foreach ($result as $row) {
			$row = (object)$row;
	?>
	<div class="ig-ac-option-item-list">
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-b-0">
			<input type="checkbox" value="<?php _e($row->username)?>"> <a href="https://www.pinterest.com/<?php _e( $row->username) ?>" target="_blank"><img src="<?php _e( $row->image_medium_url )?>">  <?php _e($row->username)?></a><span></span>
		</label>
	</div>
	<?php }?>

	<div class="m-t-15">
		<button type="button" class="btn btn-info btn-add-blacklist-username"><?php _e("Add")?></button>
	</div>

<?php }?>
