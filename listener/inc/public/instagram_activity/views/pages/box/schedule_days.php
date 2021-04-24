<div id="schedule_days" class="modal fade" role="dialog">
  	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title"><i class="ft-calendar" aria-hidden="true"></i> <?php _e('Schedule')?></h5>
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	      	</div>
	      	<div class="modal-body">

	      		<p class="fs-12"><?php _e('The schedule allows you to set up a unique schedule by time and day for your system activity to run You can manually select individual hours when your activity should be active or you can use next presets')?>
	      		</p>
	      		<div class="text-center day-schedule-auto">
	      			<a data-type="none" href="javascript:void(0);"><?php _e('None')?></a>
	      			<a data-type="all" href="javascript:void(0);"><?php _e('All')?></a>
	      			<a data-type="day" href="javascript:void(0);"><?php _e('Daytime')?></a>
	      			<a data-type="night" href="javascript:void(0);"><?php _e('Nighttime')?></a>
					<br>
	      			<a data-type="odd" href="javascript:void(0);"><?php _e('Odd')?></a>
					<a data-type="even" href="javascript:void(0);"><?php _e('Even')?></a>
					<a data-type="alternate1" href="javascript:void(0);"><?php _e('Alternate 1')?></a>
					<a data-type="alternate2" href="javascript:void(0);"><?php _e('Alternate 2')?></a>

	      			<div class="type">
	      				<div class="item">
							<span class="box active"></span> <?php _e('Activity started')?>    					
	      				</div>
	      				<div class="item">
							<span class="box"></span> <?php _e('Activity paused')?>    					      					
	      				</div>
	      			</div>
	      		</div>

      			<div class="day-schedule-selector"></div>
      			<input type="hidden" name="schedule_days" value="<?php _e( $activity?$schedule_days:$schedule_default )?>"">

	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-info click-action-save" data-dismiss="modal"><?php _e('Save')?></button>
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e('Close')?></button>
	      	</div>
	    </div>

  	</div>
</div>