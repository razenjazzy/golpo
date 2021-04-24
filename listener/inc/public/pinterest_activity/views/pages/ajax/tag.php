<?php 
if(!empty( $result )){
?>

	<?php 
		foreach ($result as $row) {
			$row = (object)$row;
			if(isset($row->query)){
				$query = str_replace("#", "", $row->query);
	?>
	<div class="ig-ac-option-item-list">
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-b-0">
			<input type="checkbox" value="<?php _e($query)?>"> <a href="https://www.pinterest.com<?php _e( $row->url )?>" target="_blank"><?php _e($query)?></a> (<?php _e($row->pin_count )?>)<span></span>
		</label>
	</div>
	<?php }}?>

	<div class="m-t-15">
		<button type="button" class="btn btn-info btn-add-tag"><?php _e("Add")?></button>
	</div>

<?php }?>
