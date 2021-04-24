<?php
class pinterest_activity_model extends MY_Model {
	public $tb_account_manager = "sp_account_manager";
	public $tb_pinterest_activities = "sp_pinterest_activities";
	public $tb_pinterest_activities_log = "sp_pinterest_activities_log";

	public function __construct(){
		parent::__construct();
		$module_path = get_module_directory(__DIR__);
		include $module_path.'libraries/vendor/autoload.php'; 
		include $module_path.'libraries/pinac.php';

		//
		$this->module_name = get_module_config( $module_path, 'name' );
		$this->module_icon = get_module_config( $module_path, 'icon' );
		$this->module_color = get_module_config( $module_path, 'color' );
		//
	}

	public function block_social_settings($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'pinterest' => [
				'position' => 900,
				'name' => __('Pinterest'),
				'desc' => $this->module_name,
				'color' => $this->module_color,
				'icon' => $this->module_icon, 
				'content' => view( $dir.'settings/configuration', ['path' => $path], true, $this ),
			]
		];
	}

	public function block_permissions($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 8550,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'html' => view( $dir.'pages/block_permissions', ['path' => $path], true, $this ),
		];
	}

	public function block_cronjobs($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 30000,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'cronjobs' => [
				[
					"name" => $this->module_name,
					"time" => __("Once/minute"),
					"command_line" => "curl ". get_url( str_replace("_model", "", get_class($this) )."/cron?key=" . get_option("cron_key", uniqid() ) ) ." >/dev/null 2>&1"
				]
			]
		];
	}

	public function get_activities(){
		$team_id = _t("id");
		$this->db->select("a.*, b.username, b.ids as ids, b.avatar, b.status as account_status");
		$this->db->from($this->tb_pinterest_activities." as a");
		$this->db->join($this->tb_account_manager." as b", "a.account = b.pid", "RIGHT");

		$this->db->where("((b.team_id = ".$team_id." AND a.pid = 0 AND b.social_network = 'pinterest' AND b.login_type = '2') OR (b.team_id = '".$team_id."' AND a.pid IS NULL  AND b.social_network = 'pinterest' AND b.login_type = '2'))");
		switch (post("f")) {
			case 'started':
				$this->db->where("a.status", 1);
				break;

			case 'stoped':
				$this->db->where("a.status", 0);
				break;
			
			case 'none':
				$this->db->where("a.status", NULL);
				break;
		}

		if( post("k") ){
			$this->db->like("b.username",  addslashes( post("k") ) );
		}		

		switch (post("s")) {
			case 'username':
				$this->db->order_by("b.username", "asc");
				break;

			case 'time':
				$this->db->order_by("b.created", "asc");
				break;
		}
		
		$query = $this->db->get();

		if($query->result()){
			$accounts = [];
			$result = [];
			foreach ($query->result() as $key => $row) {
				if(!in_array($row->username, $accounts)){
					$accounts[] = $row->username;
					$result[] = $row;
				}
			}
			return $result;
		}else{
			return false;
		}

	}

	public function get_log($account, $type, $page = 0){
		$team_id = _t("id");

		$this->db->select("*");
		$this->db->from($this->tb_pinterest_activities_log);

		switch ($type) {
			case "comment":
				$this->db->where("action", "comment");
				break;

			case "follower":
				$this->db->where("action", "follow");
				break;

			case "unfollow":
				$this->db->where("action", "unfollow");
				break;

			case "direct":
				$this->db->where("action", "direct");
				break;
			case "repost":
				$this->db->where("action", "repost");
				break;
		}

		$this->db->where("pid", $account);
		$this->db->where("team_id", $team_id);
		$this->db->order_by("created", "desc");
		$this->db->limit(30, (int)$page*30);
		$query = $this->db->get();

		if($query->result()){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_stats($id){
		$team_id = _t("id");
		$activity_id = 0;
		$activity = $this->model->get("*", $this->tb_pinterest_activities, "id = '".$id."' AND pid = 0 AND team_id = '".$team_id."'");
		$counter = [
			"comment" => 0, 
			"follow" => 0, 
			"unfollow" => 0, 
			"direct" => 0,
			"repost" => 0 
		];

		$time_start = 0;
		$total_followers_gained = 0;

		if($activity){
			$settings = $activity->settings;
			$counter["comment"] += pinac( $activity->settings, "comment" );
			$counter["follow"] += pinac( $activity->settings, "follow" );
			$counter["unfollow"] += pinac( $activity->settings, "unfollow" );
			$counter["direct"] += pinac( $activity->settings, "direct" );
			$counter["repost"] += pinac( $activity->settings, "repost" );


			$follower_count = pin_get_setting("follower_count", 0, $activity->id);
			$current_follower_count = pin_get_setting("current_follower_count", 0, $activity->id);

			$account = $this->model->get("*", $this->tb_account_manager, " username = '".$activity->ids."' AND team_id = '".$team_id."' AND social_network = 'pinterest' AND login_type = 2 ");
			if($account){
				try {
					$this->pin = new pinac();
					$this->pin->login($account);
					$account_info = $this->pin->get_friendship();
					pin_update_setting("current_follower_count", $account_info->follower_count, $activity->id);
					$current_follower_count = $account_info->follower_count;
				} catch (Exception $e) {}
			}

			if( pin_get_setting("save_count", 0, $activity->id) ){
				$time_start = time_elapsed_string( $activity->created );
				$total_followers_gained = $current_follower_count - $follower_count;
			}

			$activity_id = $activity->id;
		}

		$comment_chart = $this->get_chart_by_id($activity_id, "comment");
		$follow_chart = $this->get_chart_by_id($activity_id, "follow");
		$unfollow_chart = $this->get_chart_by_id($activity_id, "unfollow");
		$direct_chart = $this->get_chart_by_id($activity_id, "direct");
		$repost_chart = $this->get_chart_by_id($activity_id, "repost");

		$total_action = array_sum($counter);

		$comment_percent = $total_action != 0 ? $counter["comment"]/$total_action*100 : 0;
		$follow_percent = $total_action != 0 ? $counter["follow"]/$total_action*100 : 0;
		$unfollow_percent = $total_action != 0 ? $counter["unfollow"]/$total_action*100 : 0;
		$direct_percent = $total_action != 0 ? $counter["direct"]/$total_action*100 : 0;
		$repost_percent = $total_action != 0 ? $counter["repost"]/$total_action*100 : 0;

		return (object)[
			"comment_count" => $counter['comment'],
			"follow_count" => $counter['follow'],
			"unfollow_count" => $counter['unfollow'],
			"direct_count" => $counter['direct'],
			"repost_count" => $counter['repost'],
			"comment_percent" => $comment_percent,
			"follow_percent" => $follow_percent,
			"unfollow_percent" => $unfollow_percent,
			"direct_percent" => $direct_percent,
			"repost_percent" => $repost_percent,
			"time_start" => $time_start,
			"total_followers_gained" => $total_followers_gained,
			"comment_chart" => $comment_chart,
			"follow_chart" => $follow_chart,
			"unfollow_chart" => $unfollow_chart,
			"direct_chart" => $direct_chart,
			"repost_chart" => $repost_chart,
		];
	}

	public function get_chart_by_id($id, $action){
		$team_id = _t("id");

		$value_string = "";
		$date_string = "";

		$date_list = [];
		$date = strtotime(date('Y-m-d', strtotime(NOW)));
		for ($i=6; $i >= 0; $i--) { 
			$left_date = $date - 86400 * $i;
			$date_list[date('Y-m-d', $left_date)] = 0;
		}

		//Get data
		$query = $this->db->query("SELECT COUNT(FROM_UNIXTIME(created)) as count, DATE(FROM_UNIXTIME(created)) as created FROM ".$this->tb_pinterest_activities_log." WHERE pid = '".$id."' AND action = '".$action."' AND team_id = '".$team_id."' AND FROM_UNIXTIME(created) > NOW() - INTERVAL 7 DAY GROUP BY DATE(FROM_UNIXTIME(created));");
		if($query->result()){
			foreach ($query->result() as $key => $value) {
				if(isset($date_list[$value->created])){
					$date_list[$value->created] = $value->count;
				}
			}
		}

		foreach ($date_list as $date => $value) {
			$value_string .= "{$value},";
			$date_string .= "'{$date}',";
		}

		$value_string = "[".substr($value_string, 0, -1)."]";
		$date_string  = "[".substr($date_string, 0, -1)."]";

		return (object)[
			"value" => $value_string,
			"date" => $date_string
		];
	}

	public function get_profile($id, $page){
		$team_id = _t("id");
		$activity = $this->model->get("*", $this->tb_pinterest_activities, "id = '".$id."' AND pid = 0 AND team_id = '".$team_id."'");

		$account = $this->model->get("*", $this->tb_account_manager, " username = '".$activity->ids."' AND team_id = '".$team_id."' AND social_network = 'pinterest' AND login_type = 2 ");

		$account_info = false;
		$feeds = false;

		if($account){
			try {
				$this->pin = new pinac();
				$this->pin->login($account);

				if($page == 0){
					$account_info = $this->pin->get_friendship();
				}

				$feeds = $this->pin->get_feed_by_page("", 49, $page*49);
			} catch (Exception $e) {}
		}

		return (object)[
			"account" => $account_info,
			"feed" => $feeds,
			"activity" => $activity
		];
	}
}
