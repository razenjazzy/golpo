<?php
if(!class_exists("igac")){

    class igac{
        public $ig;
        public $username;
        public $tb_account_manager = "sp_account_manager";

        public function __construct(){
            $this->activity = [];
            $this->todo = false;
            $this->number = 0;
            $this->watching_stories = [];
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
            $this->token = $this->rankToken();
            $this->type = "feed";

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

        public function login($account){

            $proxy = get_proxy($account->proxy);
            if($proxy != ""){
                $this->ig->setProxy($proxy);
            }

            try {
                $this->username = $account->username;
                $this->ig->login($account->username, encrypt_decode($account->token));
                return ["status" => "success"];
            } catch (InstagramAPI\Exception\InstagramException $e) {
                // Couldn't login to Instagram account
                $CI = &get_instance();
                $CI->model->update($this->tb_account_manager, [ "status" => 0 ], [ "id" => $account->id ] );
                throw new Exception($e->getMessage());
                
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function get_user_info($username = false){
            try {
                if($username){
                    return $this->ig->people->getInfoByName($username);
                }else{
                    return $this->ig->people->getInfoByName($this->username);
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function get_user_info_by_id($user_id = false){
            try {
                return $this->ig->people->getInfoById($user_id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function get_friendship($user_id = false){
            try {
                return $this->ig->people->getFriendship($user_id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        public function search($type, $keyword){

            try {
                switch ($type) {
                    case 'tag':
                        return $this->ig->hashtag->search($keyword);

                    case 'location':
                        return $this->ig->location->search("38.8935128", "-77.1546602", $keyword);

                    case 'username':
                        return $this->ig->people->search($keyword);
                    
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
            $this->watching_stories = get_value($this->activity, "watching_stories");
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
                            $data = $this->ci->model->get("id,user_id", "sp_instagram_activities_log", "action = 'follow' AND media_id IS NULL AND created < '{$after_day}' AND pid = '{$this->data->pid}'", "id", "desc");
                            break;
                        
                        default:
                            $data = $this->get_self_following();
                            break;
                    }

                    break;

                case 'watching_story':
                    $data = $this->get_stories();
                    break;

                case 'repost':
                    $data = $this->get_repost_feed();
                    break;
                
                default:
                    $data = $this->get_data($target, $field);
                    break;
            }

            $status = "fail";
            if($data)
            {
                try {
                    switch ($this->todo) {
                        case 'like':
                                $response = $this->ig->media->like( $data->getId(), 0);
                                $status = $response->getStatus();
                            break;

                        case 'comment':
                                $comment = $this->random_field("comments");
                                if($comment){
                                    $response = $this->ig->media->comment( $data->getId(), spintax($comment), 0);
                                    $status = $response->getStatus();
                                }
                            break;

                        case 'watching_story':
                                $response = $this->ig->story->markMediaSeen([$data]);
                                $status = $response->getStatus();
                            break;

                        case 'direct':
                                $direct = $this->random_field("directs");
                                $response = $this->ig->direct->sendText( [ "users" => [$data->getPk()]] , spintax($direct) );
                                $status = $response->getStatus();
                            break;

                        case 'follow':
                                $response = $this->ig->people->follow( $data->getPk() );
                                $status = $response->getStatus();
                            break;

                        case 'unfollow':
                                $source = $this->unfollows->source;
                                switch ($source) {
                                    case 'db':
                                        if($this->unfollows->dont_follower){
                                            $friendship = $this->get_friendship( $data->user_id );
                                            if( !$friendship->getFollowedBy() && !$friendship->getIncomingRequest() ){
                                                $response = $this->ig->people->unfollow( $data->user_id );
                                                $status = $response->getStatus();
                                                if($status == "ok"){
                                                    $this->ci->db->update("sp_instagram_activities_log", array("action" => "unfollow", "created" => time()), array("id" => $data->id ));
                                                }
                                            }else{
                                                $this->ci->db->update("sp_instagram_activities_log", array("media_id" => "1"), array("id" => $data->id ));
                                            }
                                        }else{
                                            $response = $this->ig->people->unfollow( $data->user_id );
                                            $status = $response->getStatus();
                                            if($status == "ok"){
                                                $this->ci->db->update("sp_instagram_activities_log", array("action" => "unfollow", "created" => time()), array("id" => $data->id ));
                                            }
                                        }
                                        break;
                                    
                                    default:
                                        if($this->unfollows->dont_follower){
                                            $friendship = $this->get_friendship( $data->getPk() );
                                            if( !$friendship->getFollowedBy() && !$friendship->getIncomingRequest() ){
                                                $response = $this->ig->people->unfollow( $data->getPk() );
                                                $status = $response->getStatus();
                                            }
                                        }else{
                                            $response = $this->ig->people->unfollow( $data->getPk() );
                                            $status = $response->getStatus();
                                        }
                                        break;
                                }
                                
                            break;

                        case 'repost':
                                $response = $this->repost_run($data);
                                $status = $response->getStatus();
                            break;

                    }

                    return $data;
                } catch (Exception $e) {
                    throw new Exception( $e->getMessage() );
                }
            }

            return false;
        }

        public function get_stories(){
            try {
                $items = $this->ig->story->getReelsTrayFeed();
                $items = $items->getTray();

                $media_id = false;
                $media_code = false;
                $media_type = false;
                $media_thumb = false;
                $user_pk = false;
                $user_username = false;
                $user_full_name = false;
                $itemInstance = false;

                if (count($items) > 0) {

                    foreach ($items as $tray) {

                        if(!$tray->getUser()) {
                            continue;
                        }

                        if($tray->getSeen()) {
                            continue;
                        }

                        try {
                            $user_pk = $tray->getUser()->getPk();
                            $user_username = $tray->getUser()->getUsername();
                            $user_full_name = $tray->getUser()->getFullName(); 
                        } catch(\Exception $e) {
                            continue;
                        }

                        if( !$tray->getItems()) {

                            $sub = $this->ig->story->getUserReelMediaFeed($user_pk);

                            if( !$sub->getItems()) {
                                continue;
                            }

                            if(!$sub->getUser()) {
                                continue;
                            }

                            $user_pk = $sub->getUser()->getPk();
                            $user_username = $sub->getUser()->getUsername();
                            $user_full_name = $sub->getUser()->getFullName();

                            foreach($sub->getItems() as $item) {
                                $itemInstance = $item;
                                if($media_id) {
                                    break 2;
                                }
                            }

                        }else{
                            foreach($tray->getItems() as $item) {
                                $itemInstance = $item;
                                if($media_id) {
                                    break 2;
                                }
                            }
                        }
                    }
                }

                if ($itemInstance) {
                    return $itemInstance;
                }

                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function target($target){
            $value = false;
            $by = $this->random_field("targets");

            $this->random_field("targets");

            switch ($target) {
                case 'tag':
                    $value = trim( $this->random_field("tags") );
                    break;

                case 'location':
                    $value = $this->random_field("locations");
                    $value = explode("|", $value);
                    if(count($value) == 2){
                        $value = trim( $value[1] );
                    }
                    break;

                case 'follower':
                    $value = $this->target_advance($by);
                    break;

                case 'following':
                    $value = $this->target_advance($by);
                    break;

                case 'liker':
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
                
                $username = $this->random_field("usernames");
                $username = explode("|", $username);
                if(count($username) == 2){
                    $field = $username[1];
                }

                return $field;

            }else{

                $field = $this->ig->account_id;

                return $field;
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
                        if(time() - $row->getTakenAt() > $time_array[$media_age]){ continue; }
                    }

                    //Media Type
                    if(isset($this->filters->media_type)){
                        switch ($this->filters->media_type) {
                            case 'image':
                                if($row->getMediaType() != 1 || $row->getMediaType() != 8){ continue 2; }
                                break;

                            case 'video':
                                if($row->getMediaType() != 2){ continue 2; }
                                break;
                        }
                    }

                    if( isset($this->filters->min_like) && (int)$this->filters->min_like != 0 ){
                        $min_like = $this->filters->min_like;
                        if( $min_like > $row->getLikeCount() ){ continue; }
                    }

                    if( isset($this->filters->max_like) && (int)$this->filters->max_like != 0 ){
                        $max_like = $this->filters->max_like;
                        if( $max_like < $row->getLikeCount() ){ continue; }
                    }

                    $comments = $this->get_comments( $row->getId() );

                    if( isset($this->filters->min_comment) && (int)$this->filters->min_comment != 0 ){
                        $min_comment = $this->filters->min_comment;
                        if( $min_comment > $comments->getCommentCount() ){ continue; }
                    }

                    if( isset($this->filters->max_comment)  && (int)$this->filters->max_comment != 0){
                        $max_comment = $this->filters->max_comment;
                        if( $max_comment < $comments->getCommentCount() ){ continue; }
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
                        $user_id = $row->getUser()->getPk();
                    }else{
                        $user_id = $row->getPk();
                    }

                    $userinfo = $this->get_user_info_by_id($user_id)->getUser();
                    $friendship = $this->get_friendship($user_id);

                    if(isset($this->filters->min_follower) && $this->filters->min_follower != 0 && $this->filters->min_follower > $userinfo->getFollowerCount() ){
                        continue;
                    }

                    if(isset($this->filters->max_follower) && $this->filters->max_follower != 0 && $this->filters->max_follower < $userinfo->getFollowerCount() ){
                        continue;
                    }

                    if(isset($this->filters->min_following) && $this->filters->min_following != 0 && $this->filters->min_following > $userinfo->getFollowingCount() ){
                        continue;
                    }

                    if(isset($this->filters->max_following) && $this->filters->max_following != 0 && $this->filters->max_following < $userinfo->getFollowingCount() ){
                        continue;
                    }

                    //User profile
                    if(isset($this->filters->user_profile)){
                        $user_profile = $this->filters->user_profile;
                        switch ($user_profile) {
                            case 'low':
                                if( $userinfo->getProfilePicId() != "" || $userinfo->getMediaCount() == 0){
                                    continue 2;
                                }
                                break;

                            case 'medium':
                                if( $userinfo->getProfilePicId() != "" || $userinfo->getMediaCount() < 10 || $userinfo->getFullName() == ""){
                                    continue 2;
                                }
                                break;
                            case 'high':
                                if( $userinfo->getProfilePicId() != "" || $userinfo->getMediaCount() < 30 || $userinfo->getFullName() == "" || $userinfo->getBiography() == ""){
                                    continue 2;
                                }
                                break;
                        }
                    }

                    //User relation
                    if( isset($this->filters->user_relation) ){
                        $user_relation = $this->filters->user_relation;
                        switch ($user_relation) {
                            case 'followers':
                                if($friendship->getFollowedBy() == 1 || $friendship->getIncomingRequest() == 1){
                                    continue 2;
                                }
                                break;

                            case 'followings':
                                if($friendship->getFollowing() == 1 || $friendship->getOutgoingRequest() == 1){
                                    continue 2;
                                }
                                break;
                            case 'both':
                                if($friendship->getFollowedBy() == 1 || $friendship->getFollowing() == 1 || $friendship->getIncomingRequest() == 1 || $friendship->getOutgoingRequest() == 1){
                                    continue 2;
                                }
                                break;
                        }
                    }
                }

                return $row;
            }

            return false;
        }

        public function blacklist($data){
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    
                    $ok = false;

                    if( $value->getCaption() ){

                        //Tags
                        $caption = $value->getCaption()->getText();
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
                    $username = $value->getUser()->getUsername();
                    if(!empty($this->blacklist_usernames) && !$ok){
                        foreach ($this->blacklist_usernames as $value) {
                            $value = explode("|", $value);
                            if(count($value) == 2){
                                if ($username == $value[0]) {
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
                        $data = $data->getUser();
                    }
                    break;

                case 'location':
                    $data = $this->get_feed_by_location($value);
                    if($this->type == "user"){
                        $data = $data->getUser();
                    }
                    break;

                case 'follower':
                    $item = $this->get_follower($value);
                    if($item){
                        if($this->type == "user"){
                            $data = $item;
                        }else{
                            $user_id = $item->getPk();
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
                            $user_id = $item->getPk();
                            $data = $this->get_feed_by_username($user_id);
                        }
                    }
                    break;

                case 'liker':
                    $item = $this->get_likers($value);

                    if($item){
                        if($this->type == "user"){
                            $data = $item;
                        }else{
                            $user_id = $item->getPk();
                            $data = $this->get_feed_by_username($user_id);
                        }
                    }
                    break;

                case 'commenter':
                    $item = $this->get_commenter($value);

                    if($item){
                        if($this->type == "user"){
                            $data = $item;
                        }else{
                            $user_id = $item->getPk();
                            $data = $this->get_feed_by_username($user_id);
                        }
                    }
                    break;

            }

            return $data;
        }

        public function get_feed_by_tag($tag){
            try {
                $items = $this->ig->hashtag->getFeed($tag, $this->token)->getItems();

                $items = $this->remove_users_following("feed", $items);
                $items = $this->remove_post_cant_comment($items);
                $items = $this->dont_comment_same_users("feed", $items);
                $items = $this->dont_comment_same_posts($items);
                $items = $this->dont_like_same_posts($items);
                $items = $this->dont_follow_same_users("feed", $items);
                $items = $this->blacklist($items);
                $item = $this->filter("feed", $items);

                return $item;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_feed_by_location($location_id){
            try {
                $result = $this->ig->location->getFeed($location_id, $this->token, 'recent');
                $items = [];
                
                if( $result->getSections() ){
                    foreach ($result->getSections() as $row) {
                        
                        $data = $row->getLayoutContent()->getMedias();
                        foreach ($data as $value) {
                            $items[] = $value->getMedia();
                        }

                    }
                }
                $items = $this->remove_users_following("feed", $items);
                $items = $this->remove_post_cant_comment($items);
                $items = $this->dont_comment_same_users("feed", $items);
                $items = $this->dont_comment_same_posts($items);
                $items = $this->dont_like_same_posts($items);
                $items = $this->dont_follow_same_users("feed", $items);
                $items = $this->blacklist($items);
                $item = $this->filter("feed", $items);

                return $item;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_feed_by_username($user_id){
            try {
                $maxId = null;
                $items = [];
                do {
                    $response = $this->ig->timeline->getUserFeed($user_id, $maxId);

                    if($response->getNumResults() != 0){
                        foreach ($response->getItems() as $row) {
                            $items[] = $row;
                        }
                    }

                } while ( !is_null( $maxId = $response->getNextMaxId() ) && 12 > count( $items ) );

                $items = $this->remove_users_following("feed", $items);
                $items = $this->remove_post_cant_comment($items);
                $items = $this->dont_comment_same_users("feed", $items);
                $items = $this->dont_comment_same_posts($items);
                $items = $this->dont_like_same_posts($items);
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
                        $items = $this->ig->hashtag->getFeed($value, $this->token)->getItems();
                        break;

                    case 'location':
                        $value = $this->random_field("locations");
                        $value = explode("|", $value);
                        if(count($value) == 2){
                            $value = trim( $value[1] );
                            $result = $this->ig->location->getFeed($value, $this->token, 'recent');
                            if( $result->getSections() ){
                                $items = [];
                                foreach ($result->getSections() as $row) {
                                    
                                    $data = $row->getLayoutContent()->getMedias();
                                    foreach ($data as $value) {
                                        $items[] = $value->getMedia();
                                    }

                                }
                            }
                        }
                        break;

                    case 'username':
                        $maxId = null;
                        $items = [];
                        $field = false;
                        $username = $this->random_field("usernames");
                        $username = explode("|", $username);
                        if(count($username) == 2){
                            $user_id = $username[1];
                            
                            do {
                                $response = $this->ig->timeline->getUserFeed($user_id, $maxId);

                                if($response->getNumResults() != 0){
                                    foreach ($response->getItems() as $row) {
                                        $items[] = $row;
                                    }
                                }

                            } while ( !is_null( $maxId = $response->getNextMaxId() ) && 100 > count( $items ) );
                            break;
                        }
                }

                if($items){

                    $items = $this->remove_media_reposted($items);

                    $index = array_rand($items);
                    $item = $items[$index];

                    return $item;

                }

                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function repost_run($feed){
            // Download the media
            $media = [];
            if ($feed->getMediaType() == 1) {
                $media[] = $feed->getImageVersions2()->getCandidates()[0]->getUrl();
            } else if ($feed->getMediaType() == 2) {
                $media[] = $feed->video_versions[0]->getUrl();
            } else if ($feed->getMediaType() == 8) {
                foreach ($feed->getCarouselMedia() as $m) {
                    if ($m->getMediaType() == 1) {
                        $media[] = $m->getImageVersions2()->getCandidates()[0]->getUrl();

                    } else if ($m->getMediaType() == 2) {
                        $media[] = $m->getVideoVersions()[0]->getUrl();
                    }
                }
            }

            $downloaded_media = [];
            foreach ($media as $m) {
                $url_parts = parse_url($m);
                if (empty($url_parts['path'])) {
                    continue;
                }

                $ext = strtolower(pathinfo($url_parts['path'], PATHINFO_EXTENSION));
                $filename = uniqid(ids()."-").".".$ext;
                $downres = file_put_contents(TMP_PATH . "/". $filename, file_get_contents($m));
                if ($downres) {
                    $downloaded_media[] = $filename;
                }
            }

            if (empty($downloaded_media)) {
                throw new \InvalidArgumentException("Couldn't download the media of the selected post");
            }

            //Process post
            

            $original_caption = "";
            if ($feed->getCaption()) {
                $original_caption = $feed->getCaption()->getText();
            }

            $caption = $this->reposts;

            $variables = [
                "{{caption}}" => $original_caption,
                "{{username}}" => "@".$feed->getUser()->getUsername(),
                "{{full_name}}" => $feed->getUser()->getFullName() != ""?
                                       $feed->getUser()->getFullName() :
                                       "@".$feed->getUser()->getUsername()
            ];

            $caption =  str_replace(
                        array_keys($variables), 
                        array_values($variables), 
                        $caption);

            $caption = spintax($caption);
            $caption = mb_substr($caption, 0, 2200);

            // Try to repost
            try {
                if (count($downloaded_media) > 1) {
                    $album_media = [];

                    foreach ($downloaded_media as $m) {
                        $ext = strtolower(pathinfo($m, PATHINFO_EXTENSION));

                        $album_media[] = [
                            "type" => in_array($ext, ["mp4"]) ? "video" : "photo",
                            "file" => TMP_PATH."/".$m
                        ];
                    }

                    $response = $this->ig->timeline->uploadAlbum($album_media, ['caption' => $caption]);
                } else {
                    $m = $downloaded_media[0];
                    $ext = strtolower(pathinfo($m, PATHINFO_EXTENSION));
                    if (in_array($ext, ["mp4"])) {
                        $response = $this->ig->timeline->uploadVideo(TMP_PATH."/".$m, ["caption" => $caption]);
                    } else {
                        $response = $this->ig->timeline->uploadPhoto(TMP_PATH."/".$m, ["caption" => $caption]);
                    }
                }

                return $response;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_follower($user_id){
            /*try {
                $maxId = null;
                $items = [];
                do {
                    $response = $this->ig->people->getFollowers($user_id, $this->token, NULL, $maxId);
                    if( !empty( $response->getUsers() ) ){
                        foreach ($response->getUsers() as $row) {
                            $items[] = $row;
                        }
                    }
                } while ( !is_null( $maxId = $response->getNextMaxId() ) && 100 > count( $items ) );

                if(!empty($items)){
                    $index = array_rand($items);
                    return $items[$index];
                }

                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }*/

            try {
                if( ! _s("items") ){
                    $maxId = null;
                    $items = [];
                    do {
                        $response = $this->ig->people->getFollowers($user_id, $this->token, NULL, $maxId);
                        if( !empty( $response->getUsers() ) ){
                            foreach ($response->getUsers() as $row) {
                                $items[] = $row;
                            }
                        }
                    } while ( !is_null( $maxId = $response->getNextMaxId() ) && 100 > count( $items ) );

                    _ss("items", serialize($items));

                }else{
                    $items = unserialize(_s("items"));
                }

                $items = $this->remove_private_user($items);
                $items = $this->remove_users_following("user", $items);
                $items = $this->dont_follow_same_users("user", $items);

                if(!empty($items)){
                    
                    do {
                        $index = array_rand($items);
                        $result = $items[$index];
                        $userinfo = $this->get_user_info_by_id( $result->getPk() )->getUser();
                        if( $userinfo->getMediaCount() != 0 ){
                            return $userinfo;
                        }else{
                            unset($items[$index]);
                        }
                    } while ( $userinfo->getMediaCount() == 0 && !empty( $items ));
                }

                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_self_following(){
            try {
                $items = $this->ig->people->getSelfFollowing($this->token)->getUsers();

                if(!empty($items)){
                    foreach ($items as $key => $row) {
                        $username = $row->getPk();
                        if(!empty($this->blacklist_usernames)){
                            foreach ($this->blacklist_usernames as $value) {
                                $value = explode("|", $value);
                                if(count($value) == 2){
                                    if ($username == $value[1]) {
                                        unset($items[$key]);
                                        $ok = true;
                                        break;
                                    }
                                }
                            }
                        }

                    }
                }

                if(!empty($items)){
                    $items = array_values($items);

                    $index = array_rand($items);
                    return $items[$index];
                }

                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_following($user_id){
            /*try {
                $maxId = null;
                $items = [];
                do {
                    $response = $this->ig->people->getFollowing($user_id, $this->token, NULL, $maxId);
                    if( !empty( $response->getUsers() ) ){
                        foreach ($response->getUsers() as $row) {
                            $items[] = $row;
                        }
                    }
                } while ( !is_null( $maxId = $response->getNextMaxId() ) && 100 > count( $items ) );

                if(!empty($items)){
                    $index = array_rand($items);
                    return $items[$index];
                }

                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }*/

            try {
                if( ! _s("items") ){
                    $maxId = null;
                    $items = [];
                    do {
                        $response = $this->ig->people->getFollowing($user_id, $this->token, NULL, $maxId);
                        if( !empty( $response->getUsers() ) ){
                            foreach ($response->getUsers() as $row) {
                                $items[] = $row;
                            }
                        }
                    } while ( !is_null( $maxId = $response->getNextMaxId() ) && 100 > count( $items ) );

                    _ss("items", serialize($items));

                }else{
                    $items = unserialize(_s("items"));
                }

                $items = $this->remove_private_user($items);
                $items = $this->remove_users_following("user", $items);
                $items = $this->dont_follow_same_users("user", $items);

                if(!empty($items)){
                    
                    do {
                        $index = array_rand($items);
                        $result = $items[$index];
                        $userinfo = $this->get_user_info_by_id( $result->getPk() )->getUser();
                        if( $userinfo->getMediaCount() != 0 ){
                            return $userinfo;
                        }else{
                            unset($items[$index]);
                        }
                    } while ( $userinfo->getMediaCount() == 0 && !empty( $items ));
                }

                return false;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_comments($media_id){
            try {
                $item = $this->ig->media->getComments($media_id);
                return $item;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_likers($user_id){
            try {
                $maxId = null;
                $feeds = [];
                do {
                    $response = $this->ig->timeline->getUserFeed($user_id, $maxId);

                    if($response->getNumResults() != 0){
                        foreach ($response->getItems() as $row) {
                            $feeds[] = $row;
                        }
                    }

                } while ( !is_null( $maxId = $response->getNextMaxId() ) && 12 > count( $feeds ) );

                $feeds = $this->remove_post_no_likers( $feeds );

                if(!empty( $feeds )){

                    $index = array_rand($feeds);
                    $feed = $feeds[$index];

                    $items = $this->ig->media->getLikers( $feed->getId() )->getUsers();

                    $items = $this->remove_private_user($items);
                    $items = $this->remove_users_following("user", $items);
                    $items = $this->dont_follow_same_users("user", $items);
                    
                    if(!empty($items)){
                        
                        do {
                            $index = array_rand($items);
                            $result = $items[$index];
                            $userinfo = $this->get_user_info_by_id( $result->getPk() )->getUser();
                            if( $userinfo->getMediaCount() != 0 ){
                                return $userinfo;
                            }else{
                                unset($items[$index]);
                            }
                        } while ( $userinfo->getMediaCount() == 0 && !empty( $items ));
                    }

                }

                return false;

            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_commenter($user_id){
            try {
                $maxId = null;
                $feeds = [];
                do {
                    $response = $this->ig->timeline->getUserFeed($user_id, $maxId);

                    if($response->getNumResults() != 0){
                        foreach ($response->getItems() as $row) {
                            $feeds[] = $row;
                        }
                    }

                } while ( !is_null( $maxId = $response->getNextMaxId() ) && 12 > count( $feeds ) );

                $feeds = $this->remove_post_disable_comment( $feeds );

                if(!empty( $feeds )){

                    $index = array_rand($feeds);
                    $feed = $feeds[$index];

                    $items = $this->ig->media->getComments( $feed->getId() )->getComments();

                    $users = [];
                    if($items){
                        foreach ($items as $item) {
                            $users[] = $item->getUser();
                        }
                    }

                    $items = $users;
                    $items = $this->remove_private_user($items);
                    $items = $this->remove_users_following("user", $items);
                    $items = $this->dont_follow_same_users("user", $items);

                    if(!empty($items)){
                        
                        do {
                            $index = array_rand($items);
                            $result = $items[$index];
                            $userinfo = $this->get_user_info_by_id( $result->getPk() )->getUser();
                            if( $userinfo->getMediaCount() != 0 ){
                                return $userinfo;
                            }else{
                                unset($items[$index]);
                            }
                        } while ( $userinfo->getMediaCount() == 0 && !empty( $items ));

                    }

                }

                return false;

            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function get_new_followers(){
            try {
                $response = $this->ig->people->getRecentActivityInbox();
                $new_stories = $response->getNewStories();
                $old_stories = $response->getOldStories();

                $stories = array_merge($new_stories, $old_stories);

                $new_followers = [];
                if(!empty($stories)){
                    foreach ($stories as $story) {
                        if($story->getType() == 3){
                            $first = $this->get_user_info_by_id( $story->getArgs()->getProfileId() );

                            if($first){
                                $new_followers[] = $first->getUser();
                            }

                            if( $story->getArgs()->getSecondProfileId() ){
                                $second = $this->get_user_info_by_id( $story->getArgs()->getSecondProfileId() );
                                if($second){
                                    $new_followers[] = $second->getUser();
                                }
                            }
                        }
                    }
                }

                $items = $this->remove_direct_user_sent($new_followers);
                
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
                $this->ci->db->from("sp_instagram_activities_log");
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
                        $item = $this->ci->model->get("id", "sp_instagram_activities_log", "user_id = '".$row->getPk()."' AND action = 'direct' AND pid = '{$this->data->pid}'");
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

        public function remove_private_user($data){
            if(in_array($this->todo, ["like", "comment", "repost"]) || ($this->todo == "follower" && isset( $this->follows->dont_private ) )){
                if(!empty($data)){
                    foreach ($data as $key => $value) {
                        if( $value->getIsPrivate() == 1 ){
                            unset($data[$key]); continue;
                        }
                    }
                }
                
                if(!empty($data)){
                    $data = array_values($data);
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
                                $item = $this->ci->model->get("id", "sp_instagram_activities_log", "user_id = '".$row->getUser()->getPk()."' AND ( action = 'follow' OR action = 'unfollow' ) AND pid = '{$this->data->pid}'");
                                if(empty($item)) $feeds_tmp[] = $row;
                            }
                        }
                        $data = $feeds_tmp;
                        break;
                    
                    case 'user':
                        $users_tmp = array();
                        if(!empty($data)){
                            foreach ($data as $key => $row) {
                                $item = $this->ci->model->get("id", "sp_instagram_activities_log", "user_id = '".$row->getPk()."' AND ( action = 'follow' OR action = 'unfollow' ) AND pid = '{$this->data->pid}'");
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
            try {
                if($this->todo == "follow"){
                    $users = [];
                    if($data){

                        foreach ($data as $value) {
                            switch ($type) {
                                case 'feed':
                                        $users[] = $value->getUser()->getPk();
                                    break;
                                
                                case 'user':
                                        $users[] = $value->getPk();
                                    break;
                            }
                        }

                        $friendships = $this->ig->people->getFriendships( $users );

                        $remove_items = [];
                        $friendships = $friendships->getFriendshipStatuses();
                        $friendships = json_decode( json_encode( $friendships ) );

                        foreach ($friendships as $key => $value) {
                            if( $value->following == 1 || $value->outgoing_request == 1 ){
                                $remove_items[] = $key;
                            }
                        }

                        foreach ($data as $key => $value) {
                            switch ($type) {
                                case 'feed':
                                    $user_id = $value->getUser()->getPk();
                                    break;
                                
                                default:
                                    $user_id = $value->getPk();
                                    break;
                            }

                            if( in_array($user_id, $remove_items) ){
                                unset($data[$key]); continue;
                            }
                        }

                    }


                    if(!empty($data)){
                        $data = array_values($data);
                    }
                }

                return $data;
            } catch (Exception $e) {
                throw new Exception( $e->getMessage() );
            }
        }

        public function remove_post_no_likers($data){
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    if( $value->getLikeCount() == 0 ){
                        unset($data[$key]); continue;
                    }
                }
            }

            if(!empty($data)){
                $data = array_values($data);
            }

            return $data;
        }

        public function remove_post_disable_comment($data){
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    if( $value->getCommentsDisabled() == 1 ){
                        unset($data[$key]); continue;
                    }
                }
            }

            if(!empty($data)){
                $data = array_values($data);
            }

            return $data;
        }

        //Remove post can't comment
        public function remove_post_cant_comment($data){
            if($this->todo == "comment"){
                if(!empty($data)){
                    foreach ($data as $key => $value) {
                        if( $value->getCommentsDisabled() == 1 ){
                            unset($data[$key]); continue;
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
                            $item = $this->ci->model->get("id", "sp_instagram_activities_log", "user_id = '{$row->getUser()->getPk()}' AND action = 'comment' AND pid = '{$this->data->pid}'");
                            if(empty($item)) $feeds_tmp[] = $row;
                        }
                        $data = $feeds_tmp;
                        break;
                    
                    case 'user':
                        $users_tmp = [];
                        foreach ($data as $key => $row) {
                            $item = $this->ci->model->get("id", "sp_instagram_activities_log", "user_id = '{$row->getPk()}' AND action = 'comment' AND pid = '{$this->data->pid}'");
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
                        $item = $this->ci->model->get("id", "sp_instagram_activities_log", "media_id = '".$row->getId()."' AND action = 'comment' AND pid = '{$this->data->pid}'");
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

        //Don't like same posts
        public function dont_like_same_posts($data){
            if($this->todo == "like"){
                $feeds_tmp = [];
                if(!empty($data)){
                    foreach ($data as $key => $row) {
                        $item = $this->ci->model->get("id", "sp_instagram_activities_log", "media_id = '".$row->getId()."' AND action = 'like' AND pid = '{$this->data->pid}'");
                        if(empty($item)) $feeds_tmp[] = $row;
                    }
                }
                $data = $feeds_tmp;
            }

            if(!empty($data)){
                $data = array_values($data);
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

        public function rankToken(){
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            return  $rankToken;
        }

    }

}