<?php
class instagram_analytics extends MY_Controller {
	
	public $tb_account_manager = "sp_account_manager";
	public $tb_instagram_analytics = "sp_instagram_analytics";

	public function __construct(){
		parent::__construct();
		_permission(get_class($this)."_enable");
		$this->load->model(get_class($this).'_model', 'model');

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		$this->module_color = get_module_config( $this, 'color' );
		//
	}

	public function index($ids = "")
	{
		$team_id = _t("id");
		$account = $this->model->get("*", $this->tb_account_manager, "ids = '{$ids}' AND team_id = '{$team_id}' AND status = '1'");
		if($account){
			$this->model->save_stats($account->pid, $account->team_id);
		}

		//Sidebar
		$team_id = _t("id");
		$result = $this->model->fetch('*', $this->tb_account_manager, " team_id = '{$team_id}' AND social_network = 'instagram' AND login_type = 2", "social_network, category", "ASC");
		//End sidebar


		$stats = $this->model->get_stats($ids);

		if( !is_ajax() ){
			$views = [
				"subheader" => view( 'main/subheader', [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon, 'module_color' => $this->module_color ], true ),
				"column_one" => view("main/sidebar", [ 'result' => $result, 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_two" => view("pages/general", ["result" => $stats, "account" => $account] ,true), 
			];
			
			views( [
				"title" => $this->module_name,
				"fragment" => "fragment_two",
				"views" => $views
			] );
		}else{
			view("pages/general", ["result" => $stats, "account" => $account], false);
		}
	}

	public function block(){}

	public function cron()
	{
		$time = strtotime(date("Y-m-d"));
		$actions = $this->model->fetch("*", $this->tb_instagram_analytics, "next_action <= {$time}", "next_action", "ASC", 0, 5);

		if(!$actions){ 
			_e("Empty schedule");
			exit(0);
		}

		foreach ($actions as $action) {
			$this->model->save_stats($action->account, $action->team_id);
		}

		_e("Success");
	}

}