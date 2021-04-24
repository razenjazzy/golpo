<?php if(!empty($result)){?>
<div class="row">
	<?php foreach ($result as $row) {?>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 m-b-25">
		<div class="ig-ac-basic-info">
			<?php if($row->account_status == 0){?>
			<div class="disable wrap-c">
				<a href="<?php _e( get_url("instagram_profiles/index/oauth") )?>" class="btn btn-label-danger"><?php _e("Re-login")?></a>
			</div>
			<?php }?>
			<div class="info">
				<div class="avatar"><img src="<?php _e( get_url( get_data($row, "avatar") ) )?>"></div>
				<div class="detail"> 
					<div class="title"><?php _e( get_data($row, "username") )?></div>
					<div class="desc"><?php _e("Profile")?></div>
				</div>
				<div class="icon">
					<i class="fab fa-instagram"></i>
				</div>
			</div>

			<div class="status wrap-m">
				<div class="wrap-c"><?php _e("Status")?></div> 
				<div class="wrap-c">
					<?php if($row->status == "1"){?>
					<span class="ig-ac-status started badge badge-success"><?php _e("Started")?></span>
					<span class="ig-ac-status stopped badge badge-danger d-none"><?php _e("Stopped")?></span>
					<span class="ig-ac-status none badge badge-dark d-none"><?php _e("No time")?></span>
					<?php }else if($row->status == "0"){?>
					<span class="ig-ac-status started badge badge-success d-none"><?php _e("Started")?></span>
					<span class="ig-ac-status stopped badge badge-danger"><?php _e("Stopped")?></span>
					<span class="ig-ac-status none badge badge-dark d-none"><?php _e("No time")?></span>
					<?php }else{?>
					<span class="ig-ac-status started badge badge-success d-none"><?php _e("Started")?></span>
					<span class="ig-ac-status stopped badge badge-danger d-none"><?php _e("Stopped")?></span>
					<span class="ig-ac-status none badge badge-dark"><?php _e("No time")?></span>
					<?php }?>
				</div>
			</div>

			<div class="stats">
				<div class="stats-item wrap-m">
					<div class="wrap-c">
						<?php _e("Comments")?>
						<?php if( pin_get_setting("comment_block", "", $row->id) ){?>
						<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("comment_block", "", $row->id) )?>"></i>
						<?php }?>	
					</div>
					<div class="wrap-c"><span class="badge badge-dark"><?php _e( pinac( $row->settings, "comment" ) )?></span></div>
				</div>
				<div class="stats-item wrap-m">
					<div class="wrap-c">
						<?php _e("Follows")?>
						<?php if( pin_get_setting("follow_block", "", $row->id) ){?>
						<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("follow_block", "", $row->id) )?>"></i>
						<?php }?>	
					</div>
					<div class="wrap-c"><span class="badge badge-dark"><?php _e( pinac( $row->settings, "follow" ) )?></span></div>
				</div>
				<div class="stats-item wrap-m">
					<div class="wrap-c">
						<?php _e("Unfollows")?>
						<?php if( pin_get_setting("unfollow_block", "", $row->id) ){?>
						<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("unfollow_block", "", $row->id) )?>"></i>
						<?php }?>
					</div>
					<div class="wrap-c"><span class="badge badge-dark"><?php _e( pinac( $row->settings, "unfollow" ) )?></span></div>
				</div>
				<div class="stats-item wrap-m">
					<div class="wrap-c">
						<?php _e("Direct messages")?>
						<?php if( pin_get_setting("direct_block", "", $row->id) ){?>
						<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("direct_block", "", $row->id) )?>"></i>
						<?php }?>		
					</div>
					<div class="wrap-c"><span class="badge badge-dark"><?php _e( pinac( $row->settings, "direct" ) )?></span></div>
				</div>
				<div class="stats-item wrap-m">
					<div class="wrap-c">
						<?php _e("Repost medias")?>
						<?php if( pin_get_setting("repost_block", "", $row->id) ){?>
						<i class="fas fa-exclamation-circle text-warning" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="<?php _e( pin_get_setting("repost_block", "", $row->id) )?>"></i>
						<?php }?>	
					</div>
					<div class="wrap-c"><span class="badge badge-dark"><?php _e( pinac( $row->settings, "repost" ) )?></span></div>
				</div>
			</div>

			<div class="action">
				<div class="btn-group btn-group-block" role="group">
				  	<?php if($row->status != ""){?>

				  		<?php if( $row->status == 1 ){?>
					  		<a href="<?php _e( get_module_url("start/".get_data($row, "username")) )?>" class="btn btn-secondary ig-ac-btn-start d-none"><?php _e("Start")?></a>
					  		<a href="<?php _e( get_module_url("stop/".get_data($row, "username")) )?>" class="btn btn-label-danger ig-ac-btn-stop"><?php _e("Stop")?></a>
					  	<?php }else if( $row->status == 0 ){?>
					  		<a href="<?php _e( get_module_url("start/".get_data($row, "username")) )?>" class="btn btn-secondary ig-ac-btn-start"><?php _e("Start")?></a>
					  		<a href="<?php _e( get_module_url("stop/".get_data($row, "username")) )?>" class="btn btn-label-danger ig-ac-btn-stop d-none"><?php _e("Stop")?></a>
					  	<?php }?>
					  	<a href="<?php _e( get_module_url("page/settings/".get_data($row, "username")) )?>" class="btn btn-secondary"><?php _e("Settings")?></a>
					  	<div class="btn-group btn-group-block" role="group">
						    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
						      	<?php _e("More")?>
						    </button>
						    <div class="dropdown-menu dropdown-menu-right dropdown-menu-anim">
						     	<a class="dropdown-item" href="<?php _e( get_module_url("page/log/".get_data($row, "username")) )?>"><?php _e("Log")?></a>
						      	<a class="dropdown-item" href="<?php _e( get_module_url("page/stats/".get_data($row, "username")) )?>"><?php _e("Stats")?></a>
						    </div>
					  	</div>
					  	
				  	<?php }else{?>
				  		<a href="<?php _e( get_module_url("page/settings/".get_data($row, "username")) )?>" class="btn btn-secondary"><?php _e("Settings")?></a>
				  	<?php }?>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
</div>
<?php }else{?>
<div class="wrap-m h-100">
	<div class="empty">
		<div class="icon"></div>
		<a 
    		class="btn btn-info" 
    		href="<?php _e( get_url('pinterest_boards/index/oauth') )?>"
    	>
    		<i class="fab fa-pinterest"></i> <?php _e('Add account')?>
    	</a>
	</div>
</div>
<?php }?>