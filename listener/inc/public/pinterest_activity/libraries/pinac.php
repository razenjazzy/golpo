<?php
use DirkGroenen\Pinterest\Pinterest;
use seregazhuk\PinterestBot\Factories\PinterestBot;

if(!class_exists("pinac")){

    class pinac{
        public $ig;
        public $username;
        public $tb_account_manager = "sp_account_manager";

        public function __construct(){
            $this->activity = [];
            $this->todo = false;
            $this->number = 0;
            $this->follows = [];
            $this->unfollows = [];
            $this->comments = [];
            $this->directs = [];
            $this->reposts = null;
            $this->filters = [];
            $this->blacklist_tags = [];
            $this->blacklist_usernames = [];
            $this->blacklist_keywords = [];
            $this->data = null;
            $this->ci = &get_instance();
            $this->type = "feed";

            $this->bot = PinterestBot::create();
        }

        public function login($account){
            try {
                $proxy = $account->proxy;
                if($proxy != ""){
                    $this->proxy($proxy);
                }

                $access_token = json_decode($account->token);
                $this->username = $access_token->username;
                $this->bot->auth->login($access_token->username, encrypt_decode($access_token->password));
            } catch (Exception $e) {
                $this->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $account->id ] );
                throw new Exception($e->getMessage());
            }
        }

        public function get_friendship($username = ""){
            try {
                if($username == ""){
                    $username = $this->username;
                }

                $response = $this->bot->pinners->info($username);
                return (object)$response;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function get_feed_by_page($username = "", $take = 12, $from = 1){
            try {
                if($username == ""){
                    $username = $this->username;
                }

                $response = $this->bot->pinners->pins($username)->take($take)->skip($from)->toArray();
                if(!empty($response)){
                    return json_decode(json_encode($response));
                }
                return false;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function get_user_info($username = false){
            try {
                if($username){
                    return $this->bot->pinners->info($username);
                }else{
                    return $this->bot->user->profile();
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function search($type, $keyword){

            try {
                switch ($type) {
                    case 'tag':
                        return $this->bot->suggestions->tagsFor($keyword);

                    case 'username':
                        return $this->bot->pinners->search($keyword);
                    
                    default:
                        break;
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function run($data){
            $field = false;

            $this->activity = json_decode($data->data, 0);
            $this->todo = $data->action;
            $this->filters = get_value($this->activity, "filters");
            $this->follows = get_value($this->activity, "follows");
            $this->unfollows = get_value($this->activity, "unfollows");
            $this->op_comments = get_value($this->activity, "op_comments");
            $this->comments = get_value($this->activity, "comments");
            $this->op_directs = get_value($this->activity, "op_directs");
            $this->directs = get_value($this->activity, "directs");
            $this->op_reposts = get_value($this->activity, "op_reposts");
            $this->reposts = get_value($this->activity, "reposts");
            $this->blacklist_tags = get_value($this->activity, "blacklist_tags");
            $this->blacklist_usernames = get_value($this->activity, "blacklist_usernames");
            $this->blacklist_keywords = get_value($this->activity, "blacklist_keywords");
            $this->data = $data;
            $this->number = $data->number;
            $this->type = "feed";

            if( !in_array( $this->todo, ["like", "comment", "repost"]) ){
                $this->type = "user";
            }

            $target = $this->random_field("targets", false);

            if($this->todo != "unfollow"){
                $field = $this->target($target);
            }

            return $this->action($target, $field);
        }

        public function action($target, $field){
            switch ($this->todo) {
                case 'direct':
                    $by = $this->op_directs->by;
                    switch ($by) {
                        case 'follower':
                            $data = $this->get_new_followers();
                            break;
                        
                        default:
                            $data = $this->get_data($target, $field);
                            break;
                    }

                    break;

                case 'unfollow':
                    $source = $this->unfollows->source;
                    switch ($source) {
                        case 'db':
                            $after_day = $this->unfollows->after; 
                            $after_day =  time() - $after_day*86400;
                            $data = $this->ci->model->get("id,user_id", "sp_pinterest_activities_log", "action = 'follow' AND media_id IS NULL AND created < '{$after_day}' AND pid = '{$this->data->pid}'", "id", "desc");
                            break;
                        
                        default:
                            $data = $this->get_follower($this->username);
                            break;
                    }

                    break;

                case 'repost':
                    $data = $this->get_repost_feed();
                    break;
                
                default:
                    $data = $this->get_data($target, $field);
                    break;
            }

            $status = false;
            if($data)
            {
                try {
                    switch ($this->todo) {
                        case 'comment':
                                $comment = $this->random_field("comments");
                                if($comment){
                                    $response = $this->bot->comments->create( $data->id, spintax($comment));
                                    if($response){
                                        $status = true;
                                    }
                                }
                            break;

                        case 'direct':
                                $direct = $this->random_field("directs");

                                $variables = [
                                    "{{username}}" => "@".$data->username,
                                    "{{full_name}}" => $data->full_name
                                ];

                                $direct =  str_replace(
                                            array_keys($variables), 
                                            array_values($variables), 
                                            $direct);

                                $direct = spintax($direct);
                                $response = $this->bot->inbox->sendMessage( $data->id, $direct );
                                if($response){
                                    $status = true;
                                }
                            break;

                        case 'follow':
                                if (!$this->bot->pinners->isFollowedByMe( $data->username )) {
                                    $response = $this->bot->pinners->follow( $data->username );
                                    if($response){
                                        $status = true;
                                    }
                                }
                            break;

                        case 'unfollow':
                                $source = $this->unfollows->source;
                                switch ($source) {
                                    case 'db':
                                        $response = $this->bot->pinners->unfollow( $data->user_id );
                                        if($response){
                                            $status = true;
                                            $this->ci->db->delete("sp_pinterest_activities_log", ["id" => $data->id]);
                                            $friendship = $this->get_friendship( $data->user_id );
                                            $data = $friendship;
                                        }
                                        break;
                                    
                                    default:
                                        $response = $this->bot->pinners->unfollow( $data->username );
                                        if($response){
                                            $status = true;
                                        }
                                        break;
                                }
                                
                            break;

                        case 'repost':
                                $original_caption = "";
                                if ( isset($data->grid_description) ) {
                                    $original_caption = $data->grid_description;
                                }else{
                                    if ( isset($data->grid_title) ) {
                                        $original_caption = $data->grid_title;
                                    }
                                }

                                $board = $this->op_reposts->board;

                                $caption = $this->reposts;

                                $variables = [
                                    "{{caption}}" => $original_caption,
                                    "{{username}}" => "@".$data->pinner->username,
                                    "{{full_name}}" => $data->pinner->full_name
                                ];

                                $caption =  str_replace(
                                            array_keys($variables), 
                                            array_values($variables), 
                                            $caption);

                                $caption = spintax($caption);

                                $response = $this->bot->pins->repin($data->id, $board, $caption);
                                if($response){
                                    $status = true;
                                }
                            break;

                    }

                    if( $status ){
                        return $data;
                    }else{
                        return false;
                    }
                } catch (Exception $e) {
                    throw new Exception( $e->getMessage() );
                }
            }

            return false;
        }

        public function target($target){
            $value = false;
            $by = $this->random_field("targets");

            $this->random_field("targets");

            switch ($target) {
                case 'tag':
                    $value = trim( $this->random_field("tags") );
                    break;

                case 'keyword':
                    $value = $this->random_field("keywords");
                    break;

                case 'follower':
                    $value = $this->target_advance($by);
                    break;

                case 'following':
                    $value = $this->target_advance($by);
                    break;

                case 'commenter':
                    $value = $this->target_advance($by);
                    break;
            }

            return $value;
        }

        public function target_advance( $by){
            $field = false;
            $rand = rand(1,2);
            if($by == "user" || ($by == "all" && $rand == 1)){
                return $this->random_field("usernames");
            }else{
                return $this->username;
            }
        }

        public function filter($type, $data){
            $time_array = array("new" => 1800, "1h" => 3600, "12h" => 43200, "1d" => 86400, "3d" => 259000, "1w" => 604800, "2w" => 1209600, "1m" => 2419200);

            $ok = true;
            //Filter feed
            foreach ($data as $key => $row) {

                if($type = "feed"){

                    //Media Age
                    if( isset($this->filters->media_age) && array_key_exists($this->filters->media_age, $time_array) ){
                        $media_age = $this->filters->media_age;
                        if(time() - strtotime($row->created_at) > $time_array[$media_age]){ continue; }
                    }

                    //Media Type
                    if(isset($this->filters->media_type)){
                        switch ($this->filters->media_type) {
                            case 'image':
                                if(!$row->is_video){ continue 2; }
                                break;

                            case 'video':
                                if($row->is_video){ continue 2; }
                                break;
                        }
                    }
                }

                if(
                    (isset($this->filters->min_follower) && (int)$this->filters->min_follower != 0) ||
                    (isset($this->filters->max_follower) && (int)$this->filters->max_follower != 0) ||
                    (isset($this->filters->min_following) && (int)$this->filters->min_following != 0) ||
                    (isset($this->filters->max_following) && (int)$this->filters->max_following != 0) ||
                    isset($this->filters->user_profile) ||
                    isset($this->filters->user_relation)
                ){

                    if($type = "feed"){
                        if( isset($row->pinner) ){
                            $user_id = $row->pinner->username;
                        }else{
                            $user_id = false;
                        }
                    }else{
                        $user_id = $row->username;
                    }

                    if($user_id){
                        $userinfo = $this->get_user_info($user_id);

                        if(!empty($userinfo)){
                            $userinfo = (object)$userinfo;

                            if(isset($this->filters->min_follower) && $this->filters->min_follower != 0 && $this->filters->min_follower > $userinfo->follower_count ){
                                continue;
                            }

                            if(isset($this->filters->max_follower) && $this->filters->max_follower != 0 && $this->filters->max_follower < $userinfo->follower_count ){
                                continue;
                            }

                            if(isset($this->filters->min_following) && $this->filters->min_following != 0 && $this->filters->min_following > $userinfo->following_count ){
                                continue;
                            }

                            if(isset($this->filters->max_following) && $this->filters->max_following != 0 && $this->filters->max_following < $userinfo->following_count ){
                                continue;
                            }

                            //User profile
                            if(isset($this->filters->user_profile)){
                                $user_profile = $this->filters->user_profile;
                                switch ($user_profile) {
                                    case 'low':
                                        if( !isset($userinfo->image_small_url) != "" || $userinfo->pin_count == 0){
                                            continue 2;
                                        }
                                        break;

                                    case 'medium':
                                        if( !isset($userinfo->image_small_url) != "" || $userinfo->pin_count < 10 || $userinfo->full_name == ""){
                                            continue 2;
                                        }
                                        break;
                                    case 'high':
                                        if( !isset($userinfo->image_small_url) != "" || $userinfo->pin_count < 30 || $userinfo->full_name == ""){
                                            continue 2;
                                        }
                                        break;
                                }
                            }
                        }
                    }
                }

                return json_decode( json_encode( $row ) );
            }

            return false;
        }

        public function blacklist($data){
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    
                    $ok = false;

                    if( isset( $value->grid_description ) ){
                        //Tags
                        $caption = $value->grid_description;
                        if(!empty($this->blacklist_tags) && !$ok){
                            foreach ($this->blacklist_tags as $tag) {
                                if (strpos($caption, "#".$tag) !== false) {
                                    unset($data[$key]);
                                    $ok = true;
                                    break;
                                }
                            }
                        }

                        //Keywords
                        if(!empty($this->blacklist_keywords) && !$ok){
                            foreach ($this->blacklist_keywords as $keyword) {
                                if (strpos($caption, $keyword) !== false) {
                                    unset($data[$key]);
                                    $ok = true;
                                    break;
                                }
                            }
                        }
                    }

                    if( isset( $value->grid_title ) ){
                        //Tags
                        $caption = $value->grid_title;
                        if(!empty($this->blacklist_tags) && !$ok){
                            foreach ($this->blacklist_tags as $tag) {
                                if (strpos($caption, "#".$tag) !== false) {
                                    unset($data[$key]);
                                    $ok = true;
                                    break;
                                }
                            }
                        }

                        //Keywords
                        if(!empty($this->blacklist_keywords) && !$ok){
                            foreach ($this->blacklist_keywords as $keyword) {
                                if (strpos($caption, $keyword) !== false) {
                                    unset($data[$key]);
                                    $ok = true;
                                    break;
                                }
                            }
                        }
                    }

                    //Username
                    if(isset($value->pinner)){
                        $username = $value->pinner->username;
                        if(!empty($this->blacklist_usernames) && !$ok){
                            foreach ($this->blacklist_usernames as $value) {
                                if ($username == $value) {
                                    unset($data[$key]);
                                    $ok = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if(!empty($data)){
                $data = array_values($data);
            }

            return $data;
        }

        public function get_data($target, $value){

            $data = false;
            switch ($target) {
                case 'tag':
                    $data = $this->get_feed_by_tag($value);
                    if($this->type == "user"){
                        $data = $data->pinner;
                    }
                    break;

                case 'keyword':
                    $data = $this->get_feed_by_keyword($value);
                    if($this->type == "user"){
                        $data = $data->pinner;
                    }
                    break;

                case 'follower':
                    $item = $this->get_follower($value);
                    if($item){
                        if($this->type == "user"){
                            $data = $item;
                        }else{
                            $user_id = $item->username;
                            $data = $this->get_feed_by_username($user_id);
                        }
                    }
                    break;

                case 'following':
                    $item = $this->get_following($value);
                    if($item){
                        if($this->type == "user"){
                            $data = $item;
                        }else{
                            $user_id = $item->username;
                            $data = $this->get_feed_by_username($user_id);
                        }
                    }
                    break;

            }

            return $data;
        }

        public function get_feed_by_tag($tag){
            try {
                $items = array();
                foreach ($this->bot->pins->search("#".trim($tag)) as $pin) {
                    if(isset($pin['type']) && $pin['type'] == "pin"){
                        $items[] = $pin;
                    }
                }
                $items =  json_decode(json_encode($items));

                $items = $this->remove_users_following("feed", $items);
                $items = $this->dont_comment_same_users("feed", $items);
                $items = $this->dont_comment_same_posts($items);
                $items = $this->dont_follow_same_users("feed", $items);
                $items = $this->dont_direct_same_users("feed", $items);
                $items = $this->blacklist($items);
                $item = $this->filter("feed", $items);

                return $item;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_feed_by_keyword($keyword){
            try {
                $items = array();
                foreach ($this->bot->pins->search(trim($keyword)) as $pin) {
                    if(isset($pin['type']) && $pin['type'] == "pin"){
                        $items[] = $pin;
                    }
                }
                $items =  json_decode(json_encode($items));

                $items = $this->remove_users_following("feed", $items);
                $items = $this->dont_comment_same_users("feed", $items);
                $items = $this->dont_comment_same_posts($items);
                $items = $this->dont_follow_same_users("feed", $items);
                $items = $this->dont_direct_same_users("feed", $items);
                $items = $this->blacklist($items);
                $item = $this->filter("feed", $items);

                return $item;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_feed_by_username($username, $take = 50, $from = 0){
            try {
                $items = $this->bot->pinners->pins($username)->take($take)->skip($from)->toArray();
                $items = $this->dont_comment_same_users("feed", $items);
                $items = $this->dont_comment_same_posts($items);
                $items = $this->blacklist($items);
                $item = $this->filter("feed", $items);
                return $item;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_repost_feed(){
            $items = false;
            try {
                $target = $this->op_reposts->by;
                $target_list = array("username", "location", "tag");


                if($target == "all"){
                    $rand = rand(0,2);
                    $target = $target_list[$rand];
                }

                switch ($target) {
                    case 'tag':
                        $value = trim( $this->random_field("tags") );
                        $item = $this->get_feed_by_tag($value);
                        break;

                    case 'keyword':
                        $value = $this->random_field("keywords");
                        $item = $this->get_feed_by_keyword($value);
                        break;

                    case 'username':
                        $value = $this->random_field("usernames");
                        $item = $this->get_feed_by_username($value, 100);
                }

               return $item;

            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_follower($username, $take = 100){
            try {
                $response = $this->bot->pinners->followers($username)->take($take)->toArray();
                if(!empty($response)){
                    $items = json_decode(json_encode($response));
                    $items = $this->remove_users_following("user", $items);
                    $items = $this->dont_follow_same_users("user", $items);
                    $items = $this->dont_direct_same_users("user", $items);

                    if(!empty($items)){
                    
                        do {
                            $index = array_rand($items);
                            $result = $items[$index];
                            if( $result->pin_count != 0 ){
                                return $result;
                            }else{
                                unset($items[$index]);
                            }
                        } while ( $result->pin_count == 0 && !empty( $items ));
                    }
                }
                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_following($username, $take = 100){
            try {
                $response = $this->bot->pinners->followingPeople($username)->take($take)->toArray();
                if(!empty($response)){
                    $items = json_decode(json_encode($response));
                    $items = $this->remove_users_following("user", $items);
                    $items = $this->dont_follow_same_users("user", $items);
                    $items = $this->dont_direct_same_users("user", $items);

                    if(!empty($items)){
                    
                        do {
                            $index = array_rand($items);
                            $result = $items[$index];
                            if( $result->pin_count != 0 ){
                                return $result;
                            }else{
                                unset($items[$index]);
                            }
                        } while ( $result->pin_count == 0 && !empty( $items ));
                    }
                }
                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_new_followers(){
            try {
                $response = $this->bot->inbox->notifications()->toArray();
                $response = json_decode(json_encode($response));

                $items = [];
                $usernames = [];
                if(!empty($response)){
                    $count = 0;
                    foreach ($response as $key => $row) {
                        if($row->news_type == 15){
                            $details = $this->bot->inbox->newsHubDetails($row->id)->toArray();

                            if(!empty($details)){
                                $details = json_decode(json_encode($details));
                                foreach ($details as $detail) {
                                    if( isset($detail->content_items) && !empty($detail->content_items) ){
                                        foreach ( $detail->content_items as $content_item ) {
                                            if(isset($content_item->content_object->username) && !in_array($content_item->content_object->username, $usernames) ){
                                                $usernames[] = $content_item->content_object->username;
                                                $items[] = $content_item->content_object;
                                            }
                                        }
                                    }
                                }

                            }

                        }
                    }
                }

                $items = $this->remove_direct_user_sent($items);

                if(!empty($items)){
                    $index = array_rand($items);
                    $item = $items[$index];
                    return $item;
                }

                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function remove_media_reposted($data){
            if(!empty($data)){
                $media_ids = [];
                foreach ($data as $key => $value) {
                    $media_ids[] = $value->getId();
                }

                $this->ci->db->select("*");
                $this->ci->db->from("sp_pinterest_activities_log");
                $this->ci->db->where_in('media_id', $media_ids);
                $this->ci->db->where("action", "repost");
                $this->ci->db->where("pid", $this->data->pid);
                $query = $this->ci->db->get();
                if($query->result()){
                    $result = $query->result();
                    
                    foreach ($result as $row) {
                        $key = array_search($row->media_id, $media_ids);
                        unset($data[$key]);
                    }
                
                    $data = array_values($data);
                }
            }

            return $data;
        }

        public function remove_direct_user_sent($data){
            if($this->todo == "direct"){
                $feeds_tmp = [];
                if(!empty($data)){
                    foreach ($data as $key => $row) {
                        $row = json_decode( json_encode( $row ) );
                        $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "user_id = '".$row->username."' AND action = 'direct' AND pid = '{$this->data->pid}'");
                        if(empty($item)) $feeds_tmp[] = $row;
                    }
                }
                $data = $feeds_tmp;
                
                if(!empty($data)){
                    $data = array_values($data);
                }
            }
            return $data;
        }

        //Don't direct same users
        public function dont_direct_same_users($type, $data){
            if( $this->todo == "direct" ){
                switch ($type) {
                    case 'feed':
                        $feeds_tmp = array();
                        if(!empty($data)){
                            foreach ($data as $key => $row) {
                                $row = json_decode( json_encode( $row ) );
                                $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "user_id = '".$row->pinner->username."' AND action = 'direct' AND pid = '{$this->data->pid}'");
                                if(empty($item)) $feeds_tmp[] = $row;
                            }
                        }
                        $data = $feeds_tmp;
                        break;
                    
                    case 'user':
                        $users_tmp = array();
                        if(!empty($data)){
                            foreach ($data as $key => $row) {
                                $row = json_decode( json_encode( $row ) );
                                $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "user_id = '".$row->username."' AND action = 'direct' AND pid = '{$this->data->pid}'");
                                if(empty($item)) $users_tmp[] = $row;
                            }
                        }
                        $data = $users_tmp;
                        break;
                }
            }

            return $data;
        }

        //Don't follow same users
        public function dont_follow_same_users($type, $data){
            if($this->todo == "follow" && isset($this->follows->dont_spam)){
                switch ($type) {
                    case 'feed':
                        $feeds_tmp = array();
                        if(!empty($data)){
                            foreach ($data as $key => $row) {
                                $row = json_decode( json_encode( $row ) );
                                $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "user_id = '".$row->pinner->username."' AND ( action = 'follow' OR action = 'unfollow' ) AND pid = '{$this->data->pid}'");
                                if(empty($item)) $feeds_tmp[] = $row;
                            }
                        }
                        $data = $feeds_tmp;
                        break;
                    
                    case 'user':
                        $users_tmp = array();
                        if(!empty($data)){
                            foreach ($data as $key => $row) {
                                $row = json_decode( json_encode( $row ) );
                                $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "user_id = '".$row->username."' AND ( action = 'follow' OR action = 'unfollow' ) AND pid = '{$this->data->pid}'");
                                if(empty($item)) $users_tmp[] = $row;
                            }
                        }
                        $data = $users_tmp;
                        break;
                }
            }

            return $data;
        }

        public function remove_users_following($type, $data){
            if($this->todo == "follow"){
                $users = [];
                if($data){

                    foreach ($data as $key => $row) {
                        switch ($type) {
                            case 'feed':
                                $row = json_decode( json_encode( $row ) );
                                $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "user_id = '".$row->pinner->username."' AND ( action = 'follow' OR action = 'unfollow' ) AND pid = '{$this->data->pid}'");
                                if(!empty($item)) unset($data[$key]);
                                break;
                            
                            case 'user':
                                if($row->explicitly_followed_by_me){
                                    unset($data[$key]);
                                }
                                break;
                        }
                        
                    }
                }

                if(!empty($data)){
                    $data = array_values($data);
                }
            }

            return $data;
        }

        //Don't comment same users
        public function dont_comment_same_users($type, $data){

            if($this->todo == "comment" && isset($this->op_comments->dont_spam) && !empty($data)){
                switch ($type) {
                    case 'feed':
                        $feeds_tmp = [];
                        foreach ($data as $key => $row) {
                            $row = json_decode( json_encode( $row ) );
                            $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "user_id = '{$row->pinner->username}' AND action = 'comment' AND pid = '{$this->data->pid}'");
                            if(empty($item)) $feeds_tmp[] = $row;
                        }
                        $data = $feeds_tmp;
                        break;
                    
                    case 'user':
                        $users_tmp = [];
                        foreach ($data as $key => $row) {
                            $row = json_decode( json_encode( $row ) );
                            $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "user_id = '{$row->username}' AND action = 'comment' AND pid = '{$this->data->pid}'");
                            if(empty($item)) $users_tmp[] = $row;
                        }
                        $data = $users_tmp;
                        break;
                }

                if(!empty($data)){
                    $data = array_values($data);
                }
            }

            return $data;
        }

        //Don't send comment same posts
        public function dont_comment_same_posts($data){
            if($this->todo == "comment"){
                $feeds_tmp = [];
                if(!empty($data)){
                    foreach ($data as $key => $row) {
                        $row = json_decode( json_encode( $row ) );
                        $item = $this->ci->model->get("id", "sp_pinterest_activities_log", "media_id = '".$row->id."' AND action = 'comment' AND pid = '{$this->data->pid}'");
                        if(empty($item)) $feeds_tmp[] = $row;
                    }
                }
                $data = $feeds_tmp;
                
                if(!empty($data)){
                    $data = array_values($data);
                }
            }


            return $data;
        }

        public function random_field($field, $return_value = true){
            $data = get_value($this->activity, $field, true);
            $rand_key = array_rand($data);
            if(!empty($data)){
                if($return_value){
                    return $data[$rand_key];
                }else{
                    return $rand_key;
                }
            }
            return false;
        }

        public function proxy($proxy){
            $proxy = get_proxy($proxy);

            if($proxy != "" && $proxy != 0){
                $proxy = str_replace("https://", "", $proxy);
                $proxy = str_replace("http://", "", $proxy);
                $ip = "";
                $port = "";
                $auth = "";
                
                if(strripos($proxy, "@") !== false){

                    $proxy_arr = explode("@", $proxy);
                    $auth = $proxy_arr[0];
                    $proxy_none = explode(":", $proxy_arr[1]);
                    $ip = $proxy_none[0];
                    $port = $proxy_none[1];
                    $this->bot->getHttpClient()->useProxy($ip, $port, $auth);
                    
                }else{

                    $proxy_none = explode(":", $proxy);
                    $ip = $proxy_none[0];
                    $port = $proxy_none[1];
                    $this->bot->getHttpClient()->useProxy($ip, $port);

                }
            }else{
                $this->bot->getHttpClient()->dontUseProxy();
            }
        }
    }
}