<div class="tab-pane fade" id="v-pills-keyword" role="tabpanel" aria-labelledby="v-pills-keyword-tab">
	
	<div class="row m-b-25">
		<div class="col-md-12">
			<div class="ig-ac-option">
				<div class="form-group">
		  			<textarea class="form-control form-add-keyword-list" placeholder="<?php _e("Enter your keywords. Break line the row to add a new keyword.")?>"></textarea>
		  		</div>
		  		<button type="button" class="btn btn-info btn-add-keyword-list"><?php _e("Add")?></button>
			</div>
		</div>
	</div>	

	<div class="m-b-0 list-add-keyword">

		<div class="ig-ac-option-title text-info fs-18 m-b-25 wrap-m">
			<div class="wrap-c"><i class="fab fa-creative-commons-nd p-r-5"></i> <?php _e("Keywords")?></div>
			<div class="wrap-c">
				<a href="javascript:void(0);" class="btn btn-label-danger btn-sm remove-all"><i class="far fa-trash-alt"></i> <?php _e("Delete all")?></a>
			</div>
		</div>

		<?php if(!empty($keywords)){
		foreach ($keywords as $keyword) {
		?>
			<div class="ig-ac-option-item-keyword">
				<a href="javascript:void(0);" class="remove"><i class="fas fa-times-circle text-danger"></i></a> <a class="name" href="https://www.pinterest.com/search/pins/?q=<?php echo $keyword?>" target="_blank"><?php echo $keyword?></a>
				<input type="hidden" name="keywords[]" value="<?php echo $keyword?>">
			</div>
		<?php }}else{?>
			<div class="empty small"></div>
		<?php }?>
		
	</div>

</div>