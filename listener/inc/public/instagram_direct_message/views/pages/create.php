<form action="<?php _e( get_module_url("send/".segment(3))) ?>" method="POST" class="actionFormInbox">
  <input type="hidden" name="userid" class="cb-load-id">
	<div class="chatbox">
		<div class="cb-header">
			<div class="cb-info">
				<div class="avatar"><img class="cb-load-avatar" src=""></div>
				<div class="desc">
					<div class="title cb-load-username">{username}</div>
					<div class="small"><?php _e("Profile")?></div>
				</div>
        <a class="cb-load-remove" href="javascript:void(0);"><i class="ft-x-circle"></i></a>
			</div>
		</div>
		<div class="cb-loading">
			<div class="stage">
	      		<div class="dot-elastic"></div>
	        </div>
		</div>
		<div class="cb-body"></div>
		<div class="cb-footer">
      <div class="input-group">
          <textarea class="form-control input-message" name="message" placeholder="<?php _e("Message...")?>"></textarea>     
          <div class="input-group-addon">
            <button type="submit" class="btn btn-default btn-send text-info"><i class="fas fa-paper-plane"></i></button>
            <input type="hidden" class="form-control" name="ig_send_media" id="ig_send_media" value="">
            <a class="btn btn-send-media btnOpenFileManager text-success" data-id="ig_send_media" data-select="single" data-type="image" type="button"><i class="fas fa-photo-video"></i></a>
          </div>
      </div>
    </div>
	</div>
</form>

<form action="<?php _e( get_module_url("search/".segment(3)))?>" method="POST" class="FromCBSearch" data-content="cb-add-user-result" data-result="html">
  <div class="cb-add-user">
    <div class="wrap">
      <div class="input-group box-search-one">
          <input class="form-control cb-search-user" type="text" autocomplete="off" placeholder="<?php _e("Search instagram user")?>">
          <span class="input-group-append">
            <button class="btn" type="button">
                <i class="fa fa-search"></i>
            </button>
        </span>
      </div>
      <div class="cb-add-user-result"></div>
    </div>
  </div>
</form>

<script type="text/javascript">
$(function(){
  Instagram_direct_message.chatbox("<?php _e( segment(3) )?>", "");
});
</script>