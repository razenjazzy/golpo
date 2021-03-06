<?php
$allow_packages = json_decode( get_data($result, 'packages') );
?>


<div class="subheadline wrap-m">
	
	<div class="sh-main wrap-c">
		<div class="sh-title text-info fs-18 fw-5"><i class="far fa-edit"></i> <?php _e('Update')?></div>
	</div>
	<div class="sh-toolbar wrap-c">
		<div class="btn-group" role="group">
	    	<a 
	    		class="btn btn-label-info actionItem" 
	    		data-result="html" 
	    		data-content="column-two"
	    		data-history="<?php _e( get_module_url() )?>" 
	    		data-call-after="Layout.inactive_subsidebar();" 
	    		href="<?php _e( get_module_url() )?>"
	    	>
	    		<i class="fas fa-chevron-left"></i> <?php _e('Back')?>
	    	</a>
		</div>
	</div>

</div>

<div class="m-t-10">
	<form class="actionForm" action="<?php _e( get_module_url( 'save/'.segment(4) ) )?>" data-redirect="<?php _e( get_module_url() )?>">
		
		<div class="row">
			<div class="col-md-6">
				<form>
					<div class="form-group">
				    	<label for="status"><?php _e('Status')?></label>
				    	<div>
				    		<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" checked="true" value="1" <?php _e( get_data($result, 'status', 'radio', 1) )?> > <?php _e('Enable')?>
								<span></span>
							</label>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" value="0" <?php _e( get_data($result, 'status', 'radio', 0) )?> > <?php _e('Disable')?>
								<span></span>
							</label>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="proxy"><?php _e('Proxy')?></label>
				    	<input type="text" class="form-control" id="proxy" name="proxy" value="<?php _e( get_data($result, 'address') )?>">
				    	<div class="small m-t-5">
				    		<div class="text-info"><?php _e("Proxy format username:password@ip:port OR ip:port")?></div>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="location"><?php _e('Location')?></label>
				    	<select name="location" class="form-control" id="location">
                            <option value="unknown"><?php _e("Unknown")?></option>
                            <?php foreach (list_countries() as $key => $value){?>
                                <option value="<?php _e($key)?>" <?php _e( !empty($result) && $key == $result->location ?"selected":"" )?> ><?php _e($value)?></option>                             
                            <?php }?>                                
                        </select>
				  	</div>
				  	<div class="form-group">
				    	<label for="packages"><?php _e('Packages')?></label>
				    	<div>
				    		<?php if(!empty($packages)){
				    			foreach ($packages as $package) {
				    		?>
				    		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-r-10">
								<input type="checkbox" name="packages[]" value="<?php _e( $package->id )?>" <?php _e( (!empty( $allow_packages ) && in_array($package->id, $allow_packages ))?"checked":"" )?> > <?php _e( $package->name )?>
								<span></span>
							</label>
							<?php }}?>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="limit"><?php _e('Limit')?></label>
				    	<input type="number" class="form-control" id="limit" name="limit" value="<?php _e( get_data($result, 'limit') )?>">
				    	<div class="small m-t-5">
				    		<div class="text-info"><?php _e("Limit accounts can use this proxy on each social network, Set empty to unlimited")?></div>
				    	</div>
				  	</div>
				  	<button type="submit" class="btn btn-primary"><?php _e('Submit')?></button>
				</form>
			</div>
		</div>

	</form>

</div>