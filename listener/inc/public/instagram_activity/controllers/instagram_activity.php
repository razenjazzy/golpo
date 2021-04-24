<?php
class instagram_activity extends MY_Controller {
	
	public $tb_account_manager = "sp_account_manager";
	public $tb_instagram_activities = "sp_instagram_activities";
	public $tb_instagram_activities_log = "sp_instagram_activities_log";

	public function __construct(){
		parent::__construct();
		_permission(get_class($this)."_enable");
		$this->load->model(get_class($this).'_model', 'model');

		$module_path = get_module_directory(__DIR__);
		include $module_path.'libraries/vendor/autoload.php';
		include $module_path.'libraries/igac.php';

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		$this->module_color = get_module_config( $this, 'color' );
		//

		$this->ig = new igac();
	}

	public function index()
	{	
		$result = $this->model->get_activities();

		$views = [
			"subheader" => view( 'main/subheader', [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon, 'module_color' => $this->module_color ], true ),
			"column_one" => view("main/sidebar", [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
			"column_two" => view("pages/general", [ "result" => $result ] ,true), 
		];
		
		views( [
			"title" => $this->module_name,
			"fragment" => "fragment_two_right",
			"views" => $views
		] );
	}

	public function page($page = "", $ids = "")
	{
		$team_id = _t("id");
		$data = [];

		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$ids}' AND social_network = 'instagram' AND login_type = '2' AND team_id = '{$team_id}'");

		if(!$account || $account->status == 0){
			redirect( get_module_url() );
		}

		$activity = $this->model->get("*", $this->tb_instagram_activities, "account = '{$ids}' AND team_id = '{$team_id}'");

		$data['account'] = $account;

		switch ($page) {
			case 'settings':
				
				
				$recent_activities = false;
				if($activity){
					$recent_activities = $this->model->fetch("*", $this->tb_instagram_activities_log, " pid = '{$activity->id}' AND team_id = '{$team_id}'", "created", "DESC", 0, 10);
				}

				$data['recent_activities'] = $recent_activities;
				$data['activity'] = $activity;
				$page = page($this, "pages", "settings", "settings", $data);
				break;

			case 'stats':
				if(!$activity){
					redirect( get_module_url("page/settings/".$ids) );
				}
				$page = page($this, "pages", "stats", "stats", $data);
				break;

			case 'log':
				if(!$activity){
					redirect( get_module_url("page/settings/".$ids) );
				}
				$page = page($this, "pages", "log", "log", $data);
				break;

			case 'profile':
				if(!$activity){
					redirect( get_module_url("page/settings/".$ids) );
				}
				$page = page($this, "pages", "profile", "profile", $data);
				break;
			
			default:
				$page = page($this, "pages", "general", "empty", $data);
				break;
		}

		if( !is_ajax() ){
			$views = [
				"subheader" => view( 'main/subheader', [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon, 'module_color' => $this->module_color ], true ),
				"column_one" => $page, 
			];
			
			views( [
				"title" => $this->module_name,
				"fragment" => "fragment_one",
				"views" => $views
			] );
		}else{
			view("pages/general", ["result" => $stats, "account" => $account], false);
		}
	}

	public function ajax_load_log($ids = "", $type = ""){
		$team_id = _t("id");
		$activity = $this->model->get("*", $this->tb_instagram_activities, "account = '{$ids}' AND team_id = '{$team_id}'");
		if( !$activity ) return false;

		$page = (int)post("page");

		$data = [
			'page' => $page,
			'result' => $this->model->get_log($activity->id, $type, $page)
		];

		view("pages/ajax/log", $data, false);
	}

	public function ajax_load_stats($ids = "", $type = ""){
		$team_id = _t("id");
		$activity = $this->model->get("*", $this->tb_instagram_activities, "account = '{$ids}' AND team_id = '{$team_id}'");
		if( !$activity ) return false;

		$page = (int)post("page");

		$data = [
			'page' => $page,
			'result' => $this->model->get_stats($activity->id, $type, $page)
		];

		view("pages/ajax/stats", $data, false);
	}

	public function ajax_load_profile($ids = ""){
		$team_id = _t("id");
		$activity = $this->model->get("*", $this->tb_instagram_activities, "account = '{$ids}' AND team_id = '{$team_id}'");
		if( !$activity ) return false;

		$page = post("page");

		$result = $this->model->get_profile($activity->id, $page);

		$data = [
			'page' => $result->maxId,
			'result' => $result
		];

		view("pages/ajax/profile", $data, false);
	}

	public function ajax_delete_media($ids = "", $media_id = ""){
		$team_id = _t("id");

		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$ids}' AND social_network = 'instagram' AND login_type = 2 AND status = 1 AND team_id = '{$team_id}'");

		if(!$account){
			ms([
				"status" => "error",
				"message" => __("There was a temporary problem with your request")
			]);
		}

		try {
			$this->ig->login($account);
			$this->ig->ig->media->delete($media_id);
		} catch (Exception $e) {
			ms([
				"status" => "error",
				"message" => $e->getMessage()
			]);
		}

		ms([
			"status" => "success",
			"message" => __("Success")
		]);
	}

	public function start($ids = ""){
		$team_id = _t("id");
		$activity = $this->model->get("*", $this->tb_instagram_activities, "account = '{$ids}' AND team_id = '{$team_id}'");
		if(!$activity){
			ms([
				"status" => "error",
				"message" => __("There was a temporary problem with your request")
			]);
		}

		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$activity->account}' AND social_network = 'instagram' AND login_type = 2 AND status = 1");
		if(!$account){
			ms([
				"status" => "error",
				"message" => __("There was a temporary problem with your request")
			]);
		}

		try {
			$this->ig->login($account);
			$account_info = $this->ig->get_user_info()->getUser();
		} catch (Exception $e) {
			ms([
				"status" => "error",
				"message" => $e->getMessage()
			]);
		}

		$activity_data = json_decode($activity->data);
		$settings = json_decode($activity->settings);
		$todos = get_value($activity_data, "todos");
		$targets = get_value($activity_data, "targets");
		$op_comments = get_value($activity_data, "op_comments");
		$comments = get_value($activity_data, "comments");
		$op_directs = get_value($activity_data, "op_directs");
		$directs = get_value($activity_data, "directs");
		$op_reposts = get_value($activity_data, "op_reposts");
		$reposts = get_value($activity_data, "reposts");
		$tags = get_value($activity_data, "tags");
		$locations = get_value($activity_data, "locations");
		$usernames = get_value($activity_data, "usernames");
		$speeds = get_value($activity_data, "speeds");
		$todo_params = [];

		//Roles
		validate("empty", "Select at least one task to get started", $todos);
		validate("empty", "Please select at least one type of target to get started", $targets);

		if(isset($targets->tag) && empty($tags)){
			ms(array(
				"status" => "error",
				"message"=> __('Please select at least one tag to get started')
			));
		}

		if(isset($todos->comment) && empty($comments)){
			ms(array(
				"status" => "error",
				"message"=> __('Please enter at least one comment to get started')
			));
		}

		if(isset($todos->direct) && empty($directs)){
			ms(array(
				"status" => "error",
				"message"=> __('Please enter at least one message to get started')
			));
		}

		if(isset($targets->location) && empty($locations)){
			ms(array(
				"status" => "error",
				"message"=> __('Please select at least one location to get started')
			));
		}
		
		if(
			(isset($targets->follower) && $targets->follower != "me" && empty($usernames)) 
			|| (isset($targets->following) && $targets->following != "me" && empty($usernames)) 
			|| (isset($targets->liker) && $targets->liker != "me" && empty($usernames)) 
			|| (isset($targets->commenter) && $targets->commenter != "me" && empty($usernames)) 
		){
			ms([
				"status" => "error",
				"message"=> __('Please select at least one username to get started')
			]);
		}

		$like_speed = get_value($speeds, "like");
		if($like_speed > 60 || $like_speed < 1){
			ms([
				"status" => "error",
				"message" => __('Just allowed values 1-60 likes per hour')
			]);
		}

		$comment_speed = get_value($speeds, "comment");
		if($comment_speed > 20 || $comment_speed < 1){
			ms([
				"status" => "error",
				"message" => __('Just allowed values 1-20 comments per hour')
			]);
		}

		$watching_story_speed = get_value($speeds, "watching_story");
		if($watching_story_speed > 60 || $watching_story_speed < 1){
			ms([
				"status" => "error",
				"message" => __('Just allowed values 1-60 follows per hour')
			]);
		}

		$follow_speed = get_value($speeds, "follow");
		if($follow_speed > 40 || $follow_speed < 1){
			ms([
				"status" => "error",
				"message" => __('Just allowed values 1-40 follows per hour')
			]);
		}

		$unfolow_speed = get_value($speeds, "unfollow");
		if($unfolow_speed > 40 || $unfolow_speed < 1){
			ms([
				"status" => "error",
				"message" => __('Just allowed values 1-40 unfollows per hour')
			]);
		}

		$direct_speed = get_value($speeds, "direct");
		if($direct_speed > 20 || $direct_speed < 1){
			ms([
				"status" => "error",
				"message" => __('Just allowed values 1-20 direct messages per hour')
			]);
		}

		$repost_speed = get_value($speeds, "repost");
		if($repost_speed > 5 || $repost_speed < 1){
			ms([
				"status" => "error",
				"message" => __('Just allowed values 1-5 repost per day')
			]);
		}

		if(isset($todos->repost)){

			switch ($activity_data->op_reposts->by) {
				case 'tag':
					if( empty($tags) ){
						ms(array(
							"status" => "error",
							"message"=> __('Please select at least one tags to can start repost action')
						));
					}
					break;

				case 'location':
					if( empty($locations) ){
						ms(array(
							"status" => "error",
							"message"=> __('Please select at least one locations to can start repost action')
						));
					}
					break;

				case 'username':
					if(empty($usernames)){
						ms(array(
							"status" => "error",
							"message"=> __('Please select at least one usernames to can start repost action')
						));
					}
					break;
				
				default:
					if( empty($tags) ){
						ms(array(
							"status" => "error",
							"message"=> __('Please select at least one tags to can start repost action')
						));
					}

					if( empty($locations) ){
						ms(array(
							"status" => "error",
							"message"=> __('Please select at least one locations to can start repost action')
						));
					}

					if(empty($usernames)){
						ms(array(
							"status" => "error",
							"message"=> __('Please select at least one usernames to can start repost action')
						));
					}
					break;
			}
		}

		$this->db->delete($this->tb_instagram_activities, array('pid' => $activity->id));

		foreach ($todos as $action => $status) {

			$todo_params[] = $action;
			$item = $this->model->get("id", $this->tb_instagram_activities, "action = '{$action}' AND pid = {$activity->id}");

			switch ($action) {
				case 'repost':
					$settings = json_encode(get_random_numbers($speeds->$action, 3600, 1));
					break;

				default:
					$settings = json_encode(get_random_numbers($speeds->$action));
					break;
			}

			$data = array(
				"ids" => ids(),
				"team_id" => $team_id,
				"pid" => $activity->id,
				"account" => $activity->account,
				"action" => $action, 
				"time" => time(), 
				"data" => $activity->data,
				"settings" => $settings, 
				"status" => 1,
				"changed" => time(),
				"created" => time()
			);

			$this->db->insert($this->tb_instagram_activities, $data);
		}

		$this->db->update($this->tb_instagram_activities, ["changed" => time(), "status" => 1], ["id" => $activity->id]);

		//Save follow, following, media count
		$save_count = ig_get_setting("save_count", 0, $activity->id);
		if(!$save_count){
			ig_get_setting("follower_count", 0, $activity->id);
			ig_get_setting("current_follower_count", 0, $activity->id);
			ig_get_setting("following_count", 0, $activity->id);
			ig_get_setting("media_count", 0, $activity->id);

			ig_update_setting("save_count", 1, $activity->id);
			ig_update_setting("current_follower_count", $account_info->getFollowerCount(), $activity->id);
			ig_update_setting("follower_count", $account_info->getFollowerCount(), $activity->id);
			ig_update_setting("following_count", $account_info->getFollowingCount(), $activity->id);
			ig_update_setting("media_count", $account_info->getMediaCount(), $activity->id);
		}

		ms(['status' => 'success']);
	}

	public function stop($ids = ""){
		$team_id = _t("id");
		$activity = $this->model->get("*", $this->tb_instagram_activities, "account = '{$ids}' AND team_id = '{$team_id}'");

		if(!$activity){
			ms([
				"status" => "error",
				"message" => __("There was a temporary problem with your request")
			]);
		}

		$this->db->delete($this->tb_instagram_activities, array('pid' => $activity->id));
		$this->db->update($this->tb_instagram_activities, array("status" => 0), array("id" => $activity->id));

		ms(["status" => "success"]);
	}

	public function save($ids = ""){
		$team_id = _t("id");
		if($ids == "") ms(["status" => "error"]);
		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$ids}' AND team_id = '{$team_id}'");
		if(empty($account)) ms(["status" => "error"]);

		$todos = post("todos");
		$targets = post("targets");
		$speeds = post("speeds");
		$filters = post("filters");
		$op_comments = post("op_comments");
		$comments = post("comments");
		$op_comments = post("op_comments");
		$watching_stories = post("watching_stories");
		$follows = post("follows");
		$unfollows = post("unfollows");
		$op_directs = post("op_directs");
		$directs = post("directs");
		$op_reposts = post("op_reposts");
		$reposts = post("reposts");
		$tags = post("tags");
		$locations = post("locations");
		$usernames = post("usernames");
		$blacklist_tags = post("blacklist_tags");
		$blacklist_keywords = post("blacklist_keywords");
		$blacklist_usernames = post("blacklist_usernames");
		$schedule_days = post("schedule_days");
		$stops = post("stops");
		$activity_settings = [];

		//To do
		$todo_data = [
			"like" => get_value($todos, "like"),
			"comment" => get_value($todos, "comment"),
			"watching_story" => get_value($todos, "watching_story"),
			"follow" => get_value($todos, "follow"),
			"unfollow" => get_value($todos, "unfollow"),
			"direct" => get_value($todos, "direct"),
			"repost" => get_value($todos, "repost")
		];
		$activity_settings['todos'] = remove_empty_value($todo_data);

		//Targets
		$target_data = [
			"tag" => get_value($targets, "tag"),
			"location" => get_value($targets, "location"),
			"follower" => get_value($targets, "follower"),
			"following" => get_value($targets, "following"),
			"liker" => get_value($targets, "liker"),
			"commenter" => get_value($targets, "commenter")
		];
		$activity_settings['targets'] = remove_empty_value($target_data);

		//Speeds
		$speed_data = [
			"level" => get_value($speeds, "level"),
			"like" => get_value($speeds, "like"),
			"comment" => get_value($speeds, "comment"),
			"watching_story" => get_value($speeds, "watching_story"),
			"follow" => get_value($speeds, "follow"),
			"unfollow" => get_value($speeds, "unfollow"),
			"direct" => get_value($speeds, "direct"),
			"repost" => get_value($speeds, "repost")
		];
		$activity_settings['speeds'] = remove_empty_value($speed_data);

		//Filters
		$filter_data = [
			"media_age" => get_value($filters, "media_age"),
			"media_type" => get_value($filters, "media_type"),
			"min_like" => get_value($filters, "min_like"),
			"max_like" => get_value($filters, "max_like"),
			"min_comment" => get_value($filters, "min_comment"),
			"max_comment" => get_value($filters, "max_comment"),
			"user_relation" => get_value($filters, "user_relation"),
			"user_profile" => get_value($filters, "user_profile"),
			"min_follower" => get_value($filters, "min_follower"),
			"max_follower" => get_value($filters, "max_follower"),
			"min_following" => get_value($filters, "min_following"),
			"max_following" => get_value($filters, "max_following")
		];
		$activity_settings['filters'] = remove_empty_value($filter_data);

		//Option comments
		$op_comments_data = [
			'dont_spam' => get_value($op_comments, "dont_spam")
		];
		$activity_settings['op_comments'] = remove_empty_value($op_comments_data);

		//Comments
		$activity_settings['comments'] = remove_empty_value($comments);

		//Option directs
		$op_directs_data = [
			'by' => get_value($op_directs, "by")
		];
		$activity_settings['op_directs'] = remove_empty_value($op_directs_data);

		//Directs
		$activity_settings['directs'] = remove_empty_value($directs);

		//Option reposts
		$op_reposts_data = [
			'by' => get_value($op_reposts, "by")
		];
		$activity_settings['op_reposts'] = remove_empty_value($op_reposts_data);

		//Reposts
		$activity_settings['reposts'] = $reposts;

		//Follows
		$follow_data = [
			"cycle" => get_value($follows, "cycle"),
			"dont_spam" => get_value($follows, "dont_spam"),
			"dont_private" => get_value($follows, "dont_private"),
		];
		$activity_settings['follows'] = remove_empty_value($follow_data);

		//Unfollows
		$unfollow_data = [
			"cycle" => get_value($unfollows, "cycle"),
			"source" => get_value($unfollows, "source"),
			"after" => get_value($unfollows, "after"),
			"dont_follower" => get_value($unfollows, "dont_follower"),
		];
		$activity_settings['unfollows'] = remove_empty_value($unfollow_data);

		//Tags
		$activity_settings['tags'] = remove_empty_value($tags);

		//Locations
		$activity_settings['locations'] = remove_empty_value($locations);

		//Usernames
		$activity_settings['usernames'] = remove_empty_value($usernames);

		//Blacklist
		$activity_settings['blacklist_tags'] = remove_empty_value($blacklist_tags);
		$activity_settings['blacklist_usernames'] = remove_empty_value($blacklist_usernames);
		$activity_settings['blacklist_keywords'] = remove_empty_value($blacklist_keywords);

		//Auto Stop
		$stop_data = [
			"like" => get_value($stops, "like"),
			"comment" => get_value($stops, "comment"),
			"watching_story" => get_value($stops, "watching_story"),
			"follow" => get_value($stops, "follow"),
			"unfollow" => get_value($stops, "unfollow"),
			"direct" => get_value($stops, "direct"),
			"repost" => get_value($stops, "repost"),
			"timer" => get_value($stops, "timer"),
			"no_activity" => get_value($stops, "no_activity"),
		];
		$activity_settings['stops'] = remove_empty_value($stop_data);

		//Schedule days
		$activity_settings['schedule_days'] = $schedule_days;

		$activity_settings_encode = json_encode($activity_settings);

		$activity = $this->model->get("*", $this->tb_instagram_activities, "account = '{$ids}' AND pid = 0 AND team_id = '{$team_id}'");

		if(!empty($activity)){
			$data = [
				"action" => "main",
				"data" => $activity_settings_encode,
				"status" => 0
			];
			$this->db->update($this->tb_instagram_activities, $data, ["id" => $activity->id]);
			$this->db->delete($this->tb_instagram_activities, ["pid" => $activity->id]);

			if($activity->status == 1){
				ms([
					"status" => "error",
					"message" => __('All activities stopped when you changed. Click the Start button to continue'),
				]);
			}
		}else{
			$data = [
				"ids" => $ids,
				"team_id" => $team_id,
				"pid" => 0,
				"account" => $account->pid,
				"action" => "main",
				"data" => $activity_settings_encode,
				"changed" => time(),
				"created" => time()
			];

			$this->db->insert($this->tb_instagram_activities, $data);
			$id = $this->db->insert_id();
		}

		ms(["status" => "success"]);
	}

	public function search($page = ""){
		$team_id = _t("id");
		$keyword = post("keyword");
		$account = $this->model->get("*", $this->tb_account_manager, "pid = '".segment(4)."' AND social_network = 'instagram' AND login_type = 2 AND team_id = '{$team_id}' AND status = 1");
		if($account){
			try {
				$this->ig->login($account);
				switch ($page) {
					case 'tag':
						$result = $this->ig->search("tag", $keyword);
						return  view("pages/ajax/tag", ["result" => $result], false);
						break;

					case 'location':
						$result = $this->ig->search("location", $keyword);
						return  view("pages/ajax/location", ["result" => $result], false);
						break;

					case 'username':
						$result = $this->ig->search("username", $keyword);
						return  view("pages/ajax/username", ["result" => $result], false);
						break;

					case 'blacklist_tag':
						$result = $this->ig->search("tag", $keyword);
						return  view("pages/ajax/blacklist_tag", ["result" => $result], false);
						break;

					case 'blacklist_username':
						$result = $this->ig->search("username", $keyword);
						return  view("pages/ajax/blacklist_username", ["result" => $result], false);
						break;
					
					default:
						break;
				}
			} catch (Exception $e) {
				ms([
					"status" => "error",
					"message" => $e->getMessage()
				]);
			}
		}

		ms(["status" => "error"]);
	}

	public function stop_activity($action){
		$id = $action->pid;
		$type = $action->action;
		$stop_count = ig_get_setting($type."_tmp", 0, $id);
		$data = json_decode($action->data);

		//SAVE
		$status = 1;
		$save = array("data" => json_encode($data), "status" => $status);
		
		if(isset($data->todos) && isset($data->todos->$type)){
			unset($data->todos->$type);
			$save["data"] = json_encode($data);
			if(empty($data->todos)){
				$status = 0;
			}
		}
		//END SAVE

		//Schedule
		if($action->action != "repost"){
			$schedule_days = json_decode($data->schedule_days);
			$day = date("w", time());
			$hour = date("G", time());
			$hours_today = $schedule_days[$day];
			if(!empty($schedule_days)){
				if(!in_array($hour, $hours_today)){
					$next_hour = -1;

					$hour_tmp = $hour;
					$next = 0;
					$reload = 0;
					for ($i=$hour; $i < 100; $i++) { 
						if(!in_array($hour_tmp, $hours_today)){
							$next++;
						}else{
							break;
						}

						 
						if($i >= 23 && $reload == 0){
							$hour_tmp = 0;
							$reload = 1;
						}else{
							$hour_tmp++;
						}
					}

					$this->db->update(
						$this->tb_instagram_activities, 
						[
							"time" => time() + $next*3600
						], 
						"pid = {$id}"
					);

					return true;
				}
			}
		}

		//Timer stop
		if(isset($data->stops) && isset($data->stops->timer) && strlen($data->stops->timer) == 5)
		{
			$str_time = $data->stops->timer;
			$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "$1:$2", $str_time);
			sscanf($str_time, "%d:%d", $hours, $minutes);
			$time_seconds = $hours * 3600 + $minutes * 60;

			if( $action->created + $time_seconds < time() )
			{
				$this->db->update($this->tb_instagram_activities, $save, "id = {$id} OR pid = {$id}");
				$this->db->delete($this->tb_instagram_activities, [ "pid" => $id, "action" => $type ] );
				return true;
			}
		}

		//No activity stop
		if($action->action != "repost" && isset($data->stops) && isset($data->stops->no_activity) && $data->stops->no_activity != "no"){
			switch ($data->stops->no_activity) {
				case '1h':
					$strtotime = 3600;
					break;

				case '3h':
					$strtotime = 10800;
					break;

				case '12h':
					$strtotime = 43200;
					break;

				case '1d':
					$strtotime = 86400;
					break;

				case '3d':
					$strtotime = 259200;
					break;

				case '1w':
					$strtotime = 604800;
					break;
			}

			//Action stop
			if( isset($strtotime) && $action->time + $strtotime < time() )
			{
				$this->db->update($this->tb_instagram_activities, $save, "id = {$id} OR pid = {$id}");
				$this->db->delete($this->tb_instagram_activities, array("pid" => $id, "action" => $type));
				return true;
			}
		}

		if(isset($data->stops) && isset($data->stops->$type) && $data->stops->$type != 0 && $stop_count >= $data->stops->$type){
			$this->db->update($this->tb_instagram_activities, $save, "id = {$id} OR pid = {$id}");
			$this->db->delete($this->tb_instagram_activities, array("pid" => $id, "action" => $type));
			return true;
		}else{
			return false;
		}
	}

	public function save_log($action, $result){
		if(!$result) return false;

		$type = $action->action;
		$main_id = $action->pid;
		$team_id = $action->team_id;
		$settings = json_decode($action->data);
		$media_id = NULL;

		$count_action = ig_get_setting($type, 0, $main_id) + 1;
		$count_action_tmp = ig_get_setting($type."_tmp", 0, $main_id) + 1;

		ig_update_setting($type."_block", "", $main_id);
		ig_update_setting($type, $count_action, $main_id);
		ig_update_setting($type."_tmp", $count_action_tmp, $main_id);

		$parse_result = json_decode( json_encode( $result ) );

		if( isset($parse_result->code) ){

			if( $result->getCarouselMedia() ){
				$images = $result->getCarouselMedia()[0]->getImageVersions2()->getCandidates();
				$image = end( $images );
				$image = $image->getUrl();
			}else{
				$images = $result->getImageVersions2()->getCandidates();
				$image = end ($images);
				$image = $image->getUrl();
			}

			$user_id = $result->getUser()->getPk();
			$media_id = $result->getId();
			$item = array(
				"id" => $result->getCode(),
				"username" => $result->getUser()->getUsername(),
				"userid" => $result->getUser()->getPk(),
				"image" => $image,
				"type" => $result->getMediaType()
			);

		}else{

			$user_id = $result->getPk();
			$image = $result->getProfilePicUrl();
			$item = array(
				"id" => $result->getPk(),
				"username" => $result->getUsername(),
				"userid" => $result->getPk(),
				"image" => $image,
				"type" => "user"
			);

		}

		$save_log = array(
			"ids" => ids(),
			"team_id" => $team_id,
			"pid" => $main_id,
			"action" => $type,
			"user_id" => $user_id,
			"media_id" => $media_id,
			"data" => json_encode($item),
			"created" => time()
		);

		$this->db->insert($this->tb_instagram_activities_log, $save_log); 
	}

	public function cron()
	{
		$time = strtotime(date("Y-m-d"));

		$actions = $this->db->select('a.*, b.username, b.token, b.proxy, b.pid as account_id')
		->from($this->tb_instagram_activities." as a")
		->join($this->tb_account_manager." as b", "a.account = b.pid")
		->where(" a.status = 1 AND b.status = 1 AND a.pid != 0 AND a.time <= '".time()."' ")->order_by("time", "asc")->limit(5,0)->get()->result();

		if(empty($actions)){ 
			_e("Empty schedule");
			exit(0);
		}

		foreach ($actions as $action) {
			
			$main_id = $action->pid; 
			$type = $action->action;
			$activity_data = json_decode($action->data);
			$speeds = get_value($activity_data, "speeds");

			switch ($type) {
				case 'repost':
					$next = get_time_next_schedule($action->settings, $speeds->$type, 1440, 1);
					break;

				default:
					$next = get_time_next_schedule($action->settings, $speeds->$type);
					break;
			}

			$stop = $this->stop_activity($action);
			if($stop){ continue; }


			if($next->task != 0){
				$action->number = $next->task;
				
				try {
					$this->ig->login($action);
					$result = $this->ig->run($action);
					
					$this->save_log($action, $result);
					$next->numbers = get_action_left($next->numbers, $result, $next->task);

				} catch (Exception $e) {
					ig_update_setting($type."_block", $e->getMessage(), $main_id);
					$next->numbers = get_action_left($next->numbers, array(), $next->task);
				}
			}

			$this->db->update(
				$this->tb_instagram_activities, 
				[
					"time" => time() + $next->minute*60, 
					"settings" => json_encode($next->numbers)
				],
				["id" => $action->id ]
			);

		}

		_e("Success");
	}

}