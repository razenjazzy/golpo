<div class="alert alert-solid-brand">
	<span class="fw-6"><?php _e("Click this link to create Vk app:")?></span>
	<a href="https://vk.com/editapp?act=create" target="_blank">https://vk.com/editapp?act=create</a>	
</div>

<div class="form-group">
    <label for="vk_app_id"><?php _e('Vk app id')?></label>
    <input type="text" class="form-control" id="vk_app_id" name="vk_app_id" value="<?php _e( get_option('vk_app_id', '') )?>">
</div>
<div class="form-group">
    <label for="vk_secure_secret"><?php _e('Vk secure key')?></label>
    <input type="text" class="form-control" id="vk_secure_secret" name="vk_secure_secret" value="<?php _e( get_option('vk_secure_secret', '') )?>">
</div>