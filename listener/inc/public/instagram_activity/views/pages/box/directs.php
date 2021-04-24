<div class="tab-pane fade" id="v-pills-direct" role="tabpanel" aria-labelledby="v-pills-direct-tab">
	
	<div class="row">

		<div class="col-md-4 col-sm-6 m-b-25">
			<div class="ig-ac-option wrap-m">
				<div class="info wrap-c">
					<span class="p-r-5"><?php _e("Direct messages by")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Which users to direct message?<br/><br/><b>New followers</b> — select this option if you want to direct message only your new followers<br/><br/><b>Target</b> — select this option if you want to direct message by target settings", false)?>"></i>
				</div>
				<div class="action wrap-c">
					<select class="form-control action-save" name="op_directs[by]">
  					<option <?php igav($a, "op_directs", "by", "follower") ?> value="follower"><?php _e("New followers")?></option>
					<option <?php igav($a, "op_directs", "by", "target") ?> value="target"><?php _e("Targets")?></option>
  				</select>
				</div>
			</div>
		</div>

	</div>

	<div class="row m-b-25">

		<div class="col-md-12">
			<div class="ig-ac-option">
				<div class="info">
					<span class="p-r-5"><?php _e("Enter your message")?> </span>
					<i class="fa fa-question-circle" data-toggle="tooltip-custom" data-trigger="hover" data-placement="top" data-html="true" title="" data-original-title="<?php _e("Add at least one messsage if you are turned on Direct messsages in your to do section.", false)?>"></i>
					<div class="form-group">
						<textarea class="form-control form-add-direct post-message"></textarea>
					</div>
					<button type="button" class="btn btn-info btn-add-direct"><?php _e("Add new")?></button>
				</div>
			</div>
		</div>

	</div>

	<div class="m-b-0 list-add-direct">

		<div class="ig-ac-option-title text-info fs-18 m-b-25 wrap-m">
			<div class="wrap-c"><i class="fas fa-inbox p-r-5"></i> <?php _e("Messages")?></div>
			<div class="wrap-c">
				<a href="javascript:void(0);" class="btn btn-label-danger btn-sm remove-all"><i class="far fa-trash-alt"></i> <?php _e("Delete all")?></a>
			</div>
		</div>

		<?php if(!empty($directs)){
		foreach ($directs as $direct) {
		?>
		<div>
			<div class="ig-ac-option-item-direct">
				<a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <?php echo nl2br($direct)?>
				<textarea class="d-none" name="directs[]"><?php echo $direct?></textarea>
			</div>
		</div>
		<?php }}else{?>
			<div class="empty small"></div>
		<?php }?>

	</div>

</div>