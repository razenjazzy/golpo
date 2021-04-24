<form action="<?php _e( get_url("instagram_activity") )?>">
    <div class="fm-filter">
        <div class="input-group box-search-one">
            <input class="form-control search-input" name="k" type="text" autocomplete="off" placeholder="<?php _e('Search')?>" value="<?php _e( post("k") )?>">
            <span class="input-group-append">
                <button class="btn" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>

        <div class="form-group">
            <label><?php _e('Sort by')?></label>
            <select class="form-control activityFilterAction" name="s">
                <option value=""><?php _e('-')?></option>
                <option value="username" <?php _e( post("s") == "username" ? "selected" : "" )?> ><?php _e('Username')?></option>
                <option value="time" <?php _e( post("s") == "time" ? "selected" : "" )?> ><?php _e('Time')?></option>
            </select>
        </div>

        <div class="form-group">
            <label><?php _e('Filter')?></label>
            <select class="form-control activityFilterAction"  name="f">
                <option value=""><?php _e('-')?></option>
                <option value="started" <?php _e( post("f") == "started" ? "selected" : "" )?> ><?php _e('Started')?></option>
                <option value="stopped" <?php _e( post("f") == "stopped" ? "selected" : "" )?> ><?php _e('Stopped')?></option>
                <option value="none" <?php _e( post("f") == "none" ? "selected" : "" )?> ><?php _e('No time')?></option>
            </select>
        </div>
    </div>
</form>