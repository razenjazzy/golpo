<?php if( !empty($result) && !empty($result->getThreads()) ){?>

	<?php foreach ($result->getThreads() as $row):?>

		<?php 
		$cursor = "";
		if($result->getHasOlder()){
			$cursor =  $result->getOldestCursor();
		}
		?>

		<div class="widget-item widget-item-3 search-list <?php _e( segment(4) == $row->getThreadId()?"active":"" ) ?>" data-pid="<?php _e( $row->getThreadId() )?>" data-cursor="<?php _e( $cursor )?>" data-account="<?php _e( segment(3) )?>">
			 <a href="<?php _e( get_module_url("index/".segment(3)."/".$row->getThreadId()) )?>" class="actionItem" data-result="html" data-content="column-two" data-history="<?php _e( get_module_url("index/".segment(3)."/".$row->getThreadId()) )?>" data-call-after="Layout.tooltip();">
                <div class="icon"><img src="<?php _e( $row->getUsers()[0]->getProfilePicUrl() )?>"></div>
                <div class="content content-2">
                    <div class="title fw-4"><?php _e( $row->getUsers()[0]->getUsername() )?></div>
                    <div class="desc"><?php _e( $row->getItems()[0]->getText() )?></div>
                </div>
            </a>
			
			<div class="widget-option">
				<label class="i-radio i-radio--tick i-radio--brand m-t-6">
					<input type="radio" name="account[]" class="check-item" <?php _e( segment(4) == $row->getThreadId()?"checked":"" ) ?> value="<?php _e( $row->getThreadId() )?>" >
					<span></span>
				</label>
			</div>
		</div>
	<?php endforeach ?>

<?php }else{?>
	<div class="empty small"></div>
<?php }?>