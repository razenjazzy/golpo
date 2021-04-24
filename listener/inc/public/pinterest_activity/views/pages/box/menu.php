<div class="ig-ac-header">
	
	<div class="top wrap-m">
		<div class="brand wrap-c">
			
				<div class="avatar">
					<a href="<?php _e( "https://instagram.com/".get_data($account, "username") )?>" target="_blank">
						<img src="<?php _e( get_url( get_data($account, "avatar") ) )?>">
					</a>
				</div>
				<div class="info">
					<div class="title"><?php _e( get_data($account, "username") )?></div>
					<div class="desc"><?php _e("Profile")?></div>
				</div>

		</div>

		<div class="menu wrap-c">
			<ul>
				<li class="<?php _e( segment(3)=="settings"?"active":"" )?>"><a href="<?php _e( get_module_url("page/settings/".segment(4)) )?>"><i class="fas fa-cog"></i> <?php _e("Settings")?></a></li>
				<li class="<?php _e( segment(3)=="profile"?"active":"" )?>"><a href="<?php _e( get_module_url("page/profile/".segment(4)) )?>"><i class="fas fa-user"></i> <?php _e("Profile")?></a></li>
				<li class="<?php _e( segment(3)=="stats"?"active":"" )?>"><a href="<?php _e( get_module_url("page/stats/".segment(4)) )?>"><i class="far fa-chart-bar"></i> <?php _e("Stats")?></a></li>
				<li class="<?php _e( segment(3)=="log"?"active":"" )?>"><a href="<?php _e( get_module_url("page/log/".segment(4)) )?>"><i class="fas fa-history"></i> <?php _e("Log")?></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>

</div>