<div class="title m-b-8 fw-6 text-info"><?php _e("Recent activity")?></div>
<div class="recent-activity nicescroll no-update">
	<?php if( !empty( $recent_activities ) ){
		foreach ($recent_activities as $row) {
			$data = json_decode($row->data);
	?>
	<a href="https://www.instagram.com/<?php _e( is_numeric($data->id)?get_data($data, "username"):"p/".get_data($data, "id") )?>" target="_blank" class="item-recent-activity wrap-m">
		<div class="info wrap-c">
			<div class="avatar">
				<img src="<?php _e( get_data($data, "image") )?>">
			</div>
			<div class="detail">
				<div class="desc"><?php _e( igaa($row->action)->text )?></div>
				<div class="title"><?php _e( get_data($data, "id") )?></div>
			</div>
		</div>
		<div class="time wrap-c"><?php _e( time_elapsed_string( $row->created ) )?></div>
	</a>
	<?php }}else{?>
		<div class="empty small"></div>
	<?php }?>
</div>