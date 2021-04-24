<div class="col-md-3 col-sm-6">
	<div class="card m-b-30">
		<div class="card-header wrap-m">
			<div class="card-title wrap-c m-b-0"><i class="<?php _e( $module_icon )?> p-r-5" style="color: <?php _e( $module_color )?>"></i> <?php _e( $module_name )?></div>
		</div>
		<div class="card-body widget-list h-300 nicescroll p-0 no-update">
			<?php if(!empty($result)){?>

				<?php foreach ($result as $row): ?>
				<div class="widget-item widget-item-3 search-item line padding">
				 	<a href="<?php _e( get_data($row, 'url') )?>" target="_blank">
		                <div class="icon"><img src="<?php _e( get_data($row, 'avatar') )?>"></div>
		                <?php if($row->status == 1){?>
		                <div class="content content">
		                    <div class="title fw-4"><?php _e( get_data($row, 'name') )?></div>
		                </div>
		                <?php }else{?>
		                <div class="content content-2">
		                    <div class="title fw-4"><?php _e( get_data($row, 'name') )?></div>
		                    <div class="desc text-danger"><?php _e("Relogin required")?></div>
		                </div>
		                <?php }?>
		            </a>
					
					<div class="widget-option">
						<div class="dropdown">
			                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
			                    <i class="ft-more-vertical"></i>
			                </button>
			                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-anim dropdown-menu-top-unround">
			                    <li><a href="<?php _e( get_module_url('delete') )?>" data-id="<?php _e( get_data($row, 'ids') )?>" class="actionItem" data-remove="widget-item" data-confirm="<?php _e('Are you sure to delete this items?')?>"><i class="far fa-trash-alt"></i> <?php _e('Delete')?></a></li>
			                </ul>
			            </div>
					</div>
				</div>				
				<?php endforeach ?>

			<?php }else{?>
			<div class="empty small"></div>
			<?php }?>
		</div>
	</div>
</div>