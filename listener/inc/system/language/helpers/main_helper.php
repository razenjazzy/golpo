<?php
/*Build & Load Language*/
if(!function_exists('__')){
    function __($key = ''){
        $CI =& get_instance();
        
        if(_s('language')){
            $language = _s('language');
        }else{
            $language_category = $CI->main_model->get("*", "sp_language_category", "is_default = '1'");
            $language = json_encode($language_category);
            if($language_category){
                _ss("language", $language);
            }
        }

        if($language){
            $language = is_string($language)?json_decode( $language ):$language;

            if(isset($language->code)){
                $lang_file = FCPATH."assets/tmp/language/lang_".$language->code.".txt";
                if(file_exists($lang_file)){
                    $data = file_get_contents(FCPATH."assets/tmp/language/lang_".$language->code.".txt");
                    $data = json_decode($data, 1);
                    if(isset($data['language_data'])){
                        $data = $data['language_data'];
                        if(isset($data[ md5($key) ])){
                            return $data[ md5($key) ];
                        }
                    }
                }
            }
        }

        $text = $CI->lang->line($key);
        if($text != "") return $text;
        return $key;
    }
}

if(!function_exists('get_lang_file')){
    function get_lang_file(){
        $CI =& get_instance();
        $language = _s('language');
        if($language){
            $language = json_decode( $language );
            if(isset($language->code)){
                $lang_file = FCPATH."assets/tmp/language/lang_".$language->code.".txt";
                if(file_exists($lang_file)){
                    $data = file_get_contents(FCPATH."assets/tmp/language/lang_".$language->code.".txt");
                    $data = json_decode($data, 1);
                    $list = [];
                    $languages = $data['language_data'];
                    foreach ($data['language_data'] as $key => $value) {
                        $value = str_replace("'", "&apos;", $value);
                        $value = str_replace('"', " &quot;", $value);
                        $list[$key] = $value;
                    }

                    return json_encode($list);
                }
            }
        }
        return false;
    }
}

if(!function_exists('get_language_categories')){
    function get_language_categories(){
        $CI =& get_instance();
        return $CI->main_model->fetch("*", "sp_language_category", "status = '1'");
    }
};

/*Views & Pages*/
if(!function_exists('view')){
    function view($path = "", $data = array(), $return = FALSE, $CI = FALSE){
        if(!$CI){
            $CI =& get_instance();
        }

        return $CI->load->view($path, $data, $return);
    }
}