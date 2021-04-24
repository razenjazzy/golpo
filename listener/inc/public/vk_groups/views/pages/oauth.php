<div class="widget-box-add-account">
	
	<div class="headline m-b-30">
		<div class="title fs-18 fw-5 text-info"><i class="far fa-plus-square"></i> <?php _e('Get access token')?></div>
		<div class="desc"><?php _e("Get and enter your Vk code to get access token")?></div>
	</div>


	<form class="actionForm" action="<?php _e( get_module_url('token') )?>" method="POST" data-redirect="<?php _e( get_module_url('index/general') )?>">
		<div class="form-group">
			<a href="<?php _e($login_url)?>" target="_blank" class="btn btn-social btn-block"><i class="fas fa-external-link-square-alt"></i> <?php _e('Get Vk code')?></a>
		</div>

		<div class="form-group">
			<label for="code"><?php _e("Enter vk code")?></label>
			<input type="text" class="form-control" id="code" name="code">
		</div>
		
		<button type="submit" class="btn btn-block btn-info m-t-15"><?php _e('Get access token')?></button>
	</form>

</div>