<?php
/*Proxy*/
if(!function_exists('add_proxy')){
    function add_proxy($social_network){
        $CI = &get_instance();
        $package = 1; 

        $query = $CI->db->query("
            SELECT a.*, b.username, b.social_network, COUNT(a.id) as count
            FROM sp_proxy_manager as a
            LEFT JOIN sp_account_manager as b ON a.id = b.proxy 
            WHERE ( b.social_network LIKE '%{$social_network}%' ESCAPE '!' AND a.status LIKE '%1%' ESCAPE '!' AND  a.packages LIKE '%\"1\"%' ESCAPE '!' )
            OR ( b.social_network IS NULL AND a.status LIKE '%1%' ESCAPE '!' AND  a.packages LIKE '%\"1\"%' ESCAPE '!' )
            OR ( b.social_network = '{$social_network}' AND a.status = 1 AND a.packages IS NULL )
            OR ( b.social_network IS NULL AND a.status = 1 AND a.packages IS NULL )
            GROUP BY a.id,b.username,b.social_network
            ORDER BY count DESC
        ");

        $proxies = $query->result();

        if(!empty($proxies)){
              foreach ($proxies as $key => $row) {
                    $row->count = ($row->username == "")?0:$row->count;

                    if($row->count < $row->limit || $row->limit == ""){
                        return (object)[
                            "id" => $row->id,
                            "proxy" => $row->address
                        ];
                    }
              }
              
        }

        return (object)[
            "id" => "",
            "proxy" => ""
        ];
    }
}

if(!function_exists('get_proxy')){
    function get_proxy($proxy){
        if($proxy != ""){
            if( is_numeric($proxy) ){
                $CI = &get_instance();

                if( get_option('system_proxy', 1) ){
                    $item = $CI->main_model->get("*", "sp_proxy_manager", "id = '{$proxy}' AND status = 1");
                    if($item){
                        return $item->address;
                    }else{
                        return "";
                    }
                }

            }else{
                if(get_option('user_proxy', 1)){
                    return $proxy;
                }else{
                    return "";
                }
            }
        }else{
            return "";
        }
    }
}
/*End proxy*/