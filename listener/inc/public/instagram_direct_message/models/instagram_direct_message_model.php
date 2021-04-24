<?php
class instagram_direct_message_model extends MY_Model {
	public $tb_account_manager = "sp_account_manager";

	public function __construct(){
		parent::__construct();
		$module_path = get_module_directory(__DIR__);
		include $module_path.'libraries/vendor/autoload.php';

		//
		$this->module_name = get_module_config( $module_path, 'name' );
		$this->module_icon = get_module_config( $module_path, 'icon' );
		$this->module_color = get_module_config( $module_path, 'color' );
		//

		$this->ig = new \InstagramAPI\Instagram(false, false, [
            'storage'    => 'mysql',
            'dbhost'     => DB_HOST,
            'dbname'     => DB_NAME,
            'dbusername' => DB_USER,
            'dbpassword' => DB_PASS,
            'dbtablename'=> "sp_instagram_sessions"
        ]);

        $this->ig->setVerifySSL(false);
	}

	public function block_permissions($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 8810,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'html' => view( $dir.'pages/block_permissions', ['path' => $path], true, $this ),
		];
	}

	public function get_threads($pid, $team_id, $cursor = null){
		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$pid}' AND team_id = '{$team_id}' AND social_network = 'instagram' AND login_type = '2'");
		if($account){

			$proxy = get_proxy($account->proxy);
    		if($proxy != ""){
				$this->ig->setProxy($proxy);
			}

			try {
				
				//LOGIN
				try {
		           	$this->ig->login($account->username, encrypt_decode($account->token));
		        } catch (InstagramAPI\Exception\InstagramException $e) {
		            // Couldn't login to Instagram account
		           	$this->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $account->id ] );

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        } catch (\Exception $e) {

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        }
		        //END LOGIN
		        $inbox = $this->ig->direct->getInbox($cursor, 20)->getInbox();

		        if($inbox){
		        	return $inbox;
		        }

			} catch (Exception $e) {}

		}

		return false;

	}

	public function get_thread($pid, $team_id, $thread_id, $cursor = null){
		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$pid}' AND team_id = '{$team_id}' AND social_network = 'instagram' AND login_type = '2'");
		if($account){

			$proxy = get_proxy($account->proxy);
			if($proxy != ""){
				$this->ig->setProxy($proxy);
			}

			try {
				
				//LOGIN
				try {
		           	$this->ig->login($account->username, encrypt_decode($account->token));
		        } catch (InstagramAPI\Exception\InstagramException $e) {
		            // Couldn't login to Instagram account
		           	$this->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $account->id ] );

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        } catch (\Exception $e) {

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        }
		        //END LOGIN
		        $thread = $this->ig->direct->getThread($thread_id, $cursor)->getThread();

		        if($thread){
		        	return $thread;
		        }

			} catch (Exception $e) { pr($e->getMessage(),1); }

		}

		return false;

	}

	public function send($pid, $team_id, $thread_id, $message = null, $media = null){
		if(strlen($thread_id) > 15){
			$new = false;
			$thread = ["thread" => $thread_id];
		}else{
			$new = true;
			$thread = ["users" => [$thread_id]];
		}

		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$pid}' AND team_id = '{$team_id}' AND social_network = 'instagram' AND login_type = '2'");
		if($account){
			$proxy = get_proxy($account->proxy);
			if($proxy != ""){
				$this->ig->setProxy($proxy);
			}

			try {
				
				//LOGIN
				try {
		           	$this->ig->login($account->username, encrypt_decode($account->token));
		        } catch (InstagramAPI\Exception\InstagramException $e) {
		            // Couldn't login to Instagram account
		           	$this->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $account->id ] );

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        } catch (\Exception $e) {

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        }
		        //END LOGIN
		        
		        if($message){
					$result = $this->ig->direct->sendText($thread, $message);

					if($new){
						return [
							"status" => "success",
							"url" => get_module_url("index/".$account->ids."/".$result->getPayload()->getThreadId())
						];
					}

					return [
						"type" => "text",
						"status" => "success",
						"caption" => nl2br($message),
						"avatar" => BASE.$account->avatar,
						"time" => datetime_show(time()),
						"remove" => get_module_url("delete_item/".$account->ids."/".$thread_id."/".$result->getPayload()->getItemId()),
						"id" => "thread-item-".$result->getPayload()->getItemId()
					];
				}

				if($media){
					if(!is_photo($media))
                  	{
                  		$result = $this->ig->direct->sendVideo($thread, get_file_path($media));

                  		if($new){
							return [
								"status" => "success",
								"url" => get_module_url("index/".$account->ids."/".$result->getPayload()->getThreadId())
							];
						}

						return [
							"type" => "video",
							"status" => "success",
							"caption" => nl2br($message),
							"avatar" => BASE.$account->avatar,
							"time" => datetime_show(time()),
							"file" => $media,
							"remove" => get_module_url("delete_item/".$account->ids."/".$thread_id."/".$result->getPayload()->getItemId()),
							"id" => "thread-item-".$result->getPayload()->getItemId()
						];
					}else{
						$result = $this->ig->direct->sendPhoto($thread, get_file_path($media));

						if($new){
							return [
								"status" => "success",
								"url" => get_module_url("index/".$account->ids."/".$result->getPayload()->getThreadId())
							];
						}

						return [
							"type" => "photo",
							"status" => "success",
							"caption" => nl2br($message),
							"avatar" => BASE.$account->avatar,
							"time" => datetime_show(time()),
							"file" => $media,
							"remove" => get_module_url("delete_item/".$account->ids."/".$thread_id."/".$result->getPayload()->getItemId()),
							"id" => "thread-item-".$result->getPayload()->getItemId()
						];
					}
				}


			} catch (Exception $e) {

				return [
					"status" => "error",
					"message" => $e->getMessage()
				];

			}

		}
		
		return [
			"status" => "error",
			"message" => __("Cannot send this message")
		];
	}

	public function delete_item($pid, $team_id, $thread_id, $thread_item_id){
		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$pid}' AND team_id = '{$team_id}' AND social_network = 'instagram' AND login_type = '2'");
		if($account){
			$proxy = get_proxy($account->proxy);
			if($proxy != ""){
				$this->ig->setProxy($proxy);
			}

			try {
				
				//LOGIN
				try {
		           	$this->ig->login($account->username, encrypt_decode($account->token));
		        } catch (InstagramAPI\Exception\InstagramException $e) {
		            // Couldn't login to Instagram account
		           	$this->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $account->id ] );

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        } catch (\Exception $e) {

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        }
		        //END LOGIN
	        
				$result = $this->ig->direct->deleteItem($thread_id, $thread_item_id);

				return [
					"status" => "success",
					"callback" => '<script>$(".thread-item-' . $thread_item_id . '").remove();</script>'
				];


			} catch (Exception $e) {

				return [
					"status" => "error",
					"message" => $e->getMessage()
				];

			}

		}
		
		return [
			"status" => "error",
			"message" => __("Cannot delete this message")
		];
	}

	public function hide_thread($pid, $team_id, $thread_id){
		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$pid}' AND team_id = '{$team_id}' AND social_network = 'instagram' AND login_type = '2'");
		if($account){
			$proxy = get_proxy($account->proxy);
			if($proxy != ""){
				$this->ig->setProxy($proxy);
			}

			try {
				
				//LOGIN
				try {
		           	$this->ig->login($account->username, encrypt_decode($account->token));
		        } catch (InstagramAPI\Exception\InstagramException $e) {
		            // Couldn't login to Instagram account
		           	$this->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $account->id ] );

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        } catch (\Exception $e) {

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        }
		        //END LOGIN
	        
				$result = $this->ig->direct->hideThread($thread_id);

				return [
					"status" => "success",
					"message" => __("Success"),
					"callback" => '<script>$(".thread-' . $thread_id . '").remove();</script>'
				];

			} catch (Exception $e) {

				return [
					"status" => "error",
					"message" => $e->getMessage()
				];

			}

		}
		
		return [
			"status" => "error",
			"message" => __("Cannot delete this message")
		];
	}

	public function search($pid, $team_id, $keyword){
		$account = $this->model->get("*", $this->tb_account_manager, "pid = '{$pid}' AND team_id = '{$team_id}' AND social_network = 'instagram' AND login_type = '2'");
		if($account){
			$proxy = get_proxy($account->proxy);
			if($proxy != ""){
				$this->ig->setProxy($proxy);
			}

			try {
				
				//LOGIN
				try {
		           	$this->ig->login($account->username, encrypt_decode($account->token));
		        } catch (InstagramAPI\Exception\InstagramException $e) {
		            // Couldn't login to Instagram account
		           	$this->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $account->id ] );

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        } catch (\Exception $e) {

		            return [
		            	"status" => "error",
		            	"message" => __( $e->getMessage() )
		            ];
		        }
		        //END LOGIN
	        
				$result = $this->ig->people->search($keyword);
				return $result;

			} catch (Exception $e) {

				return false;

			}

		}
		
		return false;
	}
}
