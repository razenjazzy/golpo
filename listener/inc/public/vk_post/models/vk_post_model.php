<?php
class vk_post_model extends MY_Model {
	public $tb_account_manager = "sp_account_manager";

	public function __construct(){
		parent::__construct();
		$module_path = get_module_directory(__DIR__);
		include $module_path.'libraries/vkapi.php';

		//
		$this->module_name = get_module_config( $module_path, 'name' );
		$this->module_icon = get_module_config( $module_path, 'icon' );
		$this->module_color = get_module_config( $module_path, 'color' );
		//

		$this->app_id = get_option('vk_app_id', '');
        $this->secure_secret = get_option('vk_secure_secret', '');

        $this->vk = new Vkapi($this->app_id, $this->secure_secret); 
	}

	public function block_permissions($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 8200,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'html' => view( $dir.'pages/block_permissions', ['path' => $path], true, $this ),
		];
	}

	public function block_report($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'tab' => 'vk',
			'position' => 1000,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'html' => view( $dir.'pages/block_report', ['path' => $path], true, $this ),
		];
	}

	public function block_post_preview($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 1400,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'preview' => view( $dir.'pages/preview', ['path' => $path], true, $this ),
		];
	}

	public function post( $data ){
		$post_type = $data["post_type"];
		$account = $data["account"];
		$medias = $data["medias"];
		$link = urlencode($data["link"]);
		$advance = $data["advance"];
		$caption = urlencode( spintax( $data["caption"] ) );
		$is_schedule = $data["is_schedule"];
		
		if($is_schedule)
		{	
			return [
            	"status" => "success",
            	"message" => __('Success'),
            	"type" => $post_type
            ];
		}
		
		$this->vk->set_access_token($account->token);

		$params = [];
		try {
			switch ($post_type)
			{
				case 'photo':
					
					$attachments = $this->vk->upload_photo(0, $medias, false);

	                $params = [
	                    'owner_id' => $account->pid, 
	                    'message' => $caption, 
	                    'attachments' => $attachments
	                ];
					
					break;

				case 'video':

					$attachments = $this->vk->upload_video([
	                    'name' => '',
	                    'description' => $caption,
	                    'wallpost' => 1
	                ], $medias[0]);

	                $params = [
	                    'owner_id' => $account->pid, 
	                    'message' => $caption, 
	                    'attachments' => $attachments
	                ];
					
					break;

				case 'link':
					
					$params = [
	                    'owner_id' => $account->pid, 
	                    'message' => $caption,
	                    'attachments' => $link
	                ];

					break;

				case 'text':

					$params = [
	                    'owner_id' => $account->pid, 
	                    'message' => $caption
	                ];

					break;
				
			}

			$response = $this->vk->curl_post("wall.post", $params);


	        if(isset($response->post_id)){
	            $post_id =  $response->post_id;
	            return [
	            	"status" => "success",
	            	"message" => __('Success'),
	            	"id" => $post_id,
	            	"url" => "https://vk.com/wall".$account->pid."_".$post_id,
	            	"type" => $post_type
	            ]; 

	        }else{
	            throw new Exception($response->error->error_msg);
	        }

		} catch (Exception $e) {
            return [
                "status"  => "error",
                "message" => __( $e->getMessage() ),
                "type" => $post_type
            ];
        }
	}
	
	public function cut_text($text, $n = 280){ 
		if(strlen($text) <= $n){
			return $text;
		}
		
		$text= substr($text, 0, $n);
		if($text[$n-1] == ' '){
			return trim($text)."...";
		}

		$x  = explode(" ", $text);
		$sz = sizeof($x);

		if($sz <= 1){
			return $text."...";
		}

		$x[$sz-1] = '';

		return trim(implode(" ", $x))."...";
	}
}
