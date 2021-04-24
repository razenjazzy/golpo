<?php 
if(!empty( $result->getVenues() )){
?>

	<?php 
		foreach ($result->getVenues() as $row) {
	?>
	<div class="ig-ac-option-item-list">
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-b-0">
			<input type="checkbox" value="<?php _e($row->getName())?>|<?php _e($row->getExternalId())?>"> <a href="https://www.instagram.com/explore/locations/<?php _e($row->getExternalId())?>" target="_blank"><?php _e($row->getName())?></a><span></span>
		</label>
	</div>
	<?php }?>

	<div class="m-t-15">
		<button type="button" class="btn btn-info btn-add-location"><?php _e("Add")?></button>
	</div>

<?php }?>
