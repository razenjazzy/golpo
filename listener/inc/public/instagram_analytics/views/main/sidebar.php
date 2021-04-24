<div class="input-group box-search-one">
  	<input class="form-control search-input" type="text" autocomplete="off" placeholder="<?php _e('Search')?>">
  	<span class="input-group-append">
	    <button class="btn" type="button">
	        <i class="fa fa-search"></i>
	    </button>
	</span>
</div>

<div class="widget">
	
	<div class="widget-list search-list">
		<?php if( !empty($result) ){?>

			<?php foreach ($result as $row): ?>
				<div class="widget-item widget-item-3 search-list <?php _e( segment(3) == get_data($row, 'ids')?"active":"" ) ?>" data-pid="<?php _e( get_data($row, 'pid') )?>">
					 <a href="<?php _e( get_module_url("index/".get_data($row, 'ids')) )?>" class="actionItem" data-result="html" data-content="column-two" data-history="<?php _e( get_module_url("index/".get_data($row, 'ids')) )?>" data-call-after="Layout.tooltip();">
		                <div class="icon"><img src="<?php _e( BASE.get_data($row, 'avatar') )?>"></div>
		                <div class="content content-2">
		                    <div class="title fw-4"><?php _e( get_data($row, 'name') )?></div>
		                    <div class="desc"><?php _e( ucfirst( $row->social_network . " " . __($row->category) ) )?></div>
		                </div>
		            </a>
					
					<div class="widget-option">
						<label class="i-radio i-radio--tick i-radio--brand m-t-6">
							<input type="radio" name="account[]" class="check-item" <?php _e( segment(3) == get_data($row, 'ids')?"checked":"" ) ?> value="<?php _e( get_data($row, 'social_network')."__".get_data($row, 'ids') )?>" >
							<span></span>
						</label>
					</div>
				</div>
			<?php endforeach ?>

		<?php }else{?>
			<div class="empty small"></div>
		<?php }?>
	</div>

</div>