<?php if(!empty($result)){
foreach ($result as $key => $row) {
	$data = json_decode($row->data);

	switch ($row->action) {
		case 'comment':
			$link = "https://www.pinterest.com/pin/".$data->id;
			break;

		case 'follow':
			$link = "https://www.pinterest.com/".$data->username;
			break;

		case 'unfollow':
			$link = "https://www.pinterest.com/".$data->username;
			break;

		case 'direct':
			$link = "https://www.pinterest.com/".$data->username;
			break;

		case 'repost':
			$link = "https://www.pinterest.com/pin/".$data->id;
			break;
		
		default:
			$link = "https://www.pinterest.com/";
			break;
	}
?>
<div class="col-md-4 col-sm-6 m-b-30">
	<div class="item">
		<div class="item-info">
			<div class="time"><?=time_elapsed_string($row->created)?></div>
			<div class="action">
				<div class="type"><?php _e( pinaa( $row->action )->text )?></div>
				<div class="id"><?php _e( is_numeric( $data->id ) ? $data->username : $data->id )?></div>
			</div>
		</div>
		<a href="<?php _e( $link )?>" target="_blank">
			<div class="box-img">
				<img src="<?php _e( get_data($data, "image") )?>">
				<div class="icon"><i class="<?=pinaa($row->action)->icon?>"></i></div>
			</div>
		</a>
	</div>
</div>
<?php }}else{
	if($page == 0){
?>
<div class="empty m-t-100 m-b-100">
	<div class="icon"></div>
</div>
<?php }}?>