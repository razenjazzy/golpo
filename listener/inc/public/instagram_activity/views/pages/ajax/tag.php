<?php 
if(!empty( $result->getResults() )){
?>

	<?php 
		foreach ($result->getResults() as $row) {
	?>
	<div class="ig-ac-option-item-list">
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-b-0">
			<input type="checkbox" value="<?php _e($row->getName())?>"> <a href="https://www.instagram.com/explore/tags/<?php _e($row->getName())?>" target="_blank"><?php _e($row->getName())?></a> (<?php _e($row->getFormattedMediaCount())?>)<span></span>
		</label>
	</div>
	<?php }?>

	<div class="m-t-15">
		<button type="button" class="btn btn-info btn-add-tag"><?php _e("Add")?></button>
	</div>

<?php }?>
