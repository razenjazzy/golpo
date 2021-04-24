<?php
class vk_profiles extends MY_Controller {
	
	public $tb_account_manager = "sp_account_manager";
	public $module_name;

	public function __construct(){
		parent::__construct();
        _permission("account_manager_enable");
		$this->load->model(get_class($this).'_model', 'model');
		include get_module_path($this, 'libraries/vkapi.php', true);

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		$this->module_color = get_module_config( $this, 'color' );
		//

        $this->app_id = get_option('vk_app_id', '');
        $this->secure_secret = get_option('vk_secure_secret', '');

        if($this->app_id == "" || $this->secure_secret == ""){
            redirect( get_url("social_network_configuration/index/vk") );
        }

        $this->vk = new Vkapi($this->app_id, $this->secure_secret); 
	}

	public function index($page = "", $ids = "")
	{
        

        switch ($page) {
            case 'general':

                if(!_s("vk_access_token")){
                    redirect( get_module_url() );
                }

                $access_token = _s("vk_access_token");
                $this->vk->set_access_token($access_token);

                $profile = $this->vk->get_user_info()[0];

                $result = [];
                $result[] = (object)[
                    'id' => $profile->id,
                    'name' => $profile->first_name." ".$profile->last_name,
                    'avatar' => $profile->photo_big,
                    'desc' => $profile->screen_name
                ];

                $data = [
                    "status" => "success",
                    "result" => $result
                ];

                break;
            
            default:
                $data['login_url'] = $this->vk->login_url();
                break;
        }

        $data['module_name'] = $this->module_name;
        $data['module_icon'] = $this->module_icon;
        $data['module_color'] = $this->module_color;

		$views = [
			"subheader" => view( 'main/subheader', [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon, 'module_color' => $this->module_color ], true ),
			"column_one" => page($this, "pages", "oauth", $page, $data), 
		];
		
		views( [
			"title" => $this->module_name,
			"fragment" => "fragment_one",
			"views" => $views
		] );
	}

    public function token()
    {

        validate('empty', __('Please enter Vk code'), post("code"));
        $response = $this->vk->get_access_token();

        if(isset($response['error'])){
            ms($response);
        }

        _ss("vk_access_token", $response);

        ms([
            "status" => "success",
            "message" => __("Get access token successfully")
        ]);
    }

	public function oauth()
	{
        redirect(  get_module_url() );   
	}

	public function save()
	{
		try {
            $ids = post('id');
            $team_id = _t("id");

            validate('empty', __('Please select a profile to add'), $ids);

            $access_token = _s("vk_access_token");
            $this->vk->set_access_token($access_token);

            $profile = $this->vk->get_user_info()[0];

            if($ids[0] == $profile->id){
                $item = $this->model->get('*', $this->tb_account_manager, "social_network = 'vk' AND team_id = '{$team_id}' AND pid = '{$profile->id}'");
                $avatar = save_img( $profile->photo_big, TMP_PATH.'avatar/' );

                if(!$item){
                    $data = [
                        'ids' => ids(),
                        'social_network' => 'vk',
                        'category' => 'profile',
                        'login_type' => 1,
                        'can_post' => 1,
                        'team_id' => $team_id,
                        'pid' => $profile->id,
                        'name' => $profile->first_name." ".$profile->last_name,
                        'username' => $profile->screen_name,
                        'token' => $access_token,
                        'avatar' => $avatar,
                        'url' => 'https://vk.com/'.$profile->screen_name,
                        'data' => NULL,
                        'status' => 1,
                        'changed' => now(),
                        'created' => now()
                    ];

                    check_number_account("vk", "profile");

                    $this->model->insert($this->tb_account_manager, $data);
                }else{
                    @unlink($item->avatar);

                    $data = [
                        'social_network' => 'vk',
                        'category' => 'profile',
                        'login_type' => 1,
                        'can_post' => 1,
                        'team_id' => $team_id,
                        'pid' => $profile->id,
                        'name' => $profile->first_name." ".$profile->last_name,
                        'username' => $profile->screen_name,
                        'token' => $access_token,
                        'avatar' => $avatar,
                        'url' => 'https://vk.com/'.$profile->screen_name,
                        'status' => 1,
                        'changed' => now(),
                    ];

                    $this->model->update($this->tb_account_manager, $data, ['id' => $item->id]);
                }

                _us('vk_access_token');
                
                ms([
                    "status" => "success",
                    "message" => __("Success")
                ]);
            }else{
                ms([
                    "status" => "error",
                    "message" => __('No profile to add')
                ]);
            }
        } catch (Exception $e) {
            ms([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
	}

	public function get($params, $accessToken){

		try {
            $response = $this->fb->get($params, $accessToken);
            return json_decode($response->getBody()); 
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
        }

	}

}