<?php
require_once("application/controllers/Home.php"); // loading home controller

class Ecommerce extends Home
{    
  public $currency_icon;
  public $editor_allowed_tags;
  public $login_to_continue;
  public $ecommerce_review_comment_exist;
  public function __construct()
  {
      parent::__construct();
      $this->load->helpers(array('ecommerce_helper'));

      $function_name=$this->uri->segment(2);     
      $private_functions = array("","index","qr_code","download_qr","qr_code_action","qr_code_live","notification_settings","notification_settings_action","reset_notification","reset_reminder","reminder_settings","reminder_settings_action","store_list","copy_url","order_list","change_payment_status","order_list_data","reminder_send_status_data","reminder_response","add_store","add_store_action","edit_store","edit_store_action","product_list","product_list_data","delete_store","add_product","add_product_action","edit_product","edit_product_action","delete_product","payment_accounts","payment_accounts_action","attribute_list","attribute_list_data","ajax_create_new_attribute","ajax_get_attribute_update_info","ajax_update_attribute","delete_attribute","category_list","category_list_data","ajax_create_new_category","ajax_get_category_update_info","ajax_update_category","delete_category","coupon_list","coupon_list_data","add_coupon","add_coupon_action","edit_coupon","edit_coupon_action","delete_coupon","upload_product_thumb","delete_product_thumb","upload_store_logo","delete_store_logo","upload_store_favicon","delete_store_favicon","download_csv","upload_featured_image","delete_featured_image","pickup_point_list","pickup_point_list_data","ajax_create_new_pickup_point","ajax_get_pickup_point_update_info","ajax_update_pickup_point","delete_pickup_point");
      if(in_array($function_name, $private_functions)) 
      {
        if($this->session->userdata('logged_in')!= 1) redirect('home/login', 'location');
        if($this->session->userdata('user_type') != 'Admin' && !in_array(268,$this->module_access)) redirect('home/login', 'location');        
        $this->member_validity();
      }
      $this->currency_icon = $this->currency_icon();
      $this->editor_allowed_tags = '<h1><h2><h3><h4><h5><h6><a><b><strong><p><i><div><span><ul><li><ol><blockquote><code><table><tr><td><th>';
      $this->login_to_continue = $this->lang->line("You either have to purchase inside Facebook Messenger or have to login.");
  }

  public function index()
  {
      $this->store_list();
  }

  protected function ecommerce_review_comment_exist()
  {
      if($this->basic->is_exist("add_ons",array("project_id"=>48))) return true;
      return false;
  }

  public function login_action()
  {
    $this->ajax_check();
    $store_id = strip_tags($this->input->post("store_id",true));
    $email = strip_tags($this->input->post("email",true));
    $password = md5($this->input->post("password",true));

    $info = $this->basic->get_data("messenger_bot_subscriber",array("where"=>array("email"=>$email,"password"=>$password,"subscriber_type"=>"system","store_id"=>$store_id)));

    if (count($info) == 0) {
        echo json_encode(array("status"=>"0","message"=>$this->lang->line("invalid email or password")));
        exit();
    }
    else
    {
      $ecom_session_subscriber_id = isset($info['0']['subscribe_id']) ? $info['0']['subscribe_id'] : '';
      if ($ecom_session_subscriber_id=='') {
          echo json_encode(array("status"=>"0","message"=>$this->lang->line("Subscriber not found.")));
          exit();
      }
      $this->session->set_userdata($store_id."ecom_session_subscriber_id",$ecom_session_subscriber_id);
    }
    echo json_encode(array("status"=>"1","message"=>""));
  }

  public function register_action()
  {
    $this->ajax_check();
    $user_id = strip_tags($this->input->post("js_user_id",true));
    $store_id = strip_tags($this->input->post("store_id",true));
    $register_first_name = strip_tags($this->input->post("register_first_name",true));
    $register_last_name = strip_tags($this->input->post("register_last_name",true));
    $register_email = strip_tags($this->input->post("register_email",true));
    $register_password = md5($this->input->post("register_password",true));
    $register_password_confirm = md5($this->input->post("register_password_confirm",true));

    $info = $this->basic->get_data("messenger_bot_subscriber",array("where"=>array("email"=>$register_email,"store_id"=>$store_id)),"id");

    if (count($info) > 0) {
        echo json_encode(array("status"=>"0","message"=>$this->lang->line("This email is already used.")));
        exit();
    }
    else
    {
      if($register_password!=$register_password_confirm)
      {
        echo json_encode(array("status"=>"0","message"=>$this->lang->line("Passwords does not match.")));
        exit();
      }

      $subscriber_id = "sys-".time().$this->_random_number_generator(6);

      $insert_data  = array
      (
        "email"=>$register_email,
        "user_id"=>$user_id,
        "subscribe_id"=>$subscriber_id,
        "first_name"=>$register_first_name,
        "last_name"=>$register_last_name,
        "full_name"=>$register_first_name." ".$register_last_name,
        "subscribed_at"=>date("Y-m-d H:i:s"),
        "status"=>"0",
        "is_bot_subscriber"=>"0",
        "password"=>$register_password,
        "subscriber_type"=>"system",
        "store_id"=>$store_id
      );
      $this->basic->insert_data("messenger_bot_subscriber",$insert_data);
      $this->session->set_userdata($store_id."ecom_session_subscriber_id",$subscriber_id);
    }
    echo json_encode(array("status"=>"1","message"=>""));
  }

  public function logout()
  {
    $this->ajax_check();
    $store_id = $this->input->post("store_id",true);
    $this->session->unset_userdata($store_id."ecom_session_subscriber_id");
  }


  public function notification_settings($id=0)
  {
      if($id==0) exit();
      $xdata=$this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$id,"user_id"=>$this->user_id)),"notification_sms_api_id,notification_email_api_id,notification_email_subject,notification_configure_email_table,notification_message");
      if(!isset($xdata[0])) exit();

      $data['store_id'] = $id;
      $data['body'] = 'ecommerce/notification_settings';
      $data['page_title'] = $this->lang->line("Order Status Notification");
      $data['sms_option'] = $this->get_sms_api();
      $data['email_option'] = $this->get_email_api();
      $data['country_names'] = $this->get_country_names();
      $data['currency_icons'] = $this->currency_icon();
      $data['get_ecommerce_config'] = $this->get_ecommerce_config();
      $data['notification_list'] = $this->basic->get_enum_values("ecommerce_cart","status");
      $data['notification_default'] = $this->notification_default();      
      $data['xdata']=$xdata[0];
      $data["iframe"]="1";

      $this->_viewcontroller($data);
  }

  public function notification_settings_action()
  {
    $this->ajax_check();
    $post=$_POST;
    $tag_allowed = array("email_text");
    $notification_list = $this->basic->get_enum_values("ecommerce_cart","status");
    $notification_default = $this->notification_default();
    foreach ($post as $key => $value) 
    {
      if(!is_array($value) && !in_array($key, $tag_allowed)) $temp = strip_tags($value);
      else $temp = $value;
      $$key=$this->security->xss_clean($temp);
    }

    $notification_array = array();

    
    foreach ($notification_list as $key => $value) 
    { 
      $notification_array['messenger'][$value]['text'] = isset($msg_text[$key]) ? $msg_text[$key] : $notification_default['messenger'];
      $notification_array['messenger'][$value]['btn'] = isset($msg_btn[$key]) ? strtoupper($msg_btn[$key]) : 'MY ORDERS';
      
      if($this->session->userdata('user_type') == 'Admin' || in_array(263,$this->module_access))
        if($notification_email_api_id!='') $notification_array['email'][$value] =  isset($email_text[$key]) ? $email_text[$key] : $notification_default['email'];
      
      if($this->session->userdata('user_type') == 'Admin' || in_array(264,$this->module_access))
        if($notification_sms_api_id!='') $notification_array['sms'][$value] =  isset($sms_text[$key]) ? $sms_text[$key] : $notification_default['sms'];
    }


    $email_api_info = explode("-",$notification_email_api_id);
    $notification_configure_email_table = isset($email_api_info[0]) ? $email_api_info[0] : '';
    $notification_email_api_id = isset($email_api_info[1]) ? $email_api_info[1] : 0;

    if($notification_email_subject=="") $notification_email_subject = '{{store_name}} | Order Update';

    $insert_data = array
    (
      "notification_sms_api_id"=>$notification_sms_api_id,
      "notification_email_api_id"=>$notification_email_api_id,
      "notification_email_subject"=>$notification_email_subject,
      "notification_configure_email_table"=>$notification_configure_email_table,
      "notification_message"=>json_encode($notification_array)
    );
    $this->basic->update_data("ecommerce_store",array("id"=>$store_id,"user_id"=>$this->user_id),$insert_data);
    echo json_encode(array("status"=>"1","message"=>$this->lang->line("Notification has been setup successfully.")));

  }

  private function notification_default()
  {
    return array
    (
      'messenger' => 'Hello {{first_name}},

Order #{{order_no}} status has been updated to {{order_status}}.
{{update_note}}

Thank you,
{{store_name}} Team',
      'email' => 'Hello {{first_name}},<br/><br/>Order #{{order_no}} status has been updated to {{order_status}}.<br><br>{{update_note}}<br>Invoice : {{invoice_url}} <br/><br/>Thank you,<br/><a href="{{store_url}}">{{store_name}}</a> Team',
      'sms' => 'Order #{{order_no}} status has been updated to {{order_status}}.
Thanks, {{store_name}}'
    );
  }

  public function reset_notification($id=0)
  {
    $insert_data = array
    (
      "notification_sms_api_id"=>0,
      "notification_email_api_id"=>0,
      "notification_email_subject"=>'',
      "notification_configure_email_table"=>'',
      "notification_message"=>''
    );
    $this->basic->update_data("ecommerce_store",array("id"=>$id,"user_id"=>$this->user_id),$insert_data);
    redirect(base_url('ecommerce/notification_settings/'.$id),'location');
  }

  public function reset_reminder($id=0)
  {
    $reminder_default = $this->reminder_default();
    $messenger_content = array
    (
      "checkout"=>array
      (
        "checkout_text"=>$reminder_default['messenger']['checkout']['checkout_text'],
        "checkout_text_next" => $reminder_default['messenger']['checkout']['checkout_text_next'],
        "checkout_btn_next"=>"MY ORDERS"
      )
    );

    $insert_data = array
    (
      "sms_api_id"=>0,
      "email_api_id"=>0,
      "email_subject"=>'',
      "configure_email_table"=>'',
      "messenger_content"=>json_encode($messenger_content),
      "sms_content"=>'',
      "email_content"=>''
    );
    $this->basic->update_data("ecommerce_store",array("id"=>$id,"user_id"=>$this->user_id),$insert_data);
    redirect(base_url('ecommerce/reminder_settings/'.$id),'location');
  }


 

  public function store_list()
  {
      $data['body'] = 'ecommerce/store_list';
      $data['page_title'] = $this->lang->line("Ecommerce Store");
      $data['data_days'] = $data_days = 30;        

      $store_data=$this->basic->get_data("ecommerce_store",array("where"=>array("ecommerce_store.user_id"=>$this->user_id)),'ecommerce_store.*,page_name,page_profile,facebook_rx_fb_page_info.page_id as fb_page_id',array('facebook_rx_fb_page_info'=>"facebook_rx_fb_page_info.id=ecommerce_store.page_id,left"),'',$start=NULL,$order_by="store_name ASC");
      
      $default_store_id  = isset($store_data[0]['id']) ? $store_data[0]['id'] : "";
   
     
      $store_id = $this->input->post('store_id');
      if($store_id =="" && $this->session->userdata("ecommerce_selected_store")=="")  $store_id = $default_store_id;

      if($store_id!="") $this->session->set_userdata("ecommerce_selected_store",$store_id);

      $store_id = $this->session->userdata("ecommerce_selected_store");

      $current_store_data = $this->get_current_store_data();
      $default_store_name = isset($current_store_data['store_name']) ? $current_store_data['store_name'] : "";
      $default_store_unique_id = isset($current_store_data['store_unique_id']) ? $current_store_data['store_unique_id'] : "";
      $default_store_title_display = !empty($default_store_unique_id) ? "<a target='_BLANK' href='".base_url("ecommerce/store/".$default_store_unique_id)."'>".$default_store_name."</a>" : "";
      $this->session->set_userdata("ecommerce_selected_store_title_display",$default_store_title_display);
      $this->session->set_userdata("ecommerce_selected_store_title",$default_store_name);

      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $currency = $this->input->post('currency');

      if($to_date=='') $to_date = date("Y-m-d");
      if($from_date=='') $from_date = date("Y-m-d",strtotime("$to_date - ".$data_days." days"));

      $ecommerce_config = $this->get_ecommerce_config();
      if($this->input->post('from_date')=="") $from_date=$from_date." 00:00:00";
      if($this->input->post('to_date')=="") $to_date=$to_date." 23:59:59";
      if($this->input->post('currency')=="") $currency= isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";

      $this->session->set_userdata("ecommerce_from_date",$from_date);
      $this->session->set_userdata("ecommerce_to_date",$to_date);
      $this->session->set_userdata("ecommerce_currency",$currency);


      $where_simple2=array();
      $where_simple2['ecommerce_cart.currency'] = $currency;
      $where_simple2['ecommerce_cart.store_id'] = $store_id;
      $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
      $where_simple2['ecommerce_cart.updated_at >='] = $from_date;
      $where_simple2['ecommerce_cart.updated_at <='] = $to_date;
      $where2  = array('where'=>$where_simple2);
      $select2 = array("ecommerce_cart.*","first_name","last_name","full_name","profile_pic","email","image_path");  
      $table2 = "ecommerce_cart";
      $join2 = array('messenger_bot_subscriber'=>"messenger_bot_subscriber.subscribe_id=ecommerce_cart.subscriber_id,left");
      $cart_data = $this->basic->get_data($table2,$where2,$select2,$join2,$limit2='',$start2='',$order_by2='ecommerce_cart.updated_at desc');
       
      // $i=0;
      // if(isset($store_data[$i]))
      // {
      //   $store_data[$i]["page_name"] = "<a data-toggle='tooltip' data-original-title='".$this->lang->line('Visit Page')."' target='_BLANK' href='https://facebook.com/".$store_data[$i]["fb_page_id"]."'>".$store_data[$i]["page_name"]."</a>";

      //   $store_data[$i]['created_at'] = date('jS F y', strtotime($store_data[$i]['created_at']));
      // }       

      $data["store_data"] = $store_data;

      $data["cart_data"] = $cart_data;
      // $data['country_names'] = $this->get_country_names();
      $data['currency_icons'] = $this->currency_icon();
      $data['product_list'] = $this->get_product_list_array($store_id);
      $data['top_products'] = $this->basic->get_data("ecommerce_cart_item",array("where"=>array("store_id"=>$store_id,"updated_at >="=>$from_date,"updated_at <="=>$to_date)),"sum(quantity) as sales_count,product_id",$join='',$limit='10',$start=NULL,$order_by='sales_count desc',$group_by='product_id');
      $data['currecny_list_all'] = $this->currecny_list_all();
      $data['ecommerce_config'] = $ecommerce_config;
      $this->_viewcontroller($data);
  }

  public function copy_url($store_id=0)
  {
    $data['product_list'] = $this->get_product_list_array($store_id);    
    $data['category_list'] = $this->get_category_list();
    $data['current_store_data'] = $this->get_current_store_data();
    $data['body'] = "ecommerce/copy_url";
    $data['iframe'] = "1";
    $this->_viewcontroller($data);
  }

  private function store_locale_analytics($store_data=array())
  {
    return $store_data;
  }

  public function store($store_unique_id=0)
  {
    if($store_unique_id==0) exit();
    $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
    $where_simple = array("ecommerce_store.store_unique_id"=>$store_unique_id,"ecommerce_store.status"=>'1');
    $where = array('where'=>$where_simple);
    $store_data = $this->basic->get_data("ecommerce_store",$where);

    if(!isset($store_data[0]))
    {
      echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">'.$this->lang->line("Store not found.").'</h2>';
      exit();
    }

    $this->_language_loader($store_data[0]['store_locale']);
    $store_id = $store_data[0]['id'];
    $user_id = $store_data[0]['user_id'];

    $subscriber_id = $this->session->userdata($store_id."ecom_session_subscriber_id");
    if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);

    $review_data_formatted= array();
    if($this->ecommerce_review_comment_exist)
    {
      $review_data = $this->basic->get_data("ecommerce_product_review",array("where"=>array("store_id"=>$store_id,"hidden"=>"0")),array("product_id","sum(rating) as total_point","count(id) as total_review"),"","",NULL,$order_by='',$group_by='product_id');
      foreach ($review_data as $key => $value)
      {
        $review_data_formatted[$value['product_id']] = $value;
      }
    }

    $fb_app_id = $this->get_app_id();
    $data = array('body'=>"ecommerce/store_single","page_title"=>$store_data[0]['store_name']." | ".$this->lang->line("Products"),"fb_app_id"=>$fb_app_id,"favicon"=>base_url('upload/ecommerce/'.$store_data[0]['store_favicon']));

    $order_by = "product_name ASC";
    $default_where = array();

    $data["review_data"] = $review_data_formatted;
    $data["store_data"] = $store_data[0];
    $data["product_list"] = $this->get_product_list_array($store_id,$default_where,$order_by);
    $data["category_list"] = $this->get_category_list($store_id);
    $data["attribute_list"] = $this->get_attribute_list($store_id);
    $data['currency_icons'] = $this->currency_icon();
    $data['ecommerce_config'] = $this->get_ecommerce_config($store_id);
    $data['current_cart'] = $this->get_current_cart($subscriber_id,$store_id);
    $data["social_analytics_codes"] = $this->store_locale_analytics($store_data[0]);
    $this->load->view('ecommerce/bare-theme', $data);
  }

  public function product($product_id=0)
  {
    if($product_id==0) exit();
    $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
    $where_simple = array("ecommerce_product.id"=>$product_id,"ecommerce_product.status"=>"1","ecommerce_store.status"=>"1");
    $where = array('where'=>$where_simple);
    $join = array('ecommerce_store'=>"ecommerce_product.store_id=ecommerce_store.id,left");  
    $select = array("ecommerce_product.*","store_name","store_unique_id","store_logo","store_favicon","terms_use_link","refund_policy_link","store_locale","pixel_id","google_id");   
    $product_data = $this->basic->get_data("ecommerce_product",$where,$select,$join);

    if(!isset($product_data[0]))
    {
      echo '<br/><h1 style="text-align:center">'.$this->lang->line("Product not found.").'</h1>';
      exit();
    }
    $this->_language_loader($product_data[0]['store_locale']);

    $subscriber_id = $this->session->userdata($product_data[0]['store_id']."ecom_session_subscriber_id");
    if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);   
    

    $update_visit_count_sql = "UPDATE ecommerce_product SET visit_count=visit_count+1 WHERE id=".$product_id;
    $this->basic->execute_complex_query($update_visit_count_sql);

    $user_id = isset($product_data[0]["user_id"]) ? $product_data[0]["user_id"] : 0;
    $fb_app_id = $this->get_app_id();
    $data = array('body'=>"ecommerce/product_single","page_title"=>$product_data[0]['store_name']." | ".$product_data[0]['product_name'],"fb_app_id"=>$fb_app_id,"favicon"=>base_url('upload/ecommerce/'.$product_data[0]['store_favicon']));


    $review_data = array();
    $review_list_data = array();
    $xreview = array();
    $has_purchase_array=array();
    if($this->ecommerce_review_comment_exist)
    {
      $review_data = $this->basic->get_data("ecommerce_product_review",array("where"=>array("product_id"=>$product_id,"hidden"=>"0")),array("product_id","sum(rating) as total_point","count(id) as total_review"),"","",NULL,$order_by='',$group_by='product_id');

      $join=array('messenger_bot_subscriber'=>"messenger_bot_subscriber.subscribe_id=ecommerce_product_review.subscriber_id,left");    
      $review_list_data = $this->basic->get_data("ecommerce_product_review",array("where"=>array("product_id"=>$product_id,"hidden"=>"0")),array("ecommerce_product_review.*","first_name","last_name","profile_pic","image_path"),$join,"",NULL,$order_by='id DESC');

      if($subscriber_id!='' && $this->user_id=="")
      {
        $join_me = array('ecommerce_cart_item'=>"ecommerce_cart_item.cart_id=ecommerce_cart.id,left"); 
        $has_purchase_array = $this->basic->get_data("ecommerce_cart",array("where"=>array("subscriber_id"=>$subscriber_id,"product_id"=>$product_id),"where_not_in"=>array("status"=>array("pending","rejected"))),'ecommerce_cart_item.*,count(cart_id) as total_row',$join_me,'',NULL,'','cart_id');
        $xreview = $this->basic->get_data("ecommerce_product_review",array("where"=>array("product_id"=>$product_id,"subscriber_id"=>$subscriber_id)),'');
       
      }

    }
    $data["review_data"] = $review_data;
    $data["review_list_data"] = $review_list_data;
    $data["xreview"] = $xreview;
    $data["has_purchase_array"] = $has_purchase_array;   
   
    $data["product_data"] = $product_data[0];      
    $data["category_list"] = $this->get_category_list($product_data[0]["store_id"]);
    $data["attribute_list"] = $this->get_attribute_list($product_data[0]["store_id"],true);
    $data['currency_icons'] = $this->currency_icon();
    $data['ecommerce_config'] = $this->get_ecommerce_config($product_data[0]["store_id"]);  
    $data['current_cart'] = $this->get_current_cart($subscriber_id,$product_data[0]['store_id']);  
    $data["social_analytics_codes"] = $this->store_locale_analytics($product_data[0]);
    if($this->addon_exist('ecommerce_product_price_variation')) $data["attribute_price_map"] = $this->basic->get_data("ecommerce_attribute_product_price",array("where"=>array("product_id"=>$product_id)));
    else $data["attribute_price_map"] = array();
    $data['current_product_id'] = isset($product_data[0]['id']) ? $product_data[0]['id'] : 0;
    $data['current_store_id'] = isset($product_data[0]['store_id']) ? $product_data[0]['store_id'] : 0;

    $this->load->view('ecommerce/bare-theme', $data);
  }

  public function comment($comment_id=0)
  {
    if($comment_id==0) exit();
    $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
    if(!$this->ecommerce_review_comment_exist) exit();
    $where_simple = array("ecommerce_product_comment.id"=>$comment_id,"ecommerce_product_comment.hidden"=>"0","ecommerce_product.deleted"=>"0");
    $where = array('where'=>$where_simple);
    $join = array('ecommerce_product'=>"ecommerce_product.id=ecommerce_product_comment.product_id,left",'ecommerce_store'=>"ecommerce_product_comment.store_id=ecommerce_store.id,left");  
    $select = array("ecommerce_product_comment.*","product_name","ecommerce_product.user_id","store_name","store_unique_id","store_logo","store_favicon","terms_use_link","refund_policy_link","store_locale","pixel_id","google_id");   
    $product_data = $this->basic->get_data("ecommerce_product_comment",$where,$select,$join);

    if(!isset($product_data[0]))
    {
      echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">'.$this->lang->line("Comment not found.").'</h2>';
      exit();
    }
    $this->_language_loader($product_data[0]['store_locale']);

    $subscriber_id = $this->session->userdata($product_data[0]['store_id']."ecom_session_subscriber_id");
    if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);

    $user_id = isset($product_data[0]["user_id"]) ? $product_data[0]["user_id"] : 0;
    $fb_app_id = $this->get_app_id();
    $page_title = $product_data[0]['store_name']." | ".$product_data[0]['product_name']." | ".$this->lang->line("Comment")."#".$comment_id;
    $data = array('body'=>"ecommerce/comment_single","page_title"=>$page_title,"fb_app_id"=>$fb_app_id,"favicon"=>base_url('upload/ecommerce/'.$product_data[0]['store_favicon']));
   
    $data["product_data"] = $product_data[0]; 
    $data['current_cart'] = $this->get_current_cart($subscriber_id,$product_data[0]['store_id']);  
    $data["social_analytics_codes"] = $this->store_locale_analytics($product_data[0]);      
    $data['current_product_id'] = isset($product_data[0]['product_id']) ? $product_data[0]['product_id'] : 0;
    $data['current_store_id'] = isset($product_data[0]['store_id']) ? $product_data[0]['store_id'] : 0;
    $data['comment_id'] = $comment_id;
    $this->load->view('ecommerce/bare-theme', $data);
  }

  public function review($review_id=0)
  {
    if($review_id==0) exit();
    $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
    if(!$this->ecommerce_review_comment_exist) exit();

    $where_simple = array("ecommerce_product_review.id"=>$review_id,"ecommerce_product_review.hidden"=>"0","ecommerce_product.deleted"=>"0");
    $where = array('where'=>$where_simple);
    $join = array('ecommerce_product'=>"ecommerce_product.id=ecommerce_product_review.product_id,left",'ecommerce_store'=>"ecommerce_product_review.store_id=ecommerce_store.id,left",'messenger_bot_subscriber'=>"messenger_bot_subscriber.subscribe_id=ecommerce_product_review.subscriber_id,left");  
    $select = array("ecommerce_product_review.*","product_name","ecommerce_product.user_id","store_name","store_unique_id","store_logo","store_favicon","terms_use_link","refund_policy_link","store_locale","pixel_id","google_id","first_name","last_name","profile_pic","image_path");   
    $product_data = $this->basic->get_data("ecommerce_product_review",$where,$select,$join);

    if(!isset($product_data[0]))
    {
      echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">'.$this->lang->line("Review not found.").'</h2>';
      exit();
    }
    $this->_language_loader($product_data[0]['store_locale']);

    $subscriber_id = $this->session->userdata($product_data[0]['store_id']."ecom_session_subscriber_id");
    if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);

    $user_id = isset($product_data[0]["user_id"]) ? $product_data[0]["user_id"] : 0;
    $fb_app_id = $this->get_app_id();
    $page_title = $product_data[0]['store_name']." | ".$product_data[0]['product_name']." | ".$this->lang->line("Review")."#".$review_id;
    $data = array('body'=>"ecommerce/review_single","page_title"=>$page_title,"fb_app_id"=>$fb_app_id,"favicon"=>base_url('upload/ecommerce/'.$product_data[0]['store_favicon']));
   
    $data["review_data"] = $product_data; 
    $data['current_cart'] = $this->get_current_cart($subscriber_id,$product_data[0]['store_id']);  
    $data["social_analytics_codes"] = $this->store_locale_analytics($product_data[0]);      
    $data['current_product_id'] = isset($product_data[0]['product_id']) ? $product_data[0]['product_id'] : 0;
    $data['current_store_id'] = isset($product_data[0]['store_id']) ? $product_data[0]['store_id'] : 0;
    $data['review_id'] = $review_id;
    $this->load->view('ecommerce/bare-theme', $data);
  }

  public function cart($id=0)
  {      
    $store_data_temp = $this->basic->get_data("ecommerce_cart",array("where"=>array("id"=>$id)),"store_id");
    $store_id_temp = isset($store_data_temp[0]['store_id']) ? $store_data_temp[0]['store_id'] : "0";

    $subscriber_id=$this->session->userdata($store_id_temp."ecom_session_subscriber_id");
    if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);    
    if($subscriber_id=="")
    {
      echo $this->login_to_continue;
      exit();      
    }

    $this->update_cart($id,$subscriber_id);

    $select2 = array("ecommerce_cart.*","first_name","last_name","full_name","profile_pic","email","image_path","phone_number","user_location","store_name","store_email","store_favicon","store_phone","store_logo","store_address","store_zip","store_city","store_phone","store_email","store_country","store_state","store_unique_id","refund_policy_link","terms_use_link","store_locale","pixel_id","google_id");  
    $join2 = array('messenger_bot_subscriber'=>"messenger_bot_subscriber.subscribe_id=ecommerce_cart.subscriber_id,left",'ecommerce_store'=>"ecommerce_store.id=ecommerce_cart.store_id,left");
    $where_simple2 = array("ecommerce_cart.id"=>$id,"action_type !="=>"checkout");
    if($subscriber_id!="") $where_simple2['ecommerce_cart.subscriber_id'] = $subscriber_id;
    else $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
    $where2 = array('where'=>$where_simple2);
    $webhook_data = $this->basic->get_data("ecommerce_cart",$where2,$select2,$join2);


    if(!isset($webhook_data[0]))
    {
      $not_found = $this->lang->line("Sorry, we could not find the cart you are looking for.");
      echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">'.$not_found.'</h2>';
      exit();
    }
    $webhook_data_final = $webhook_data[0];
    $ecommerce_config = $this->get_ecommerce_config($webhook_data_final['store_id']);      
    $this->_language_loader($webhook_data_final['store_locale']);

    $join = array('ecommerce_product'=>"ecommerce_product.id=ecommerce_cart_item.product_id,left");

    $fb_app_id = $this->get_app_id();

    $data['webhook_data_final'] = $webhook_data_final;
    $data['currency_list'] = $this->currecny_list_all();
    $data['country_names'] = $this->get_country_names();
    $data['phonecodes'] = $this->get_country_iso_phone_currecncy('phonecode');
    $data['currency_icons'] = $this->currency_icon();
    $data['product_list'] = $this->basic->get_data("ecommerce_cart_item",array('where'=>array("cart_id"=>$id)),array("ecommerce_cart_item.*","product_name","thumbnail","taxable","attribute_ids"),$join);      
    $data['fb_app_id'] = $fb_app_id;
    $data['favicon'] = base_url('upload/ecommerce/'.$webhook_data_final['store_favicon']);
    $data['page_title'] = $webhook_data_final['store_name']." | ".$this->lang->line("Checkout");
    $data['body'] = "ecommerce/cart";
    $data['subscriber_id'] = $subscriber_id;
    $data['ecommerce_config'] = $ecommerce_config;
    $data['current_cart'] = $this->get_current_cart($subscriber_id,$webhook_data_final['store_id']);
    $data["social_analytics_codes"] = $this->store_locale_analytics($webhook_data_final);
    $data["pickup_point_list"] = $this->basic->get_data("ecommerce_cart_pickup_points",array("where"=>array("store_id"=>$webhook_data_final['store_id'])));
    $this->load->view('ecommerce/bare-theme', $data);      
    
  }

  public function order($id=0) // if $id passed means not ajax, it's loading view
  {
    $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
    $store_data_temp = $this->basic->get_data("ecommerce_cart",array("where"=>array("id"=>$id)),"store_id");
    $store_id_temp = isset($store_data_temp[0]['store_id']) ? $store_data_temp[0]['store_id'] : "0";

    $is_ajax = $this->input->post('is_ajax',true);
    if($id==0) $id = $this->input->post('webhook_id',true);
    $subscriber_id = "";

    if($is_ajax=='1') // ajax call | means it's being loaded inside xerochat admin panel
    {      
      $this->ajax_check();
      if($this->session->userdata('logged_in')!= 1)
      {
        echo '<div class="alert alert-danger text-center">'.$this->lang->line("Access Forbidden").'</div>';
        exit();
      }
    }
    else // view load
    {
      $subscriber_id = $this->session->userdata($store_id_temp."ecom_session_subscriber_id");
      if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true); // if loaded via webview then we will get this
    }

    if($subscriber_id=="" && $this->session->userdata('logged_in')!= 1)
    {
      echo $this->login_to_continue;      
      exit();
    }

    $select2 = array("ecommerce_cart.*","first_name","last_name","full_name","profile_pic","user_location","email","image_path","phone_number","store_name","store_email","store_favicon","store_phone","store_logo","store_address","store_zip","store_city","store_country","store_state","store_unique_id","terms_use_link","refund_policy_link","store_locale","pixel_id","google_id");  
    $join2 = array('messenger_bot_subscriber'=>"messenger_bot_subscriber.subscribe_id=ecommerce_cart.subscriber_id,left",'ecommerce_store'=>"ecommerce_store.id=ecommerce_cart.store_id,left");
    $where_simple2 = array("ecommerce_cart.id"=>$id);
    if($subscriber_id!="") $where_simple2['ecommerce_cart.subscriber_id'] = $subscriber_id;
    else $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
    $where2 = array('where'=>$where_simple2);
    $webhook_data = $this->basic->get_data("ecommerce_cart",$where2,$select2,$join2);

    if(!isset($webhook_data[0]))
    {
      $not_found = $this->lang->line("Sorry, we could not find the order you are looking for.");
      if($is_ajax=='1') echo '<div class="alert alert-danger text-center">'.$not_found.'</div>';
      else echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">'.$not_found.'</h2>';
      exit();
    }
    $webhook_data_final = $webhook_data[0];
    if($is_ajax!='1')$this->_language_loader($webhook_data_final['store_locale']);
    $country_names = $this->get_country_names();
    $currency_icons = $this->currency_icon();
    $order_title = $this->lang->line("Order");

    $ecommerce_config = $this->get_ecommerce_config($webhook_data_final['store_id']);
    $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
    $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
    $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';

    $join = array('ecommerce_product'=>"ecommerce_product.id=ecommerce_cart_item.product_id,left");
    $product_list = $this->basic->get_data("ecommerce_cart_item",array('where'=>array("cart_id"=>$id)),array("ecommerce_cart_item.*","product_name","thumbnail","taxable"),$join);

    $order_date = date("jS M,Y",strtotime($webhook_data_final['updated_at']));      
    $order_date2 = date("d M,y H:i",strtotime($webhook_data_final['updated_at']));      
    $wc_first_name = $webhook_data_final['first_name'];
    $wc_last_name = $webhook_data_final['last_name'];
    $wc_buyer_bill = ($webhook_data_final['bill_first_name']!='') ? $webhook_data_final['bill_first_name']." ".$webhook_data_final['bill_last_name'] : $wc_first_name." ".$wc_last_name;
    $confirmation_response = json_decode($webhook_data_final['confirmation_response'],true);
    $currency = $webhook_data_final['currency'];
    $currency_icon = isset($currency_icons[$currency])?$currency_icons[$currency]:'$';
    $wc_email_bill = $webhook_data_final['bill_email'];
    $wc_phone_bill = $webhook_data_final['bill_mobile'];
    $shipping_cost = $webhook_data_final["shipping"];
    $total_tax = $webhook_data_final["tax"];     
    $checkout_amount  = $webhook_data_final['payment_amount'];
    $coupon_code = $webhook_data_final['coupon_code'];
    $coupon_type = $webhook_data_final['coupon_type'];
    $coupon_amount =  $webhook_data_final['discount'];
    $subtotal =  $webhook_data_final['subtotal'];
    $payment_status = $webhook_data_final['status'];
    $currency_left = $currency_right = "";
    if($currency_position=='left') $currency_left = $currency_icon;
    if($currency_position=='right') $currency_right = $currency_icon;
    
    $payment_method =  $webhook_data_final['payment_method'];
    if($payment_method!='') $payment_method =  $payment_method." ".$webhook_data_final['card_ending'];

    if($payment_status=='pending' && $webhook_data_final['action_type']=='checkout') $payment_status_badge = "<span class='text-danger'><i class='fas fa-spinner'></i> ".$this->lang->line("Pending")."</span>";
    else if($payment_status=='approved') $payment_status_badge = "<span class='text-primary'><i class='fas fa-thumbs-up'></i> ".$this->lang->line("Approved")."</span>";
    else if($payment_status=='rejected') $payment_status_badge = "<span class='text-warning'><i class='fas fa-thumbs-down'></i> ".$this->lang->line("Rejected")."</span>";
    else if($payment_status=='shipped') $payment_status_badge = "<span class='text-info'><i class='fas fa-truck'></i> ".$this->lang->line("Shipped")."</span>";
    else if($payment_status=='delivered') $payment_status_badge = "<span class=text-info'><i class='fas fa-truck-loading'></i> ".$this->lang->line("Delivered")."</span>";
    else if($payment_status=='completed') $payment_status_badge = "<span class='text-success'><i class='fas fa-check-circle'></i> ".$this->lang->line("Completed")."</span>";
    else $payment_status_badge = $payment_status_badge = "<span class='text-danger'><i class='fas fa-times'></i> ".$this->lang->line("Incomplete")."</span>";
    
    $order_no =  $webhook_data_final['id'];
    $order_url =  base_url("ecommerce/order/".$order_no);
    
    $buyer_country = isset($country_names[$webhook_data_final["buyer_country"]]) ? ucwords(strtolower($country_names[$webhook_data_final["buyer_country"]])) : $webhook_data_final["buyer_country"];
    $store_country = isset($country_names[$webhook_data_final["store_country"]]) ? ucwords(strtolower($country_names[$webhook_data_final["store_country"]])) : $webhook_data_final["store_country"];

    $tmp_buter_state = $webhook_data_final["buyer_state"];
    if(!empty($webhook_data_final["buyer_zip"])) $tmp_buter_state = $tmp_buter_state.' '.$webhook_data_final["buyer_zip"];
    $buyer_address_array = array($webhook_data_final["buyer_address"],$webhook_data_final["buyer_city"],$tmp_buter_state,$buyer_country);
    $buyer_address_array =array_filter($buyer_address_array);
    $buyer_address =implode('<br>', $buyer_address_array);
    $store_name = $webhook_data_final['store_name'];
    $store_address = $webhook_data_final["store_address"]."<br>".$webhook_data_final["store_city"]."<br>".$webhook_data_final["store_state"]." ".$webhook_data_final["store_zip"]."<br>".$store_country;
    $store_phone = $webhook_data_final["store_phone"];
    $store_email = $webhook_data_final["store_email"];
    $subscriber_id_database = $webhook_data_final["subscriber_id"];
    $store_unique_id = $webhook_data_final["store_unique_id"];
    $store_address2 = $webhook_data_final["store_address"]."<br>".$webhook_data_final["store_city"].", ".$webhook_data_final["store_state"].", ".$store_country."<br>".$store_phone;

    $table_bordered = ($is_ajax=='1') ? '' : 'table-bordered';
    $table_data ='';
    $i=0;
    $subtotal_count = 0;
    $table_data_print = '
    <table>
    <thead>
        <tr>
            <th class="description">'.$this->lang->line("Item").'</th>
            <th class="price">'.$this->lang->line("Price").'</th>
        </tr>
    </thead>
    <tbody>';
    foreach ($product_list as $key => $value) 
    {        
      $title = isset($value['product_name']) ? $value['product_name'] : "";
      $quantity = isset($value['quantity']) ? $value['quantity'] : 1;
      $price = isset($value['unit_price']) ? $value['unit_price'] : 0;
      $item_total = $price*$quantity;
      $subtotal_count+=$item_total;
      $item_total = mec_number_format($item_total,$decimal_point,$thousand_comma); 
      $price =  mec_number_format($price,$decimal_point,$thousand_comma); 
      $image_url = (isset($value['thumbnail']) && !empty($value['thumbnail'])) ? base_url('upload/ecommerce/'.$value['thumbnail']) : base_url('assets/img/example-image.jpg');        
      $permalink = base_url("ecommerce/product/".$value['product_id']);
      $attribute_info = (is_array(json_decode($value["attribute_info"],true))) ? json_decode($value["attribute_info"],true) : array();

      $attribute_query_string_array = array();
      $attribute_query_string = "";
      foreach ($attribute_info as $key2 => $value2) 
      {
        $urlencode = is_array($value2) ? implode(',', $value2) : $value2;
        $attribute_query_string_array[]="option".$key2."=".urlencode($urlencode);
      }
      $attribute_query_string = implode("&", $attribute_query_string_array);
      if(!empty($attribute_query_string_array)) $attribute_query_string = "&quantity=".$quantity."&".$attribute_query_string;

      $attribute_print = "";
      if(!empty($attribute_info))
      {
        $attribute_print_tmp = array();
        foreach ($attribute_info as $key2 => $value2)
        {
          $attribute_print_tmp[] = is_array($value2) ? implode('+', array_values($value2)) : $value2;
        }
        $attribute_print = "<small class='text-primary'>".implode(', ', $attribute_print_tmp)."</small>";
      }

      if($subscriber_id!='') $permalink.="?subscriber_id=".$subscriber_id.$attribute_query_string;

      $i++;
      $off = $value["coupon_info"];
  		if($off!="") $off.=" ".$this->lang->line("OFF");
        $table_data .='
        <ul class="list-unstyled list-unstyled-border mb-2">
            <li class="media align-items-center">
              <a href="'.$permalink.'" class="d-print-none-thermal d-print-none">
                <img class="mr-3 rounded" width="70" height="70" src="'.$image_url.'"><br>
              </a>
              <div class="media-body">
                <div class="media-right font-14 text-dark">'.$currency_left.$item_total.$currency_right.'</div>
                <div class="media-title mb-0 font-14"><a href="'.$permalink.'">'.$title.'</a> <span class="text-primary text-small"> '.$off.'</span></div>
                <div class="text-small">'.$currency_left.$price.$currency_right.'x'.$quantity.'<br>'.$attribute_print.'</div>                   
                
              </div>
            </li>
          </ul>';
        $table_data_print .= '
        <tr>
            <th class="description">'.$title.' ('.$quantity.')<br><small>'.$attribute_print.'</small></th>
            <th class="price">'.$currency_left.$item_total.$currency_right.'</th>
        </tr>';
    }
    $table_data_print .= '</tbody></table>';

    if($coupon_code=="") $coupon_info = "";
    else $coupon_info = '<div class="section-title">'.$this->lang->line("Coupon").' : '.$coupon_code.'</div>';

    $coupon_info2 = "";
    if($coupon_code!='' && $coupon_type=="fixed cart")
    $coupon_info2 = 
    '<div class="invoice-detail-item">
      <div class="invoice-detail-name">'.$this->lang->line("Discount").'</div>
      <div class="invoice-detail-value">-'.$currency_left.mec_number_format($coupon_amount,$decimal_point,$thousand_comma).$currency_right.'</div>
    </div>';

    $tax_info = "";
    if($total_tax>0)
    $tax_info = 
    '<div class="invoice-detail-item">
        <div class="invoice-detail-name">'.$this->lang->line("Tax").'</div>
        <div class="invoice-detail-value">+'.$currency_left.mec_number_format($total_tax,$decimal_point,$thousand_comma).$currency_right.'</div>
    </div>';

    $shipping_info = "";
    if($shipping_cost>0)
    $shipping_info = 
    '<div class="invoice-detail-item">
        <div class="invoice-detail-name">'.$this->lang->line("Delivery Charge").'</div>
        <div class="invoice-detail-value">+'.$currency_left.mec_number_format($shipping_cost,$decimal_point,$thousand_comma).$currency_right.'</div>
    </div>';


    // $coupon_code." (".$currency_icon.$coupon_amount.")";      

    if($webhook_data_final['action_type']!='checkout') $subtotal = $subtotal_count;
    $subtotal = mec_number_format($subtotal,$decimal_point,$thousand_comma);
    $checkout_amount = mec_number_format($checkout_amount,$decimal_point,$thousand_comma);
    $coupon_amount = mec_number_format($coupon_amount,$decimal_point,$thousand_comma);

    if($subscriber_id=='')
    {
      $wc_buyer_bill_formatted = '<a href="'.base_url('subscriber_manager/bot_subscribers/'.$subscriber_id_database).'">'.$wc_buyer_bill.'</a>';
      $store_name_formatted = '<a href="'.base_url('ecommerce/store/'.$store_unique_id).'">'.$store_name.'</a>';
      $store_image = ($webhook_data_final['store_logo']!='' && $is_ajax!='1') ? '<div class="col-lg-12 text-center d-print-none-thermal"><a href="'.base_url('ecommerce/store/'.$store_unique_id).'"><img style="max-height:50px" src="'.base_url("upload/ecommerce/".$webhook_data_final['store_logo']).'"></a><hr class="m-3 mb-4"></div>':'';
    }
    else 
    {
      $wc_buyer_bill_formatted = $wc_buyer_bill;
      $store_name_formatted = '<a href="'.base_url('ecommerce/store/'.$store_unique_id."?subscriber_id=".$subscriber_id).'">'.$store_name.'</a>';
      $store_image = ($webhook_data_final['store_logo']!='' && $is_ajax!='1') ? '<div class="col-lg-12 text-center d-print-none-thermal"><a href="'.base_url('ecommerce/store/'.$store_unique_id."?subscriber_id=".$subscriber_id).'"><img style="max-height:50px" src="'.base_url("upload/ecommerce/".$webhook_data_final['store_logo']).'"></a><hr class="m-3 mb-4"></div>':'';
    }

    if($is_ajax=='1') $order_details = '<h5>'.$order_title.' #<a href="'.$order_url.'">'.$order_no.'</a></h5>';
    else $order_details = '<h5>'.$order_title.' #'.$order_no.'</h5>';


    $order_details_print = '<h5>#'.$order_no.' ('.$order_date2.')</h5>';


    $output = "";
    $coupon_details_print = "";
    $after_checkout_details ="";
    $payment_method_deatils = 
    '<div class="section-title">'.$this->lang->line("Order Status").'</div>
     <p class="section-lead ml-0">'.$payment_status_badge.'<br>'.$payment_method.'</p>
     ';
    $coupon_details = '<div class="col-7">'.$payment_method_deatils.'</div>';

    $hide_on_modal = '';
    $hide_on_modal_md = 'd-md-block';
    if($is_ajax=='1'){
      $hide_on_modal = 'd-none';
      $hide_on_modal_md = '';
    }

    if($webhook_data_final['action_type']=='checkout')
    {
      $after_checkout_details = 
      $coupon_info2.$shipping_info.$tax_info.'
      <hr class="mt-2 mb-2">
      <div class="invoice-detail-item">
        <div class="invoice-detail-name">'.$this->lang->line("Total").'</div>
        <div class="invoice-detail-value">('.$currency.') '.$currency_left.$checkout_amount.$currency_right.'</div>
      </div>';

      $delivery_note = !empty($webhook_data_final['delivery_note']) ? "<br>(".$webhook_data_final['delivery_note'].")":"";
      $receipt_name = !empty($webhook_data_final['buyer_first_name']) ? $webhook_data_final['buyer_first_name']." ".$webhook_data_final['buyer_last_name'] : $wc_buyer_bill;
      $recipt_address = $webhook_data_final['store_pickup']=='1' ? $webhook_data_final['pickup_point_details'] : $buyer_address;
      $contact_address = $webhook_data_final["buyer_email"];
      if(!empty($webhook_data_final["buyer_mobile"])) $contact_address.=' , '.$webhook_data_final["buyer_mobile"];
      $coupon_details =
      '<div class="col-7 d-print-none-thermal">
        '.$coupon_info.$payment_method_deatils.'
        <div class="section-title">'.$this->lang->line("Deliver to").'</div>
        <p class="section-lead ml-0">
        	'.$receipt_name."<br>".$recipt_address.'<br>'.$contact_address.'<small>'.$delivery_note.'</small>
        </p>  
      </div>';

       $coupon_details_print =
      '<div class="d-print-thermal '.$hide_on_modal.'">'.$order_details_print.'</div>
       <div class="d-print-thermal '.$hide_on_modal.'">
        <p class="section-lead m-0 text-center small">
          '.$store_address2.'
        </p>
        <br>
        <p class="section-lead m-0 text-left">
          '.$this->lang->line("Customer")." : ".$receipt_name."<br>".$recipt_address.'
        </p>  
      </div>';
    }
    $padding = ($is_ajax=='1') ? "padding:40px" : "padding:25px;margin:20px 0;";

    $user_loc = "";
    if($webhook_data_final['bill_first_name']=='')
    {
      $tmp = json_decode($webhook_data_final['user_location'],true);
      if(is_array($tmp)) 
      {
        $user_country = isset($tmp['country']) ? $tmp['country'] : "";
        $country_name = isset($country_names[$user_country]) ? ucwords(strtolower($country_names[$user_country])) : $user_country;
        $tmp["country"] = $country_name;
        if(isset($tmp["state"]) && isset($tmp["zip"])) 
        {
          $tmp["state"] = $tmp["state"]." ".$tmp["zip"];
          unset($tmp["zip"]);
        }
        $user_loc = implode('<br>', $tmp);
      }
    }
    else
    { 
      $user_country = isset($webhook_data_final['bill_country']) ? $webhook_data_final['bill_country'] : "";
      $country_name = isset($country_names[$user_country]) ? ucwords(strtolower($country_names[$user_country])) : $user_country;

      $tmp =  array($webhook_data_final['bill_address'],$webhook_data_final['bill_city'],$webhook_data_final['bill_state'],$country_name);
      if(isset($tmp["bill_state"]) || isset($tmp["bill_zip"]))  $tmp["bill_state"] = $tmp["bill_state"]." ".$tmp["bill_zip"];
      unset($tmp["bill_zip"]);
      $tmp = array_filter($tmp);
      $user_loc = implode('<br>', $tmp);
    }

    $pay_message = "";
    if($subscriber_id!="")
    {
  	  $payment_action = $this->input->get("action",true);
      $payment_status_message=$payment_status='';
  	  if($payment_action!="")
  	  {
  	  	if($payment_action=="success")
  	  	{
  	  		$invoice_link = base_url("ecommerce/my_orders/".$webhook_data_final['store_id']."?subscriber_id=".$subscriber_id);
  	  		$message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your payment has been received successfully and order will be processed soon. It may take few seconds to change your payment status depending on PayPal request.');
  	  		$payment_status='1';
          $payment_status_message=$message;
  	  	}
        else if($payment_action=="success3")
        {
          $invoice_link = base_url("ecommerce/my_orders/".$webhook_data_final['store_id']."?subscriber_id=".$subscriber_id);
          $message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your payment has been received successfully and order will be processed soon.');
          $payment_status='1';
          $payment_status_message=$message;
        }
        else if($payment_action=="success2")
        {
          $invoice_link = base_url("ecommerce/my_orders/".$webhook_data_final['store_id']."?subscriber_id=".$subscriber_id);
          $message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your order has been placed successfully and is now being reviewed.');
          $payment_status='1';
          $payment_status_message=$message;
        }
  	  	else if($payment_action=="cancel")
  	  	{
  	  		$message = "<i class='fas fa-times-circle'></i> ".$this->lang->line('Payment was failed to process and the cart has been cancelled.');
  	  		$payment_status='0';
          $payment_status_message=$message;
  	  	}
  	  }
    	  
	  	if($payment_status=='1')
		  $pay_message = "<div class='alert alert-success d-print-none-thermal text-center mt-2 mb-0 ml-0 mr-0'>".$payment_status_message."</div>";
		  else if($payment_status=='0')
		  $pay_message = "<div class='alert alert-danger d-print-none-thermal text-center mt-2 mb-0 ml-0 mr-0'>".$payment_status_message."</div>"; 	  
    }

    $hide_order = '';
    $no_order = '';
    if(count($product_list)==0)
    {
      $hide_order='d-none';
      $no_order = '
      <div class="col-12">
        <div class="empty-state">
          <img class="img-fluid" style="height: 300px" src="'.base_url('assets/img/drawkit/drawkit-full-stack-man-colour.svg').'" alt="image">
           <h2 class="mt-0">'.$this->lang->line("Cart is empty").'</h2>
           <p class="lead">'.$this->lang->line("There is no product added to cart.").'</p>
        </div>
      </div>
      ';
    }

   $print_button_text = ($this->session->userdata('user_type') == 'Admin') ? $this->lang->line("Large").' <b>A4</b>' : '<i class="fas fa-print"></i> '. $this->lang->line("Print");
   $thermal_hide = ($this->session->userdata('user_type') == 'Admin') ? '' : 'd-none';

   $output .= 
    '<div class="d-print-none pt-2 text-center d-none '.$hide_on_modal_md.'">
      <p class="mb-0 '.$thermal_hide.'"><b>'.$this->lang->line("Print Options").'</b></p>
      <div class="btn-group" role="group" aria-label="">
        <button type="button" id="large-print" class="btn-sm btn btn-outline-primary print-options no_radius">'.$print_button_text.'</button>
        <button type="button" id="thermal-print" class="'.$thermal_hide.' btn-sm btn btn-outline-primary print-options no_radius">'.$this->lang->line("Thermal").' <b>80mm</b></button>
        <button type="button" id="mobile-print" class="'.$thermal_hide.' btn-sm btn btn-outline-primary print-options no_radius">'.$this->lang->line("Thermal").' <b>57mm</b></button>
      </div>
      </div>
      <section class="section" id="print-area">
        '.$pay_message.'
        <div class="section-body">
          <div class="invoice" style="border:1px solid #dee2e6;'.$padding.'">
            <div class="invoice-print">
              <div class="row">
                '.$store_image.'
                <h4 class="d-print-thermal '.$hide_on_modal.'">'.$store_name.'</h4>
                '.$no_order.'
                <div class="col-lg-12 '.$hide_order.'">
                  <div class="invoice-title d-print-none-thermal">
                    '.$order_details.'
                    <div class="invoice-number" style="margin-top:-35px;">'.$order_date.'</div>
                  </div>
                  <br class="d-print-none-thermal">
                  <div class="row d-print-none-thermal">
                    <div class="col-6">
                      <address>
                        <strong>'.$this->lang->line("Bill to").':</strong><br><br>
                        '.$wc_buyer_bill_formatted.'
                        <br>                        
                        <span class="d-print-none-thermal">'.$user_loc.'<br>                     
                        '.$wc_email_bill.'<br>                         
                        '.$wc_phone_bill.'</span>
                      </address>
                    </div>
                    <div class="col-6 text-right">
                      <address>
                        <strong>'.$this->lang->line("Seller").':</strong><br><br>
                        '.$store_name_formatted.'<br>
                        '.$store_address.'<br>
                      </address>
                    </div>
                  </div>
                  <div class="d-print-thermal">'.$coupon_details_print.'</div>
                </div>
              </div>

              <div class="row '.$hide_order.'">
                <div class="col-md-12">
                  <span class="d-print-none-thermal">'.$table_data.'</span>
                  <span class="d-print-thermal '.$hide_on_modal.'">'.$table_data_print.'</span>
                  <div class="row">
                    '.$coupon_details.'
                    <div class="col-5 text-right">
                      <div class="invoice-detail-item"  style="margin-top: 20px;">
                        <div class="invoice-detail-name">'.$this->lang->line("Subtotal").'</div>
                        <div class="invoice-detail-value">'.$currency_left.$subtotal.$currency_right.'</div>
                      </div>
                      '.$after_checkout_details.'
                    </div>
                  </div>
                </div>
              </div>
            </div>              
          </div>
        </div>
      </section>
    ';
    if(!$is_ajax) $output.="<div style='height:60px'></div>";

    if($webhook_data_final['action_type']=='checkout' && $is_ajax=='1')
    {  
      $messenger_confirmation_badge = '<span class="badge badge-light badge-pill">'.$this->lang->line("Unknown").'</span>';
      if(isset($confirmation_response['messenger']))
      {
        if(isset($confirmation_response['messenger']['status']) && $confirmation_response['messenger']['status']=='1') $messenger_confirmation_badge = '<span data-toggle="tooltip" title="'.htmlspecialchars($confirmation_response['messenger']['response']).'" class="badge badge-success badge-pill">'.$this->lang->line("Sent").'</span>';
        else if(isset($confirmation_response['messenger']['status']) && $confirmation_response['messenger']['status']=='0') $messenger_confirmation_badge = '<span data-toggle="tooltip" title="'.htmlspecialchars($confirmation_response['messenger']['response']).'" class="badge badge-danger badge-pill">'.$this->lang->line("Error").'</span>';
        else $messenger_confirmation_badge = '<span class="badge badge-dark badge-pill">'.$this->lang->line("Not Set").'</span>';
      }
      $messenger_li = '<li class="list-group-item d-flex justify-content-between align-items-center">
                        '.$this->lang->line("Messenger Confirmation").'
                        '.$messenger_confirmation_badge.'
                      </li>';

      $sms_li = $email_li = "";
      if($this->session->userdata('user_type') == 'Admin' || in_array(264,$this->module_access)) 
      {
        $sms_confirmation_badge = '<span class="badge badge-light badge-pill">'.$this->lang->line("Unknown").'</span>';
        if(isset($confirmation_response['sms']))
        {
          if(isset($confirmation_response['sms']['status']) && $confirmation_response['sms']['status']=='1') $sms_confirmation_badge = '<span data-toggle="tooltip" title="'.htmlspecialchars($confirmation_response['sms']['response']).'" class="badge badge-success badge-pill">'.$this->lang->line("Sent").'</span>';
          else if(isset($confirmation_response['sms']['status']) && $confirmation_response['sms']['status']=='0') $sms_confirmation_badge = '<span data-toggle="tooltip" title="'.htmlspecialchars($confirmation_response['sms']['response']).'" class="badge badge-danger badge-pill">'.$this->lang->line("Error").'</span>';
          else $sms_confirmation_badge = '<span class="badge badge-dark badge-pill">'.$this->lang->line("Not Set").'</span>';
        }
        $sms_li = '<li class="list-group-item d-flex justify-content-between align-items-center">
                    '.$this->lang->line("SMS Confirmation").'
                    '.$sms_confirmation_badge.'
                  </li>';
      }

      if($this->session->userdata('user_type') == 'Admin' || in_array(263,$this->module_access)) 
      {
        $email_confirmation_badge = '<span class="badge badge-light badge-pill">'.$this->lang->line("Unknown").'</span>';
        if(isset($confirmation_response['email']))
        {
          if(isset($confirmation_response['email']['status']) && $confirmation_response['email']['status']=='1') $email_confirmation_badge = '<span data-toggle="tooltip" title="'.htmlspecialchars($confirmation_response['email']['response']).'" class="badge badge-success badge-pill">'.$this->lang->line("Sent").'</span>';
          else if(isset($confirmation_response['email']['status']) && $confirmation_response['email']['status']=='0') $email_confirmation_badge ='<span data-toggle="tooltip" title="'.htmlspecialchars($confirmation_response['email']['response']).'" class="badge badge-danger badge-pill">'. $this->lang->line("Error").'</span>';
          else $email_confirmation_badge = '<span class="badge badge-dark badge-pill">'.$this->lang->line("Not Set").'</span>';
        }
        $email_li = '<li class="list-group-item d-flex justify-content-between align-items-center">
                      '.$this->lang->line("Email Confirmation").'
                      '.$email_confirmation_badge.'
                    </li>';
      }
      $output .=  
      '
        <section class="section">
          <div class="section-body">
            <div class="invoice" style="border:1px solid #dee2e6;">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-12">
                    <div class="invoice-title">
                      <h4>'.$this->lang->line("Checkout Confirmation").'</h4>
                      <div class="invoice-number"></div>
                    </div>
                    <hr>
                    <ul class="list-group">
                      '.$messenger_li.$sms_li.$email_li.'
                    </ul>
                  </div>
                </div>              
              </div>
            </div>
          </div>
        </section>
      ';      
      $output .=  "<script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";
    }

    $output.="<style>.section .section-title{margin:20px 0 20px 0;}</style>";

    if($is_ajax=='1') 
    {
      if($webhook_data_final['action_type']=='checkout') $report_where = array("where"=>array("cart_id"=>$id,"is_sent"=>"1"));
      else $report_where = array("where"=>array("cart_id"=>$id));

      $reminder_report_data = $this->basic->get_data("ecommerce_reminder_report",$report_where,'','','','','sent_at DESC');
      
      $tableBody = '';
      $trsl = 0;
      foreach ($reminder_report_data as $keyReport => $valueReport) 
      {
        $trsl++;

        if($valueReport["is_sent"]=='1' && $valueReport["sent_at"] != "0000-00-00 00:00:00")
        $sent_time_tmp = date("M j, y H:i",strtotime($valueReport["sent_at"]));
        else $sent_time_tmp = '<span class="text-muted">X<span>';
      
        $subscriber_id_tmp =  "<a href='".base_url("subscriber_manager/bot_subscribers/".$valueReport['subscriber_id'])."' target='_BLANK'>".$valueReport['subscriber_id']."</a>";        
        $last_updated_at_tmp = date("M j, y H:i",strtotime($valueReport['last_updated_at']));

        $response_tmp =  "<a class='btn btn-sm btn-outline-primary woo_error_log' href='' data-id='".$valueReport['id']."'><i class='fas fa-plug'></i> ".$this->lang->line('Response')."</a>";
        $cart_id_tmp =  "<a target='_BLANK' href='".base_url('ecommerce/order/'.$valueReport['cart_id'])."'>".$this->lang->line('Order').'#'.$valueReport['cart_id']."</a>";

        $tableBody .= '
        <tr>
          <td>'.$trsl.'</td>
          <td class="text-center">'.$valueReport["last_completed_hour"].'</td>
          <td>'.$response_tmp.'</td>
          <td class="text-center">'.$sent_time_tmp.'</td>
          <td>'.$cart_id_tmp.'</td>
        </tr>';
      }
      if(empty($reminder_report_data)) $tableBody.='<tr><td class="text-center" colspan="5">'.$this->lang->line("No data found").'</td></tr>';

      if(count($product_list)>0) $output .= '
      <section class="section">
        <div class="section-body">
          <div class="invoice" style="border:1px solid #dee2e6;">
            <div class="invoice-print">
              <div class="row">
                <div class="col-12">
                  <div class="invoice-title">
                    <h4>'.$this->lang->line("Abandoned Cart Reminder Report").'</h4>
                    <div class="invoice-number"></div>
                  </div>
                  <hr>
                  <div class="data-card">
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="myTableReport">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>'.$this->lang->line("Reminder Hour").'</th>
                              <th>'.$this->lang->line("API Response").'</th>
                              <th>'.$this->lang->line("Sent at").'</th>
                              <th>'.$this->lang->line("Order").'</th>
                            </tr>
                          </thead>
                          <tbody>'.$tableBody.'</tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>';
      echo $output;
    }
    else
    {
      $fb_app_id = $this->get_app_id();
      $data = array('output'=>$output,"page_title"=>$store_name." | Order# ".$order_no,"fb_app_id"=>$fb_app_id,"favicon"=>base_url('upload/ecommerce/'.$webhook_data_final['store_favicon']));
      $data['current_cart'] = $this->get_current_cart($subscriber_id,$webhook_data_final['store_id']);
      $data["social_analytics_codes"] = $this->store_locale_analytics($webhook_data_final);
      include(APPPATH."views/ecommerce/common_style.php");  
      $this->load->view('ecommerce/bare-theme', $data); 
    }
    
  }

  public function delete_cart_item()
  {
    $id = $this->input->post("id");
    $cart_id = $this->input->post("cart_id");
    $subscriber_id = $this->input->post("subscriber_id");
    $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,"ecommerce_cart.id");
    if(isset($cart_data[0]))
    {
      $this->basic->delete_data("ecommerce_cart_item",array("id"=>$id,"cart_id"=>$cart_id));
      $this->basic->update_data("ecommerce_cart",array("id"=>$cart_id),array("action_type"=>"remove","updated_at"=>date("Y-m-d H:i:s")));
      echo json_encode(array('status'=>'1','message'=>$this->lang->line("Item deleted successfully.")));
    }
    else
    {
      echo json_encode(array('status'=>'0','message'=>$this->lang->line("Order data not found.")));
    }
  }

  
  public function update_cart_item_checkout()
  {
    $this->ajax_check();
    $id = $this->input->post("id",true);
    $cart_id = $this->input->post("cart_id",true);
    $action = $this->input->post("action",true);
    $curdate = date("Y-m-d H:i:s");
    $what_action = $action=='add' ? 'quantity=quantity+1' : 'quantity=quantity-1';
    $sql="UPDATE ecommerce_cart_item SET ".$what_action.",updated_at='$curdate' WHERE cart_id='$cart_id' AND id='$id'; ";
    $this->basic->execute_complex_query($sql);
  }

  public function update_cart_item()
  {
    $this->ajax_check();
    $mydata = json_decode($this->input->post("mydata"),true);
    $product_id = isset($mydata['product_id']) ? $mydata['product_id'] : 0;
    $action = isset($mydata['action']) ? $mydata['action'] : 'add';  // add,remove

    $where_simple = array("ecommerce_product.id"=>$product_id,"ecommerce_product.status"=>"1","ecommerce_store.status"=>"1");
    $where = array('where'=>$where_simple);
    $join = array('ecommerce_store'=>"ecommerce_product.store_id=ecommerce_store.id,left");  
    $select = array("ecommerce_product.*","store_unique_id","store_locale");   
    $product_data = $this->basic->get_data("ecommerce_product",$where,$select,$join);
    if(!isset($product_data[0]))
    {
      echo json_encode(array('status'=>'0','message'=>$this->lang->line("Product not found.")));
      exit();
    }
    $this->_language_loader($product_data[0]['store_locale']);

    /*Added by Konok 23.10.2020 for system outside Messenger*/
    $where_subs = array();
    $subscriber_id=$this->session->userdata($product_data[0]['store_id']."ecom_session_subscriber_id");
    if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$product_data[0]['store_id']);
    else
    {
      if($subscriber_id=="") $subscriber_id = isset($mydata['subscriber_id']) ? $mydata['subscriber_id'] : '';
      if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
    }
    if($subscriber_id=='')
    {
      echo json_encode(array('status'=>'0','message'=>$this->login_to_continue,'login_popup'=>'1'));
      exit();
    }
    $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");

    if($subscriber_info[0]['total_rows']==0){
       echo json_encode(array('status'=>'0','message'=>$this->login_to_continue,'login_popup'=>'1'));
       exit();
    }

    $attribute_info = isset($mydata['attribute_info']) ? $mydata['attribute_info'] : array();
    $attribute_info = array_filter($attribute_info);
    // pre($attribute_info);
    $attribute_info_json = json_encode($attribute_info,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

    $message = $cart_url = "";   
    
    $stock_item = $product_data[0]['stock_item'];
    $stock_prevent_purchase = $product_data[0]['stock_prevent_purchase'];

    if($stock_prevent_purchase=='1' && $stock_item==0 && $action=='add')
    {
      echo json_encode(array('status'=>'0','message'=>$this->lang->line("Sorry, this item is out of stock. We are not taking any order right now.")));
      exit();
    }

    $store_id = $product_data[0]['store_id'];
    $user_id = $product_data[0]['user_id'];
    $original_price = $product_data[0]['original_price'];
    $sell_price = $product_data[0]['sell_price'];
    $store_unique_id = $product_data[0]['store_unique_id'];
    $ecommerce_config = $this->get_ecommerce_config($store_id);
    $currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
    $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
    $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;

    // price calculation based on attribute values
    $calculated_price_info = $this->calculate_price_basedon_attribute($product_id,$attribute_info,$original_price,$sell_price);
    $original_price = $calculated_price_info['calculated_original_price'];
    $sell_price = $calculated_price_info['calculated_sell_price'];

    $price = mec_display_price($original_price,$sell_price,'','2',$currency_position,$decimal_point,'0');
    $cart_data = $this->basic->get_data("ecommerce_cart",array('where'=>array("ecommerce_cart.subscriber_id"=>$subscriber_id,"ecommerce_cart.store_id"=>$store_id,"action_type!="=>"checkout")));
    $cart_item_data = array();
    if(isset($cart_data[0])) // already have a cart running entry
    {
      $cart_id = isset($cart_data[0]['id']) ? $cart_data[0]['id'] : 0;
      $cart_item_data = $this->basic->get_data("ecommerce_cart_item",array("where"=>array("cart_id"=>$cart_id)));
    }

    if(!isset($cart_data[0]) && $action=="remove") // no cart, no removing, securty in case
    {
      echo json_encode(array('status'=>'0','message'=>$this->lang->line("Cart not found.")));
      exit();
    }

    $curdate = date("Y-m-d H:i:s");
    if($action=='add') // add item
    {
      if(!isset($cart_data[0])) // new cart, create cart first
      {
        $insert_data =array
        (
          'user_id' => $user_id,
          'store_id' => $store_id,
          'subscriber_id' => $subscriber_id,
          'currency' => $currency,
          'status' => "pending",
          'ordered_at' => $curdate,
          'payment_method'=>'',
          'updated_at' => $curdate,
          'initial_date' => $curdate,
          'confirmation_response' => '[]'
        );         
        $this->basic->insert_data("ecommerce_cart",$insert_data);
        $cart_id = $this->db->insert_id();         
      }

      $sql="INSERT INTO ecommerce_cart_item
      (
        store_id,cart_id,product_id,unit_price,quantity,attribute_info,updated_at
      ) 
      VALUES 
      (
        '$store_id','$cart_id','$product_id','$price','1','$attribute_info_json','$curdate'
      )
      ON DUPLICATE KEY UPDATE 
      unit_price='$price',quantity=quantity+1,updated_at='$curdate'; ";
      $this->basic->execute_complex_query($sql);

      $message = $this->lang->line("Product has been added to cart successfully.");
    }
    else // remove item
    {
        $sql="UPDATE ecommerce_cart_item SET unit_price='$price',quantity=quantity-1,updated_at='$curdate' WHERE cart_id='$cart_id' AND product_id='$product_id' AND attribute_info='$attribute_info_json'; ";
        $this->basic->execute_complex_query($sql);
        $message = $this->lang->line("Product has been removed from cart successfully.");       
    }

    $this_cart_item = array("quantity"=>"1");
    if(!empty($attribute_info))
    {
      $this_cart_item_data = $this->basic->get_data("ecommerce_cart_item",array("where"=>array("cart_id"=>$cart_id,"product_id"=>$product_id,"attribute_info"=>$attribute_info_json)),"quantity");
      if(isset($this_cart_item_data[0])) $this_cart_item = $this_cart_item_data[0];
    }

    $cart_url = base_url("ecommerce/cart/".$cart_id."?subscriber_id=".$subscriber_id);
    $current_cart_data = $this->get_current_cart($subscriber_id,$store_id);
    echo json_encode(array('status'=>'1','cart_url'=>$cart_url,'message'=>$message,"cart_data"=>$current_cart_data,"this_cart_item"=>$this_cart_item));
  }    

  public function update_cart($cart_id=0,$subscriber_id_passed='')
  {     
    if($subscriber_id_passed=='') $subscriber_id = $this->input->get_post("subscriber_id");
    else $subscriber_id = $subscriber_id_passed;

    if($cart_id!=0 && $subscriber_id!='')
    {
      $cart_data = $this->valid_cart_data($cart_id,$subscriber_id);
      if(isset($cart_data[0]))
      {          
        if($cart_data[0]["store_unique_id"]!="") // store availabe and online
        {
          $store_id = $cart_data[0]['store_id'];
          $user_id = $cart_data[0]['user_id'];

          $ecommerce_config = $this->get_ecommerce_config($store_id);
          $currency = isset($ecommerce_config["currency"]) ? $ecommerce_config["currency"] : "USD";
          $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
          $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
          $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
          $currency_icons = $this->currency_icon();
          $currency_icon = isset($currency_icons[$currency])?$currency_icons[$currency]:'$';   

          $coupon_code = $cart_data[0]['coupon_code'];
          $tax_percentage = $cart_data[0]['tax_percentage'];
          $shipping_charge = $cart_data[0]['shipping_charge'];
          $store_pickup = $cart_data[0]['store_pickup'];

          $product_list = $this->get_product_list_array($store_id);
          $cart_item_data = $this->basic->get_data("ecommerce_cart_item",array('where'=>array("cart_id"=>$cart_id)));         

          $product_list_assoc = array();
          $cart_item_data_assoc = array();

          foreach($product_list as $key => $value) 
          {
            $product_list_assoc[$value["id"]] = $value;
          }

          // foreach($cart_item_data as $key => $value) 
          // {
          //   $cart_item_data_assoc[$value["product_id"]] = $value;
          // }
          // $cart_item_data_new = $cart_item_data_assoc;

          $coupon_data = array();
          if($coupon_code!='') $coupon_data =$this->get_coupon_data($coupon_code,$store_id);
          $coupon_product_ids = isset($coupon_data["product_ids"]) ? $coupon_data["product_ids"] : '0';
          $coupon_product_ids_array = array_filter(explode(',', $coupon_product_ids));
          $free_shipping_enabled = isset($coupon_data["free_shipping_enabled"]) ? $coupon_data["free_shipping_enabled"] : "0";
          if($store_pickup=='1') $free_shipping_enabled = '1';
          $coupon_type = isset($coupon_data["coupon_type"]) ? $coupon_data["coupon_type"] : "";
          $coupon_amount = isset($coupon_data["coupon_amount"]) ? $coupon_data["coupon_amount"] : 0;
          $coupon_code_new = isset($coupon_data["coupon_code"]) ? $coupon_data["coupon_code"] : '';

          $subtotal = 0;
          $taxable_amount = 0;
          $discount = 0;
          $tax = 0;            
          $shipping = 0;
          foreach($cart_item_data as $key => $value)
          {
            $product_id = $value['product_id'];
            if(array_key_exists($product_id, $product_list_assoc))
            {

              $attribute_info  = json_decode($value['attribute_info'],true);
              $calculated_price_info = $this->calculate_price_basedon_attribute($product_id,$attribute_info,$product_list_assoc[$product_id]["original_price"],$product_list_assoc[$product_id]["sell_price"]);

              $original_price = $calculated_price_info['calculated_original_price'];
              $sell_price = $calculated_price_info['calculated_sell_price'];
              $new_price = mec_display_price($original_price,$sell_price,'','2',$currency_position,$decimal_point,'0');
             
              $coupon_info = "";

              if(!empty($coupon_data) && $coupon_amount>0 && ($coupon_product_ids=="0" || in_array($product_id, $coupon_product_ids_array)))
              {
                $new_price = $original_price; 
                $new_price = mec_number_format($new_price,$decimal_point,'0');
                if($coupon_type=="percent")
                {
                  $disc = ($new_price*$coupon_amount)/100;
                  if($disc<0) $disc=0;
                  $disc = mec_number_format($disc,$decimal_point,'0');

                  $discount+=$disc;

                  $coupon_info = $coupon_amount."%";

                  $new_price = $new_price-$disc;
                }
                else if($coupon_type=="fixed product")
                {
                   $new_price = $new_price-$coupon_amount;
                   if($new_price<0) $new_price =0;
                   $coupon_info = $currency_icon.$coupon_amount;                     
                   $discount+=$coupon_amount;
                   $discount = mec_number_format($discount,$decimal_point,'0');
                }
                $new_price = mec_number_format($new_price,$decimal_point,'0');
              }


              if($new_price!=mec_number_format($value['unit_price'],$decimal_point,'0')) 
              $this->basic->update_data("ecommerce_cart_item",array("id"=>$value['id']),array("unit_price"=>$new_price,"coupon_info"=>$coupon_info));

              $total_price = $new_price*$value["quantity"];
              $subtotal+=$total_price;

              if($product_list_assoc[$product_id]["taxable"]=='1') $taxable_amount+=$new_price*$value["quantity"];
            }
            else
            {
              $this->basic->delete_data("ecommerce_cart_item",array("id"=>$value['id']));
            }
          }
          $subtotal = mec_number_format($subtotal,$decimal_point,'0');
          
          if($tax_percentage>0) 
          {
            $tax = ($tax_percentage*$taxable_amount)/100;
            $tax = mec_number_format($tax,$decimal_point,'0');
          }
          if($free_shipping_enabled=='0') $shipping = mec_number_format($shipping_charge,$decimal_point,'0');
          $payment_amount = $subtotal + $shipping + $tax;

          if(!empty($coupon_data) && $coupon_amount>0 && $coupon_type=="fixed cart")
          {
            $discount = $coupon_amount;
            $discount = mec_number_format($discount,$decimal_point,'0');
            $payment_amount = $payment_amount - $discount;
            if($payment_amount<0) $payment_amount = 0;
          }
          $payment_amount = mec_number_format($payment_amount,$decimal_point,'0');

          $update_data = array
          (
            "subtotal"=>$subtotal,
            "tax"=>$tax,
            "shipping"=>$shipping,
            "coupon_code"=>$coupon_code_new,
            "discount"=>$discount,
            "coupon_type" =>  $coupon_type,
            "payment_amount"=>$payment_amount,
            "currency"=>$currency
          );
          $this->basic->update_data("ecommerce_cart",array("id"=>$cart_id),$update_data);
        }
        else // store not availabe anymore, delete cart
        {
          $this->basic->delete_data("ecommerce_cart",array("id"=>$cart_id));
          $this->basic->delete_data("ecommerce_cart_item",array("cart_id"=>$cart_id));
        }
      }
    }

  }

  public function apply_coupon()
  {
  	$this->ajax_check();
  	$cart_id = $this->input->post("cart_id");
  	$coupon_code = $this->input->post("coupon_code");
  	$subscriber_id = $this->input->post("subscriber_id");    	

    $select = array("store_id","store_unique_id","coupon_code","store_locale");
    $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select);

    $store_id = 0;
    if(isset($cart_data[0]) && $cart_data[0]["store_id"]!="")
    {
    	$store_id = $cart_data[0]["store_id"];
    	$xcoupon_code = $cart_data[0]["coupon_code"];
      $this->_language_loader($cart_data[0]['store_locale']);
    	if($coupon_code=="")
    	{
    		if($xcoupon_code!="")
    		{
    			$this->basic->update_data("ecommerce_cart",array("id"=>$cart_id,"subscriber_id"=>$subscriber_id),array("coupon_code"=>$coupon_code));
    			echo json_encode(array('status'=>'1','message'=>$this->lang->line('Coupon has been removed successfully.')));
    		}
    		else echo json_encode(array('status'=>'0','message'=>$this->lang->line('No coupon code provided.')));
    		exit();    	
    	}
    }
    else
    {
    	echo json_encode(array('status'=>'0','message'=>$this->lang->line('Order data not found.')));
    	exit();
    }

  	$coupon_data =$this->get_coupon_data($coupon_code,$store_id);
  	if(!empty($coupon_data)) 
  	{
  		$this->basic->update_data("ecommerce_cart",array("id"=>$cart_id),array("coupon_code"=>$coupon_code));
  		echo json_encode(array('status'=>'1','message'=>$this->lang->line('Coupon has been applied successfully.')));
  	}
  	else echo json_encode(array('status'=>'0','message'=>$this->lang->line('Invalid coupon code.')));

  }

  public function apply_store_pickup()
  {
    $this->ajax_check();
    $cart_id = $this->input->post("cart_id");
    $store_pickup = $this->input->post("store_pickup");
    $subscriber_id = $this->input->post("subscriber_id");
    $this->basic->update_data("ecommerce_cart",array("id"=>$cart_id,"subscriber_id"=>$subscriber_id),array("store_pickup"=>$store_pickup,"pickup_point_details"=>"")); 
  }

  public function get_buyer_profile()
  {
    $this->ajax_check();
    $store_id = $this->input->post("store_id",true);
    $login_error = '<p>
        <div class="alert alert-danger text-center">
          '.$this->lang->line("You either have to purchase inside Facebook Messenger or have to login.").'<br><br><a href="" id="login_form" class="pointer btn btn-primary">'.$this->lang->line("Login to continue").'</a>
        </div>
      </p>';

    $where_subs = array();
    $subscriber_id=$this->session->userdata($store_id."ecom_session_subscriber_id");
    if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$store_id);
    else
    {
      if($subscriber_id=="") $subscriber_id = $this->input->post("subscriber_id",true);
      if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
    }
    if($subscriber_id=='')
    {
      echo $login_error;
      exit();
    }
    $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");
    $login_needed = false;
    if($subscriber_info[0]['total_rows']==0){
       echo $login_error;
       exit();
    }

    $where = array("subscriber_id"=>$subscriber_id,'profile_address'=>'1');
    $address_data = $this->basic->get_data("ecommerce_cart_address_saved",array("where"=>$where));
    $country_names =  $this->get_country_names();
    $phonecodes = $this->get_country_iso_phone_currecncy('phonecode');
    $first_name=$last_name=$email=$mobile=$country=$city=$state=$address=$zip=$note='';
    $store_data = $this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$store_id)),"store_country");
    if(!isset($store_data[0]))
    {
      echo '<div class="alert alert-danger text-center">'.$this->lang->line("Store not found.").'</div>';
      exit();
    }

    $is_checkout_country = $is_checkout_state = $is_checkout_city = $is_checkout_zip = $is_checkout_email = $is_checkout_phone = '1';

    if(!isset($address_data[0])) 
    {
      $address_data  = $this->basic->get_data("messenger_bot_subscriber",array("where"=>array("subscribe_id"=>$subscriber_id)),"first_name,last_name,full_name,profile_pic,phone_number,user_location,email");
      $user_location = isset($address_data[0]['user_location']) ? json_decode($address_data[0]['user_location'],true) : array();
      $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
      $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
      $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
      $mobile = isset($address_data[0]['phone_number']) ? $address_data[0]['phone_number'] : '';
      $country = isset($user_location['country']) ? $user_location['country'] : '';
      $city = isset($user_location['city']) ? $user_location['city'] : '';
      $state = isset($user_location['state']) ? $user_location['state'] : '';
      $address = isset($user_location['street']) ? $user_location['street'] : '';
      $zip = isset($user_location['zip']) ? $user_location['zip'] : '';
    }
    else
    {
      $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
      $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
      $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
      $mobile = isset($address_data[0]['mobile']) ? $address_data[0]['mobile'] : '';
      $country = isset($address_data[0]['country']) ? $address_data[0]['country'] : '';
      $city = isset($address_data[0]['city']) ? $address_data[0]['city'] : '';
      $state = isset($address_data[0]['state']) ? $address_data[0]['state'] : '';
      $address = isset($address_data[0]['address']) ? $address_data[0]['address'] : '';
      $zip = isset($address_data[0]['zip']) ? $address_data[0]['zip'] : '';
      $note = isset($address_data[0]['note']) ? $address_data[0]['note'] : '';
    }
    $options = "";
    foreach ($country_names as $key => $value) {
      if($country!='')  $selected_country = ($key==$country) ? 'selected' : '';
      else $selected_country = ($key==$store_data[0]['store_country']) ? 'selected' : '';
      $phonecode_attr = isset($phonecodes[$key]) ? $phonecodes[$key] : '';
      $options .='<option phonecode="'.$phonecode_attr.'" value="'.$key.'" '.$selected_country.'>'.$value.'</option>';
    }

    $state_city_street_html = $country_html = $email_html = $phone_html = '';

    $state_var = ($is_checkout_state=='1') ? '<input type="text" class="form-control"  name="state" value="'.$state.'" placeholder="'.$this->lang->line('State').'">':'';
    $city_var = ($is_checkout_city=='1') ? '<input type="text" class="form-control"  name="city" value="'.$city.'" placeholder="'.$this->lang->line('City').'">':'';
    $zip_var = ($is_checkout_zip=='1') ? '<input type="text" class="form-control"  name="zip" value="'.$zip.'" placeholder="'.$this->lang->line('Zip').'">':'';

    if($state_var!='' || $city_var!='' || $zip_var!='')
    $state_city_street_html .= 
    '<div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-city"></i></span>
         </div>                  
         '.$state_var.$city_var.$zip_var.'
       </div>
    </div>';

    if($is_checkout_country=='1')
    $country_html .= 
    '<div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-globe-americas"></i></span>
         </div>
         <select id="country" name="country" class="form-control"> 
           '.$options.'
         </select>
       </div>
    </div>';

    $email_var = ($is_checkout_email=='1') ? '<input type="text" class="form-control" name="email" value="'.$email.'" placeholder="'.$this->lang->line("Email").'">' : '';
    $mobile_var = ($is_checkout_phone=='1') ? '<div class="input-group-prepend d-none text-right" style="width:60px;"><span class="input-group-text" id="phonecode_val"></span></div><input type="text" class="form-control" name="mobile" value="'.$mobile.'" placeholder="'.$this->lang->line("Phone Number").'">' : '';

    if($is_checkout_email=='1')
    $email_html .= '
    <div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-at"></i></span>
         </div>        
         '.$email_var.'
       </div>
    </div>';

    if($is_checkout_phone=='1')
    $phone_html .= '
    <div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-mobile-alt"></i></span>
         </div>        
         '.$mobile_var.'
       </div>
    </div>';

    echo 
    '<div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-user-circle"></i></span>
         </div>
         <input type="text" class="form-control" name="first_name" placeholder="'.$this->lang->line("First Name").'*"  class="form-control-plaintext" value="'.$first_name.'">
         <input type="text" class="form-control" name="last_name" placeholder="'.$this->lang->line("Last Name").'*"  class="form-control-plaintext" value="'.$last_name.'">
       </div>
     </div>               
                  
     <div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-road"></i></span>
         </div>
         <input type="text" class="form-control"  name="street" value="'.$address.'" placeholder="'.$this->lang->line('Street').'*">
       </div>
     </div>
     
     '.$state_city_street_html.'
     '.$country_html.'
     '.$email_html.'
     '.$phone_html;
  }

  public function save_profile_data()
  {
    $this->ajax_check();
    $data = array();
    foreach ($_POST as $key => $value)
    {
      $$key = strip_tags($this->input->post($key,true));
      $data[$key] = $$key;
    }
    if($subscriber_id==''){
       echo json_encode(array('status'=>'0','message'=>$this->login_to_continue));
       exit();
    }

    $pos = strpos($mobile, $country_code);
    $country_code_embeded = ($pos!==false && $pos===0) ? true : false;
    if($mobile!=='' && !$country_code_embeded) $mobile = $country_code.$mobile;
    if(isset($data["mobile"])) $data["mobile"] = $mobile;

    $query = "UPDATE messenger_bot_subscriber  SET  
    `phone_number` = CASE WHEN `phone_number`='' THEN '$mobile' ELSE phone_number END, 
    `email` = CASE WHEN `email`='' THEN '$email' ELSE email END
    WHERE `subscribe_id` = '".$subscriber_id."' ";
    $this->db->query($query);

    $data["title"] = "Billing Address";
    $data["address"] = $data["street"];
    $data["profile_address"] = "1";
    unset($data['store_id']);
    unset($data['country_code']);
    unset($data['street']);

    if($this->basic->is_exist("ecommerce_cart_address_saved",array("subscriber_id"=>$subscriber_id,"profile_address"=>"1")))
    $this->basic->update_data("ecommerce_cart_address_saved",array("subscriber_id"=>$subscriber_id,"profile_address"=>"1"),$data);
    else $this->basic->insert_data("ecommerce_cart_address_saved",$data);

    echo json_encode(array('status'=>'1','message'=>$this->lang->line("Profile data has been saved successfully.")));

  }

  public function get_buyer_address_list($return_dropdown='0')
  {
    $this->ajax_check();
    $store_id = $this->input->post("store_id",true);
    $login_error = '<p>
        <div class="alert alert-danger text-center">
          '.$this->lang->line("You either have to purchase inside Facebook Messenger or have to login.").'<br><br><a href="" id="login_form" class="pointer btn btn-primary">'.$this->lang->line("Login to continue").'</a>
        </div>
      </p>';

    $where_subs = array();
    $subscriber_id=$this->session->userdata($store_id."ecom_session_subscriber_id");
    if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$store_id);
    else
    {
      if($subscriber_id=="") $subscriber_id = $this->input->post("subscriber_id",true);
      if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
    }
    if($subscriber_id=="")
    {
      echo $login_error;
      exit();
    }
    $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");
    $login_needed = false;
    if($subscriber_info[0]['total_rows']==0 && $return_dropdown!='1'){       
      echo $login_error;
      exit();
    }

    $data_close = $this->input->post("data_close",true);
    if(!isset($data_close) || $data_close=='') $data_close = '0';
    $where = array("subscriber_id"=>$subscriber_id);
    $address_data = $this->basic->get_data("ecommerce_cart_address_saved",array("where"=>$where));
    $country_names =  $this->get_country_names();
    $store_data = $this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$store_id)),"store_country");
    if(!isset($store_data[0]))
    {
      echo '<div class="alert alert-danger text-center">'.$this->lang->line("Store not found.").'</div>';
      exit();
    }

    if($return_dropdown=='1')
    {
      echo '<select class="form-control" name="select_delivery_address" id="select_delivery_address" >';
      foreach ($address_data as $key => $value)
      {
        $country = isset($country_names[$value['country']]) ? $country_names[$value['country']] : $value['country'];
        $store_address_array = array($value['address'],$value['city'],$value['state'],$value['zip'],$country);
        $store_address = implode(',', $store_address_array);
        $default = ($value['is_default']=='1') ? 'selected' : '';
        $title = (empty($value['title']) && $value['profile_address']=='1') ? $this->lang->line("Same as Billing") : $value['title'];
        if(!empty($title)) $title = $title.': ';
        echo '<option value="'.$value['id'].'" '.$default.'>'.$title.$value['first_name'].' '.$value['last_name'].' : '.$value["address"].'</option>';
      }
      echo '</select>';
    }
    else
    {
      echo '<div class="list-group">';
      foreach ($address_data as $key => $value)
      {
        $country = isset($country_names[$value['country']]) ? $country_names[$value['country']] : $value['country'];
        $store_address_array = array($value['address'],$value['city'],$value['state'],$value['zip'],$country);
        $store_address = implode(',', $store_address_array);
        $default = ($value['is_default']=='1') ? '<span class="text-primary">'.$this->lang->line("Default").'</span>':'';
        $title = (empty($value['title']) && $value['profile_address']=='1') ? $this->lang->line("Billing") : $value['title'];
        if(!empty($title)) $title = $title.': ';
        echo '      
          <a href="#" data-close="'.$data_close.'" class="list-group-item list-group-item-action flex-column align-items-start saved_address_row" data-profile="'.$value['profile_address'].'" data-id="'.$value['id'].'">
            <div class="d-flex w-100 justify-content-between">
              <h6 class="mb-1">'.$title.$value['first_name'].' '.$value['last_name'].'</h6>
              <!--<small>'.$default.'</small>-->
            </div>
            <small>'.$store_address.'</small>
          </a>';
      }
      echo '</div>';
    }

   
  }

  public function get_buyer_address()
  {
    $this->ajax_check();
    $id=0;
    $address_data = array();
    $subscriber_id = $this->input->post("subscriber_id",true);
    $store_id = $this->input->post("store_id",true);
    $operation = $this->input->post("operation",true);    
       
    $country_names =  $this->get_country_names();
    $phonecodes = $this->get_country_iso_phone_currecncy('phonecode');
    $first_name=$last_name=$email=$mobile=$country=$city=$state=$address=$zip=$title='';
    $store_data = $this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$store_id)),"store_country");
    if(!isset($store_data[0]))
    {
      echo '<div class="alert alert-danger text-center">'.$this->lang->line("Store not found.").'</div>';
      exit();
    }

    $delete='';

    if($operation=='edit')
    {
      $id = $this->input->post("id",true);    
      $where = array("subscriber_id"=>$subscriber_id,'id'=>$id);
      $address_data = $this->basic->get_data("ecommerce_cart_address_saved",array("where"=>$where));
      if(isset($address_data[0])) 
      {      
        $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
        $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
        $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
        $mobile = isset($address_data[0]['mobile']) ? $address_data[0]['mobile'] : '';
        $country = isset($address_data[0]['country']) ? $address_data[0]['country'] : '';
        $city = isset($address_data[0]['city']) ? $address_data[0]['city'] : '';
        $state = isset($address_data[0]['state']) ? $address_data[0]['state'] : '';
        $address = isset($address_data[0]['address']) ? $address_data[0]['address'] : '';
        $zip = isset($address_data[0]['zip']) ? $address_data[0]['zip'] : '';
        $title = isset($address_data[0]['title']) ? $address_data[0]['title'] : '';
      }
      $delete = '<a href="#" id="delete_address" data-id="'.$id.'" class="text-danger float-right pb-2"><i class="fas fa-trash"></i> '.$this->lang->line("Delete").'</a>';
    }
    else
    {
      $address_data = $this->basic->get_data("messenger_bot_subscriber",array("where"=>array("subscribe_id"=>$subscriber_id)));
      if(isset($address_data[0])) 
      {      
        $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
        $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
        $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
        $mobile = isset($address_data[0]['phone_number']) ? $address_data[0]['phone_number'] : '';
        $user_location = isset($address_data[0]['user_location']) ? json_decode($address_data[0]['user_location'],true) : array();
        $country = isset($user_location['country']) ? $user_location['country'] : '';
        $city = isset($user_location['city']) ? $user_location['city'] : '';
        $state = isset($user_location['state']) ? $user_location['state'] : '';
        $address = isset($user_location['street']) ? $user_location['street'] : '';
        $zip = isset($user_location['zip']) ? $user_location['zip'] : '';
      }
    }

    $ecommerce_config = $this->get_ecommerce_config($store_id);
    $is_checkout_country = isset($ecommerce_config['is_checkout_country']) ? $ecommerce_config['is_checkout_country'] : '1';
    $is_checkout_state = isset($ecommerce_config['is_checkout_state']) ? $ecommerce_config['is_checkout_state'] : '1';
    $is_checkout_city = isset($ecommerce_config['is_checkout_city']) ? $ecommerce_config['is_checkout_city'] : '1';
    $is_checkout_zip = isset($ecommerce_config['is_checkout_zip']) ? $ecommerce_config['is_checkout_zip'] : '1';
    $is_checkout_email = isset($ecommerce_config['is_checkout_email']) ? $ecommerce_config['is_checkout_email'] : '1';
    $is_checkout_phone = isset($ecommerce_config['is_checkout_phone']) ? $ecommerce_config['is_checkout_phone'] : '1';
    $is_delivery_note = isset($ecommerce_config['is_delivery_note']) ? $ecommerce_config['is_delivery_note'] : '1';

    
    $options = "";
    foreach ($country_names as $key => $value) {
      if($country!='')  $selected_country = ($key==$country) ? 'selected' : '';
      else $selected_country = ($key==$store_data[0]['store_country']) ? 'selected' : '';
      $phonecode_attr = isset($phonecodes[$key]) ? $phonecodes[$key] : '';
      $options .='<option phonecode="'.$phonecode_attr.'" value="'.$key.'" '.$selected_country.'>'.$value.'</option>';
    }

    $state_city_street_html = $country_html = $email_html = $phone_html = '';

    $state_var = ($is_checkout_state=='1') ? '<input type="text" class="form-control"  name="state" value="'.$state.'" placeholder="'.$this->lang->line('State').'">':'';
    $city_var = ($is_checkout_city=='1') ? '<input type="text" class="form-control"  name="city" value="'.$city.'" placeholder="'.$this->lang->line('City').'">':'';
    $zip_var = ($is_checkout_zip=='1') ? '<input type="text" class="form-control"  name="zip" value="'.$zip.'" placeholder="'.$this->lang->line('Zip').'">':'';

    if($state_var!='' || $city_var!='' || $zip_var!='')
    $state_city_street_html .= 
    '<div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-city"></i></span>
         </div>                  
         '.$state_var.$city_var.$zip_var.'
       </div>
    </div>';

    if($is_checkout_country=='1')
    $country_html .= 
    '<div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-globe-americas"></i></span>
         </div>
         <select id="country" name="country" class="form-control"> 
           '.$options.'
         </select>
       </div>
    </div>';

    $email_var = ($is_checkout_email=='1') ? '<input type="text" class="form-control" name="email" value="'.$email.'" placeholder="'.$this->lang->line("Email").'">' : '';
    $mobile_var = ($is_checkout_phone=='1') ? '<div class="input-group-prepend d-none text-right" style="width:60px;"><span class="input-group-text" id="phonecode_val"></span></div><input type="text" class="form-control" name="mobile" value="'.$mobile.'" placeholder="'.$this->lang->line("Phone Number").'">' : '';

    if($is_checkout_email=='1')
    $email_html .= '
    <div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-at"></i></span>
         </div>        
         '.$email_var.'
       </div>
    </div>';

    if($is_checkout_phone=='1')
    $phone_html .= '
    <div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-mobile-alt"></i></span>
         </div>        
         '.$mobile_var.'
       </div>
    </div>';

    echo     
    $delete.'
    <div class="form-group">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id=""><i class="fas fa-file-signature"></i></span>
        </div>
        <input type="text" class="form-control"  name="title" value="'.$title.'" placeholder="'.$this->lang->line('Title').'">
      </div>
    </div>

    <div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-user-circle"></i></span>
         </div>
         <input type="hidden" name="id" class="form-control-plaintext" value="'.$id.'">
         <input type="text" class="form-control" name="first_name" placeholder="'.$this->lang->line("First Name").'*" class="form-control-plaintext" value="'.$first_name.'">
         <input type="text" class="form-control" name="last_name" placeholder="'.$this->lang->line("Last Name").'*" class="form-control-plaintext" value="'.$last_name.'">
       </div>
     </div>               
                  
     <div class="form-group">
       <div class="input-group">
         <div class="input-group-prepend">
           <span class="input-group-text" id=""><i class="fas fa-road"></i></span>
         </div>
         <input type="text" class="form-control"  name="street" value="'.$address.'" placeholder="'.$this->lang->line('Street').'*">
       </div>
     </div>
     
     '.$state_city_street_html.'
     '.$country_html.'
     '.$email_html.'
     '.$phone_html;
   }

  public function save_address()
  {    
    $this->ajax_check();
    $data = array();
    foreach ($_POST as $key => $value)
    {
      $$key = strip_tags($this->input->post($key,true));
      $data[$key] = $$key;
    }
    if($subscriber_id==''){
       echo json_encode(array('status'=>'0','message'=>$this->login_to_continue));
       exit();
    }
    if(isset($mobile) && isset($country_code))
    {
      $pos = strpos($mobile, $country_code);
      $country_code_embeded = ($pos!==false && $pos===0) ? true : false;
      if($mobile!=='' && !$country_code_embeded) $mobile = $country_code.$mobile;
      if(isset($data["mobile"])) $data["mobile"] = $mobile;
    }
    
    $data["address"] = $data["street"];
    $data["profile_address"] = "0";
    unset($data['store_id']);
    if(isset($data['country_code'])) unset($data['country_code']);
    unset($data['street']);
    if(isset($data['id']))unset($data['id']);

    if(isset($id) && $id!=0)
    $this->basic->update_data("ecommerce_cart_address_saved",array("subscriber_id"=>$subscriber_id,"id"=>$id),$data);
    else
    {
      $this->basic->update_data("ecommerce_cart_address_saved",array("subscriber_id"=>$subscriber_id),array("is_default"=>"0"));
      $data["is_default"] = "1";
      $this->basic->insert_data("ecommerce_cart_address_saved",$data);
    }

    echo json_encode(array('status'=>'1','message'=>$this->lang->line("Delivery address has been saved successfully.")));

  }

  public function delete_address()
  {
    $this->ajax_check();
    $subscriber_id = $this->input->post("subscriber_id");
    $id = $this->input->post("id");
    $this->basic->delete_data("ecommerce_cart_address_saved",array("id"=>$id,"subscriber_id"=>$subscriber_id));
  }


  public function proceed_checkout()
  {
  	$this->ajax_check();
  	$mydata = json_decode($this->input->post("mydata"),true);
    $tmp_store_id = isset($mydata['store_id']) ? $mydata['store_id'] : '0';

  	$cart_id = isset($mydata["cart_id"]) ? $mydata["cart_id"] : 0;

    $where_subs = array();
    $subscriber_id=$this->session->userdata($tmp_store_id."ecom_session_subscriber_id");
    if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$tmp_store_id);
    else
    {
      if($subscriber_id=="") $subscriber_id = isset($mydata['subscriber_id']) ? $mydata['subscriber_id'] : '';
      if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
    }
    if($subscriber_id=="")
    {
      echo json_encode(array('status'=>'0','message'=>$this->login_to_continue,'login_popup'=>'1'));
      exit();
    }
    $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");
    if($subscriber_info[0]['total_rows']==0){
       echo json_encode(array('status'=>'0','message'=>$this->login_to_continue,'login_popup'=>'1'));
       exit();
    }

  	$select = array("store_name","store_id","store_unique_id","store_favicon","store_locale","paypal_enabled","stripe_enabled","razorpay_enabled","paystack_enabled","mollie_enabled","manual_enabled","cod_enabled","ecommerce_cart.user_id as user_id","payment_amount");
  	$cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select);

  	if(!isset($cart_data[0]) || (isset($cart_data[0]) && $cart_data[0]["store_id"]=="") )
  	{
  		echo json_encode(array('status'=>'0','message'=>$this->lang->line('Order data not found.')));
  		exit();
  	}
    $this->_language_loader($cart_data[0]['store_locale']);   
    $subscriber_first_name = isset($mydata['subscriber_first_name']) ? $mydata['subscriber_first_name'] : '';
    $subscriber_last_name = isset($mydata['subscriber_last_name']) ? $mydata['subscriber_last_name'] : '';
    $subscriber_country = isset($mydata['subscriber_country']) ? $mydata['subscriber_country'] : '';
    $delivery_address_id = isset($mydata['delivery_address_id']) ? $mydata['delivery_address_id'] : '';
    $store_pickup = isset($mydata['store_pickup']) ? $mydata['store_pickup'] : '0'; 
    $pickup_point_details = isset($mydata['pickup_point_details']) ? strip_tags($mydata['pickup_point_details']) : ''; 
    $delivery_note = isset($mydata['delivery_note']) ? $this->security->xss_clean(strip_tags($mydata['delivery_note'])) : ''; 

    $buyer_first_name  = $bill_first_name = $subscriber_first_name;
    $buyer_last_name = $bill_last_name = $subscriber_last_name;
    $buyer_country =  $bill_country = $subscriber_country;
    $buyer_email = $buyer_mobile = $buyer_address = $buyer_state = $buyer_city = $buyer_zip = "";
    $bill_email = $bill_mobile = $bill_city = $bill_state = $bill_address = $bill_zip = "";
    $billing_data = $this->basic->get_data("ecommerce_cart_address_saved",array("where"=>array("subscriber_id"=>$subscriber_id,"profile_address"=>"1")));
    if(isset($billing_data[0]))
    {
      $bill_first_name = $billing_data[0]['first_name'];
      $bill_last_name = $billing_data[0]['last_name'];
      $bill_country = $billing_data[0]['country'];
      $bill_email = $billing_data[0]['email'];
      $bill_mobile = $billing_data[0]['mobile'];
      $bill_city = $billing_data[0]['city'];
      $bill_state = $billing_data[0]['state'];
      $bill_address = $billing_data[0]['address'];
      $bill_zip = $billing_data[0]['zip'];
    }
    if(!empty($delivery_address_id) && $store_pickup=='0')
    {
      $delivery_data = $this->basic->get_data("ecommerce_cart_address_saved",array("where"=>array("subscriber_id"=>$subscriber_id,"id"=>$delivery_address_id)));
      if(isset($delivery_data[0]))
      {
        $this->basic->update_data("ecommerce_cart_address_saved",array("subscriber_id"=>$subscriber_id),array("is_default"=>'0'));
        $this->basic->update_data("ecommerce_cart_address_saved",array("subscriber_id"=>$subscriber_id,"id"=>$delivery_address_id),array("is_default"=>'1'));
        $buyer_first_name = $delivery_data[0]['first_name'];
        $buyer_last_name = $delivery_data[0]['last_name'];
        $buyer_country = $delivery_data[0]['country'];
        $buyer_email = $delivery_data[0]['email'];
        $buyer_mobile = $delivery_data[0]['mobile'];
        $buyer_city = $delivery_data[0]['city'];
        $buyer_state = $delivery_data[0]['state'];
        $buyer_address = $delivery_data[0]['address'];
        $buyer_zip = $delivery_data[0]['zip'];
      }
    }
    else $buyer_first_name = $buyer_last_name = $buyer_country = "";

  	$store_id = $cart_data[0]["store_id"];
  	$user_id = $cart_data[0]["user_id"];
  	$payment_amount = $cart_data[0]["payment_amount"];
  	$store_name = $cart_data[0]["store_name"];
  	$paypal_enabled = $cart_data[0]["paypal_enabled"];
  	$stripe_enabled = $cart_data[0]["stripe_enabled"];
  	$manual_enabled = $cart_data[0]["manual_enabled"];
  	$cod_enabled = $cart_data[0]["cod_enabled"];
    $razorpay_enabled = $cart_data[0]["razorpay_enabled"];
    $paystack_enabled = $cart_data[0]["paystack_enabled"];
    $mollie_enabled = $cart_data[0]["mollie_enabled"];
  	$store_favicon = $cart_data[0]["store_favicon"];
  	if($store_favicon!="") $store_favicon = base_url("upload/ecommerce/".$store_favicon);
  	
  	$ecommerce_config =  $this->get_ecommerce_config($store_id);
  	$paypal_email = isset($ecommerce_config['paypal_email']) ? $ecommerce_config['paypal_email'] : '';
  	$paypal_mode = isset($ecommerce_config['paypal_mode']) ? $ecommerce_config['paypal_mode'] : 'live';
  	$stripe_secret_key = isset($ecommerce_config['stripe_secret_key']) ? $ecommerce_config['stripe_secret_key'] : '';
  	$stripe_publishable_key = isset($ecommerce_config['stripe_publishable_key']) ? $ecommerce_config['stripe_publishable_key'] : '';
    $stripe_billing_address = isset($ecommerce_config['stripe_billing_address']) ? $ecommerce_config['stripe_billing_address'] : '0';
    $razorpay_key_id = isset($ecommerce_config['razorpay_key_id']) ? $ecommerce_config['razorpay_key_id'] : '';
    $razorpay_key_secret = isset($ecommerce_config['razorpay_key_secret']) ? $ecommerce_config['razorpay_key_secret'] : '';
    $paystack_secret_key = isset($ecommerce_config['paystack_secret_key']) ? $ecommerce_config['paystack_secret_key'] : '';
    $paystack_public_key = isset($ecommerce_config['paystack_public_key']) ? $ecommerce_config['paystack_public_key'] : '';
    $mollie_api_key = isset($ecommerce_config['mollie_api_key']) ? $ecommerce_config['mollie_api_key'] : '';
  	$manual_payment_instruction = isset($ecommerce_config['manual_payment_instruction']) ? $ecommerce_config['manual_payment_instruction'] : '';
  	$currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : 'USD';

  	if($paypal_enabled=='1'  && $paypal_email=='') 
  	{
  	    echo json_encode(array('status'=>'0','message'=>$this->lang->line('PayPal payment settings not found.')));
  		  exit();
  	}
  	if($stripe_enabled=='1'  && ($stripe_secret_key=='' || $stripe_publishable_key=='')) 
  	{
  	    echo json_encode(array('status'=>'0','message'=>$this->lang->line('Stripe payment settings not found.')));
  		  exit();
  	}
    if($razorpay_enabled=='1'  && ($razorpay_key_id=='' || $razorpay_key_secret=='')) 
    {
        echo json_encode(array('status'=>'0','message'=>$this->lang->line('Razorpay payment settings not found.')));
        exit();
    }
    if($paystack_enabled=='1'  && ($paystack_secret_key=='' || $paystack_public_key=='')) 
    {
        echo json_encode(array('status'=>'0','message'=>$this->lang->line('Paystack payment settings not found.')));
        exit();
    }
  	if($mollie_enabled=='1'  && $mollie_api_key=='') 
  	{
  	    echo json_encode(array('status'=>'0','message'=>$this->lang->line('Mollie payment settings not found.')));
  		  exit();
  	}
    if($manual_enabled=='1'  && $manual_payment_instruction=='') 
    {
        echo json_encode(array('status'=>'0','message'=>$this->lang->line('Manual payment settings not found.')));
        exit();
    }

  	$curtime = date("Y-m-d H:i:s");
  	$update_data = array
  	(
  		"store_pickup"=>$store_pickup,
      "buyer_first_name"=>$buyer_first_name,
  		"buyer_last_name"=>$buyer_last_name,
  		"buyer_email"=>$buyer_email,
  		"buyer_mobile"=>$buyer_mobile,
  		"buyer_country"=>$buyer_country,
  		"buyer_state"=>$buyer_state,
      "buyer_city"=>$buyer_city,
  		"buyer_address"=>$buyer_address,
  		"buyer_zip"=>$buyer_zip,
  		"updated_at"=>$curtime,
  		"buyer_zip"=>$buyer_zip,
      "bill_first_name"=>$bill_first_name,
      "bill_last_name"=>$bill_last_name,
      "bill_country"=>$bill_country,
      "bill_email"=>$bill_email,
      "bill_mobile"=>$bill_mobile,
      "bill_city"=>$bill_city,
      "bill_state"=>$bill_state,
      "bill_address"=>$bill_address,
      "bill_zip"=>$bill_zip,
      "pickup_point_details"=>$pickup_point_details,
      "delivery_note"=>$delivery_note
  	);
  	$this->basic->update_data("ecommerce_cart",array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"),$update_data);   	    
        
    $paypal_button = $stripe_button = $razorpay_button = $paystack_button = $mollie_button = $manual_button = $cod_button = "";
  	$product_name  = $store_name." : ".$this->lang->line("Order")." #".$cart_id;
    if($paypal_enabled=="1")
    { 
    	$this->load->library('paypal_class_ecommerce');
  		$cancel_url=base_url()."ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=cancel";
	    $success_url=base_url()."ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=success";    
	    
	    $this->paypal_class_ecommerce->mode=$paypal_mode;
	    $this->paypal_class_ecommerce->cancel_url=$cancel_url;
	    $this->paypal_class_ecommerce->success_url=$success_url;
	    $this->paypal_class_ecommerce->notify_url=base_url("ecommerce/paypal_action/".$store_id);
	    $this->paypal_class_ecommerce->business_email=$paypal_email;
      $this->paypal_class_ecommerce->amount=$payment_amount;
	    $this->paypal_class_ecommerce->user_id=$user_id;
	    $this->paypal_class_ecommerce->currency=$currency;
	    $this->paypal_class_ecommerce->cart_id=$cart_id;
	    $this->paypal_class_ecommerce->subscriber_id=$subscriber_id;
	    $this->paypal_class_ecommerce->product_name=$product_name;
      $this->paypal_class_ecommerce->button_lang=$this->lang->line("Pay with PayPal");
      $this->paypal_class_ecommerce->secondary_button = true;
	    $paypal_button = $this->paypal_class_ecommerce->set_button();
	    $paypal_button = '<div class="col-12 col-md-6">'.$paypal_button.'</div>';
   	}

   	if($stripe_enabled=="1")
    { 
    	$this->load->library('stripe_class_ecommerce');
	    $this->stripe_class_ecommerce->secret_key=$stripe_secret_key;
	    $this->stripe_class_ecommerce->publishable_key=$stripe_publishable_key;
	    $this->stripe_class_ecommerce->title=$store_name;
	    $this->stripe_class_ecommerce->description=$this->lang->line("Order")." #".$cart_id;
	    $this->stripe_class_ecommerce->amount=$payment_amount;
	    $this->stripe_class_ecommerce->action_url=base_url("ecommerce/stripe_action/".$store_id.'/'.$cart_id.'/'.$subscriber_id.'/'.$payment_amount.'/'.$currency.'/'.urlencode($store_name));
	    $this->stripe_class_ecommerce->currency=$currency;
	    $this->stripe_class_ecommerce->img_url=$store_favicon;
      $this->stripe_class_ecommerce->button_lang=$this->lang->line("Pay with Stripe");
      $this->stripe_class_ecommerce->stripe_billing_address=$stripe_billing_address;
      $this->stripe_class_ecommerce->secondary_button = true;
	    $stripe_button = $this->stripe_class_ecommerce->set_button();
	    $stripe_button = '<div class="col-12 col-md-6">'.$stripe_button.'</div>'; 
	  }

    if($razorpay_enabled=="1")
    { 
      $this->load->library("razorpay_class_ecommerce");

      $this->razorpay_class_ecommerce->key_id=$razorpay_key_id;
      $this->razorpay_class_ecommerce->key_secret=$razorpay_key_secret; 
      $this->razorpay_class_ecommerce->title=$store_name;
      $this->razorpay_class_ecommerce->description=$this->lang->line("Order")." #".$cart_id;
      $this->razorpay_class_ecommerce->amount=$payment_amount;
      $this->razorpay_class_ecommerce->action_url=base_url("ecommerce/razorpay_action/".$store_id.'/'.$cart_id.'/'.$subscriber_id); 
      $this->razorpay_class_ecommerce->currency=$currency;
      $this->razorpay_class_ecommerce->img_url=$store_favicon;
      $this->razorpay_class_ecommerce->customer_name=$bill_first_name." ".$bill_last_name;
      $this->razorpay_class_ecommerce->customer_email=$bill_email;
      $this->razorpay_class_ecommerce->button_lang=$this->lang->line("Pay with Razorpay");
      $this->razorpay_class_ecommerce->secondary_button = true;
      $razorpay_button =  $this->razorpay_class_ecommerce->set_button();
      $razorpay_button = '<div class="col-12 col-md-6">'.$razorpay_button.'</div>';
    }

    if($paystack_enabled=="1")
    { 
      $this->load->library("paystack_class_ecommerce");

      $this->paystack_class_ecommerce->secret_key=$paystack_secret_key;
      $this->paystack_class_ecommerce->public_key=$paystack_public_key; 
      $this->paystack_class_ecommerce->title=$store_name;
      $this->paystack_class_ecommerce->description=$this->lang->line("Order")." #".$cart_id;
      $this->paystack_class_ecommerce->amount=$payment_amount;
      $this->paystack_class_ecommerce->action_url=base_url("ecommerce/paystack_action/".$store_id.'/'.$cart_id.'/'.$subscriber_id); 
      $this->paystack_class_ecommerce->currency=$currency;
      $this->paystack_class_ecommerce->img_url=$store_favicon;
      $this->paystack_class_ecommerce->customer_first_name=$bill_first_name;
      $this->paystack_class_ecommerce->customer_last_name=$bill_last_name;
      $this->paystack_class_ecommerce->customer_email=$bill_email;
      $this->paystack_class_ecommerce->button_lang=$this->lang->line("Pay with Paystack");
      $this->paystack_class_ecommerce->secondary_button = true;
      $paystack_button =  $this->paystack_class_ecommerce->set_button();
      $paystack_button = '<div class="col-12 col-md-6">'.$paystack_button.'</div>';
    }

    if($mollie_enabled=="1")
    { 
      $this->load->library("mollie_class_ecommerce");

      $this->mollie_class_ecommerce->api_key=$mollie_api_key; 
      $this->mollie_class_ecommerce->title=$store_name;
      $this->mollie_class_ecommerce->description=$this->lang->line("Order")." #".$cart_id;
      $this->mollie_class_ecommerce->amount=$payment_amount;
      $this->mollie_class_ecommerce->action_url=base_url("ecommerce/mollie_action/".$store_id.'/'.$cart_id.'/'.$subscriber_id); 
      $this->mollie_class_ecommerce->currency=$currency;
      $this->mollie_class_ecommerce->img_url=$store_favicon;
      $this->mollie_class_ecommerce->customer_name=$bill_first_name." ".$bill_last_name;
      $this->mollie_class_ecommerce->customer_email=$bill_email;
      $this->mollie_class_ecommerce->ec_order_id=$cart_id;
      $this->mollie_class_ecommerce->button_lang=$this->lang->line("Pay with Mollie");
      $this->mollie_class_ecommerce->secondary_button = true;
      $mollie_button =  $this->mollie_class_ecommerce->set_button_ecommerce();
      $mollie_button = '<div class="col-12 col-md-6">'.$mollie_button.'</div>';
    }

		if($manual_enabled=='1')
		{
			$manual_button = '
      <div class="col-12 col-md-6 text-center">
      <a href="#" class="list-group-item list-group-item-action flex-column align-items-start" id="manual-payment-button">
          <div class="d-flex w-100 align-items-center">
            <small class="text-muted"><img class="rounded" width="60" height="60" src="'.base_url("assets/img/payment/manual.png").'"></small>
            <h6 class="mb-1">'.$this->lang->line("Manual Payment").'</h6>
          </div>
      </a>
      </div>';
		} 

		if($cod_enabled=='1')
		{
      $cod_button = '
      <div class="col-12 col-md-6 text-center">
      <a href="#" class="list-group-item list-group-item-action flex-column align-items-start" id="cod-payment-button">
          <div class="d-flex w-100 align-items-center">
            <small class="text-muted"><img class="rounded" width="60" height="60" src="'.base_url("assets/img/payment/cod.png").'"></small>
            <h6 class="mb-1">'.$this->lang->line("Cash on Delivery").'</h6>
          </div>
      </a>
      </div>';
		}          

	  $html ='<div class="row">'.$cod_button.$paypal_button.$stripe_button.$razorpay_button.$paystack_button.$mollie_button.$manual_button.'</div>';

	  echo json_encode(array('status'=>'1','message'=>'','html'=>$html));
  	
  }


  public function manual_payment() 
  {
      $this->ajax_check();
      if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) exit();
      $cart_id = $this->input->post('cart_id',true);
      $subscriber_id = $this->input->post('subscriber_id',true);

      if($cart_id!="" && $subscriber_id!="") 
      {
        $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select="");
        if(isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
      }

      // Sets validation rules
      $this->form_validation->set_rules('paid-amount', $this->lang->line('Amount'), 'required|numeric');
      $this->form_validation->set_rules('paid-currency', $this->lang->line('Currency'), 'required');
      $this->form_validation->set_rules('additional-info', $this->lang->line('Additional info'), 'trim');
      $this->form_validation->set_rules('cart_id', $this->lang->line('Cart'), 'required|numeric');
      $this->form_validation->set_rules('subscriber_id', $this->lang->line('Subscriber ID'), 'required');

      // Shows errors if user data is invalid
      if (false === $this->form_validation->run())
      {
        if ($this->form_validation->error('paid-amount')) $message = $this->form_validation->error('paid-amount');
        else if ($this->form_validation->error('paid-currency')) $message = $this->form_validation->error('paid-currency');
        else if ($this->form_validation->error('additional-info')) $message = $this->form_validation->error('additional-info');
        else if ($this->form_validation->error('cart_id')) $message = $this->form_validation->error('cart_id');
        else if ($this->form_validation->error('subscriber_id')) $message = $this->form_validation->error('subscriber_id');
        else $message = $this->lang->line('Something went wrong, please try again.');
          
        echo json_encode(['error' => strip_tags($message)]);
        exit;
      }

      $paid_amount = $this->input->post('paid-amount',true);
      $paid_currency = $this->input->post('paid-currency',true);
      $additional_info = strip_tags($this->input->post('additional-info',true));

      $this->load->library('upload');

      if ($_FILES['manual-payment-file']['size'] != 0) {

          $base_path = FCPATH.'upload/ecommerce';
          $filename = "payment_" . time() . substr(uniqid(mt_rand(), true), 0, 6).'_'.$_FILES['manual-payment-file']['name'];
          $config = array(
            "allowed_types" => 'pdf|doc|txt|png|jpg|jpeg|zip',
            "upload_path" => $base_path,
            "overwrite" => true,
            "file_name" => $filename,
            'max_size' => '5120',
          );

          $this->upload->initialize($config);
          $this->load->library('upload', $config);

          if (!$this->upload->do_upload('manual-payment-file')) {
            
            $message = $this->upload->display_errors();
            echo json_encode(['error' => $message]); exit;
          }
      }
      else
      {
      	$message =$this->lang->line('Payment File is Required.');
        echo json_encode(['error' => $message]); exit;
      }

      $curtime  = date('Y-m-d H:i:s');
      $transaction_id = strtoupper('MP'.$cart_id.hash_pbkdf2('sha512', $paid_amount, mt_rand(19999999, 99999999), 1000, 6));
      $data = [
          'manual_amount' => $paid_amount, 
          'manual_currency' => $paid_currency, 
          'manual_additional_info' => $additional_info,            
          'transaction_id' => $transaction_id,
          'manual_filename' => $filename,
          'paid_at' => $curtime,
          'status' => 'pending',
          'status_changed_at' => $curtime,
          'action_type'=>'checkout',
          'payment_method'=>'Manual'
      ];

      if($this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"), $data)) 
      {
          $message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your order has been placed successfully and your payment request is now being reviewed. You can see your order status from this page')." : <br>";
          $invoice_link = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=success2");
          $message .= "<a href='".$invoice_link."'>".$invoice_link."</a>";
          // $this->session->set_userdata('payment_status','1');
          // $this->session->set_userdata('payment_status_message',$message);
          $this->confirmation_message_sender($cart_id,$subscriber_id);
          echo json_encode(['success' => $message,'redirect'=>$invoice_link]);
          exit;
      }

      $message = $this->lang->line('Something went wrong, please try again.');
      echo json_encode(['error' => $message]);
  }

  public function cod_payment() 
  {
      $this->ajax_check();
      $cart_id = $this->input->post("cart_id",true);
      $subscriber_id = $this->input->post("subscriber_id",true);

      if($cart_id!="" && $subscriber_id!="") 
      {
        $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select="");
        if(isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
      }

      $curtime  = date('Y-m-d H:i:s');
      $transaction_id = strtoupper('PD'.$cart_id.hash_pbkdf2('sha512', $subscriber_id, mt_rand(19999999, 99999999), 1000, 6));
      $data = [                       
          'transaction_id' => $transaction_id,            
          'paid_at' => $curtime,
          'status' => 'pending',
          'status_changed_at' => $curtime,
          'action_type'=>'checkout',
          'payment_method'=>'Cash on Delivery'
      ];

      if($this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"), $data)) 
      {
          $message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your order has been placed successfully and is now being reviewed. You can see your order status from this page')." : <br>";
          $invoice_link = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=success2");
          $message .= "<a href='".$invoice_link."'>".$invoice_link."</a>";
          // $this->session->set_userdata('payment_status','1');
          // $this->session->set_userdata('payment_status_message',$message);
          $this->confirmation_message_sender($cart_id,$subscriber_id);
          echo json_encode(['success' => $message,'redirect'=>$invoice_link]);
          exit;
      }
      $message = $this->lang->line('Something went wrong, please try again.');
      echo json_encode(['error' => $message]);
  }

  public function stripe_action($store_id='',$cart_id='',$subscriber_id='',$payment_amount='',$currency='',$store_name='')
  {	
  		$this->load->library('stripe_class_ecommerce');
  		// $user_id  = $this->session->userdata('ecommerce_stripe_payment_user_id');
  		$ecommerce_config =  $this->get_ecommerce_config($store_id);
      $stripe_secret_key = isset($ecommerce_config['stripe_secret_key']) ? $ecommerce_config['stripe_secret_key'] : '';
      $this->stripe_class_ecommerce->secret_key=$stripe_secret_key;
  		$response= $this->stripe_class_ecommerce->stripe_payment_action($payment_amount,$currency,$store_name);

      // pre($response); exit();

  		if($response['status']=='Error'){
  			echo $response['message'];
  			exit();
  		}
  		
  		$currency = isset($response['charge_info']['currency'])?$response['charge_info']['currency']:"";
  		$currency=strtoupper($currency);
  		
  		$receiver_email=$response['email'];

  		if($currency=='JPY' || $currency=='VND') $payment_amount=$response['charge_info']['amount'];
  		else $payment_amount=$response['charge_info']['amount']/100;

  		$transaction_id=$response['charge_info']['balance_transaction'];
  		$payment_date=date("Y-m-d H:i:s",$response['charge_info']['created']) ;
  		$country=isset($response['charge_info']['source']['country'])?$response['charge_info']['source']['country']:"";
  		
  		$stripe_card_source=isset($response['charge_info']['source'])?$response['charge_info']['source']:"";
  		$stripe_card_source=json_encode($stripe_card_source);		
  	
  		$curtime = date("Y-m-d H:i:s");
  		$insert_data=array
  		(
          'checkout_account_receiver_email' => $receiver_email, 
          'checkout_account_country' => $country, 
          'checkout_amount' => $payment_amount, 
          'checkout_currency' => $currency,           
          'checkout_timestamp' => $payment_date,           
          'transaction_id' => $transaction_id,
		      "checkout_source_json"=>$stripe_card_source,            
          'paid_at' => $curtime,
          'status' => 'approved',
          'status_changed_at' => $curtime,
          'action_type'=>'checkout',
          'payment_method'=>'Stripe'
      );		
  		// $cart_id = $this->session->userdata('ecommerce_stripe_payment_cart_id');
  		// $subscriber_id = $this->session->userdata('ecommerce_stripe_payment_subscriber_id');
      $this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"),$insert_data);

      if($cart_id!="" && $subscriber_id!="") 
      {
        $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select="");
        if(isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
      }
          
  		// $message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your payment has been received successfully and order will be processed soon. You can see your order status from this page')." : <br>";
  		$invoice_link = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=success3");
  		// $message .= "<a href='".$invoice_link."'>".$invoice_link."</a>";

  		// $this->session->set_userdata('payment_status','1');
  		// $this->session->set_userdata('payment_status_message',$message);

  		$this->confirmation_message_sender($cart_id,$subscriber_id);

  		redirect($invoice_link, 'location');		
	}

  public function razorpay_action($store_id='',$cart_id='',$subscriber_id='',$raz_order_id_session="")
  { 
      $this->load->library('razorpay_class_ecommerce');    
      // $user_id  = $this->session->userdata('ecommerce_razorpay_payment_user_id');
      $ecommerce_config =  $this->get_ecommerce_config($store_id);
      $razorpay_key_id = isset($ecommerce_config['razorpay_key_id']) ? $ecommerce_config['razorpay_key_id'] : '';
      $razorpay_key_secret = isset($ecommerce_config['razorpay_key_secret']) ? $ecommerce_config['razorpay_key_secret'] : '';
      $this->razorpay_class_ecommerce->key_id=$razorpay_key_id;    
      $this->razorpay_class_ecommerce->key_secret=$razorpay_key_secret;    
      $response= $this->razorpay_class_ecommerce->razorpay_payment_action($raz_order_id_session);

      if(isset($response['status']) && $response['status']=='Error'){
        echo $response['message'];
        exit();
      }      
      
      $receiver_email="";
      $country="";

      $currency = isset($response['charge_info']['currency'])?$response['charge_info']['currency']:"INR";
      $currency = strtoupper($currency);
      $payment_amount = isset($response['charge_info']['amount_paid'])?($response['charge_info']['amount_paid']/100):"0";
      $transaction_id = isset($response['charge_info']['id'])?$response['charge_info']['id']:"";
      $payment_date= isset($response['charge_info']['created_at']) ? date("Y-m-d H:i:s",$response['charge_info']['created_at']) : '';
    
      $curtime = date("Y-m-d H:i:s");
      $insert_data=array
      (
          'checkout_account_receiver_email' => $receiver_email, 
          'checkout_account_country' => $country, 
          'checkout_amount' => $payment_amount, 
          'checkout_currency' => $currency,           
          'checkout_timestamp' => $payment_date,           
          'transaction_id' => $transaction_id,
          "checkout_source_json"=>json_encode($response),            
          'paid_at' => $curtime,
          'status' => 'approved',
          'status_changed_at' => $curtime,
          'action_type'=>'checkout',
          'payment_method'=>'Razorpay'
      );    
      // $cart_id = $this->session->userdata('ecommerce_razorpay_payment_cart_id');
      // $subscriber_id = $this->session->userdata('ecommerce_razorpay_payment_subscriber_id');
      $this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"),$insert_data);

      if($cart_id!="" && $subscriber_id!="") 
      {
        $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select="");
        if(isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
      }
          
      // $message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your payment has been received successfully and order will be processed soon. You can see your order status from this page')." : <br>";
      $invoice_link = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=success3");
      // $message .= "<a href='".$invoice_link."'>".$invoice_link."</a>";

      // $this->session->set_userdata('payment_status','1');
      // $this->session->set_userdata('payment_status_message',$message);

      $this->confirmation_message_sender($cart_id,$subscriber_id);

      redirect($invoice_link, 'location');    
  }

  public function paystack_action($store_id='',$cart_id='',$subscriber_id='',$reference="")
  { 
      $this->load->library('paystack_class_ecommerce'); 
      // $user_id  = $this->session->userdata('ecommerce_paystack_payment_user_id');
      $ecommerce_config =  $this->get_ecommerce_config($store_id);
      $paystack_secret_key = isset($ecommerce_config['paystack_secret_key']) ? $ecommerce_config['paystack_secret_key'] : '';
      $this->paystack_class_ecommerce->secret_key=$paystack_secret_key; 
      $response= $this->paystack_class_ecommerce->paystack_payment_action($reference);

      if(isset($response['status']) && $response['status']=='Error'){
        echo $response['message'];
        exit();
      }      
      
      $receiver_email="";
      $country="";

      $currency = isset($response['charge_info']['data']['currency'])?$response['charge_info']['data']['currency']:"NGN";
      $currency = strtoupper($currency);
      $payment_amount = isset($response['charge_info']['data']['amount'])?($response['charge_info']['data']['amount']/100):"0";
      $transaction_id = isset($response['charge_info']['data']['id'])?$response['charge_info']['data']['id']:"";
      $payment_date= isset($response['charge_info']['data']['paid_at']) ? date("Y-m-d H:i:s",strtotime($response['charge_info']['data']['paid_at'])) : '';
    
      $curtime = date("Y-m-d H:i:s");
      $insert_data=array
      (
          'checkout_account_receiver_email' => $receiver_email, 
          'checkout_account_country' => $country, 
          'checkout_amount' => $payment_amount, 
          'checkout_currency' => $currency,           
          'checkout_timestamp' => $payment_date,           
          'transaction_id' => $transaction_id,
          "checkout_source_json"=>json_encode($response),            
          'paid_at' => $curtime,
          'status' => 'approved',
          'status_changed_at' => $curtime,
          'action_type'=>'checkout',
          'payment_method'=>'Paystack'
      );    
      // $cart_id = $this->session->userdata('ecommerce_paystack_payment_cart_id');
      // $subscriber_id = $this->session->userdata('ecommerce_paystack_payment_subscriber_id');
      $this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"),$insert_data);

      if($cart_id!="" && $subscriber_id!="") 
      {
        $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select="");
        if(isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
      }
          
      // $message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your payment has been received successfully and order will be processed soon. You can see your order status from this page')." : <br>";
      $invoice_link = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=success3");
      // $message .= "<a href='".$invoice_link."'>".$invoice_link."</a>";

      // $this->session->set_userdata('payment_status','1');
      // $this->session->set_userdata('payment_status_message',$message);

      $this->confirmation_message_sender($cart_id,$subscriber_id);

      redirect($invoice_link, 'location');    
  }

  public function mollie_action($store_id='',$cart_id='',$subscriber_id='')
  { 
      $this->load->library('mollie_class_ecommerce'); 
      // $user_id  = $this->session->userdata('ecommerce_mollie_payment_user_id');
      // $cart_id = $this->session->userdata('ecommerce_mollie_payment_cart_id');
      $ecommerce_config =  $this->get_ecommerce_config($store_id);
      $mollie_api_key = isset($ecommerce_config['mollie_api_key']) ? $ecommerce_config['mollie_api_key'] : '';
      $this->mollie_class_ecommerce->ec_order_id=$cart_id; 
      $this->mollie_class_ecommerce->api_key=$mollie_api_key; 
      $response= $this->mollie_class_ecommerce->mollie_payment_action_ecommerce($cart_id);

      if(isset($response['status']) && $response['status']=='Error'){
        echo $response['message'];
        exit();
      }      
      
      $receiver_email="";
      $country="";

      $currency = isset($response['charge_info']['amount']['currency'])?$response['charge_info']['amount']['currency']:"EUR";
      $currency = strtoupper($currency);
      $payment_amount = isset($response['charge_info']['amount']['value'])?$response['charge_info']['amount']['value']:"0";
      $transaction_id = isset($response['charge_info']['id'])?$response['charge_info']['id']:"";
      $payment_date= isset($response['charge_info']['createdAt']) ? date("Y-m-d H:i:s",strtotime($response['charge_info']['createdAt'])) : '';
    
      $curtime = date("Y-m-d H:i:s");
      $insert_data=array
      (
          'checkout_account_receiver_email' => $receiver_email, 
          'checkout_account_country' => $country, 
          'checkout_amount' => $payment_amount, 
          'checkout_currency' => $currency,           
          'checkout_timestamp' => $payment_date,           
          'transaction_id' => $transaction_id,
          "checkout_source_json"=>json_encode($response),            
          'paid_at' => $curtime,
          'status' => 'approved',
          'status_changed_at' => $curtime,
          'action_type'=>'checkout',
          'payment_method'=>'Mollie'
      );    
      // $subscriber_id = $this->session->userdata('ecommerce_mollie_payment_subscriber_id');
      $this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"),$insert_data);

      if($cart_id!="" && $subscriber_id!="") 
      {
        $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select="");
        if(isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
      }
          
      // $message = "<i class='fas fa-check-circle'></i> ".$this->lang->line('Your payment has been received successfully and order will be processed soon. You can see your order status from this page')." : <br>";
      $invoice_link = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=success3");
      // $message .= "<a href='".$invoice_link."'>".$invoice_link."</a>";

      // $this->session->set_userdata('payment_status','1');
      // $this->session->set_userdata('payment_status_message',$message);

      $this->confirmation_message_sender($cart_id,$subscriber_id);

      redirect($invoice_link, 'location');    
  }

	public function paypal_action($store_id=0)
	{
    $this->load->library('paypal_class_ecommerce');
    $ecommerce_config =  $this->get_ecommerce_config($store_id);
    $paypal_mode = isset($ecommerce_config['paypal_mode']) ? $ecommerce_config['paypal_mode'] : 'live';
    $this->paypal_class_ecommerce->mode=$paypal_mode;
    $payment_info=$this->paypal_class_ecommerce->run_ipn();

    $api_data=$this->basic->get_data("native_api","","",$join='',$limit='1',$start=0,$order_by='id asc');
    $api_key="";
    if(count($api_data)>0) $api_key=$api_data[0]["api_key"];
    $payment_info['api_key'] =$api_key;

    $custom_data = isset($payment_info['data']['custom']) ? $payment_info['data']['custom'] : "";
    $explode=explode('_',$custom_data);
    $cart_id=isset($explode[0]) ? $explode[0] : 0;
    $subscriber_id=isset($explode[1]) ? $explode[1] : "";  

    if($cart_id!="" && $subscriber_id!="") 
    {
      $cart_data = $this->valid_cart_data($cart_id,$subscriber_id,$select="");
      if(isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
    }    

    $post_data_payment_info=array("response_raw"=>json_encode($payment_info));
    $url=base_url()."ecommerce/paypal_action_main";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data_payment_info);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    $reply_response=curl_exec($ch); 

    $curl_information =  curl_getinfo($ch);
  	$curl_error="";
    if($curl_information['http_code']!='200'){
      $curl_error = curl_error($ch);
    }

    $payment_info["error_log"] = $curl_information['http_code']." : ".$curl_error;
    $payment_info_json=json_encode($payment_info);
    $this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"),array("checkout_source_json"=>$payment_info_json));
	}
	    
  public function paypal_action_main()
  {    
    $response_raw=$this->input->post("response_raw");   
    $payment_info = json_decode($response_raw,TRUE);
    
    $verify_status=isset($payment_info['verify_status']) ? $payment_info['verify_status']:"";
    $first_name= isset($payment_info['data']['first_name']) ? $payment_info['data']['first_name']:"";
    $last_name= isset($payment_info['data']['last_name']) ? $payment_info['data']['last_name']:"";
    $buyer_email= isset($payment_info['data']['payer_email']) ? $payment_info['data']['payer_email']:"";
    $receiver_email= isset($payment_info['data']['receiver_email']) ? $payment_info['data']['receiver_email']:""; 
    $country= isset($payment_info['data']['address_country_code']) ? $payment_info['data']['address_country_code']:""; 
    $payment_date=isset($payment_info['data']['payment_date']) ? $payment_info['data']['payment_date']:""; 
    $transaction_id=isset($payment_info['data']['txn_id']) ? $payment_info['data']['txn_id']:""; 
    $payment_type=isset($payment_info['data']['payment_type']) ? "PAYPAL-".ucfirst($payment_info['data']['payment_type']) : "PAYPAL"; 
    $payment_amount=isset($payment_info['data']['mc_gross']) ? $payment_info['data']['mc_gross']:"";
    
    $custom_data = isset($payment_info['data']['custom']) ? $payment_info['data']['custom'] : "";
    $explode=explode('_',$custom_data);
    $cart_id=isset($explode[0]) ? $explode[0] : 0;
    $subscriber_id=isset($explode[1]) ? $explode[1] : "";

    $payment_date = date("Y-m-d H:i:s",strtotime($payment_date));

    /****Get API Key & Match With the post API Key, If not same , then exit it . ***/
    $api_data=$this->basic->get_data("native_api","","",$join='',$limit='1',$start=0,$order_by='id asc');
    $api_key="";
    if(count($api_data)>0) $api_key=$api_data[0]["api_key"];
    $post_api_from_ipn = $payment_info['api_key']; 
    if($api_key!=$post_api_from_ipn) exit();


    /***Check if the transaction id is already used or not, if used, then exit to prevent multiple add***/
    $simple_where_duplicate_check['where'] = array('transaction_id'=>$transaction_id,"payment_method"=>"PayPal");
    $prev_payment_info_transaction = $this->basic->get_data('ecommerce_cart',$simple_where_duplicate_check,"id",$join='',$limit='1',$start=0,$order_by='id desc');
    if(count($prev_payment_info_transaction)>0) exit;

    $cart_data = $this->basic->get_data("ecommerce_cart",array("where"=>array("id"=>$cart_id,"subscriber_id"=>$subscriber_id)),"payment_amount");
    if(!isset($cart_data[0])) exit();
    $price = $cart_data[0]["payment_amount"];        
   
    /** insert the transaction into database ***/       
    $paypal_status_verification = $this->config->item("paypal_status_verification");
    if($paypal_status_verification=='') $paypal_status_verification='1';
   
   /* if($paypal_status_verification=='1') if($verify_status!="VERIFIED" || $payment_amount<$price) exit();
    else if($payment_amount<$price)  exit(); */

    $curtime = date("Y-m-d H:i:s");
		$insert_data=array
		(
        'checkout_account_email' => $buyer_email, 
        'checkout_account_receiver_email' => $receiver_email, 
        'checkout_account_country' => $country,
        'checkout_account_first_name' => $first_name,
        'checkout_account_last_name' => $last_name,
        'checkout_amount' => $payment_amount, 
        'checkout_currency' => "",
        'checkout_verify_status' => $verify_status,
        'checkout_timestamp' => $payment_date,           
        'transaction_id' => $transaction_id,          
        'paid_at' => $curtime,
        'status' => 'approved',
        'status_changed_at' => $curtime,
        'action_type'=>'checkout',
        'payment_method'=>'PayPal'
    );		
    $this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"),$insert_data);
    $this->confirmation_message_sender($cart_id,$subscriber_id);     
  }



  private function spin_and_replace($str="",$replace = array(),$is_spin=true)
  {
    if(!isset($replace['store_name'])) $replace['store_name'] = '';
    if(!isset($replace['store_url'])) $replace['store_url'] = '';
    if(!isset($replace['order_no'])) $replace['order_no'] = '';
    if(!isset($replace['order_url'])) $replace['order_url'] = '';
    if(!isset($replace['checkout_url'])) $replace['checkout_url'] = '';
    if(!isset($replace['my_orders_url'])) $replace['my_orders_url'] = '';
    if(!isset($replace['last_name'])) $replace['last_name'] = '';
    if(!isset($replace['first_name'])) $replace['first_name'] = '';
    if(!isset($replace['email'])) $replace['email'] = '';
    if(!isset($replace['mobile'])) $replace['mobile'] = '';
    $replace_values = array_values($replace);
    $str = str_replace(array("{{store_name}}","{{store_url}}","{{order_no}}","{{order_url}}","{{checkout_url}}","{{my_orders_url}}","{{last_name}}","{{first_name}}","{{email}}","{{mobile}}"), $replace_values, $str);
    if($is_spin) return spintax_process($str);
    else return $str;
  }

  private function spin_and_replace_notification($str="",$replace = array(),$is_spin=true)
  {
    if(!isset($replace['store_name'])) $replace['store_name'] = '';
    if(!isset($replace['store_url'])) $replace['store_url'] = '';
    if(!isset($replace['order_no'])) $replace['order_no'] = '';
    if(!isset($replace['order_status'])) $replace['order_status'] = '';
    if(!isset($replace['invoice_url'])) $replace['invoice_url'] = '';
    if(!isset($replace['update_note'])) $replace['update_note'] = '';
    if(!isset($replace['last_name'])) $replace['last_name'] = '';
    if(!isset($replace['first_name'])) $replace['first_name'] = '';
    if(!isset($replace['my_orders_url'])) $replace['my_orders_url'] = '';

    $replace_values = array_values($replace);
    $str = str_replace(array("{{store_name}}","{{store_url}}","{{order_no}}","{{order_status}}","{{invoice_url}}","{{update_note}}","{{last_name}}","{{first_name}}","{{my_orders_url}}"), $replace_values, $str);
    if($is_spin) return spintax_process($str);
    else return $str;
  }

  private function send_messenger_reminder($message='',$page_access_token='',$store_id=0,$subscriber_id='')
 	{        
    if(empty($subscriber_id) || strpos($subscriber_id, "sys") !== false){
      return $sent_response = array("response"=> $this->lang->line("Not a Messenger subscriber, message sending was skipped."),"status"=>'1');
    }

    $sent_response = array();
    $this->load->library("fb_rx_login"); 
    try
 		{
 		    $response = $this->fb_rx_login->send_non_promotional_message_subscription($message,$page_access_token);
 		
 		    if(isset($response['message_id']))
 		    {
 		       $sent_response = array("response"=>$response['message_id'],"status"=>'1'); 
 		    }
 		    else 
 		    {
 		        if(isset($response["error"]["message"])) 
 		        $sent_response = array("response"=> $response["error"]["message"],"status"=>'0');              
 		    }              
 		    
 		}
 		catch(Exception $e) 
 		{
 		  $sent_response = array("response"=> $e->getMessage(),"status"=>'0'); 
 		}
 		return $sent_response;
 	}

  private function confirmation_message_sender($cart_id=0,$subscriber_id="")
  {
    if($cart_id==0 || $subscriber_id=="") return false;
    $cart_select = array("ecommerce_cart.*","store_unique_id","page_id","messenger_content","sms_content","sms_api_id","email_content","email_api_id","email_subject","configure_email_table","label_ids","store_name");
    $cart_join = array('ecommerce_store'=>"ecommerce_cart.store_id=ecommerce_store.id,left");
    $cart_where = array('where'=>array("ecommerce_cart.subscriber_id"=>$subscriber_id,"ecommerce_cart.id"=>$cart_id,"ecommerce_store.status"=>"1"));      
    $cart_data_2d = $this->basic->get_data("ecommerce_cart",$cart_where,$cart_select,$cart_join);
    if(!isset($cart_data_2d[0])) return false;      

    $cart_data = $cart_data_2d[0];      

    $store_unique_id = isset($cart_data['store_unique_id'])?$cart_data['store_unique_id']:'';
    $store_id = isset($cart_data['store_id'])?$cart_data['store_id']:'0';
    $user_id = isset($cart_data['user_id'])?$cart_data['user_id']:'0';
    $page_id = isset($cart_data['page_id'])?$cart_data['page_id']:'0';
    $sms_api_id = isset($cart_data['sms_api_id'])?$cart_data['sms_api_id']:'0';
    $sms_content = (isset($cart_data['sms_content']) && !empty($cart_data['sms_content'])) ? json_decode($cart_data['sms_content'],true) : array();
    $email_api_id = isset($cart_data['email_api_id'])?$cart_data['email_api_id']:'0';
    $email_content = (isset($cart_data['email_content']) && !empty($cart_data['email_content'])) ? json_decode($cart_data['email_content'],true) : array();
    $configure_email_table = isset($cart_data['configure_email_table'])?$cart_data['configure_email_table']:'';
    $email_subject = isset($cart_data['email_subject'])?$cart_data['email_subject']:'{{store_name}} | Order Update';
    $messenger_content = (isset($cart_data['messenger_content']) && !empty($cart_data['messenger_content'])) ? json_decode($cart_data['messenger_content'],true) : array();
    $action_type = isset($cart_data['action_type'])?$cart_data['action_type']:'checkout';
    $buyer_first_name = isset($cart_data['buyer_first_name'])?$cart_data['buyer_first_name']:'';
    $buyer_last_name = isset($cart_data['buyer_last_name'])?$cart_data['buyer_last_name']:'';
    $buyer_email = isset($cart_data['buyer_email'])?$cart_data['buyer_email']:'';
    $buyer_mobile = isset($cart_data['buyer_mobile'])?$cart_data['buyer_mobile']:'';
    $buyer_country = isset($cart_data['buyer_country'])?$cart_data['buyer_country']:'-';
    $buyer_state = isset($cart_data['buyer_state'])?$cart_data['buyer_state']:'-';
    $buyer_city = isset($cart_data['buyer_city'])?$cart_data['buyer_city']:'-';
    $buyer_address = isset($cart_data['buyer_address'])?$cart_data['buyer_address']:'-';
    $buyer_zip = isset($cart_data['buyer_zip'])?$cart_data['buyer_zip']:'-';
    $subtotal = isset($cart_data['subtotal'])?$cart_data['subtotal']:0;
    $payment_amount = isset($cart_data['payment_amount'])?$cart_data['payment_amount']:0;
    $currency = isset($cart_data['currency'])?$cart_data['currency']:'USD';
    $shipping = isset($cart_data['shipping'])?$cart_data['shipping']:0;
    $tax = isset($cart_data['tax'])?$cart_data['tax']:0;
    $coupon_code = isset($cart_data['coupon_code'])?$cart_data['coupon_code']:"";
    $discount = isset($cart_data['discount'])?$cart_data['discount']:0;
    $payment_method = isset($cart_data['payment_method'])?$cart_data['payment_method']:"Cash on Delivery";
    $ecom_store_name = isset($cart_data['store_name'])?$cart_data['store_name']:'';

    $checkout_url = base_url("ecommerce/cart/".$cart_id."?subscriber_id=".$subscriber_id);
    $order_url = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id);
    $store_url = base_url("ecommerce/store/".$store_unique_id."?subscriber_id=".$subscriber_id);
    $my_orders_url = base_url("ecommerce/my_orders/".$store_id."?subscriber_id=".$subscriber_id);

    if(empty($buyer_email))$buyer_email = isset($cart_data['bill_email'])?$cart_data['bill_email']:'';
    if(empty($buyer_mobile))$buyer_mobile = isset($cart_data['bill_mobile'])?$cart_data['bill_mobile']:'';

    $cart_info =  $this->basic->get_data("ecommerce_cart_item",array("where"=>array("cart_id"=>$cart_id)),"quantity,product_name,unit_price,coupon_info,attribute_info,thumbnail,product_id",array('ecommerce_product'=>"ecommerce_cart_item.product_id=ecommerce_product.id,left"));
    
    $curdate = date("Y-m-d H:i:s");

    $buyer_mobile = preg_replace("/[^0-9]+/", "", $buyer_mobile);

    $replace_variables = array(
      "store_name"=>$ecom_store_name,
      "store_url"=>$store_url,
      "order_no"=>$cart_id,
      "order_url"=>$order_url,
      "checkout_url"=>$checkout_url,
      "my_orders_url"=>$my_orders_url,
      "first_name"=>$buyer_first_name,
      "last_name"=>$buyer_last_name,
      "email"=>$buyer_email,
      "mobile"=>$buyer_mobile
    );

    $checkout_info = array();
    $confirmation_response = array();
    if($action_type=='checkout')
    { 
      $i=0;
      $elements = array();

      foreach ($cart_info as $key => $value) 
      {
        $elements[$i]['title'] = isset($value['product_name']) ? $value['product_name'] : "";

        $attribute_print = "";
        $attribute_info = json_decode($value["attribute_info"],true);
        if(!empty($attribute_info))
        {
          $attribute_print_tmp = array();
          foreach ($attribute_info as $key2 => $value2)
          {
            $attribute_print_tmp[] = is_array($value2) ? implode('+', array_values($value2)) : $value2;
          }
          $attribute_print = implode(', ', $attribute_print_tmp);
        } 
        
        // $subtitle = array_values(json_decode($value["attribute_info"],true));
        // $subtitle = implode(', ', $subtitle);
        $elements[$i]['subtitle'] = $attribute_print;
        
        $elements[$i]['quantity'] = isset($value['quantity']) ? $value['quantity'] : 1;
        $elements[$i]['price'] = isset($value['unit_price']) ? $value['unit_price'] : 0;
        $elements[$i]['currency'] = $currency;

        if($value['thumbnail']=='') $image_url = base_url('assets/img/products/product-1.jpg');
        else $image_url = base_url('upload/ecommerce/'.$value['thumbnail']);
        $elements[$i]['image_url'] = $image_url;
        $i++;
        $update_sales_count_sql = "UPDATE ecommerce_product SET sales_count=sales_count+".$value["quantity"]." WHERE id=".$value["product_id"];
        $this->basic->execute_complex_query($update_sales_count_sql);
        $update_stock_count_sql = "UPDATE ecommerce_product SET stock_item=stock_item-".$value["quantity"]." WHERE stock_item>0 AND id=".$value["product_id"];
        $this->basic->execute_complex_query($update_stock_count_sql);
      }

      if(empty($buyer_address)) $buyer_address = '-';
      if(empty($buyer_city)) $buyer_city = '-';
      if(empty($buyer_zip)) $buyer_zip = '-';
      if(empty($buyer_state)) $buyer_state = '-';
      if(empty($buyer_country)) $buyer_country = '-';

      if($cart_data['store_pickup']=='0')      
	    $address = array
	    (
	        "street_1" => $buyer_address,
	        "street_2" => "",
	        "city" => $buyer_city,
	        "postal_code" => $buyer_zip,
	        "state" => $buyer_state,
	        "country" => $buyer_country
	    );
      else
      $address = array
      (
          "street_1" => "-",
          "street_2" => "",
          "city" => "-",
          "postal_code" => "-",
          "state" => "-",
          "country" => "-"
      );

	    $recipient_name = $buyer_first_name." ".$buyer_last_name;
	    if(trim($recipient_name=="")) $recipient_name="-";       

      $summary =array
      (
        "subtotal"=> $subtotal,
        "shipping_cost"=>$shipping,
        "total_tax"=> $tax,
        "total_cost"=> $payment_amount
      );

      $adjustments = array
      (
        0 => array
        (
          "name"=> $coupon_code,
          "amount"=> $discount
        )
      );

      $payload = array 
      (
        "template_type" => "receipt",
        "recipient_name"=> $recipient_name,
        "order_number"=> $cart_id,
        "currency"=> $currency,
        "payment_method"=> $payment_method,        
        "order_url"=> $order_url,
        "timestamp"=> time(),
        "address" => $address,
        "summary" => $summary,
        "elements" => $elements
      );
      if($coupon_code!="") $payload['adjustments'] = $adjustments;

      $messenger_checkout_confirmation = array 
      (
        "recipient" => array("id"=>$subscriber_id),
        "messaging_type" => "MESSAGE_TAG",
        "tag" => "POST_PURCHASE_UPDATE",
        'message' => array
        (
          'attachment' => 
          array 
          (
            'type' => 'template',
            'payload' => $payload              
          )
        )           
      );

      // Messenger send block
      $sent_response = array();
      $this->load->library("fb_rx_login"); 
      $page_info = $this->basic->get_data("facebook_rx_fb_page_info",array('where'=>array('id'=>$page_id)));
      $page_access_token = isset($page_info[0]['page_access_token']) ? $page_info[0]['page_access_token'] : "";

      // template 1
      $intro_text = isset($messenger_content["checkout"]["checkout_text"]) ? $messenger_content["checkout"]["checkout_text"] : "";
      if($intro_text!="")
      {
      	$intro_text = $this->spin_and_replace($intro_text,$replace_variables);
      	$messenger_confirmation_template1 = json_encode(array("recipient"=>array("id"=>$subscriber_id),"message"=>array("text"=>$intro_text)));
          $this->send_messenger_reminder($messenger_confirmation_template1,$page_access_token,$store_id,$subscriber_id);
      }

      // template 2
      $messenger_confirmation_template2 = json_encode($messenger_checkout_confirmation);
      $sent_response = $this->send_messenger_reminder($messenger_confirmation_template2,$page_access_token,$store_id,$subscriber_id);
      
      // template 3
      $after_checkout_text = isset($messenger_content["checkout"]["checkout_text_next"]) ? $messenger_content["checkout"]["checkout_text_next"] : "";
      $after_checkout_btn = isset($messenger_content["checkout"]["checkout_btn_next"]) ? $messenger_content["checkout"]["checkout_btn_next"] : "MY ORDERS";
      if($after_checkout_text!="")
      {
      	$after_checkout_text = $this->spin_and_replace($after_checkout_text,$replace_variables);
      	$messenger_confirmation_template3 = array 
          (
    			  "recipient" => array("id"=>$subscriber_id),					  
    			  'message' => array
    			  (
    			  	'attachment' => 
    				  array 
    				  (
    				    'type' => 'template',
    				    'payload' => 
    				    array 
    				    (
    				      'template_type' => 'button',
    				      'text' => $after_checkout_text,
    				      'buttons'=> array(
    				      	0=>array(
    				      		"type"=>"web_url",
    				      		"url"=>$my_orders_url,
    				      		"title"=>$after_checkout_btn,
    				      		"messenger_extensions" => 'true',
    				      		"webview_height_ratio" => 'full'
    				      		)				      	
    				     	)
    				    ),
    				  )
    			  )					  
		     );
			 $this->send_messenger_reminder(json_encode($messenger_confirmation_template3),$page_access_token,$store_id,$subscriber_id);
  		}
      $confirmation_response['messenger'] = $sent_response;
      // Messenger send block


      //  SMS Sending block        
      if($buyer_mobile!="" && $sms_api_id!='0')
      {
        $checkout_text_sms = isset($sms_content['checkout']['checkout_text']) ? $this->spin_and_replace($sms_content['checkout']['checkout_text'],$replace_variables,false) : "";
        $checkout_text_sms = str_replace(array("'",'"'),array('`','`'),$checkout_text_sms);
        
        $sms_response = array("response"=> 'missing param',"status"=>'0');

        if(trim($checkout_text_sms)!="")
        {
          $this->load->library('Sms_manager');
          $this->sms_manager->set_credentioal($sms_api_id,$user_id);
          try
          {
              $response = $this->sms_manager->send_sms($checkout_text_sms, $buyer_mobile);

              if(isset($response['id']) && !empty($response['id']))
              {   
                  $message_sent_id = $response['id'];
                  $sms_response = array("response"=> $message_sent_id,"status"=>'1');              
              }
              else 
              {   if(isset($response['status']) && !empty($response['status']))
              {
                      $message_sent_id = $response["status"];
                      $sms_response = array("response"=> $message_sent_id,"status"=>'0');  
                  }
              }           
              
          }
          catch(Exception $e) 
          {
             $message_sent_id = $e->getMessage();
             $sms_response = array("response"=> $message_sent_id,"status"=>'0');
          }
        }

        $confirmation_response['sms']=$sms_response;
      }
      //  SMS Sending block

      //  Email Sending block
      if($buyer_email!="" && $email_api_id!='0')
      {
        $checkout_text_email = isset($email_content['checkout']['checkout_text']) ? $this->spin_and_replace($email_content['checkout']['checkout_text'],$replace_variables,false) : "";
        $email_subject = $this->spin_and_replace($email_subject,$replace_variables,false);
        $from_email = "";

        if ($configure_email_table == "email_smtp_config") 
        {
          $from_email = "smtp_".$email_api_id;
        } 
        elseif ($configure_email_table == "email_mandrill_config") 
        {
          $from_email = "mandrill_".$email_api_id;
        } 
        elseif ($configure_email_table == "email_sendgrid_config") 
        {
          $from_email = "sendgrid_".$email_api_id;
        } 
        elseif ($configure_email_table == "email_mailgun_config") 
        {
          $from_email = "mailgun_".$email_api_id;
        }

        $email_response = array("response"=> 'missing param',"status"=>'0');  
        if(trim($checkout_text_email)!='')
        {
          try
          {
            $response = $this->_email_send_function($from_email, $checkout_text_email, $buyer_email, $email_subject, $attachement='', $filename='',$user_id);
  
            if(isset($response) && !empty($response) && $response == "Submited")
            {   
              $message_sent_id = $response;
              if($message_sent_id=="Submited") $message_sent_id = "Submitted";
              $email_response = array("response"=> $message_sent_id,"status"=>'1');  
            }
            else 
            {   
              $message_sent_id = $response;
              $email_response = array("response"=> $message_sent_id,"status"=>'0');  
            }           
          }
          catch(Exception $e) 
          {
            $message_sent_id = $e->getMessage();
            $email_response = array("response"=> $message_sent_id,"status"=>'0');  
          }
        }
        $confirmation_response['email']=$email_response;
      }
      //  Email Sending block

    	$confirmation_response = json_encode($confirmation_response);
    	$this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id),array("confirmation_response"=>$confirmation_response));
      if($coupon_code!="")
      {
         $coupon_used_sql = "UPDATE ecommerce_coupon SET used=used+1 WHERE coupon_code='".$coupon_code."' AND store_id=".$store_id;
         $this->basic->execute_complex_query($coupon_used_sql);
      }

    }

    // Email Send to Seller 

    $product_short_name = $this->config->item('product_short_name');
    $from = $this->config->item('institute_email');
    $mask = $this->config->item('product_name');
    $where = array();
    $where['where'] = array('id'=>$user_id);
    $user_email = $this->basic->get_data('users',$where,$select='');

    // echo $this->db->last_query();
    $order_confirmation_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'emcommerce_sale_admin')),array('subject','message'));
    if(isset($order_confirmation_email_template[0]) && $order_confirmation_email_template[0]['subject'] != '' && $order_confirmation_email_template[0]['message'] != '')
    {

      $to = $user_email[0]['email'];
      $url = base_url();

      $subject = str_replace(array('#APP_NAME#','#APP_URL#','#STORE_NAME#','#INVOICE_URL#'),array($mask,$url,$ecom_store_name,$order_url),$order_confirmation_email_template[0]['subject']);

      $message = str_replace(array('#APP_NAME#','#APP_URL#','#STORE_NAME#','#INVOICE_URL#'),array($mask,$url,$ecom_store_name,$order_url),$order_confirmation_email_template[0]['message']);

      //send mail to user
      $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);
    }
    // End of Email Send to Seller



  }

  public function my_orders($store_id=0)
  {
    $where_subs = array();
    $subscriber_id=$this->session->userdata($store_id."ecom_session_subscriber_id");
    $login_needed = false;
    if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$store_id);
    else
    {
      if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);
      if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
    }
    if($subscriber_id=='') $login_needed = true;
    else
    {
      $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");
      if($subscriber_info[0]['total_rows']==0) $login_needed = true;
    }

    $store_data = $this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$store_id)),"store_name,store_unique_id,store_logo,store_favicon,terms_use_link,refund_policy_link,store_locale,pixel_id,google_id,id,user_id");
    if($store_id==0 || !isset($store_data[0]))
    {
    	$not_found = $this->lang->line("Order data not found.");
        echo '<br/><h1 style="text-align:center">'.$not_found.'</h1>';
        exit();
    }
    $this->_language_loader($store_data[0]['store_locale']);
    $data['store_data'] = $store_data[0];
    $data['store_id'] = $store_id;
    $data['subscriber_id'] = $subscriber_id;
    $data['body'] = 'ecommerce/my_orders';
    $data['page_title'] = $this->lang->line('My Orders');
    $data['status_list'] = $this->get_payment_status();
    $data["fb_app_id"] = $this->get_app_id();
    $data['current_cart'] = $this->get_current_cart($subscriber_id,$store_id);
    $data["social_analytics_codes"] = $this->store_locale_analytics($store_data[0]);
    if($login_needed){
      $data['body'] = 'ecommerce/login_to_continue';
      $data['page_title'] = $this->lang->line('Login to Continue');
    }
    $this->load->view('ecommerce/bare-theme', $data);
  }

  public function my_orders_data()
  { 
      $this->ajax_check();

      $search_value = $this->input->post("search_value");
      $subscriber_id = $this->input->post("search_subscriber_id");        
      $store_id = $this->input->post("search_store_id");        
      $search_status = $this->input->post("search_status");        
      $search_date_range = $this->input->post("search_date_range");

      $display_columns = 
      array(
        "#",
        "CHECKBOX",
        "id",        
        'discount',        
        'transaction_id',
        'my_data'
      );
      $search_columns = array('coupon_code','transaction_id','ecommerce_cart.id');

      $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
      $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
      $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
      $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
      $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'ecommerce_cart.id';
      $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
      $order_by=$sort." ".$order;

      if($search_status!="") $this->db->where(array("ecommerce_cart.status"=>$search_status));    
      $where_custom="action_type='checkout' AND ecommerce_cart.subscriber_id = '".$subscriber_id."' AND store_id=".$store_id;

      if($search_value != '') 
      {
          foreach ($search_columns as $key => $value) 
          $temp[] = $value." LIKE "."'%$search_value%'";
          $imp = implode(" OR ", $temp);
          $where_custom .=" AND (".$imp.") ";
      }
      if($search_date_range!="")
      {
          $exp = explode('|', $search_date_range);
          $from_date = isset($exp[0])?$exp[0]:"";
          $to_date = isset($exp[1])?$exp[1]:"";
          if($from_date!="Invalid date" && $to_date!="Invalid date")
          $where_custom .= " AND ecommerce_cart.updated_at >= '{$from_date}' AND ecommerce_cart.updated_at <='{$to_date}'";
      }
      $this->db->where($where_custom);      
      
      $table="ecommerce_cart";
      $select = "ecommerce_cart.id,action_type,ecommerce_cart.user_id,store_id,subscriber_id,coupon_code,coupon_type,discount,payment_amount,currency,ordered_at,transaction_id,card_ending,payment_method,manual_additional_info,manual_filename,paid_at,ecommerce_cart.status,ecommerce_cart.updated_at,ecommerce_store.store_name,status_changed_note";
      $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_cart.store_id,left");
      $info=$this->basic->get_data($table,$where='',$select,$join,$limit,$start,$order_by,$group_by='');
      
      if($search_status!="") $this->db->where(array("ecommerce_cart.status"=>$search_status));
      $this->db->where($where_custom);
      $total_rows_array=$this->basic->count_row($table,$where='',$count=$table.".id",$join,$group_by='');

      $total_result=$total_rows_array[0]['total_rows'];      

      $payment_status = $this->get_payment_status();
      $time=0;
      $currency_position = "left";
      $decimal_point = 0;
      $thousand_comma = '0';
      foreach($info as $key => $value) 
      {
          $time++;
          if($time==1)
          {
              $ecommerce_config = $this->get_ecommerce_config($value["store_id"]);
              $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
              $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
              $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
          }
          
          $config_currency = isset($value['currency']) ? $value['currency'] : "USD";

          if($value['coupon_code']!='')
          $info[$key]['discount']= mec_number_format($info[$key]['discount'],$decimal_point,$thousand_comma);
          else $info[$key]['discount'] = "";

          $payment_amount = $value['currency']." ".mec_number_format($info[$key]['payment_amount'],$decimal_point,$thousand_comma);

          if($info[$key]['payment_method'] == 'Cash on Delivery') $pay = "Cash";
          else $pay = $info[$key]['payment_method'];
          
          $payment_method = $pay." ".$info[$key]['card_ending'];
          if(trim($payment_method)=="") $payment_method = "x";

          $transaction_id = ($info[$key]['transaction_id']!="") ? "<b class='text-primary'>".$info[$key]['transaction_id']."</b>" : "x";

          $updated_at = date("M j,y H:i",strtotime($info[$key]['updated_at']));

          if($value["paid_at"]!='0000-00-00 00:00:00')
          {
            $paid_at = date("M j, y H:i",strtotime($info[$key]['paid_at']));
          }
          else $paid_at = 'x';

          $st1=$st2="";
          $file = base_url('upload/ecommerce/'.$value['manual_filename']);
          $st1 = ($value['payment_method']=='Manual') ? $this->handle_attachment($value['id'], $file,true):"";
          
          if($value['payment_method']=='Manual')
          $st2 = '<a data-id="'.$value['id'].'" href="#" class="dropdown-item has-icon additional_info" itle="" data-original-title="'.$this->lang->line("Additional Info").'"><i class="fas fa-info-circle"></i> '.$this->lang->line("Payment Info").'</a>';
          
          if($value["action_type"]=="checkout") $invoice =  base_url("ecommerce/order/".$value['id']."?subscriber_id=".$subscriber_id);
          else $invoice =  base_url("ecommerce/cart/".$value['id']."?subscriber_id=".$subscriber_id);

          $payment_status = $info[$key]['status'];

          if($payment_status=='pending') $payment_status_badge = "<span class='text-danger'>".$this->lang->line("Pending")."</span>";
          else if($payment_status=='approved') $payment_status_badge = "<span class='text-primary'>".$this->lang->line("Approved")."</span>";
          else if($payment_status=='rejected') $payment_status_badge = "<span class='text-danger'>".$this->lang->line("Rejected")."</span>";
          else if($payment_status=='shipped') $payment_status_badge = "<span class='text-info'>".$this->lang->line("Shipped")."</span>";
          else if($payment_status=='delivered') $payment_status_badge = "<span class='text-info'>".$this->lang->line("Delivered")."</span>";
          else if($payment_status=='completed') $payment_status_badge = "<span class='text-success'>".$this->lang->line("Completed")."</span>";

          $payment_status_note = ($info[$key]['status_changed_note']!='') ? htmlspecialchars($info[$key]['status_changed_note']) : "";

          $info[$key]['my_data'] = '
          <div class="activities">
            <div class="activity">
              <div class="activity-detail w-100 mb-2">
                <div class="mb-2">
                  <span class="text-job">'.$updated_at.'</span>
                  <span class="bullet"></span>
                  <a class="text-job text-primary" href="'.$invoice.'">'." #".$value["id"]." (".$payment_amount.')</a>
                  <div class="float-right dropdown ml-3">
                    <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                    <div class="dropdown-menu">
                      <div class="dropdown-title">'.$this->lang->line("Options").'</div>
                      <a href="'.$invoice.'" class="dropdown-item has-icon"><i class="fas fa-receipt"></i> '.$this->lang->line("Invoice").'</a>
                      '.$st1.'
                      '.$st2.'
                    </div>
                  </div>
                  <span class="float-right text-small">'.$payment_status_badge.'</span>
                </div>
                <p>'.$payment_status_note.'</p>
              </div>
            </div>
          </div>';
          

      }
      $data['draw'] = (int)$_POST['draw'] + 1;
      $data['recordsTotal'] = $total_result;
      $data['recordsFiltered'] = $total_result;
      $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
      echo json_encode($data);
  }


  public function order_list()
  {
    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Store");
    $data['store_list'] = $store_list;
    $data['status_list'] = $this->get_payment_status();
    $data['body'] = 'ecommerce/order_list';
    $data['page_title'] = $this->lang->line('Orders')." : ".$this->session->userdata("ecommerce_selected_store_title");
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }

  public function order_list_data()
  { 
    $this->ajax_check();
    $ecommerce_config = $this->get_ecommerce_config();
    $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
    $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
    $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';

    $search_value = $this->input->post("search_value");
    $store_id = $this->input->post("search_store_id");        
    $search_status = $this->input->post("search_status");        
    $search_date_range = $this->input->post("search_date_range");

    $display_columns = 
    array(
      "#",
      "CHECKBOX",
      "subscriber_id",
      'store_name',
      'status',
      'discount',
      'payment_amount',
      'currency',
      'invoice',
      'transaction_id',
      'manual_filename',
      'payment_method',
      'updated_at',
      'paid_at'
    );
    $search_columns = array('subscriber_id','coupon_code','transaction_id');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 11;
    $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'updated_at';
    $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
    $order_by=$sort." ".$order;

    if($store_id!="") $this->db->where(array("store_id"=>$store_id));    
    if($search_status!="") $this->db->where(array("ecommerce_cart.status"=>$search_status));  
    $where_custom="ecommerce_cart.user_id = ".$this->user_id;

    if ($search_value != '') 
    {
        foreach ($search_columns as $key => $value) 
        $temp[] = $value." LIKE "."'%$search_value%'";
        $imp = implode(" OR ", $temp);
        $where_custom .=" AND (".$imp.") ";
    }
    if($search_date_range!="")
    {
        $exp = explode('|', $search_date_range);
        $from_date = isset($exp[0])?$exp[0]:"";
        $to_date = isset($exp[1])?$exp[1]:"";
        if($from_date!="Invalid date" && $to_date!="Invalid date")
        $where_custom .= " AND ecommerce_cart.updated_at >= '{$from_date}' AND ecommerce_cart.updated_at <='{$to_date}'";
    }
    $this->db->where($where_custom);      
    
    $table="ecommerce_cart";
    $select = "ecommerce_cart.id,ecommerce_cart.user_id,store_id,subscriber_id,coupon_code,coupon_type,discount,payment_amount,currency,ordered_at,transaction_id,card_ending,payment_method,manual_additional_info,manual_filename,paid_at,ecommerce_cart.status,ecommerce_cart.updated_at,ecommerce_store.store_name";
    // $select = "ecommerce_cart.*,ecommerce_store.store_name";
    $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_cart.store_id,left");
    $info=$this->basic->get_data($table,$where='',$select,$join,$limit,$start,$order_by,$group_by='');
    
    $last_query = $this->db->last_query();
    $xp1 = explode('WHERE', $last_query);
    $xp2 = isset($xp1[1]) ? explode('ORDER', $xp1[1]) : array();
    $latest_order_list_sql = isset($xp2[0]) ? $xp2[0] : "";
    $this->session->set_userdata("latest_order_list_sql",$latest_order_list_sql);
    
    if($store_id!="") $this->db->where(array("store_id"=>$store_id));    
    if($search_status!="") $this->db->where(array("ecommerce_cart.status"=>$search_status));  
    $this->db->where($where_custom);
    $total_rows_array=$this->basic->count_row($table,$where='',$count=$table.".id",$join,$group_by='');

    $total_result=$total_rows_array[0]['total_rows'];
    

    $payment_status = $this->get_payment_status();
    foreach($info as $key => $value) 
    {
        $config_currency = isset($value['currency']) ? $value['currency'] : "USD";
        // $info[$key]['currency']= isset($this->currency_icon[$config_currency]) ? $this->currency_icon[$config_currency] : "$";

        $info[$key]['subscriber_id']= "<a target='_BLANK' href='".base_url("subscriber_manager/bot_subscribers/".$info[$key]['subscriber_id'])."'>".$info[$key]['subscriber_id']."</a>";

        if($value['coupon_code']!='')
        $info[$key]['discount']= mec_number_format($info[$key]['discount'],$decimal_point,$thousand_comma);
        else $info[$key]['discount'] = "";

        $info[$key]['payment_amount'] = mec_number_format($info[$key]['payment_amount'],$decimal_point,$thousand_comma);
        $info[$key]['payment_method'] = $info[$key]['payment_method']." ".$info[$key]['card_ending'];
        if(trim($info[$key]['payment_method'])=="") $info[$key]['payment_method'] = "x";

        $info[$key]['transaction_id'] = ($info[$key]['transaction_id']!="") ? "<b class='text-primary'>".$info[$key]['transaction_id']."</b>" : "x";

        $updated_at = date("M j, y H:i",strtotime($info[$key]['updated_at']));
        $info[$key]['updated_at'] =  "<div style='min-width:110px;'>".$updated_at."</div>";

        if($value["paid_at"]!='0000-00-00 00:00:00')
        {
          $paid_at = date("M j, y H:i",strtotime($info[$key]['paid_at']));
          $info[$key]['paid_at'] =  "<div style='min-width:110px;'>".$paid_at."</div>";
        }
        else $info[$key]['paid_at'] = 'x';

        $st1=$st2="";
        $file = base_url('upload/ecommerce/'.$value['manual_filename']);
        $st1 = ($value['payment_method']=='Manual') ? $this->handle_attachment($value['id'], $file):"";
        
        if($value['payment_method']=='Manual')
        $st2 = ' <a data-id="'.$value['id'].'" href="#"  class="btn btn-outline-primary additional_info" data-toggle="tooltip" title="" data-original-title="'.$this->lang->line("Additional Info").'"><i class="fas fa-info-circle"></i></a>';            

    	  $info[$key]['manual_filename'] = ($st1=="" && $st2=="") ? "x" : "<div style='width:100px;'>".$st1.$st2."</div>"; 
        
        $info[$key]['status'] = form_dropdown('payment_status', $payment_status, $value["status"],'class="select2 payment_status" style="width:120px !important;" data-id="'.$value["id"].'" id="payment_status'.$value['id'].'"').'<script>$("#payment_status'.$value['id'].'").select2();$(\'[data-toggle="tooltip"]\').tooltip();</script>';
        
        $info[$key]['invoice'] =  "<a class='btn btn-outline-primary' data-toggle='tooltip' title='".$this->lang->line("Invoice")."' target='_BLANK' href='".base_url("ecommerce/order/".$value['id'])."'><i class='fas fa-receipt'></i></a>";

    }
    $data['draw'] = (int)$_POST['draw'] + 1;
    $data['recordsTotal'] = $total_result;
    $data['recordsFiltered'] = $total_result;
    $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
    echo json_encode($data);
  }

  public function addtional_info_modal_content()
  {
  	$this->ajax_check();
  	$cart_id = $this->input->post("cart_id",true);
  	$cart_data = $this->basic->get_data("ecommerce_cart",array("where"=>array("id"=>$cart_id)),"manual_additional_info,manual_currency,manual_amount,paid_at,user_id");
  	$currency = isset($cart_data[0]["manual_currency"]) ? $cart_data[0]["manual_currency"] : "";
  	$manual_amount = isset($cart_data[0]["manual_amount"]) ? $cart_data[0]["manual_amount"] : "0";
    $store_id = isset($cart_data[0]["store_id"]) ? $cart_data[0]["store_id"] : "";
  	$manual_additional_info = isset($cart_data[0]["manual_additional_info"]) ? $cart_data[0]["manual_additional_info"] : "";
  	$paid_at = isset($cart_data[0]["paid_at"]) ? date("M j, y H:i",strtotime($cart_data[0]["paid_at"])) : "";
  	// echo $this->db->last_query();

    $ecommerce_config = $this->get_ecommerce_config($store_id);
    $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
    $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
    $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';

  	echo '<div class="list-group">
            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">'.$this->lang->line("Paid Amount").' : '.$currency.' '.mec_number_format($manual_amount,$decimal_point,$thousand_comma).'</h5>
              </div>
            </a>
            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">'.$this->lang->line("Description").' : '.'</h5>
              </div>
              <p class="mb-1">'.$manual_additional_info.'</p>
            </a>
            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">'.$this->lang->line("Paid at").' : '.$paid_at.'</h5>
              </div>
            </a>
          </div>';
  }

  public function change_payment_status()
  {
    $this->ajax_check();
    $id = $this->input->post("table_id",true);
    $payment_status = $this->input->post("payment_status",true);
    $status_changed_note = strip_tags($this->input->post("status_changed_note",true));
    $update_data = array("status"=>$payment_status,"status_changed_at"=>date("Y-m-d H:i:s"));
    $update_data['status_changed_note'] = $status_changed_note;

    $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_cart.store_id,left");;
    $cart_data = $this->basic->get_data('ecommerce_cart',array("where"=>array("ecommerce_cart.id"=>$id)),"buyer_email,buyer_mobile,buyer_first_name,buyer_last_name,bill_email,bill_mobile,ecommerce_cart.id,subscriber_id,page_id,store_name,store_unique_id,ecommerce_store.id as store_id,notification_message,notification_sms_api_id,notification_email_api_id,notification_email_subject,notification_configure_email_table",$join);
    if(!isset($cart_data[0]))
    {
      echo json_encode(array('status'=>'1','message'=>$this->lang->line("Order data not found.")));
      exit();
    }
    $user_id = $this->user_id;
    $page_id = $cart_data[0]['page_id'];
    $subscriber_id = $cart_data[0]['subscriber_id'];
    $last_name = $cart_data[0]['buyer_last_name'];
    $first_name = $cart_data[0]['buyer_first_name'];
    $email = $cart_data[0]['buyer_email'];
    $mobile = $cart_data[0]['buyer_mobile'];
    $store_name = $cart_data[0]['store_name'];
    $order_no = $cart_data[0]['id'];
    $store_url = base_url("ecommerce/store/".$cart_data[0]['store_unique_id']."?subscriber_id=".$subscriber_id);
    $invoice_url = base_url("ecommerce/cart/".$order_no."?subscriber_id=".$subscriber_id);
    $order_url = base_url("ecommerce/order/".$order_no."?subscriber_id=".$subscriber_id);
    $my_orders_url = base_url("ecommerce/my_orders/".$cart_data[0]['store_id']."?subscriber_id=".$subscriber_id);
    $notification_sms_api_id = $cart_data[0]['notification_sms_api_id'];
    $notification_email_api_id = $cart_data[0]['notification_email_api_id'];
    $notification_email_subject = $cart_data[0]['notification_email_subject'];
    $notification_configure_email_table = $cart_data[0]['notification_configure_email_table'];
    if($notification_email_subject=="") $notification_email_subject = "{{store_name}} | Order Update";
    if(empty($email))$email = isset($cart_data[0]['bill_email'])?$cart_data[0]['bill_email']:'';
    if(empty($mobile))$mobile = isset($cart_data[0]['bill_mobile'])?$cart_data[0]['bill_mobile']:'';
    $api_response = array();

    if($this->basic->update_data("ecommerce_cart",array("id"=>$id,"user_id"=>$user_id),$update_data))
    {      
      $notification_default = $this->notification_default();
      $notification_message = json_decode($cart_data[0]['notification_message'],true);
      $messenger_text = isset($notification_message['messenger'][$payment_status]['text']) ? $notification_message['messenger'][$payment_status]['text'] : $notification_default['messenger'];
      $messenger_btn = isset($notification_message['messenger'][$payment_status]['btn']) ? $notification_message['messenger'][$payment_status]['btn'] : 'MY ORDERS';

      $replace_variables = array("store_name"=>$store_name,"store_url"=>$store_url,"order_no"=>$order_no,"order_status"=>$payment_status,"invoice_url"=>$invoice_url,"update_note"=>$status_changed_note,"last_name"=>$last_name,"first_name"=>$first_name,"my_orders_url"=>$my_orders_url); 
      
      //  Messenger Sending block  
      $page_info = $this->basic->get_data("facebook_rx_fb_page_info",array('where'=>array('id'=>$page_id)),"page_access_token");
      $page_access_token = isset($page_info[0]['page_access_token']) ? $page_info[0]['page_access_token'] : "";

      //  Messenger Sending block  
      if($messenger_text!="")
      {
        $api_response['messenger'] = array("status"=>0,"response"=>"unknown");
        $messenger_text = $this->spin_and_replace_notification($messenger_text,$replace_variables);
        $messenger_confirmation_template = array 
          (
            "recipient" => array("id"=>$subscriber_id),
            "messaging_type" => "MESSAGE_TAG",
            "tag" => "POST_PURCHASE_UPDATE",        
            'message' => array
            (
              'attachment' => 
              array 
              (
                'type' => 'template',
                'payload' => 
                array 
                (
                  'template_type' => 'button',
                  'text' => $messenger_text,
                  'buttons'=> array(
                    0=>array(
                      "type"=>"web_url",
                      "url"=>$my_orders_url,
                      "title"=>$messenger_btn,
                      "messenger_extensions" => 'true',
                      "webview_height_ratio" => 'full'
                      )               
                  )
                ),
              )
            )           
         );
        $api_response['messenger'] = $this->send_messenger_reminder(json_encode($messenger_confirmation_template),$page_access_token,$cart_data[0]['store_id'],$subscriber_id);
      }
      //  Messenger Sending block  


      //  SMS Sending block        
      if($mobile!="" && $notification_sms_api_id!='0')
      {
        $sms_text = isset($notification_message['sms'][$payment_status]) ? $notification_message['sms'][$payment_status] : $notification_default['sms'];
        // $sms_text = str_replace(array("'",'"'),array('`','`'),$sms_text);
        $sms_text = $this->spin_and_replace_notification($sms_text,$replace_variables);
        
        $api_response['sms'] = array("response"=> 'missing param',"status"=>'0');

        if(trim($sms_text)!="")
        {
          $this->load->library('Sms_manager');
          $this->sms_manager->set_credentioal($notification_sms_api_id,$user_id);
          try
          {
              $response = $this->sms_manager->send_sms($sms_text, $mobile);

              if(isset($response['id']) && !empty($response['id']))
              {   
                  $message_sent_id = $response['id'];
                  $sms_response = array("response"=> $message_sent_id,"status"=>'1');              
              }
              else 
              {   if(isset($response['status']) && !empty($response['status']))
              {
                      $message_sent_id = $response["status"];
                      $sms_response = array("response"=> $message_sent_id,"status"=>'0');  
                  }
              }           
              
          }
          catch(Exception $e) 
          {
             $message_sent_id = $e->getMessage();
             $sms_response = array("response"=> $message_sent_id,"status"=>'0');
          }
          $api_response['sms']=$sms_response;
        }

      }
      //  SMS Sending block



      //  Email Sending block
      if($email!="" && $notification_email_api_id!='0')
      {
        $email_text = isset($notification_message['email'][$payment_status]) ? $notification_message['email'][$payment_status] : $notification_default['email'];
        $email_text = $this->spin_and_replace_notification($email_text,$replace_variables);
        $notification_email_subject = $this->spin_and_replace_notification($notification_email_subject,$replace_variables);
        $from_email = "";

        if ($notification_configure_email_table == "email_smtp_config") 
        {
          $from_email = "smtp_".$notification_email_api_id;
        } 
        elseif ($notification_configure_email_table == "email_mandrill_config") 
        {
          $from_email = "mandrill_".$notification_email_api_id;
        } 
        elseif ($notification_configure_email_table == "email_sendgrid_config") 
        {
          $from_email = "sendgrid_".$notification_email_api_id;
        } 
        elseif ($notification_configure_email_table == "email_mailgun_config") 
        {
          $from_email = "mailgun_".$notification_email_api_id;
        }

        $email_response = array("response"=> 'missing param',"status"=>'0');  
        if(trim($email_text)!='')
        {
          try
          {
            $response = $this->_email_send_function($from_email, $email_text, $email, $notification_email_subject, $attachement='', $filename='',$user_id);
    
            if(isset($response) && !empty($response) && $response == "Submited")
            {   
              $message_sent_id = $response;
              if($message_sent_id=="Submited") $message_sent_id = "Submitted";
              $email_response = array("response"=> $message_sent_id,"status"=>'1');  
            }
            else 
            {   
              $message_sent_id = $response;
              $email_response = array("response"=> $message_sent_id,"status"=>'0');  
            }           
          }
          catch(Exception $e) 
          {
            $message_sent_id = $e->getMessage();
            $email_response = array("response"=> $message_sent_id,"status"=>'0');  
          }
        }
        $api_response['email']=$email_response;
      }
      //  Email Sending block

      $api_response_formatted = '';
      if(!empty($api_response))
      {
        $api_response_formatted .= "<h6>".$this->lang->line("Notification API Response")."</h6>";
        $api_response_formatted .= "<div class='table-responsive'>";
        $api_response_formatted .= "<table class='table table-bordered table-sm table-striped table-hover'>";
      }

      foreach ($api_response as $key => $value)
      {
        if($value['status']=='1') $api_status = "<span class='badge badge-success'><i class='fas fa-check-circle'></i> ".$this->lang->line("Success")."</span>";
        else $api_status = "<span class='badge badge-danger'><i class='fas fa-times-circle'></i> ".$this->lang->line("Error")."</span>";

        $api_response_formatted .= "<tr class='text-center'>";
        $api_response_formatted .= "<td>".$this->lang->line($key)."</td>";
        $api_response_formatted .= "<td>".$api_status."</td>";
        $api_response_formatted .= "<td>".$value['response']."</td>";
        $api_response_formatted .= "</tr>";
      }

      if(!empty($api_response))
      {
        $api_response_formatted .= "</table>";
        $api_response_formatted .= "</div>";
      }     

      echo json_encode(array('status'=>'1','message'=>$this->lang->line("Payment status has been updated successfully.")."<br><br><br>".$api_response_formatted."</pre>"));
    }
    else echo json_encode(array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try again.")));
  }

  public function reminder_send_status_data()
  { 
    $this->ajax_check();

    $data_days = 30; 
    $from_date = $this->session->userdata("ecommerce_from_date");
    $to_date = $this->session->userdata("ecommerce_to_date");
    if($to_date=='') $to_date = date("Y-m-d");
    if($from_date=='') $from_date = date("Y-m-d",strtotime("$to_date - ".$data_days." days"));

    $search_value = $_POST['search']['value'];
    $page_id = $this->input->post("page_id",true);

    $display_columns = 
    array(
      "#",
      "CHECKBOX",
      'first_name',
      'last_name',
      'email',
      'subscriber_id',
      'last_completed_hour',
      'sent_at',
      'response',
      'cart_id'
    );
    $search_columns = array('first_name','last_name','subscriber_id');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 7;
    $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'sent_at';
    $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
    $order_by=$sort." ".$order;

    $where_custom="user_id = ".$this->user_id." AND store_id = ".$this->session->userdata('ecommerce_selected_store')." AND sent_at >= '".$from_date."' AND sent_at <= '".$to_date."'";      

    if ($search_value != '') 
    {
        foreach ($search_columns as $key => $value) 
        $temp[] = $value." LIKE "."'%$search_value%'";
        $imp = implode(" OR ", $temp);
        $where_custom .=" AND (".$imp.") ";
    }
 
    $this->db->where($where_custom);
    
    $table="ecommerce_reminder_report";
    $info=$this->basic->get_data($table,$where='',$select='',$join='',$limit,$start,$order_by,$group_by='');
    // echo $this->db->last_query();

    $this->db->where($where_custom);
    $total_rows_array=$this->basic->count_row($table,$where='',$count=$table.".id",$join='',$group_by='');

    $total_result=$total_rows_array[0]['total_rows'];

    foreach($info as $key => $value) 
    {
        if($info[$key]['is_sent']=='1' && $info[$key]['sent_at'] != "0000-00-00 00:00:00")
        $sent_time = date("M j, y H:i",strtotime($info[$key]['sent_at']));
        else $sent_time = '<span class="text-muted"><i class="fas fa-exclamation-circle"></i> '.$this->lang->line("Not Sent")."<span>";
        $info[$key]['sent_at'] =  $sent_time;

        $info[$key]['subscriber_id'] =  "<a href='".base_url("subscriber_manager/bot_subscribers/".$info[$key]['subscriber_id'])."' target='_BLANK'>".$info[$key]['subscriber_id']."</a>";
        
        $last_updated_at = date("M j, y H:i",strtotime($info[$key]['last_updated_at']));
        $info[$key]['last_updated_at'] =  $last_updated_at;

        $info[$key]['response'] =  "<a class='btn btn-sm btn-outline-primary woo_error_log' href='' data-id='".$info[$key]['id']."'><i class='fas fa-plug'></i> ".$this->lang->line('Response')."</a>";
        $info[$key]['cart_id'] =  "<a target='_BLANK' href='".base_url('ecommerce/order/'.$info[$key]['id'])."'>".$this->lang->line('Order').'#'.$info[$key]['id']."</a>";
    }
    $data['draw'] = (int)$_POST['draw'] + 1;
    $data['recordsTotal'] = $total_result;
    $data['recordsFiltered'] = $total_result;
    $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
    echo json_encode($data);
  }

  public function reminder_response()
  {
    $this->ajax_check();
    $id = $this->input->post('id',true);
    $getdata = $this->basic->get_data("ecommerce_reminder_report",array("where"=>array("id"=>$id,"user_id"=>$this->user_id)),"sent_response");
    $response = isset($getdata[0]['sent_response']) ? $getdata[0]['sent_response'] : '';

    if(is_array(json_decode($response,true))) 
    {
        echo "<div class='list-group'>";
        $response = json_decode($response,true);
        foreach ($response as $key => $value) 
        {
          if($key=="messenger")
          {
            foreach ($value as $key2 => $value2) 
            {                  

              $tmp_heading = strtoupper($key)." : ".$key2;
              $tmp_status = (isset($value2['status']) && $value2['status']=='1') ? '<small class="text-success">'."SUCCESS".'</small>' : '<small class="text-danger">'."ERROR".'</small>';
              $tmp_response = isset($value2['response']) ? $value2['response'] : "";
              echo '
                <a  class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1" style="font-size: 1rem;">'.$tmp_heading.'</h5>
                  '.$tmp_status.'
                </div>
                <p class="mb-1 text-left" style="font-size: 12px;">'.$tmp_response.'</p>
              </a>';
            }
          }
          else
          {
              $tmp_heading = strtoupper($key);
              $tmp_status = (isset($value['status']) && $value['status']=='1') ? '<small class="text-success">'."SUCCESS".'</small>' : '<small class="text-danger">'."ERROR".'</small>';
              $tmp_response = isset($value['response']) ? $value['response'] : "";
              echo '
                <a  class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1" style="font-size: 1rem;">'.$tmp_heading.'</h5>
                  '.$tmp_status.'
                </div>
                <p class="mb-1 text-left" style="font-size: 12px;">'.$tmp_response.'</p>
              </a>';
          }
        }
        echo "</div>";
    } 
  }    

  public function add_store()
  {
    $data['body'] = 'ecommerce/store_add';
    $data['page_title'] = $this->lang->line("Create Store");
    $data['page_info'] = $this->get_user_page();
    
    $data['country_names'] = $this->get_country_names();
    $data['currency_icons'] = $this->currency_icon();
    $data['get_ecommerce_config'] = $this->get_ecommerce_config();
    $data['locale_list'] = $this->_language_list();
    $data["iframe"]="1";
    $this->_viewcontroller($data);    
    
  }

  public function add_store_action()
  {
    $this->ajax_check();
    $status=$this->_check_usage($module_id=268,$request=1);
    if($status=="3")  //monthly limit is exceeded, can not create another campaign this month
    {
        echo json_encode(array("status" => "0", "message" =>$this->lang->line("Limit has been exceeded. You can can not create more stores.")));
        exit();
    }

    $post=$_POST;

    $tag_allowed = array("terms_use_link","refund_policy_link");
    foreach ($post as $key => $value) 
    {
      if(!is_array($value) && !in_array($key, $tag_allowed)) $temp = strip_tags($value);
      else $temp = $value;
      $$key=$this->security->xss_clean($temp);
    }
    
    $created_at = date("Y-m-d H:i:s");    $store_unique_id = $this->user_id.time();
    if($this->basic->is_exist("ecommerce_store",array("store_unique_id"=>$store_unique_id))) 
    {
        echo json_encode(array("status" => "0", "message" =>$this->lang->line("Something went wrong, please try again.")));
        exit();
    }
  
    $this->db->trans_start(); 

    if(!isset($label_ids)) $label_ids=array();
    if(!isset($status) || $status=='') $status='0';

    $reminder_default = $this->reminder_default();
    $messenger_content = array
    (
      "checkout"=>array
      (
        "checkout_text"=>$reminder_default['messenger']['checkout']['checkout_text'],
        "checkout_text_next" => $reminder_default['messenger']['checkout']['checkout_text_next'],
        "checkout_btn_next"=>"MY ORDERS"
      )
    );
    if($refund_policy_link=="<p></p>") $refund_policy_link="";
    if($terms_use_link=="<p></p>") $terms_use_link="";
    $insert_data = array(
      "user_id"=>$this->user_id,
      "page_id"=>$page,
      "created_at"=>$created_at,
      "store_unique_id"=>$store_unique_id,
      "store_name"=>$store_name,
      "store_logo"=>$store_logo,
      "store_favicon"=>$store_favicon,
      "store_email"=> $store_email,
      "store_phone"=> $store_phone,
      "store_country"=> $store_country,
      "store_state"=> $store_state,
      "store_city"=> $store_city,
      "store_zip"=> $store_zip,
      "store_address"=> $store_address,
      "refund_policy_link"=> strip_tags($refund_policy_link,$this->editor_allowed_tags),
      "terms_use_link"=> strip_tags($terms_use_link,$this->editor_allowed_tags),
      "store_locale"=> $store_locale,
      "pixel_id"=> $pixel_id,
      "google_id"=> $google_id,
      "status"=> $status,
      "label_ids"=>implode(',',$label_ids),
      "messenger_content"=>json_encode($messenger_content),
      "manual_enabled"=>"0",
      "cod_enabled"=>"1"
    );   
    $this->basic->insert_data("ecommerce_store",$insert_data);
    $insert_id = $this->db->insert_id();
    $this->_insert_usage_log($module_id=268,$request=1);
    $this->db->trans_complete();

    if($this->db->trans_status() === false)
    {
         echo json_encode(array('status'=>'0','message'=>"".$this->lang->line('Something went wrong, please try again.')));
         exit();
    }
    else
    {
        $this->session->set_userdata("ecommerce_selected_store",$insert_id);
        echo json_encode(array('status'=>'1','message'=>$this->lang->line('Store has been created successfully.')));
        exit();
    } 
  }


  private function reminder_default()
  {
    return array
    (
      'messenger' => array
      (
        'reminder' =>array
        (
          'reminder_text' => 'Hi {{first_name}},
You wanted to buy something! Seems like you have forgotten.',
          'reminder_text_checkout' => 'Stock limited, complete your order before it is out of stock.'
        ),
        'checkout' =>array
        (
          'checkout_text' => 'Congratulations {{first_name}}!
Thanks for shopping from our store. You made the right choice. If you need any information, just leave us a message here.',
          'checkout_text_next' => 'You can see your order history and status here.'
        )        
      ),
      'sms' => array
      (
        'reminder' =>array('reminder_text' => 'Hi, you wanted to buy something! Seems like you have forgotten : {{order_url}}
{{store_name}}'),
        'checkout' =>array('checkout_text' => 'Thanks for shopping from our store. You made the right choice.
{{store_name}}')
      ),
      'email' => array
      (
        'reminder' =>array('reminder_text' => 'Hi {{first_name}},<br>You wanted to buy something! Seems like you have forgotten. Stock limited, complete your order before it is out of stock : <a href="{{checkout_url}}" target="_blank">Checkout here</a><br><br>Happy shopping :)<br><a href="{{store_url}}" target="_blank">{{store_name}}</a> Team'),
        'checkout' =>array('checkout_text' => 'Congratulations {{first_name}}!<br>Thanks for shopping from our store. You made the right choice. If you need any information, just leave us a message here.<br><br>You can see your order history and status <a href="{{my_orders_url}}" target="_blank"> clicking here</a>. <br><br>Have a nice day :)<br><a href="{{store_url}}" target="_blank">{{store_name}}</a> Team')
      )
    );
  }
  public function reminder_settings($id=0)
  {
    if($id==0) exit();
    $data['body'] = 'ecommerce/reminder_settings';
    $data['page_title'] = $this->lang->line("Reminder Settings");
    $data['page_info'] = $this->get_user_page();
    
    $data['how_many_reminder'] = 3;
    $data['hours'] = $this->get_reminder_hour();

    $data['sms_option'] = $this->get_sms_api();
    $data['email_option'] = $this->get_email_api();
    $data['country_names'] = $this->get_country_names();
    $data['currency_icons'] = $this->currency_icon();
    $data['get_ecommerce_config'] = $this->get_ecommerce_config();
    $data['reminder_default'] = $this->reminder_default();

    $xdata=$this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$id,"user_id"=>$this->user_id)));
    if(!isset($xdata[0])) exit();
    $data['xdata']=$xdata[0];
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }

  public function reminder_settings_action()
  {
    $this->ajax_check();
    $post=$_POST;

    $tag_allowed = array("email_reminder_text_checkout_next");
    foreach ($post as $key => $value) 
    {
      if(!is_array($value) && !in_array($key, $tag_allowed)) $temp = strip_tags($value);
      else $temp = $value;
      $$key=$this->security->xss_clean($temp);
    }
        
    $messenger_content = array();
    $sms_content = array();
    $email_content = array();
    $created_at = date("Y-m-d H:i:s");
    $insert_data2 = array();
    $reminder_default = $this->reminder_default();
    
    foreach ($msg_reminder_time as $key => $value) 
    {
      $i=$key;
      $j=$i+1;
      if($value!="")
      {            
        $tmp_msg_reminder_text = isset($msg_reminder_text[$i]) ? $msg_reminder_text[$i] : $reminder_default['messenger']['reminder']['reminder_text'];
        $tmp_msg_reminder_btn_details = isset($msg_reminder_btn_details[$i]) ? strtoupper($msg_reminder_btn_details[$i]) : "VISIT DETAILS";
        $tmp_msg_reminder_text_checkout = isset($msg_reminder_text_checkout[$i]) ? $msg_reminder_text_checkout[$i] : $messenger_content['reminder'][$i]['reminder_text_checkout'];
        $tmp_msg_reminder_btn_checkout = isset($msg_reminder_btn_checkout[$i]) ? strtoupper($msg_reminder_btn_checkout[$i]) : "CHECKOUT NOW";
        $messenger_content['reminder'][$j] = array('hour'=>$value,"reminder_text"=>$tmp_msg_reminder_text,"reminder_btn_details"=>$tmp_msg_reminder_btn_details,"reminder_text_checkout"=>$tmp_msg_reminder_text_checkout,"reminder_btn_checkout"=>$tmp_msg_reminder_btn_checkout);
        $anything_found = true;
      }          
    }
    if($msg_checkout_text=="") $msg_reminder_text_checkout_next=$reminder_default['messenger']['checkout']['checkout_text'];
    if($msg_reminder_text_checkout_next=="") $msg_reminder_text_checkout_next=$reminder_default['messenger']['checkout']['checkout_text_next'];
    $messenger_content['checkout'] = array("checkout_text"=>$msg_checkout_text,"checkout_text_next"=>$msg_reminder_text_checkout_next,"checkout_btn_next"=>strtoupper($msg_checkout_btn_website));
    $insert_data2['messenger_content'] = json_encode($messenger_content);

    if($this->session->userdata('user_type') == 'Admin' || in_array(264,$this->module_access))
    {
      foreach ($sms_reminder_time as $key => $value) 
      {
        $i=$key;
        $j=$i+1;
        if($value!="")
        {           
          $temp_sms_reminder_text_checkout = isset($sms_reminder_text_checkout[$i]) ? $sms_reminder_text_checkout[$i] : "";
          $sms_content['reminder'][$j] = array('hour'=>$value,"reminder_text"=>$temp_sms_reminder_text_checkout);
          $anything_found = true;
        }
        
      }
      $sms_content['checkout'] = array("checkout_text"=>$sms_reminder_text_checkout_next);
      if(isset($sms_api_id) && $sms_api_id!="")
      {
        $insert_data2['sms_api_id'] = $sms_api_id;
        $insert_data2['sms_content'] = json_encode($sms_content);
      }
    }

    if($this->session->userdata('user_type') == 'Admin' || in_array(263,$this->module_access))
    {
      foreach ($email_reminder_time as $key => $value) 
      {
        $i=$key;  
        $j=$i+1; 
        if($value!="")
        {           
          $tmp_email_reminder_text_checkout = isset($email_reminder_text_checkout[$i]) ? $email_reminder_text_checkout[$i] : "";
          $email_content['reminder'][$j] = array('hour'=>$value,"reminder_text"=>$tmp_email_reminder_text_checkout);
          $anything_found = true;
        }
        
      }
      $email_content['checkout'] = array("checkout_text"=>$email_reminder_text_checkout_next);
      if(isset($email_api_id) && $email_api_id!="")
      {
        if($email_subject=="") $email_subject = "{{store_name}} | Order Update";
        $exp = explode('-', $email_api_id);
        $insert_data2['configure_email_table'] = isset($exp[0]) ? $exp[0] : '';
        $insert_data2['email_api_id'] = isset($exp[1]) ? $exp[1] : 0;
        $insert_data2['email_content'] = json_encode($email_content);
        $insert_data2['email_subject'] = $email_subject;
      }
    }
  
    $this->db->trans_start(); 
       
    $this->basic->update_data("ecommerce_store",array("id"=>$hidden_id,"user_id"=>$this->user_id),$insert_data2);
    $this->db->trans_complete();

    if($this->db->trans_status() === false)
    {
         echo json_encode(array('status'=>'0','message'=>"".$this->lang->line('Something went wrong, please try again.')));
         exit();
    }
    else
    {
        echo json_encode(array('status'=>'1','message'=>$this->lang->line('Confirmation and reminder messages have been updated successfully.')));
        exit();
    } 
  }

  public function qr_code($id=0)
  {
    if($id==0) exit();
    $data['body'] = 'ecommerce/qr_code';
    $data['page_title'] = $this->lang->line("Contactless QR Menu");
    $xdata=$this->basic->get_data("ecommerce_store",array("where"=>array("ecommerce_store.id"=>$id,"ecommerce_store.user_id"=>$this->user_id)),'ecommerce_store.id,qr_code,store_unique_id,facebook_rx_fb_page_info.page_id as fb_page_id,ecommerce_store.page_id as page_auto_id,facebook_rx_fb_user_info_id',array('facebook_rx_fb_page_info'=>"facebook_rx_fb_page_info.id=ecommerce_store.page_id,left"));
    if(!isset($xdata[0])) exit();
    $data['xdata']=$xdata[0];
    $data["iframe"]="1";

    $this->load->library('quick_response_code');
    $page_id  = $xdata[0]['fb_page_id'];
    $reference  = "ecomqrmelink01-store-".$xdata[0]["store_unique_id"];
    $qr_code = json_decode($xdata[0]['qr_code'],true);
    $msg_fore_color = isset($qr_code['msg_fore_color']) ? $qr_code['msg_fore_color'] : "#000000";
    $msg_back_color = isset($qr_code['msg_back_color']) ? $qr_code['msg_back_color'] : "#FFFFFF";
    $out_fore_color = isset($qr_code['out_fore_color']) ? $qr_code['out_fore_color'] : "#000000";
    $out_back_color = isset($qr_code['out_back_color']) ? $qr_code['out_back_color'] : "#FFFFFF";

    $msg_fore_color = hexdec(str_replace('#', '', $msg_fore_color));
    $msg_back_color = hexdec(str_replace('#', '', $msg_back_color));
    $out_fore_color = hexdec(str_replace('#', '', $out_fore_color));
    $out_back_color = hexdec(str_replace('#', '', $out_back_color));
   
    $str='https://m.me/'.$page_id.'?ref='.urlencode($reference);
    $qrc = $this->quick_response_code;
    $filename = "ecommerce1-".$this->user_id.'-'.$xdata[0]["store_unique_id"].".png";
    $qrc->create($str,$filename,$qrc::QRC_ECLEVEL_L,8,1,false,$msg_back_color,$msg_fore_color);

    $str2=base_url('ecommerce/store/'.$xdata[0]['store_unique_id']);
    $qrc2 = $this->quick_response_code;
    $filename2 = "ecommerce2-".$this->user_id.'-'.$xdata[0]["store_unique_id"].".png";
    $qrc->create($str2,$filename2,$qrc2::QRC_ECLEVEL_L,8,1,false,$out_back_color,$out_fore_color);

    $data['qr_img'] = array("messenger_link"=>$str,"messenger_qr"=>$filename,"public_link"=>$str2,"public_qr"=>$filename2);

    
    $domain_only_whitelist= get_domain_only_with_http(base_url());
    if(!$this->basic->is_exist("messenger_bot_domain_whitelist",array("page_id"=>$xdata[0]['page_auto_id'],"domain"=>$domain_only_whitelist)))
    {
      $page_info = $this->basic->get_data("facebook_rx_fb_page_info",array('where'=>array('id'=>$xdata[0]['page_auto_id'])));
      $page_access_token = isset($page_info[0]['page_access_token']) ? $page_info[0]['page_access_token'] : "";
      $this->load->library("fb_rx_login");
      $response=$this->fb_rx_login->domain_whitelist($page_access_token,$domain_only_whitelist);
      $this->basic->insert_data("messenger_bot_domain_whitelist",array("user_id"=>$this->user_id,"messenger_bot_user_info_id"=>$xdata[0]['facebook_rx_fb_user_info_id'],"page_id"=>$xdata[0]['page_auto_id'],"domain"=>$domain_only_whitelist,"created_at"=>date("Y-m-d H:i:s")));
    }

    $this->_viewcontroller($data);
  }

  public function download_qr($filename='')
  {
    $this->load->helper('download');
    force_download('upload/qrc/'.$filename, NULL);
  }

  public function qr_code_action()
  {
    $this->ajax_check();
    $store_id= $this->input->post("store_id");
    $msg_text= $this->input->post("msg_text");   
    $msg_btn= $this->input->post("msg_btn");
    $msg_fore_color= $this->input->post("msg_fore_color");
    $msg_back_color= $this->input->post("msg_back_color");
    $out_fore_color= $this->input->post("out_fore_color");
    $out_back_color= $this->input->post("out_back_color");

    if(($msg_fore_color==$msg_back_color)||($out_fore_color==$out_back_color))
    {
      echo json_encode(array('status'=>'0','message'=>$this->lang->line('Please make sure you are not using same color for both foreground and background.')));
      exit();
    }

    if($msg_text=="") $msg_text = "Hi {{first_name}}, welcome to our store.";
    if($msg_btn=="") $msg_btn = "START";
   
    $qr_code = 
    array
    (
      "msg_text"=>$msg_text,
      "msg_btn"=>$msg_btn,
      "msg_fore_color"=>$msg_fore_color,
      "msg_back_color"=>$msg_back_color,
      "out_fore_color"=>$out_fore_color,
      "out_back_color"=>$out_back_color
    );
    $insert_data = array("qr_code"=>json_encode($qr_code));     
    if($this->basic->update_data("ecommerce_store",array("id"=>$store_id,"user_id"=>$this->user_id),$insert_data))
    {
        echo json_encode(array('status'=>'1','message'=>$this->lang->line('QR code has been generated successfully. Please try scanning the code before you use it and adjust the colors if it does not work.')));
        exit();
    }
    else
    {
        echo json_encode(array('status'=>'0','message'=>"".$this->lang->line('Something went wrong, please try again.')));
        exit();
    } 
  }


  public function edit_store($id=0)
  {
    if($id==0) exit();
    $data['body'] = 'ecommerce/store_edit';
    $data['page_title'] = $this->lang->line("Edit Store");
    $data['page_info'] = $this->get_user_page();    
    
    $data['country_names'] = $this->get_country_names();
    $data['currency_icons'] = $this->currency_icon();
    $data['get_ecommerce_config'] = $this->get_ecommerce_config();
    $data['locale_list'] = $this->_language_list();

    $xdata=$this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$id,"user_id"=>$this->user_id)));
    if(!isset($xdata[0])) exit();
    $data['xdata']=$xdata[0];
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }

  public function edit_store_action()
  {
    $this->ajax_check();
    $post=$_POST;

    $tag_allowed = array("terms_use_link","refund_policy_link");
    foreach ($post as $key => $value) 
    {
      if(!is_array($value) && !in_array($key, $tag_allowed)) $temp = strip_tags($value);
      else $temp = $value;
      $$key=$this->security->xss_clean($temp);
    }        

    $xdata=$this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$hidden_id,"user_id"=>$this->user_id)));
    $xstore_logo = isset($xdata[0]['store_logo']) ? $xdata[0]['store_logo'] : "";
    $xstore_favicon = isset($xdata[0]['store_favicon']) ? $xdata[0]['store_favicon'] : "";
  
    $this->db->trans_start(); 

    if(!isset($label_ids)) $label_ids=array();
    if(!isset($status) || $status=='') $status='0';
    if($refund_policy_link=="<p></p>") $refund_policy_link="";
    if($terms_use_link=="<p></p>") $terms_use_link="";
    $insert_data = array(
      "store_name"=>$store_name,
      "store_email"=> $store_email,
      "store_phone"=> $store_phone,
      "store_country"=> $store_country,
      "store_state"=> $store_state,
      "store_city"=> $store_city,
      "store_zip"=> $store_zip,
      "store_locale"=> $store_locale,
      "store_address"=> $store_address,           
      "refund_policy_link"=> strip_tags($refund_policy_link,$this->editor_allowed_tags),
      "terms_use_link"=> strip_tags($terms_use_link,$this->editor_allowed_tags),
      "status"=> $status,
      "store_locale"=> $store_locale,
      "pixel_id"=> $pixel_id,
      "google_id"=> $google_id,
      "label_ids"=>implode(',',$label_ids)
    );
    if($store_logo!='') 
    {
      $insert_data["store_logo"] = $store_logo;
      if($xstore_logo!='') @unlink('upload/ecommerce/'.$xstore_logo);
    }
    if($store_favicon!='') 
    {
      $insert_data["store_favicon"] = $store_favicon;
      if($xstore_favicon!='') @unlink('upload/ecommerce/'.$xstore_favicon);
    }
   
    $this->basic->update_data("ecommerce_store",array("id"=>$hidden_id,"user_id"=>$this->user_id),$insert_data);
    $this->db->trans_complete();

    if($this->db->trans_status() === false)
    {
         echo json_encode(array('status'=>'0','message'=>"".$this->lang->line('Something went wrong, please try again.')));
         exit();
    }
    else
    {
        echo json_encode(array('status'=>'1','message'=>$this->lang->line('Store has been updated successfully.')));
        exit();
    } 
  }

  public function product_list()
  {
    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Store");
    $data['store_list'] = $store_list;

    $data['body'] = 'ecommerce/product_list';
    $data['page_title'] = $this->lang->line('Product')." : ".$this->session->userdata("ecommerce_selected_store_title");
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }

  public function product_list_data()
  { 
    $this->ajax_check();
    $ecommerce_config = $this->get_ecommerce_config();
    $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
    $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
    $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';


    $search_value = $this->input->post("search_value");
    $store_id = $this->input->post("search_store_id");        
    $search_date_range = $this->input->post("search_date_range");

    $display_columns = 
    array(
      "#",
      "CHECKBOX",
      "thumbnail",
      'product_name',
      'original_price',
      'store_name',
      'status',
      'actions',
      'stock_item',
      'category_name',
      'updated_at',
    );
    $search_columns = array('product_name');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 3;
    $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'product_name';
    $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
    $order_by=$sort." ".$order;

    $where_custom="ecommerce_product.user_id = ".$this->user_id;

    if ($search_value != '') 
    {
        foreach ($search_columns as $key => $value) 
        $temp[] = $value." LIKE "."'%$search_value%'";
        $imp = implode(" OR ", $temp);
        $where_custom .=" AND (".$imp.") ";
    }
    if($search_date_range!="")
    {
        $exp = explode('|', $search_date_range);
        $from_date = isset($exp[0])?$exp[0]:"";
        $to_date = isset($exp[1])?$exp[1]:"";
        if($from_date!="Invalid date" && $to_date!="Invalid date")
        $where_custom .= " AND ecommerce_product.updated_at >= '{$from_date}' AND ecommerce_product.updated_at <='{$to_date}'";
    }
    $this->db->where($where_custom);

    if($store_id!="") $this->db->where(array("ecommerce_product.store_id"=>$store_id));       
    
    $table="ecommerce_product";
    $select = "ecommerce_product.*,ecommerce_store.store_name,ecommerce_category.category_name";
    $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_product.store_id,left",'ecommerce_category'=>"ecommerce_category.id=ecommerce_product.category_id,left");
    $info=$this->basic->get_data($table,$where='',$select,$join,$limit,$start,$order_by,$group_by='');
    // echo $this->db->last_query(); exit();
    
    $this->db->where($where_custom);
    if($store_id!="") $this->db->where(array("ecommerce_product.store_id"=>$store_id)); 
    $total_rows_array=$this->basic->count_row($table,$where='',$count=$table.".id",$join,$group_by='');

    $total_result=$total_rows_array[0]['total_rows'];
    $config_currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
    $config_currency_icon = isset($this->currency_icon[$config_currency]) ? $this->currency_icon[$config_currency] : "$";
    $currency_left = $currency_right = "";
    if($currency_position=='left') $currency_left = $config_currency_icon;
    if($currency_position=='right') $currency_right = $config_currency_icon;

    foreach($info as $key => $value) 
    {
        $updated_at = date("M j, y H:i",strtotime($info[$key]['updated_at']));
        $info[$key]['updated_at'] =  "<div style='min-width:110px;'>".$updated_at."</div>";

        $actions = "<a target='_BLANK' href='".base_url("ecommerce/product/".$info[$key]['id'])."' title='".$this->lang->line("Product Page")."' data-toggle='tooltip' class='btn btn-circle btn-outline-info'><i class='fas fa-eye'></i></a>&nbsp;&nbsp;";
        $actions .= "<a href='".base_url("ecommerce/edit_product/".$info[$key]['id'])."' title='".$this->lang->line("Edit")."' data-toggle='tooltip' class='btn btn-circle btn-outline-warning edit_row' table_id='".$info[$key]['id']."'><i class='fas fa-edit'></i></a>&nbsp;&nbsp;";
        $actions .= "<a href='".base_url("ecommerce/edit_product/".$info[$key]['id'])."/clone' title='".$this->lang->line("Clone")."' data-toggle='tooltip' class='btn btn-circle btn-outline-primary edit_row' table_id='".$info[$key]['id']."'><i class='fas fa-clone'></i></a>&nbsp;&nbsp;";
        $actions .= "<a href='#' title='".$this->lang->line("Delete")."' data-toggle='tooltip' class='btn btn-circle btn-outline-danger delete_row' table_id='".$info[$key]['id']."'><i class='fas fa-trash-alt'></i></a>";

        $action_width = (4*47)+20;
        $info[$key]['actions'] ='
        <div class="dropdown d-inline dropright">
          <button class="btn btn-outline-primary dropdown-toggle no_caret" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-briefcase"></i>
          </button>
          <div class="dropdown-menu mini_dropdown text-center" style="width:'.$action_width.'px !important">
           '.$actions.'
          </div>
        </div>
        <script>
        $(\'[data-toggle="tooltip"]\').tooltip();
        </script>';

        if($info[$key]['status'] == 1) $info[$key]['status'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> ".$this->lang->line('Active')."</span>";
        else $info[$key]['status'] = "<span class='badge badge-status text-danger'><i class='fa fa-times-circle red'></i> ".$this->lang->line('Inactive')."</span>"; 

        if($info[$key]['taxable'] == 1) $info[$key]['taxable'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> ".$this->lang->line('Yes')."</span>";
        else $info[$key]['taxable'] = "<span class='badge badge-status text-danger'><i class='fa fa-times red'></i> ".$this->lang->line('No')."</span>";

        if($info[$key]['sell_price']>0) $info[$key]['original_price'] = "<span style='text-decoration: line-through;' class='text-muted'>".$currency_left.mec_number_format($info[$key]['original_price'],$decimal_point,$thousand_comma).$currency_right."</span> <b class='text-warning'>".$currency_left.mec_number_format($info[$key]['sell_price'],$decimal_point,$thousand_comma).$currency_right."</b>";
        else $info[$key]['original_price'] = "<b>".$currency_left.mec_number_format($info[$key]['original_price'],$decimal_point,$thousand_comma).$currency_right."</b>";

        if($info[$key]['thumbnail']=='') $url = base_url('assets/img/products/product-1.jpg');
        else $url = base_url('upload/ecommerce/'.$info[$key]['thumbnail']);
        $info[$key]['thumbnail'] = "<a  target='_BLANK' href='".$url."'><img class='img-fluid' style='height:80px;width:80px;border-radius:4px;border:1px solid #eee;padding:2px;' src='".$url."'></a>";
    }
    $data['draw'] = (int)$_POST['draw'] + 1;
    $data['recordsTotal'] = $total_result;
    $data['recordsFiltered'] = $total_result;
    $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
    echo json_encode($data);
  }

  public function delete_store($campaign_id=0)
  {   
    $this->ajax_check();
    $id = $this->input->post('campaign_id',true);
    $response = array();
    $xdata=$this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$id,"user_id"=>$this->user_id)));
    if(!isset($xdata[0]))
    {
        $response['status'] = '0';
        $response['message'] = $this->lang->line('Something went wrong, please try once again.');
    }
    $xstore_logo = isset($xdata[0]['store_logo']) ? $xdata[0]['store_logo'] : "";
    $xstore_favicon = isset($xdata[0]['store_favicon']) ? $xdata[0]['store_favicon'] : "";

    $this->db->trans_start();
    $this->basic->delete_data('ecommerce_store',$where=array('id'=>$id,"user_id"=>$this->user_id));
    $this->basic->delete_data('ecommerce_product',$where=array('store_id'=>$id,"user_id"=>$this->user_id));
    $this->basic->delete_data('ecommerce_coupon',$where=array('store_id'=>$id,"user_id"=>$this->user_id));
    $this->basic->delete_data('ecommerce_cart',$where=array('store_id'=>$id,"user_id"=>$this->user_id));
    $this->basic->delete_data('ecommerce_cart_item',$where=array('store_id'=>$id));
    $this->basic->delete_data('ecommerce_reminder_report',$where=array('store_id'=>$id,"user_id"=>$this->user_id));
    $this->basic->delete_data('ecommerce_category',$where=array('store_id'=>$id,"user_id"=>$this->user_id));
    $this->basic->delete_data('ecommerce_attribute',$where=array('store_id'=>$id,"user_id"=>$this->user_id));
    //******************************//
    // delete data to useges log table
    $this->_delete_usage_log($module_id=268,$request=1);   
    //******************************//

    $this->db->trans_complete();
    if($this->db->trans_status() === false) 
    {
      $response['status'] = '0';
      $response['message'] = $this->lang->line('Something went wrong.');
    } 
    else 
    {
      if($xstore_logo!='') @unlink('upload/ecommerce/'.$xstore_logo);         
      if($xstore_favicon!='') @unlink('upload/ecommerce/'.$xstore_favicon);          
      $response['status'] = '1';
      $response['message'] = $this->lang->line('Store has been deleted successfully.');
      $this->session->unset_userdata("ecommerce_selected_store");
    }
    echo json_encode($response);
  }


  public function add_product()
  {       
    $data['body']='ecommerce/product_add';     
    $data['page_title']=$this->lang->line('Add Product')." : ".$this->session->userdata("ecommerce_selected_store_title");

    $selected_attributes = '';
    $x_attribute_values = '';
    $data['x_attribute_values'] = '';
    if($this->session->userdata('validation_check_attribute_ids')!='')
      $selected_attributes = $this->session->userdata('validation_check_attribute_ids');
    if($selected_attributes != '')
    {
      if($this->addon_exist('ecommerce_product_price_variation'))
      {
          if($this->session->userdata('user_type') == 'Admin' || in_array(281,$this->module_access))
          {
            if(!empty($selected_attributes))
            {
              foreach ($selected_attributes as $attribute_id) 
              {
                $info = $this->basic->get_data('ecommerce_attribute',['where'=>['id'=>$attribute_id,'user_id'=>$this->user_id]]);
                $attribute_name = isset($info[0]['attribute_name']) ? $info[0]['attribute_name'] : '';
                $values = isset($info[0]['attribute_values']) ? json_decode($info[0]['attribute_values'],true) : [];
                if(!empty($values))
                {
                    $x_attribute_values .= '
                              <div class="col-12" id="attribute_values_'.$attribute_id.'">
                                <div class="card">
                                  <div class="card-header">
                                    <h4>'.$this->lang->line("Set price variation for attribute's values of").' "'.$attribute_name.'"</h4>
                                  </div>
                                  <div class="card-body attribute_values_body">
                                    <div class="table-responsive">
                                      <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                          <th>'.$this->lang->line("Attribute Value").'</th>
                                          <th>'.$this->lang->line("Increment/Decrement (with main price)").'</th>
                                          <th>'.$this->lang->line("Amount (Keep it blank/Zero for no variation)").'</th>
                                        </tr>';
                    foreach ($values as $key=>$value) {
                      $x_attribute_values .= '<tr>
                                      <td>'.$value.'</td>
                                      <td>
                                        <select class="form-control select2" name="single_attribute_names_'.$attribute_id.'_'.$key.'" style="width:100%;">
                                          <option value="+">'.$this->lang->line("+").'</option>
                                          <option value="-">'.$this->lang->line("-").'</option>
                                        </select>
                                      </td>
                                      <td><input class="form-control" type="text" name="single_attribute_values_'.$attribute_id.'_'.$key.'" id="single_attribute_values_'.$attribute_id.'_'.$key.'"></td>
                                    </tr>';
                    }
                                        
                    $x_attribute_values .= '</tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              ';

                }
              }
            }
            $data['x_attribute_values'] = $x_attribute_values;
          }
          else
            $data['x_attribute_values'] = '';

      }
      else
        $data['x_attribute_values'] = '';
    }

    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Select Store");
    $data['store_list'] = $store_list;

    $category_list = $this->get_category_list();
    $category_list[''] = $this->lang->line("Select Category");
    $data['category_list'] = $category_list;

    $attribute_list = $this->get_attribute_list();
    $data['attribute_list'] = $attribute_list;

    $data['ecommerce_config'] = $this->get_ecommerce_config();
    $data["iframe"]="1";
    $this->session->unset_userdata('validation_check_attribute_ids');
    $this->_viewcontroller($data);
  }


  public function add_product_action() 
  {
    if($_SERVER['REQUEST_METHOD'] === 'GET') 
    redirect('home/access_forbidden','location');

    if($_POST)
    {
        $this->form_validation->set_rules('store_id', '<b>'.$this->lang->line("Store").'</b>', 'trim|required');      
        $this->form_validation->set_rules('product_name', '<b>'.$this->lang->line("Product name").'</b>', 'trim|required');      
        $this->form_validation->set_rules('original_price', '<b>'.$this->lang->line("Original price").'</b>', 'trim|required|numeric');
        $this->form_validation->set_rules('sell_price', '<b>'.$this->lang->line("Sell price").'</b>', 'trim|numeric');
        $this->form_validation->set_rules('product_description', '<b>'.$this->lang->line("Product description").'</b>', 'trim');      
        $this->form_validation->set_rules('purchase_note', '<b>'.$this->lang->line("Purchase note").'</b>', 'trim');      
        $this->form_validation->set_rules('thumbnail', '<b>'.$this->lang->line("Thumbnail").'</b>', 'trim');      
        $this->form_validation->set_rules('stock_item', '<b>'.$this->lang->line("Item in stock").'</b>', 'trim|numeric');   
            
        if ($this->form_validation->run() == FALSE)
        {
          $attribute_ids=$this->input->post('attribute_ids',true);
          $this->session->set_userdata('validation_check_attribute_ids',$attribute_ids);
          $this->add_product(); 
        }
        else
        {   
            $store_id=$this->input->post('store_id',true);
            $category_id=$this->input->post('category_id',true);
            $attribute_ids=$this->input->post('attribute_ids',true);
            $product_name=strip_tags($this->input->post('product_name',true));
            $original_price=$this->input->post('original_price',true);
            $sell_price=$this->input->post('sell_price',true);
            $product_description=strip_tags($this->input->post('product_description',true),$this->editor_allowed_tags);
            $purchase_note=strip_tags($this->input->post('purchase_note',true),$this->editor_allowed_tags);
            $thumbnail=$this->input->post('thumbnail',true);
            $featured_images=$this->input->post('featured_images',true);
            $taxable=$this->input->post('taxable',true);
            $status=$this->input->post('status',true);
            $stock_item=$this->input->post('stock_item',true);
            $stock_display=$this->input->post('stock_display',true);
            $stock_prevent_purchase=$this->input->post('stock_prevent_purchase',true);

            if($product_description=="<p></p>") $product_description="";
            if($purchase_note=="<p></p>") $purchase_note="";

            if($status=='') $status='0';
            if($taxable=='') $taxable='0';
            if($stock_display=='') $stock_display='0';
            if($stock_prevent_purchase=='') $stock_prevent_purchase='0';
            if(!isset($attribute_ids) || !is_array($attribute_ids) || empty($attribute_ids)) $attribute_ids = '';
            else $attribute_ids = implode(',', $attribute_ids);
                                                   
            $data=array
            (
                'store_id'=>$store_id,
                'category_id'=>$category_id,
                'attribute_ids'=>$attribute_ids,
                'product_name'=>$product_name,
                'original_price'=>$original_price,
                'sell_price'=>$sell_price,
                'product_description'=>$product_description,
                'purchase_note'=>$purchase_note,
                'thumbnail'=>$thumbnail,
                'featured_images'=>$featured_images,
                'taxable' => $taxable,
                'status'=> $status,
                'stock_item'=> $stock_item,
                'stock_display'=> $stock_display,
                'stock_prevent_purchase'=> $stock_prevent_purchase,
                'user_id'=> $this->user_id,
                'deleted'=>'0',
                'updated_at'=>date("Y-m-d H:i:s")
            );
            
            if($this->basic->insert_data('ecommerce_product',$data))
            {
              $product_id = $this->db->insert_id();
              $this->session->set_flashdata('success_message',1);   
            }
            else 
            {
              $product_id = '';
              $this->session->set_flashdata('error_message',1);    
            }

            if($this->addon_exist('ecommerce_product_price_variation'))
            {
                if($this->session->userdata('user_type') == 'Admin' || in_array(281,$this->module_access))
                {
                  if($product_id != '')
                  {
                    $insert_data = [];
                    $attribute_ids_array = explode(',', $attribute_ids) ;
                    foreach ($attribute_ids_array as $attribute_id) {
                      $attribute_values_info = $this->basic->get_data('ecommerce_attribute',['where'=>['id'=>$attribute_id,'user_id'=>$this->user_id]]);
                      $attribute_values = isset($attribute_values_info[0]['attribute_values']) ? json_decode($attribute_values_info[0]['attribute_values'],true) : [];
                      $attribute_option_name = isset($attribute_values_info[0]['attribute_name']) ? $attribute_values_info[0]['attribute_name'] : '';
                      $insert_data['attribute_id'] = $attribute_id;
                      $insert_data['product_id'] = $product_id;
                      foreach ($attribute_values as $key => $value) {
                        $insert_data['attribute_option_name'] = $value;
                        $variable_amount = "single_attribute_values_".$attribute_id."_".$key;
                        $variable_indicator = "single_attribute_names_".$attribute_id."_".$key;
                        $insert_data['amount'] = $this->input->post($variable_amount,true);
                        $insert_data['price_indicator'] = $this->input->post($variable_indicator,true);
                        $this->basic->insert_data('ecommerce_attribute_product_price',$insert_data);
                      }
                    }
                  }
                }
            }
            
            
            redirect('ecommerce/product_list','location');                 
            
        }
    }   
  }


  public function edit_product($id='0',$operation='edit')
  {       
    if($id=='0') exit();
    $data['body']='ecommerce/product_edit';     
    $data['page_title']=$this->lang->line('Edit Product')." : ".$this->session->userdata("ecommerce_selected_store_title");

    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Select Store");
    $data['store_list'] = $store_list;

    $category_list = $this->get_category_list();
    $category_list[''] = $this->lang->line("Select Category");
    $data['category_list'] = $category_list;

    $attribute_list = $this->get_attribute_list();
    $data['attribute_list'] = $attribute_list;
    $data['operation'] = $operation;

    $data['ecommerce_config'] = $this->get_ecommerce_config();

    $xdata = $this->basic->get_data("ecommerce_product",array('where'=>array('id'=>$id,"user_id"=>$this->user_id)));
    if(!isset($xdata[0])) exit();
    $data['xdata'] = $xdata[0];
    $data["iframe"]="1";

    $x_attribute_values = '';
    $attribute_values_array = isset($xdata[0]['attribute_ids']) ? explode(',', $xdata[0]['attribute_ids']) : [];



    if($this->addon_exist('ecommerce_product_price_variation'))
    {
        if($this->session->userdata('user_type') == 'Admin' || in_array(281,$this->module_access))
        {
          if(!empty($attribute_values_array))
          {
            foreach ($attribute_values_array as $attribute_id) 
            {
              $info = $this->basic->get_data('ecommerce_attribute',['where'=>['id'=>$attribute_id,'user_id'=>$this->user_id]]);
              $attribute_name = isset($info[0]['attribute_name']) ? $info[0]['attribute_name'] : '';
              $given_attribute_info = $this->basic->get_data('ecommerce_attribute_product_price',['where'=>['product_id'=>$id,'attribute_id'=>$attribute_id]]);
              if(!empty($given_attribute_info))
              {
                  $x_attribute_values .= '
                            <div class="col-12" id="attribute_values_'.$attribute_id.'">
                              <div class="card">
                                <div class="card-header">
                                  <h4>'.$this->lang->line("Set price variation for attribute's values of").' "'.$attribute_name.'"</h4>
                                </div>
                                <div class="card-body attribute_values_body">
                                  <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                      <tbody>
                                      <tr>
                                        <th>'.$this->lang->line("Attribute Value").'</th>
                                        <th>'.$this->lang->line("Increment/Decrement (with main price)").'</th>
                                        <th>'.$this->lang->line("Amount (Keep it blank/Zero for no variation)").'</th>
                                      </tr>';
                  foreach ($given_attribute_info as $key=>$value) {
                    $indicator = $value['price_indicator'];
                    $plus_selected = '';
                    $minus_selected = '';
                    if($indicator == '+') $plus_selected = "selected";
                    if($indicator == '-') $minus_selected = "selected";
                    $amount = $value['amount'];
                    $attribute_option_name = $value['attribute_option_name'];
                    $x_attribute_values .= '<tr>
                                    <td>'.$attribute_option_name.'</td>
                                    <td>
                                      <select class="form-control select2" name="single_attribute_names_'.$attribute_id.'_'.$key.'" style="width:100%;">
                                        <option value="+" '.$plus_selected.'>'.$this->lang->line("+").'</option>
                                        <option value="-" '.$minus_selected.'>'.$this->lang->line("-").'</option>
                                      </select>
                                    </td>
                                    <td><input class="form-control" type="text" name="single_attribute_values_'.$attribute_id.'_'.$key.'" id="single_attribute_values_'.$attribute_id.'_'.$key.'" value="'.$amount.'"></td>
                                  </tr>';
                  }
                                      
                  $x_attribute_values .= '</tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            ';

              }
            }
          }
          $data['x_attribute_values'] = $x_attribute_values;
        }
        else
          $data['x_attribute_values'] = '';

    }
    else
      $data['x_attribute_values'] = '';
    
    $this->_viewcontroller($data);
  }


  public function edit_product_action() 
  {
    if($_SERVER['REQUEST_METHOD'] === 'GET') 
    redirect('home/access_forbidden','location');

    if($_POST)
    {
        $id=$this->input->post('hidden_id',true);
        // $this->form_validation->set_rules('store_id', '<b>'.$this->lang->line("Store").'</b>', 'trim|required');      
        $this->form_validation->set_rules('product_name', '<b>'.$this->lang->line("Product name").'</b>', 'trim|required');      
        $this->form_validation->set_rules('original_price', '<b>'.$this->lang->line("Original price").'</b>', 'trim|required|numeric');
        $this->form_validation->set_rules('sell_price', '<b>'.$this->lang->line("Sell price").'</b>', 'trim|numeric');
        $this->form_validation->set_rules('product_description', '<b>'.$this->lang->line("Product description").'</b>', 'trim');      
        $this->form_validation->set_rules('purchase_note', '<b>'.$this->lang->line("Purchase note").'</b>', 'trim');      
        $this->form_validation->set_rules('thumbnail', '<b>'.$this->lang->line("Thumbnail").'</b>', 'trim');        
        $this->form_validation->set_rules('stock_item', '<b>'.$this->lang->line("Item in stock").'</b>', 'trim|numeric'); 

            
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_product($id); 
        }
        else
        {   
            $xdata = $this->basic->get_data("ecommerce_product",array('where'=>array('id'=>$id,"user_id"=>$this->user_id)));
            $xthumbnail = isset($xdata[0]['thumbnail']) ? $xdata[0]['thumbnail'] : "";
            $xfeatured_images = isset($xdata[0]['featured_images']) ? $xdata[0]['featured_images'] : "";

            // $store_id=$this->input->post('store_id',true);
            $category_id=$this->input->post('category_id',true);
            $attribute_ids=$this->input->post('attribute_ids',true);
            $product_name=strip_tags($this->input->post('product_name',true));
            $original_price=$this->input->post('original_price',true);
            $sell_price=$this->input->post('sell_price',true);
            $product_description=strip_tags($this->input->post('product_description',true),$this->editor_allowed_tags);
            $purchase_note=strip_tags($this->input->post('purchase_note',true),$this->editor_allowed_tags);
            $thumbnail=$this->input->post('thumbnail',true);
            $featured_images=$this->input->post('featured_images',true);
            $taxable=$this->input->post('taxable',true);
            $status=$this->input->post('status',true);
            $stock_item=$this->input->post('stock_item',true);
            $stock_display=$this->input->post('stock_display',true);
            $stock_prevent_purchase=$this->input->post('stock_prevent_purchase',true);

            if($product_description=="<p></p>") $product_description="";
            if($purchase_note=="<p></p>") $purchase_note="";

            if($status=='') $status='0';
            if($taxable=='') $taxable='0';
            if($stock_display=='') $stock_display='0';
            if($stock_prevent_purchase=='') $stock_prevent_purchase='0';
            if(!isset($attribute_ids) || !is_array($attribute_ids) || empty($attribute_ids)) $attribute_ids = '';
            else $attribute_ids = implode(',', $attribute_ids);
                                                   
            $data=array
            (
                'category_id'=>$category_id,
                'attribute_ids'=>$attribute_ids,
                'product_name'=>$product_name,
                'original_price'=>$original_price,
                'sell_price'=>$sell_price,
                'product_description'=>$product_description,
                'purchase_note'=>$purchase_note,
                'taxable' => $taxable,
                'status'=> $status,
                'stock_item'=> $stock_item,
                'stock_display'=> $stock_display,
                'stock_prevent_purchase'=> $stock_prevent_purchase,
                'updated_at'=>date("Y-m-d H:i:s")
            );
            if($thumbnail!='') 
            {
              $data['thumbnail'] = $thumbnail;
              if($xthumbnail!='') @unlink('upload/ecommerce/'.$xthumbnail);
            }
            if($featured_images!='') 
            {
              $data['featured_images'] = $featured_images;
              if($xfeatured_images!='')
              {
                $exp = explode(',', $xfeatured_images);
                foreach ($exp as $key => $value) {
                  @unlink('upload/ecommerce/'.$value);
                }
              }
            }
            
            $success = '0';
            if($this->basic->update_data('ecommerce_product',array("id"=>$id,"user_id"=>$this->user_id),$data)) 
            {
              $success = '1';
              $this->session->set_flashdata('success_message',1);   
            }
            else $this->session->set_flashdata('error_message',1);   

            if($this->addon_exist('ecommerce_product_price_variation'))
            {
              if($this->session->userdata('user_type') == 'Admin' || in_array(281,$this->module_access))
              {
                if($success == '1')
                {
                  $insert_data = [];
                  $attribute_ids_array = explode(',', $attribute_ids) ;
                  foreach ($attribute_ids_array as $attribute_id) {
                    $this->basic->delete_data('ecommerce_attribute_product_price',['product_id'=>$id,'attribute_id'=>$attribute_id]);
                    $attribute_values_info = $this->basic->get_data('ecommerce_attribute',['where'=>['id'=>$attribute_id,'user_id'=>$this->user_id]]);
                    $attribute_values = isset($attribute_values_info[0]['attribute_values']) ? json_decode($attribute_values_info[0]['attribute_values'],true) : [];
                    $attribute_option_name = isset($attribute_values_info[0]['attribute_name']) ? $attribute_values_info[0]['attribute_name'] : '';
                    $insert_data['attribute_id'] = $attribute_id;
                    $insert_data['product_id'] = $id;
                    foreach ($attribute_values as $key => $value) {
                      $insert_data['attribute_option_name'] = $value;
                      $variable_amount = "single_attribute_values_".$attribute_id."_".$key;
                      $variable_indicator = "single_attribute_names_".$attribute_id."_".$key;
                      $insert_data['amount'] = is_null($this->input->post($variable_amount,true)) ? 0 : $this->input->post($variable_amount,true);
                      $insert_data['price_indicator'] = is_null($this->input->post($variable_indicator,true)) ? "+" : $this->input->post($variable_indicator,true);
                      $this->basic->insert_data('ecommerce_attribute_product_price',$insert_data);
                    }
                  }
                } 
              }
            }
             
            
            redirect('ecommerce/product_list','location');                 
            
        }
    }   
  }

  public function delete_product()
  {
    $this->ajax_check();
    $table_id = $this->input->post("table_id");

    $xdata=$this->basic->get_data("ecommerce_product",array("where"=>array("id"=>$table_id,"user_id"=>$this->user_id)),"thumbnail,featured_images");
    if(!isset($xdata[0]))
    {
        $response['status'] = '0';
        $response['message'] = $this->lang->line('Something went wrong, please try once again.');
    }
    $xthumbnail = isset($xdata[0]['thumbnail']) ? $xdata[0]['thumbnail'] : "";
    $xfeatured_images = isset($xdata[0]['featured_images']) ? $xdata[0]['featured_images'] : "";


    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));
    if($table_id == "0" || $table_id == "")
    {
        echo json_encode($result); 
        exit();
    }
    if($this->basic->update_data("ecommerce_product", array("id"=>$table_id,'user_id'=>$this->user_id),array('deleted'=>'1')))
    {
      echo json_encode(array('message' => $this->lang->line("Product has been deleted successfully."),'status'=>'1'));
      if($xthumbnail!='') @unlink('upload/ecommerce/'.$xthumbnail); 
      if($xfeatured_images!='')
      {
        $exp = explode(',', $xfeatured_images);
        foreach ($exp as $key => $value) {
          @unlink('upload/ecommerce/'.$value);
        }
      }
    }       
    else echo json_encode($result);  
  }  

  public function payment_accounts()
  {     
    $xdata=$this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$this->session->userdata("ecommerce_selected_store"),"user_id"=>$this->user_id)));
    if(!isset($xdata[0])) exit();
    $data['xdata2']=$xdata[0];
    $data['body'] = "ecommerce/payment_accounts";
    $data['page_title'] = $this->lang->line('Checkout Settings');
    $data['xvalue'] = $this->get_ecommerce_config();
    if($this->is_demo == '1')$data["xvalue"]["stripe_secret_key"]=$data["xvalue"]["stripe_publishable_key"]=$data["xvalue"]["paypal_email"]=$data["xvalue"]["paystack_secret_key"]=$data["xvalue"]["paystack_public_key"]=$data["xvalue"]["razorpay_key_id"]=$data["xvalue"]["razorpay_key_secret"]=$data["xvalue"]["mollie_api_key"]="XXXXXXXXXX";
    $paypal_stripe_currency_list = $this->paypal_stripe_currency_list();
    asort($paypal_stripe_currency_list);   

    $data['iframe'] = '1';    
    $data['currency_list'] = $paypal_stripe_currency_list;
    $data['currecny_list_all'] = $this->currecny_list_all();
    $this->_viewcontroller($data);
  }

  public function payment_accounts_action()
  {
    if($this->is_demo == '1')
    {
        echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>"; 
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET') redirect('home/access_forbidden', 'location');
    if ($_POST) 
    {
        $this->form_validation->set_rules('paypal_email','<b>'.$this->lang->line("Paypal Email").'</b>','trim|valid_email');
        $this->form_validation->set_rules('paypal_mode','<b>'.$this->lang->line("Paypal Sandbox Mode").'</b>','trim');
        $this->form_validation->set_rules('stripe_secret_key','<b>'.$this->lang->line("Stripe Secret Key").'</b>','trim');
        $this->form_validation->set_rules('stripe_publishable_key','<b>'.$this->lang->line("Stripe Publishable Key").'</b>','trim');
        $this->form_validation->set_rules('razorpay_key_id','<b>'.$this->lang->line("Razorpay Key ID").'</b>','trim');
        $this->form_validation->set_rules('razorpay_key_secret','<b>'.$this->lang->line("Razorpay Key Secret").'</b>','trim');
        $this->form_validation->set_rules('paystack_secret_key','<b>'.$this->lang->line("Paystack Secret Key").'</b>','trim');
        $this->form_validation->set_rules('paystack_public_key','<b>'.$this->lang->line("Paystack Public Key").'</b>','trim');
        $this->form_validation->set_rules('mollie_api_key','<b>'.$this->lang->line("mollie_api_key").'</b>','trim');
        $this->form_validation->set_rules('currency','<b>'.$this->lang->line("Currency").'</b>',  'trim');
        $this->form_validation->set_rules('manual_payment_instruction','<b>'.$this->lang->line("Manual Payment Instruction").'</b>',  'trim');            
        $this->form_validation->set_rules('currency_position','<b>'.$this->lang->line("Currency Position").'</b>',  'trim');
        $this->form_validation->set_rules('decimal_point','<b>'.$this->lang->line("Decimal Point").'</b>',  'trim|integer');
        $this->form_validation->set_rules('thousand_comma','<b>'.$this->lang->line("Thousand Comma").'</b>',  'trim');
        $this->form_validation->set_rules('buy_button_title','<b>'.$this->lang->line("Buy button title").'</b>',  'trim');
        $this->form_validation->set_rules('store_pickup_title','<b>'.$this->lang->line("Store pickup title").'</b>',  'trim');

        // go to config form page if validation wrong
        if ($this->form_validation->run() == false) 
        {
            return $this->payment_accounts();
        } 
        else 
        {
            // assign
            $paypal_email=strip_tags($this->input->post('paypal_email',true));
            $paypal_payment_type=strip_tags($this->input->post('paypal_payment_type',true));
            $paypal_mode=strip_tags($this->input->post('paypal_mode',true));
            $stripe_billing_address=strip_tags($this->input->post('stripe_billing_address',true));
            $stripe_secret_key=strip_tags($this->input->post('stripe_secret_key',true));
            $stripe_publishable_key=strip_tags($this->input->post('stripe_publishable_key',true));
            $razorpay_key_id=strip_tags($this->input->post('razorpay_key_id',true));
            $razorpay_key_secret=strip_tags($this->input->post('razorpay_key_secret',true));
            $paystack_secret_key=strip_tags($this->input->post('paystack_secret_key',true));
            $paystack_public_key=strip_tags($this->input->post('paystack_public_key',true));
            $mollie_api_key=strip_tags($this->input->post('mollie_api_key',true));
            $currency=strip_tags($this->input->post('currency',true));
            $currency_position=strip_tags($this->input->post('currency_position',true));
            $decimal_point=strip_tags($this->input->post('decimal_point',true));
            $thousand_comma=strip_tags($this->input->post('thousand_comma',true));
            $paypal_enabled=strip_tags($this->input->post('paypal_enabled',true));
            $stripe_enabled=strip_tags($this->input->post('stripe_enabled',true));
            $manual_enabled=strip_tags($this->input->post('manual_enabled',true));
            $cod_enabled=strip_tags($this->input->post('cod_enabled',true));
            $razorpay_enabled=strip_tags($this->input->post('razorpay_enabled',true));
            $paystack_enabled=strip_tags($this->input->post('paystack_enabled',true));
            $mollie_enabled=strip_tags($this->input->post('mollie_enabled',true));
            $tax_percentage=strip_tags($this->input->post('tax_percentage',true));
            $shipping_charge=strip_tags($this->input->post('shipping_charge',true));
            $buy_button_title=strip_tags($this->input->post('buy_button_title',true));
            $store_pickup_title=strip_tags($this->input->post('store_pickup_title',true));
            $is_store_pickup=strip_tags($this->input->post('is_store_pickup',true));
            $is_checkout_country=strip_tags($this->input->post('is_checkout_country',true));
            $is_checkout_state=strip_tags($this->input->post('is_checkout_state',true));
            $is_checkout_city=strip_tags($this->input->post('is_checkout_city',true));
            $is_checkout_zip=strip_tags($this->input->post('is_checkout_zip',true));
            $is_checkout_email=strip_tags($this->input->post('is_checkout_email',true));
            $is_checkout_phone=strip_tags($this->input->post('is_checkout_phone',true));
            $is_delivery_note=strip_tags($this->input->post('is_delivery_note',true));
            // $manual_payment=$this->input->post('manual_payment');
            $manual_payment='1';
            $manual_payment_instruction=$this->input->post('manual_payment_instruction',true);

            if($paypal_mode=="") $paypal_mode="live";
            if($stripe_billing_address=="") $stripe_billing_address="0";
            if($manual_payment=="") $manual_payment="0";
            if($currency_position=="") $currency_position="left";
            if($thousand_comma=="") $thousand_comma="0";
            if($decimal_point=="") $decimal_point="0";

            if($is_store_pickup=="") $is_store_pickup="0";
            if($is_checkout_country=="") $is_checkout_country="0";
            if($is_checkout_state=="") $is_checkout_state="0";
            if($is_checkout_city=="") $is_checkout_city="0";
            if($is_checkout_zip=="") $is_checkout_zip="0";
            if($is_checkout_email=="") $is_checkout_email="0";
            if($is_checkout_phone=="") $is_checkout_phone="0";
            if($is_delivery_note=="") $is_delivery_note="0";

            if($paypal_enabled=='0' && $stripe_enabled=='0' && $manual_enabled=='0' && $cod_enabled=='0' && $razorpay_enabled=='0' && $paystack_enabled=='0' && $mollie_enabled=='0')
            {
              $this->session->set_flashdata('error_message', 1);
              redirect('ecommerce/payment_accounts', 'location');
              exit();
            } 

            $update_data = 
            array
            (
                'paypal_email'=>$paypal_email,
                'paypal_mode'=>$paypal_mode,
                'stripe_billing_address'=>$stripe_billing_address,
                'stripe_secret_key'=>$stripe_secret_key,
                'stripe_publishable_key'=>$stripe_publishable_key,
                'razorpay_key_id'=>$razorpay_key_id,
                'razorpay_key_secret'=>$razorpay_key_secret,
                'paystack_secret_key'=>$paystack_secret_key,
                'paystack_public_key'=>$paystack_public_key,
                'mollie_api_key'=>$mollie_api_key,
                'currency'=>$currency,
                'manual_payment'=> $manual_payment,
                'manual_payment_instruction'=>$manual_payment_instruction,
                'user_id'=>$this->user_id,
                'store_id'=>$this->session->userdata("ecommerce_selected_store"),
                'currency_position'=>$currency_position,
                'decimal_point'=>$decimal_point,
                'thousand_comma'=>$thousand_comma,
                'buy_button_title'=>$buy_button_title,
                'store_pickup_title'=>$store_pickup_title,
                'updated_at'=>date("Y-m-d H:i:s"),
                'is_store_pickup'=>$is_store_pickup,
                'is_checkout_country'=>$is_checkout_country,
                'is_checkout_state'=>$is_checkout_state,
                'is_checkout_city'=>$is_checkout_city,
                'is_checkout_zip'=>$is_checkout_zip,
                'is_checkout_email'=>$is_checkout_email,
                'is_checkout_phone'=>$is_checkout_phone,
                'is_delivery_note'=>$is_delivery_note
            );

            $get_data = $this->basic->get_data("ecommerce_config",array("where"=>array("store_id"=>$this->session->userdata("ecommerce_selected_store"))));
            if(isset($get_data[0]))
            $this->basic->update_data("ecommerce_config",array("store_id"=>$this->session->userdata("ecommerce_selected_store")),$update_data);
            else $this->basic->insert_data("ecommerce_config",$update_data);

            $update_store = array
            (
              "paypal_enabled"=> $paypal_enabled,
              "stripe_enabled"=> $stripe_enabled,
              "manual_enabled"=> $manual_enabled,
              "razorpay_enabled"=> $razorpay_enabled,
              "paystack_enabled"=> $paystack_enabled,
              "mollie_enabled"=> $mollie_enabled,
              "cod_enabled"=> $cod_enabled,
              "tax_percentage"=> $tax_percentage,
              "shipping_charge"=> $shipping_charge
            );
            $this->basic->update_data("ecommerce_store",array("id"=>$this->session->userdata("ecommerce_selected_store")),$update_store);
                                     
            $this->session->set_flashdata('success_message', 1);
            redirect('ecommerce/payment_accounts', 'location');
        }
    }
  }

  public function attribute_list()
  {
    $data['body'] = 'ecommerce/attribute_list'; 
    $data['page_title'] = $this->lang->line('Attribute')." : ".$this->session->userdata("ecommerce_selected_store_title");
    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Store");
    $data['store_list'] = $store_list; 
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }

  public function attribute_list_data()
  {
    $search_value = $_POST['search']['value'];
    $display_columns = array("#",'CHECKBOX','attribute_name','attribute_values','status','actions','store_name','updated_at');
    $search_columns = array('attribute_name','store_name');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
    $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'attribute_name';
    $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
    $order_by=$sort." ".$order;

    $where_custom = '';
    $where_custom="ecommerce_attribute.user_id = ".$this->user_id." AND ecommerce_attribute.store_id = ".$this->session->userdata("ecommerce_selected_store");
    if($search_value != '') 
    {
        foreach ($search_columns as $key => $value) 
        $temp[] = $value." LIKE "."'%$search_value%'";
        $imp = implode(" OR ", $temp);
        $where_custom .=" AND (".$imp.") ";
    }   

    $table = "ecommerce_attribute";
    $select = "ecommerce_attribute.*,ecommerce_store.store_name";
    $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_attribute.store_id,left");
    $this->db->where($where_custom);
    $info = $this->basic->get_data($table,$where='',$select,$join,$limit,$start,$order_by,$group_by='');

    $this->db->where($where_custom);
    $total_rows_array = $this->basic->count_row($table,$where='',$count="ecommerce_attribute.id",$join,$group_by='');
    $total_result=$total_rows_array[0]['total_rows'];

    foreach ($info as $key => $value) 
    {
        $info[$key]['attribute_values'] = implode(', ', json_decode($info[$key]['attribute_values'],true));
        $info[$key]['actions'] = "<div style='min-width:100px'><a href='#' title='".$this->lang->line("Edit")."' data-toggle='tooltip' class='btn btn-circle btn-outline-warning edit_row' table_id='".$info[$key]['id']."'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;";

        $info[$key]['actions'] .= "<a href='#' title='".$this->lang->line("Delete")."' data-toggle='tooltip' class='btn btn-circle btn-outline-danger delete_row' table_id='".$info[$key]['id']."'><i class='fa fa-trash-alt'></i></a></div>
            <script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";

        if($info[$key]['status'] == 1) $info[$key]['status'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> ".$this->lang->line('Active')."</span>";
        else $info[$key]['status'] = "<span class='badge badge-status text-danger'><i class='fa fa-times-circle red'></i> ".$this->lang->line('Inactive')."</span>";

        $info[$key]['updated_at'] = date("jS M y H:i",strtotime($info[$key]['updated_at']));     
    }

    $data['draw'] = (int)$_POST['draw'] + 1;
    $data['recordsTotal'] = $total_result;
    $data['recordsFiltered'] = $total_result;
    $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
    echo json_encode($data);
  }

  public function ajax_create_new_attribute()
  {
    $this->ajax_check();
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));

    if($_POST) 
    {
        $attribute_name = strip_tags($this->input->post("attribute_name",true));
        $store_id = $this->input->post("store_id",true);

        $attribute_values = $this->input->post("attribute_values",true);
        if(!is_array($attribute_values)) $attribute_values=array();

        $status = $this->input->post("status",true);
        if(!isset($status) || $status=='') $status='0';

        $optional = $this->input->post("optional",true);
        if(!isset($optional) || $optional=='') $optional='0';

        $multiselect = $this->input->post("multiselect",true);
        if(!isset($multiselect) || $multiselect=='') $multiselect='0';

        $inserted_data = array
        (
        	"store_id"=>$store_id,
          "attribute_name"=>$attribute_name,
        	"attribute_values"=>json_encode($attribute_values),
        	"status"=>$status,
        	"user_id"=>$this->user_id,
          "updated_at"=>date("Y-m-d H:i:s"),
          "optional"=>$optional,
          "multiselect"=>$multiselect,
        );

        if($this->basic->insert_data("ecommerce_attribute",$inserted_data))
        {
            $result['status'] = "1";
            $result['message'] = $this->lang->line("Attribute has been added successfully.");
        }            

        echo json_encode($result);
    }
  }

  public function ajax_get_attribute_update_info()
  {

    $this->ajax_check();

    $table_id = $this->input->post("table_id");
    $user_id = $this->user_id;

    if($table_id == "0" || $table_id == "") exit;

    $details = $this->basic->get_data("ecommerce_attribute",array('where'=>array('id'=> $table_id, 'user_id'=> $user_id)));
    $values = json_decode($details[0]['attribute_values'],true);
    $selected=($details[0]['status']=='1') ? 'checked' : '';
    $selected2=($details[0]['optional']=='1') ? 'checked' : '';
    $selected3=($details[0]['multiselect']=='1') ? 'checked' : '';

    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Store");

    $form = ' <div class="row">
                <div class="col-12">                    
                  <form action="#" enctype="multipart/form-data" id="row_update_form" method="post">
                    <input type="hidden" name="table_id" value="'.$table_id.'">
                    <div class="row">

                        <div class="col-12">
                          <div class="form-group">
                            <label for="name">'.$this->lang->line("Store").' *</label>
                            '.form_dropdown('', $store_list, $details[0]['store_id'],' style="width:100%;" disabled class="form-control seelct"').'
                          </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>'.$this->lang->line('Attribute Name').' *</label>
                                <input type="text" class="form-control" name="attribute_name2" id="attribute_name2" value="'.$details[0]['attribute_name'].'">
                            </div>
                        </div>

                        <div class="col-12">
                          <div class="form-group">
                            <label>'.$this->lang->line('Attribute Values').' * ('.$this->lang->line('comma separated').')</label>
                            <select name="attribute_values2[]" id="attribute_values2" multiple class="form-control" style="width:100%;">';
                            foreach($values as $val)
                            $form .='<option value="'.$val.'" selected>'.$val.'</option>';
          							    $form .= '
          							    </select>
          		            </div>
          		          </div>

                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label class="custom-switch mt-2">
                              <input type="checkbox" name="multiselect2" id="multiselect2" value="1" class="custom-switch-input" '.$selected3.'>
                              <span class="custom-switch-indicator"></span>
                              <span class="custom-switch-description">
                                '.$this->lang->line('Multi-select').'
                                <a href="#" class="d-inline" data-placement="top" data-toggle="popover" data-trigger="focus" title="'. $this->lang->line("Multi-select").'" data-content="'.$this->lang->line("If enabled, buyer can select multiple values for this attribute.").'"><i class="fas fa-info-circle"></i> </a>
                              </span>
                            </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label class="custom-switch mt-2">
                              <input type="checkbox" name="optional2" id="optional2" value="1" class="custom-switch-input"  '.$selected2.'>
                              <span class="custom-switch-indicator"></span>
                              <span class="custom-switch-description">
                              '.$this->lang->line('Optional').'
                              <a href="#" class="d-inline" data-placement="top" data-toggle="popover" data-trigger="focus" title="'. $this->lang->line("Optional").'" data-content="'.$this->lang->line("If enabled, buyer can skip selecting this attribute.").'"><i class="fas fa-info-circle"></i> </a>
                              </span>
                            </label>
                            </div>
                        </div>

    		                <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label class="custom-switch mt-2">
                              <input type="checkbox" name="status2" id="status2" value="1" class="custom-switch-input" '.$selected.'>
                              <span class="custom-switch-indicator"></span>
                              <span class="custom-switch-description">'.$this->lang->line('Active').'</span>
                            </label>
                            </div>
                        </div>
                		</div>
                  </form>
                </div>
              </div>
              <script>$("#attribute_values2").select2();$("#attribute_values2").select2({placeholder: "",tags: true,tokenSeparators: [","]});$(\'[data-toggle="popover"]\').popover(); $(\'[data-toggle="popover"]\').on("click", function(e) {e.preventDefault(); return true;});</script>';
    echo $form;
  }

  public function ajax_update_attribute()
  {
    $this->ajax_check();
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));

    if($_POST) 
    {
    	$table_id = $this->input->post("table_id",true);
        $attribute_name = strip_tags($this->input->post("attribute_name2",true));

        $attribute_values = $this->input->post("attribute_values2",true);
        if(!is_array($attribute_values)) $attribute_values=array();

        $status = $this->input->post("status2",true);
        if(!isset($status) || $status=='') $status='0';

        $optional = $this->input->post("optional2",true);
        if(!isset($optional) || $optional=='') $optional='0';

        $multiselect = $this->input->post("multiselect2",true);
        if(!isset($multiselect) || $multiselect=='') $multiselect='0';

        $updated_data = array
        (
        	"attribute_name"=>$attribute_name,
        	"attribute_values"=>json_encode($attribute_values),
        	"status"=>$status,
          "updated_at"=>date("Y-m-d H:i:s"),
          "optional"=>$optional,
          "multiselect"=>$multiselect
        );

        if($this->basic->update_data("ecommerce_attribute",array("id"=>$table_id,"user_id"=>$this->user_id),$updated_data))
        {
            $result['status'] = "1";
            $result['message'] = $this->lang->line("Attribute has been updated successfully.");
        }                     

        echo json_encode($result);
    }
  }

  public function delete_attribute()
  {
    $this->ajax_check();
    $table_id = $this->input->post("table_id");
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));
    if($table_id == "0" || $table_id == "")
    {
    	echo json_encode($result); 
    	exit();
    }

    if($this->basic->delete_data("ecommerce_attribute", array("id"=>$table_id,'user_id'=>$this->user_id)))       	
    echo json_encode(array('message' => $this->lang->line("Attribute has been deleted successfully."),'status'=>'1'));       	
    else echo json_encode($result);  
  }

  public function pickup_point_list()
  {
    $data['body'] = 'ecommerce/pickup_point_list'; 
    $data['page_title'] = $this->lang->line('Delivery Point')." : ".$this->session->userdata("ecommerce_selected_store_title");
    $data["iframe"]="1";      
    $this->_viewcontroller($data);
  }

  public function pickup_point_list_data()
  {
    $search_value = $_POST['search']['value'];
    $display_columns = array("#",'CHECKBOX','point_name','point_details','status','actions');
    $search_columns = array('point_name');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
    $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'point_name';
    $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
    $order_by=$sort." ".$order;

    $where_custom = '';
    $where_custom="ecommerce_cart_pickup_points.store_id = ".$this->session->userdata("ecommerce_selected_store");
    if($search_value != '') 
    {
        foreach ($search_columns as $key => $value) 
        $temp[] = $value." LIKE "."'%$search_value%'";
        $imp = implode(" OR ", $temp);
        $where_custom .=" AND (".$imp.") ";
    }   

    $table = "ecommerce_cart_pickup_points";
    // $select = "ecommerce_cart_pickup_points.*,ecommerce_store.store_name";
    // $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_cart_pickup_points.store_id,left");
    $this->db->where($where_custom);
    $info = $this->basic->get_data($table,$where='',$select='',$join='',$limit,$start,$order_by,$group_by='');

    $this->db->where($where_custom);
    $total_rows_array = $this->basic->count_row($table,$where='',$count="ecommerce_cart_pickup_points.id",$join,$group_by='');
    $total_result=$total_rows_array[0]['total_rows'];

    foreach ($info as $key => $value) 
    {
        $info[$key]['actions'] = "<div style='min-width:100px'><a href='#' title='".$this->lang->line("Edit")."' data-toggle='tooltip' class='btn btn-circle btn-outline-warning edit_row' table_id='".$info[$key]['id']."'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;";
        $info[$key]['actions'] .= "<a href='#' title='".$this->lang->line("Delete")."' data-toggle='tooltip' class='btn btn-circle btn-outline-danger delete_row' table_id='".$info[$key]['id']."'><i class='fa fa-trash-alt'></i></a></div>
            <script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";
        if($info[$key]['status'] == 1) $info[$key]['status'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> ".$this->lang->line('Active')."</span>";
        else $info[$key]['status'] = "<span class='badge badge-status text-danger'><i class='fa fa-times-circle red'></i> ".$this->lang->line('Inactive')."</span>";
    }
    $data['draw'] = (int)$_POST['draw'] + 1;
    $data['recordsTotal'] = $total_result;
    $data['recordsFiltered'] = $total_result;
    $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
    echo json_encode($data);
  }

  public function ajax_create_new_pickup_point()
  {
    $this->ajax_check();
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));

    if($_POST) 
    {
        $point_name = strip_tags($this->input->post("point_name",true));
        $point_details = strip_tags($this->input->post("point_details",true));
        $store_id = $this->input->post("store_id",true);      

        $status = $this->input->post("status",true);
        if(!isset($status) || $status=='') $status='0';

        $inserted_data = array
        (
          "store_id"=>$store_id,
          "point_name"=>$point_name,
          "point_details"=>$point_details,
          "status"=>$status
        );

        if($this->basic->insert_data("ecommerce_cart_pickup_points",$inserted_data))
        {
            $result['status'] = "1";
            $result['message'] = $this->lang->line("Delivery point has been added successfully.");
        }            

        echo json_encode($result);
    }
  }

  public function ajax_get_pickup_point_update_info()
  {

    $this->ajax_check();

    $table_id = $this->input->post("table_id");
    $user_id = $this->user_id;

    if($table_id == "0" || $table_id == "") exit;

    $details = $this->basic->get_data("ecommerce_cart_pickup_points",array('where'=>array('id'=> $table_id, 'store_id'=> $this->session->userdata('ecommerce_selected_store'))));
    $selected=($details[0]['status']=='1') ? 'checked' : '';

    $form = ' <div class="row">
                <div class="col-12">                    
                  <form action="#" enctype="multipart/form-data" id="row_update_form" method="post">
                    <input type="hidden" name="table_id" value="'.$table_id.'">
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label>'.$this->lang->line('Point Name').' *</label>
                                <input type="text" class="form-control" name="point_name2" id="point_name2" value="'.$details[0]['point_name'].'">
                            </div>
                        </div>

                        <div class="col-12">
                          <div class="form-group">
                            <label>'.$this->lang->line('Point Details').' * </label>
                             <textarea id="point_details2" name="point_details2" class="form-control">'.$details[0]['point_details'].'</textarea>
                          </div>
                        </div>

                        <div class="col-12 col-md-4">
                          <div class="form-group">
                            <label class="custom-switch mt-2">
                              <input type="checkbox" name="status2" id="status2" value="1" class="custom-switch-input" '.$selected.'>
                              <span class="custom-switch-indicator"></span>
                              <span class="custom-switch-description">'.$this->lang->line('Active').'</span>
                            </label>
                            </div>
                        </div>
                    </div>
                  </form>
                </div>
              </div>
              <script>$(\'[data-toggle="popover"]\').popover(); $(\'[data-toggle="popover"]\').on("click", function(e) {e.preventDefault(); return true;});</script>';
    echo $form;
  }

  public function ajax_update_pickup_point()
  {
    $this->ajax_check();
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));

    if($_POST) 
    {
        $table_id = $this->input->post("table_id",true);
        $point_name = strip_tags($this->input->post("point_name2",true));
        $point_details = strip_tags($this->input->post("point_details2",true));      

        $status = $this->input->post("status2",true);
        if(!isset($status) || $status=='') $status='0';
        $updated_data = array
        (
          "point_name"=>$point_name,
          "point_details"=>$point_details,
          "status"=>$status
        );

        if($this->basic->update_data("ecommerce_cart_pickup_points",array("id"=>$table_id,"store_id"=>$this->session->userdata("ecommerce_selected_store")),$updated_data))
        {
            $result['status'] = "1";
            $result['message'] = $this->lang->line("Delivery point has been updated successfully.");
        }                     

        echo json_encode($result);
    }
  }

  public function delete_pickup_point()
  {
    $this->ajax_check();
    $table_id = $this->input->post("table_id");
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));
    if($table_id == "0" || $table_id == "")
    {
      echo json_encode($result); 
      exit();
    }

    if($this->basic->delete_data(" ecommerce_cart_pickup_points", array("id"=>$table_id,"store_id"=>$this->session->userdata("ecommerce_selected_store"))))         
    echo json_encode(array('message' => $this->lang->line("Delivery point has been deleted successfully."),'status'=>'1'));         
    else echo json_encode($result);  
  }



  public function category_list()
  {
    $data['body'] = 'ecommerce/category_list'; 
    $data['page_title'] = $this->lang->line('Category')." : ".$this->session->userdata("ecommerce_selected_store_title");
    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Store");
    $data['store_list'] = $store_list; 
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }

  public function category_list_data()
  {
    $search_value = $_POST['search']['value'];
    $display_columns = array("#",'CHECKBOX','category_name','status','actions','store_name','updated_at',);
    $search_columns = array('category_name','store_name');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
    $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'category_name';
    $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
    $order_by=$sort." ".$order;

    $where_custom = '';
    $where_custom="ecommerce_category.user_id = ".$this->user_id." AND ecommerce_category.store_id = ".$this->session->userdata("ecommerce_selected_store");
    if($search_value != '') 
    {
        foreach ($search_columns as $key => $value) 
        $temp[] = $value." LIKE "."'%$search_value%'";
        $imp = implode(" OR ", $temp);
        $where_custom .=" AND (".$imp.") ";
    }

    $table = "ecommerce_category";
    $select = "ecommerce_category.*,ecommerce_store.store_name";
    $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_category.store_id,left");
    $this->db->where($where_custom);
    $info = $this->basic->get_data($table,$where='',$select,$join,$limit,$start,$order_by,$group_by='');

    $this->db->where($where_custom);
    $total_rows_array = $this->basic->count_row($table,$where='',$count="ecommerce_category.id",$join,$group_by='');
    $total_result=$total_rows_array[0]['total_rows'];

    foreach ($info as $key => $value) 
    {
        $info[$key]['actions'] = "<div style='min-width:100px'><a href='#' title='".$this->lang->line("Edit")."' data-toggle='tooltip' class='btn btn-circle btn-outline-warning edit_row' table_id='".$info[$key]['id']."'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;";

        $info[$key]['actions'] .= "<a href='#' title='".$this->lang->line("Delete")."' data-toggle='tooltip' class='btn btn-circle btn-outline-danger delete_row' table_id='".$info[$key]['id']."'><i class='fa fa-trash-alt'></i></a></div>
            <script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";

        if($info[$key]['status'] == 1) $info[$key]['status'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> ".$this->lang->line('Active')."</span>";
        else $info[$key]['status'] = "<span class='badge badge-status text-danger'><i class='fa fa-times-circle red'></i> ".$this->lang->line('Inactive')."</span>";

        $info[$key]['updated_at'] = date("jS M y H:i",strtotime($info[$key]['updated_at']));   
    }

    $data['draw'] = (int)$_POST['draw'] + 1;
    $data['recordsTotal'] = $total_result;
    $data['recordsFiltered'] = $total_result;
    $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
    echo json_encode($data);
  }

  public function ajax_create_new_category()
  {
    $this->ajax_check();
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));

    if($_POST) 
    {
        $category_name = strip_tags($this->input->post("category_name",true));
        $store_id = $this->input->post("store_id",true);

        $status = $this->input->post("status",true);
        if(!isset($status) || $status=='') $status='0';

        $inserted_data = array
        (
            "store_id"=>$store_id,
            "category_name"=>$category_name,
            "status"=>$status,
            "user_id"=>$this->user_id,
            "updated_at"=>date("Y-m-d H:i:s")
        );

        if($this->basic->insert_data("ecommerce_category",$inserted_data))
        {
            $result['status'] = "1";
            $result['message'] = $this->lang->line("Category has been added successfully.");
        }            

        echo json_encode($result);

    }
  }

  public function ajax_get_category_update_info()
  {

    $this->ajax_check();

    $table_id = $this->input->post("table_id");
    $user_id = $this->user_id;

    if($table_id == "0" || $table_id == "") exit;

    $details = $this->basic->get_data("ecommerce_category",array('where'=>array('id'=> $table_id, 'user_id'=> $user_id)));
    $selected=($details[0]['status']=='1') ? 'checked' : '';

    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Store");

    $form = '<div class="row">
                <div class="col-12">                    
                    <form action="#" enctype="multipart/form-data" id="row_update_form" method="post">
                        <input type="hidden" name="table_id" value="'.$table_id.'">
                        <div class="row">
                            <div class="col-12">
                              <div class="form-group">
                                <label for="name">'.$this->lang->line("Store").' *</label>
                                '.form_dropdown('', $store_list, $details[0]['store_id'],' style="width:100%;" disabled class="form-control seelct"').'
                              </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>'.$this->lang->line('Category Name').' *</label>
                                    <input type="text" class="form-control" name="category_name2" id="category_name2" value="'.$details[0]['category_name'].'">
                                </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group">
                                <label class="custom-switch mt-2">
                                  <input type="checkbox" name="status2" id="status2" value="1" class="custom-switch-input" '.$selected.'>
                                  <span class="custom-switch-indicator"></span>
                                  <span class="custom-switch-description">'.$this->lang->line('Active').'</span>
                                </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>';
    echo $form;
  }

  public function ajax_update_category()
  {
    $this->ajax_check();
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));

    if($_POST) 
    {
        $table_id = $this->input->post("table_id",true);
        $category_name = strip_tags($this->input->post("category_name2",true));

        $status = $this->input->post("status2",true);
        if(!isset($status) || $status=='') $status='0';

        $updated_data = array
        (
            "category_name"=>$category_name,
            "status"=>$status,                
            "updated_at"=>date("Y-m-d H:i:s")
        );

        if($this->basic->update_data("ecommerce_category",array("id"=>$table_id,"user_id"=>$this->user_id),$updated_data))
        {
            $result['status'] = "1";
            $result['message'] = $this->lang->line("Category has been updated successfully.");
        }                     

        echo json_encode($result);

    }
  }

  public function delete_category()
  {
    $this->ajax_check();
    $table_id = $this->input->post("table_id");
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));
    if($table_id == "0" || $table_id == "")
    {
        echo json_encode($result); 
        exit();
    }

    if($this->basic->delete_data("ecommerce_category", array("id"=>$table_id,'user_id'=>$this->user_id)))          
    echo json_encode(array('message' => $this->lang->line("Category has been deleted successfully."),'status'=>'1'));        
    else echo json_encode($result);  
  }  

  public function coupon_list()
  {
    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Store");
    $data['store_list'] = $store_list;

    $data['body'] = 'ecommerce/coupon_list';
    $data['page_title'] = $this->lang->line('Coupon')." : ".$this->session->userdata("ecommerce_selected_store_title");
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }


  public function coupon_list_data()
  { 
    $this->ajax_check();

    $search_value = $this->input->post("search_value");
    $store_id = $this->input->post("search_store_id");        
    $search_date_range = $this->input->post("search_date_range");

    $display_columns = 
    array(
      "#",
      "CHECKBOX",
      'coupon_code',
      'coupon_amount',
      'coupon_type',
      'expiry_date',
      'status',
      'actions',
      'store_name',
      'free_shipping_enabled',
      'used',
      'updated_at',
    );
    $search_columns = array('coupon_code','coupon_amount');

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 5;
    $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'expiry_date';
    $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
    $order_by=$sort." ".$order;

    $where_custom="ecommerce_coupon.user_id = ".$this->user_id;

    if ($search_value != '') 
    {
        foreach ($search_columns as $key => $value) 
        $temp[] = $value." LIKE "."'%$search_value%'";
        $imp = implode(" OR ", $temp);
        $where_custom .=" AND (".$imp.") ";
    }
    if($search_date_range!="")
    {
        $exp = explode('|', $search_date_range);
        $from_date = isset($exp[0])?$exp[0]:"";
        $to_date = isset($exp[1])?$exp[1]:"";
        if($from_date!="Invalid date" && $to_date!="Invalid date")
        $where_custom .= " AND expiry_date >= '{$from_date}' AND expiry_date <='{$to_date}'";
    }
    $this->db->where($where_custom);

    if($store_id!="") $this->db->where(array("store_id"=>$store_id));       
    
    $table="ecommerce_coupon";
    $select = "ecommerce_coupon.*,ecommerce_store.store_name";
    $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_coupon.store_id,left");
    $info=$this->basic->get_data($table,$where='',$select,$join,$limit,$start,$order_by,$group_by='');

    // echo $this->db->last_query(); exit();
    
    $this->db->where($where_custom);
    if($store_id!="") $this->db->where(array("store_id"=>$store_id)); 
    $total_rows_array=$this->basic->count_row($table,$where='',$count=$table.".id",$join,$group_by='');

    $total_result=$total_rows_array[0]['total_rows'];

    foreach($info as $key => $value) 
    {
        $expiry_date = date("M j, y H:i",strtotime($info[$key]['expiry_date']));
        $info[$key]['expiry_date'] =  "<div style='min-width:110px;'>".$expiry_date."</div>";

        $updated_at = date("M j, y H:i",strtotime($info[$key]['updated_at']));
        $info[$key]['updated_at'] =  "<div style='min-width:110px;'>".$updated_at."</div>";

        $info[$key]['actions'] = "<div style='min-width:100px'><a href='".base_url("ecommerce/edit_coupon/".$info[$key]['id'])."' title='".$this->lang->line("Edit")."' data-toggle='tooltip' class='btn btn-circle btn-outline-warning edit_row' table_id='".$info[$key]['id']."'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;";
        $info[$key]['actions'] .= "<a href='#' title='".$this->lang->line("Delete")."' data-toggle='tooltip' class='btn btn-circle btn-outline-danger delete_row' table_id='".$info[$key]['id']."'><i class='fa fa-trash-alt'></i></a></div>
            <script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";

        if($info[$key]['status'] == 1) $info[$key]['status'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> ".$this->lang->line('Active')."</span>";
        else $info[$key]['status'] = "<span class='badge badge-status text-danger'><i class='fa fa-times-circle red'></i> ".$this->lang->line('Inactive')."</span>"; 

        if($info[$key]['free_shipping_enabled'] == 1) $info[$key]['free_shipping_enabled'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> ".$this->lang->line('Enabled')."</span>";
        else $info[$key]['free_shipping_enabled'] = "<span class='badge badge-status text-danger'><i class='fa fa-times red'></i> ".$this->lang->line('Disabled')."</span>";

        if($info[$key]['max_usage_limit'] == '' || $info[$key]['max_usage_limit'] == '0')  $info[$key]['max_usage_limit'] = '∞';
        $info[$key]['used'] = $info[$key]['used']."/".$info[$key]['max_usage_limit'];

        $info[$key]['coupon_type'] = ucfirst($info[$key]['coupon_type']);
    }
    $data['draw'] = (int)$_POST['draw'] + 1;
    $data['recordsTotal'] = $total_result;
    $data['recordsFiltered'] = $total_result;
    $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
    echo json_encode($data);
  }

  public function add_coupon()
  {       
    $data['body']='ecommerce/coupon_add';     
    $data['page_title']=$this->lang->line('Add Coupon')." : ".$this->session->userdata("ecommerce_selected_store_title");

    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Select Store");
    $data['store_list'] = $store_list;

    $product_list = $this->get_product_list();  
    $product_list['0'] = $this->lang->line("Select Product");
    $data['product_list'] = $product_list;

    $data['coupon_type_list'] = $this->basic->get_enum_values("ecommerce_coupon","coupon_type");
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }


  public function add_coupon_action() 
  {
    if($_SERVER['REQUEST_METHOD'] === 'GET') 
    redirect('home/access_forbidden','location');

    if($_POST)
    {
      $this->form_validation->set_rules('store_id', '<b>'.$this->lang->line("Store").'</b>', 'trim|required');      
      $this->form_validation->set_rules('coupon_code', '<b>'.$this->lang->line("Coupon code").'</b>', 'trim|required|callback_check_coupon');      
      $this->form_validation->set_rules('coupon_amount', '<b>'.$this->lang->line("Coupon amount").'</b>', 'trim|required');      
      $this->form_validation->set_rules('expiry_date', '<b>'.$this->lang->line("Expiry date").'</b>', 'trim|required');      
      $this->form_validation->set_rules('max_usage_limit', '<b>'.$this->lang->line("Max usage limit").'</b>', 'trim|numeric');
          
      if ($this->form_validation->run() == FALSE)
      {
          $this->add_coupon(); 
      }
      else
      {           

          $store_id=$this->input->post('store_id',true);
          $product_ids=$this->input->post('product_ids',true);
          $coupon_type=$this->input->post('coupon_type',true);
          $coupon_code=strip_tags($this->input->post('coupon_code',true));
          $coupon_amount=$this->input->post('coupon_amount',true);
          $expiry_date=$this->input->post('expiry_date',true);
          $max_usage_limit=$this->input->post('max_usage_limit',true);
          $free_shipping_enabled=$this->input->post('free_shipping_enabled',true);
          $status=$this->input->post('status',true);

          if($status=='') $status='0';
          if($free_shipping_enabled=='') $free_shipping_enabled='0';
          if(!isset($product_ids) || !is_array($product_ids) || empty($product_ids)) $product_ids = '0';
          else $product_ids = implode(',', $product_ids);
                                                 
          $data=array
          (
              'store_id'=>$store_id,
              'product_ids'=>$product_ids,
              'coupon_type'=>$coupon_type,
              'coupon_code'=>$coupon_code,
              'coupon_amount'=>$coupon_amount,
              'expiry_date'=>$expiry_date,
              'max_usage_limit'=>$max_usage_limit,
              'free_shipping_enabled'=>$free_shipping_enabled,
              'status'=>$status,
              'updated_at' => date("Y-m-d H:i:s"),
              'user_id'=>$this->user_id
          );

          
          if($this->basic->insert_data('ecommerce_coupon',$data)) $this->session->set_flashdata('success_message',1);   
          else $this->session->set_flashdata('error_message',1);     
          
          redirect('ecommerce/coupon_list','location');
      }
    }   
  }


  public function edit_coupon($id='0')
  {       
    if($id=='0') exit();
    $data['body']='ecommerce/coupon_edit';     
    $data['page_title']=$this->lang->line('Edit Coupon')." : ".$this->session->userdata("ecommerce_selected_store_title");

    $store_list = $this->get_store_list();  
    $store_list[''] = $this->lang->line("Select Store");
    $data['store_list'] = $store_list;

    $product_list = $this->get_product_list();  
    $product_list['0'] = $this->lang->line("Select Product");
    $data['product_list'] = $product_list;

    $data['coupon_type_list'] = $this->basic->get_enum_values("ecommerce_coupon","coupon_type");

    $xdata = $this->basic->get_data("ecommerce_coupon",array('where'=>array('id'=>$id,"user_id"=>$this->user_id)));
    if(!isset($xdata[0])) exit();
    $data['xdata'] = $xdata[0];
    $data["iframe"]="1";
    
    $this->_viewcontroller($data);
  }

  public function edit_coupon_action() 
  {
    if($_SERVER['REQUEST_METHOD'] === 'GET') 
    redirect('home/access_forbidden','location');

    if($_POST)
    {
        $id=$this->input->post('hidden_id',true);
        // $this->form_validation->set_rules('store_id', '<b>'.$this->lang->line("Store").'</b>', 'trim|required');      
        $this->form_validation->set_rules('coupon_code', '<b>'.$this->lang->line("Coupon code").'</b>', 'trim|required|callback_check_coupon');      
        $this->form_validation->set_rules('coupon_amount', '<b>'.$this->lang->line("Coupon amount").'</b>', 'trim|required');      
        $this->form_validation->set_rules('expiry_date', '<b>'.$this->lang->line("Expiry date").'</b>', 'trim|required');      
        $this->form_validation->set_rules('max_usage_limit', '<b>'.$this->lang->line("Max usage limit").'</b>', 'trim|numeric');
            
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit_coupon($id); 
        }
        else
        {   
            // $store_id=$this->input->post('store_id',true);
            $product_ids=$this->input->post('product_ids',true);
            $coupon_type=$this->input->post('coupon_type',true);
            $coupon_code=strip_tags($this->input->post('coupon_code',true));
            $coupon_amount=$this->input->post('coupon_amount',true);
            $expiry_date=$this->input->post('expiry_date',true);
            $max_usage_limit=$this->input->post('max_usage_limit',true);
            $free_shipping_enabled=$this->input->post('free_shipping_enabled',true);
            $status=$this->input->post('status',true);

            if($status=='') $status='0';
            if($free_shipping_enabled=='') $free_shipping_enabled='0';
            if(!isset($product_ids) || !is_array($product_ids) || empty($product_ids)) $product_ids = '0';
            else $product_ids = implode(',', $product_ids);
                                                   
            $data=array
            (
                'product_ids'=>$product_ids,
                'coupon_type'=>$coupon_type,
                'coupon_code'=>$coupon_code,
                'coupon_amount'=>$coupon_amount,
                'expiry_date'=>$expiry_date,
                'max_usage_limit'=>$max_usage_limit,
                'free_shipping_enabled'=>$free_shipping_enabled,
                'status'=>$status,
                'updated_at' => date("Y-m-d H:i:s")
            );

            
            if($this->basic->update_data('ecommerce_coupon',array("id"=>$id,"user_id"=>$this->user_id),$data)) $this->session->set_flashdata('success_message',1);   
            else $this->session->set_flashdata('error_message',1); 
            redirect('ecommerce/coupon_list','location');                 
            
        }
    }   
  }

  public function delete_coupon()
  {
    $this->ajax_check();
    $table_id = $this->input->post("table_id");
    $result = array('status'=>'0','message'=>$this->lang->line("Something went wrong, please try once again."));
    if($table_id == "0" || $table_id == "")
    {
        echo json_encode($result); 
        exit();
    }

    if($this->basic->delete_data("ecommerce_coupon", array("id"=>$table_id,'user_id'=>$this->user_id)))          
    echo json_encode(array('message' => $this->lang->line("Coupon has been deleted successfully."),'status'=>'1'));          
    else echo json_encode($result);  
  }

  public function upload_product_thumb() 
  {
      // Kicks out if not a ajax request
      $this->ajax_check();

      if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
          exit();
      }

      $upload_dir = APPPATH . '../upload/ecommerce';

      // Makes upload directory
      if( ! file_exists($upload_dir)) {
          mkdir($upload_dir, 0777, true);
      }

      if (isset($_FILES['file'])) {

        $file_size = $_FILES['file']['size'];
        if ($file_size > 1048576) {
            $message = $this->lang->line('The file size exceeds the limit. Please remove the file and upload again.');
            echo json_encode(['error' => $message]);
            exit;
        }
        
        // Holds tmp file
        $tmp_file = $_FILES['file']['tmp_name'];

          if (is_uploaded_file($tmp_file)) {

            $post_fileName = $_FILES['file']['name'];
            $post_fileName_array = explode('.', $post_fileName);
            $ext = array_pop($post_fileName_array);

            $allow_ext = ['png', 'jpg', 'jpeg'];
            if(! in_array(strtolower($ext), $allow_ext)) {
                $message = $this->lang->line('Invalid file type');
                echo json_encode(['error' => $message]);
                exit;
            }

            $filename = implode('.', $post_fileName_array);
            $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
            $filename = "product_".$this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

            // Moves file to the upload dir
            $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
            if (! @move_uploaded_file($tmp_file, $dest_file)) {
                $message = $this->lang->line('That was not a valid upload file.');
                echo json_encode(['error' => $message]);
                exit;
            }

            // Sets filename to session
            $this->session->set_userdata('product_thumb_uploaded_file', $filename);

            // Returns response
            echo json_encode([ 'filename' => $filename]);
        }
     }        
  }

  public function delete_product_thumb() 
  {
    // Kicks out if not a ajax request
    $this->ajax_check();

    if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
        exit();
    }

    // Upload dir path
    $upload_dir = APPPATH . '../upload/ecommerce';

    // Grabs filename
    $filename = (string) $this->input->post('filename');
    $session_filename = $this->session->userdata('product_thumb_uploaded_file');
    if ($filename !== $session_filename) {
        exit;
    }

    // Prepares file path
    $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;
    
    // Tries to remove file
    if (file_exists($filepath)) {
        // Deletes file from disk
        unlink($filepath);

        // Clears the file from cache 
        clearstatcache();

        // Deletes file from session
        $this->session->unset_userdata('product_thumb_uploaded_file');
        
        echo json_encode(['deleted' => 'yes']);
        exit();
    }

    echo json_encode(['deleted' => 'no']);
  }

  public function upload_featured_image() 
  {
      // Kicks out if not a ajax request
      $this->ajax_check();

      if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
          exit();
      }

      $upload_dir = APPPATH . '../upload/ecommerce';

      // Makes upload directory
      if( ! file_exists($upload_dir)) {
          mkdir($upload_dir, 0777, true);
      }

      if (isset($_FILES['file'])) {

        $file_size = $_FILES['file']['size'];
        if ($file_size > 1048576) {
            $message = $this->lang->line('The file size exceeds the limit. Please remove the file and upload again.');
            echo json_encode(['error' => $message]);
            exit;
        }
        
        // Holds tmp file
        $tmp_file = $_FILES['file']['tmp_name'];

          if (is_uploaded_file($tmp_file)) {

            $post_fileName = $_FILES['file']['name'];
            $post_fileName_array = explode('.', $post_fileName);
            $ext = array_pop($post_fileName_array);

            $allow_ext = ['png', 'jpg', 'jpeg'];
            if(! in_array(strtolower($ext), $allow_ext)) {
                $message = $this->lang->line('Invalid file type');
                echo json_encode(['error' => $message]);
                exit;
            }

            $filename = implode('.', $post_fileName_array);
            $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
            $filename = "fproduct_".$this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

            // Moves file to the upload dir
            $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
            if (! @move_uploaded_file($tmp_file, $dest_file)) {
                $message = $this->lang->line('That was not a valid upload file.');
                echo json_encode(['error' => $message]);
                exit;
            }

            // Returns response
            echo json_encode([ 'filename' => $filename]);
        }
     }        
  }

  public function delete_featured_image() 
  {
    // Kicks out if not a ajax request
    $this->ajax_check();

    if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
        exit();
    }

    // Upload dir path
    $upload_dir = APPPATH . '../upload/ecommerce';

    // Grabs filename
    $filename = (string) $this->input->post('filename');
    $filename_exp = explode('_', $filename);
    if(!isset($filename_exp['1']) || $filename_exp['1']!=$this->user_id) exit();

    // Prepares file path
    $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;
    
    // Tries to remove file
    if (file_exists($filepath)) {
        // Deletes file from disk
        unlink($filepath);

        // Clears the file from cache 
        clearstatcache();

        echo json_encode(['deleted' => 'yes']);
        exit();
    }

    echo json_encode(['deleted' => 'no']);
  }


  public function upload_store_logo() 
  {
    // Kicks out if not a ajax request
    $this->ajax_check();

    if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
        exit();
    }

    $upload_dir = APPPATH . '../upload/ecommerce';

    // Makes upload directory
    if( ! file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

   if (isset($_FILES['file'])) {

        $file_size = $_FILES['file']['size'];
        if ($file_size > 1048576) {
            $message = $this->lang->line('The file size exceeds the limit. Please remove the file and upload again.');
            echo json_encode(['error' => $message]);
            exit;
        }
        
        // Holds tmp file
        $tmp_file = $_FILES['file']['tmp_name'];

        if (is_uploaded_file($tmp_file)) {

            $post_fileName = $_FILES['file']['name'];
            $post_fileName_array = explode('.', $post_fileName);
            $ext = array_pop($post_fileName_array);

            $allow_ext = ['png', 'jpg', 'jpeg'];
            if(! in_array(strtolower($ext), $allow_ext)) {
                $message = $this->lang->line('Invalid file type');
                echo json_encode(['error' => $message]);
                exit;
            }

            $filename = implode('.', $post_fileName_array);
            $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
            $filename = "storelogo_".$this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

            // Moves file to the upload dir
            $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
            if (! @move_uploaded_file($tmp_file, $dest_file)) {
                $message = $this->lang->line('That was not a valid upload file.');
                echo json_encode(['error' => $message]);
                exit;
            }

            // Sets filename to session
            $this->session->set_userdata('store_logo_uploaded_file', $filename);

            // Returns response
            echo json_encode([ 'filename' => $filename]);
        }
     }        
  }

  public function delete_store_logo() 
  {
      // Kicks out if not a ajax request
      $this->ajax_check();

      if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
          exit();
      }

      // Upload dir path
      $upload_dir = APPPATH . '../upload/ecommerce';

      // Grabs filename
      $filename = (string) $this->input->post('filename');
      $session_filename = $this->session->userdata('store_logo_uploaded_file');
      if ($filename !== $session_filename) {
          exit;
      }

      // Prepares file path
      $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;
      
      // Tries to remove file
      if (file_exists($filepath)) {
          // Deletes file from disk
          unlink($filepath);

          // Clears the file from cache 
          clearstatcache();

          // Deletes file from session
          $this->session->unset_userdata('store_logo_uploaded_file');
          
          echo json_encode(['deleted' => 'yes']);
          exit();
      }

      echo json_encode(['deleted' => 'no']);
  }


  public function upload_store_favicon() 
  {
      // Kicks out if not a ajax request
      $this->ajax_check();

      if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
          exit();
      }

      $upload_dir = APPPATH . '../upload/ecommerce';

      // Makes upload directory
      if( ! file_exists($upload_dir)) {
          mkdir($upload_dir, 0777, true);
      }

     if (isset($_FILES['file'])) {

          $file_size = $_FILES['file']['size'];
          if ($file_size > 1048576) {
              $message = $this->lang->line('The file size exceeds the limit. Please remove the file and upload again.');
              echo json_encode(['error' => $message]);
              exit;
          }
          
          // Holds tmp file
          $tmp_file = $_FILES['file']['tmp_name'];

          if (is_uploaded_file($tmp_file)) {

              $post_fileName = $_FILES['file']['name'];
              $post_fileName_array = explode('.', $post_fileName);
              $ext = array_pop($post_fileName_array);

              $allow_ext = ['png', 'jpg', 'jpeg'];
              if(! in_array(strtolower($ext), $allow_ext)) {
                  $message = $this->lang->line('Invalid file type');
                  echo json_encode(['error' => $message]);
                  exit;
              }

              $filename = implode('.', $post_fileName_array);
              $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
              $filename = "storefavicon_".$this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

              // Moves file to the upload dir
              $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
              if (! @move_uploaded_file($tmp_file, $dest_file)) {
                  $message = $this->lang->line('That was not a valid upload file.');
                  echo json_encode(['error' => $message]);
                  exit;
              }

              // Sets filename to session
              $this->session->set_userdata('store_favicon_uploaded_file', $filename);

              // Returns response
              echo json_encode([ 'filename' => $filename]);
          }
     }        
  }

  public function delete_store_favicon() 
  {
      // Kicks out if not a ajax request
      $this->ajax_check();

      if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
          exit();
      }

      // Upload dir path
      $upload_dir = APPPATH . '../upload/ecommerce';

      // Grabs filename
      $filename = (string) $this->input->post('filename');
      $session_filename = $this->session->userdata('store_favicon_uploaded_file');
      if ($filename !== $session_filename) {
          exit;
      }

      // Prepares file path
      $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;
      
      // Tries to remove file
      if (file_exists($filepath)) {
          // Deletes file from disk
          unlink($filepath);

          // Clears the file from cache 
          clearstatcache();

          // Deletes file from session
          $this->session->unset_userdata('store_logo_uploaded_file');
          
          echo json_encode(['deleted' => 'yes']);
          exit();
      }

      echo json_encode(['deleted' => 'no']);
  }

  public function manual_payment_upload_file() 
  {
      // Kicks out if not a ajax request
      $this->ajax_check();

      if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
          exit();
      }

      $upload_dir = APPPATH . '../upload/ecommerce';

      // Makes upload directory
      if( ! file_exists($upload_dir)) {
          mkdir($upload_dir, 0777, true);
      }

     if (isset($_FILES['file'])) {

          $file_size = $_FILES['file']['size'];
          if ($file_size > 5242880) {
              $message = $this->lang->line('The file size exceeds the limit. Allowed size is 5MB. Please remove the file and upload again.');
              echo json_encode(['error' => $message]);
              exit;
          }
          
          // Holds tmp file
          $tmp_file = $_FILES['file']['tmp_name'];

          if (is_uploaded_file($tmp_file)) {

              $post_fileName = $_FILES['file']['name'];
              $post_fileName_array = explode('.', $post_fileName);
              $ext = array_pop($post_fileName_array);

              $allow_ext = ['pdf', 'doc', 'txt', 'png', 'jpg', 'jpeg', 'zip'];
              if(! in_array(strtolower($ext), $allow_ext)) {
                  $message = $this->lang->line('Invalid file type');
                  echo json_encode(['error' => $message]);
                  exit;
              }

              $filename = implode('.', $post_fileName_array);
              $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
              $filename = "payment_" . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

              // Moves file to the upload dir
              $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
              if (! @move_uploaded_file($tmp_file, $dest_file)) {
                  $message = $this->lang->line('That was not a valid upload file.');
                  echo json_encode(['error' => $message]);
                  exit;
              }

              // Sets filename to session
              $this->session->set_userdata('ecommerce_manual_payment_uploaded_file', $filename);

              // Returns response
              echo json_encode([ 'filename' => $filename]);
          }
     }        
  }

  public function manual_payment_delete_file() 
  {
      // Kicks out if not a ajax request
      $this->ajax_check();

      if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
          exit();
      }

      // Upload dir path
      $upload_dir = APPPATH . '../upload/ecommerce';

      // Grabs filename
      $filename = (string) $this->input->post('filename');
      $session_filename = $this->session->userdata('ecommerce_manual_payment_uploaded_file');
      if ($filename !== $session_filename) {
          exit;
      }

      // Prepares file path
      $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;
      
      // Tries to remove file
      if (file_exists($filepath)) {
          // Deletes file from disk
          unlink($filepath);

          // Clears the file from cache 
          clearstatcache();

          // Deletes file from session
          $this->session->unset_userdata('ecommerce_manual_payment_uploaded_file');
          
          echo json_encode(['deleted' => 'yes']);
          exit();
      }

      echo json_encode(['deleted' => 'no']);
  }

  private function valid_cart_data($cart_id=0,$subscriber_id="",$select="")
  {
  	$join = array('ecommerce_store'=>"ecommerce_cart.store_id=ecommerce_store.id,left");
    $where = array('where'=>array("ecommerce_cart.subscriber_id"=>$subscriber_id,"ecommerce_cart.id"=>$cart_id,"action_type!="=>"checkout","ecommerce_store.status"=>"1"));
    if($select=="") $select = array("ecommerce_cart.*","tax_percentage","shipping_charge","store_unique_id","store_locale");
    return $cart_data = $this->basic->get_data("ecommerce_cart",$where,$select,$join);
  }

  private function get_app_id()
  {
    $fb_app_id_info=$this->basic->get_data('facebook_rx_config',$where=array('where'=>array('status'=>'1')),"api_id");
    $fb_app_id = isset($fb_app_id_info[0]['api_id']) ? $fb_app_id_info[0]['api_id'] : "";
    return $fb_app_id;
  }

  public function get_coupon_data($coupon_code='',$store_id='0')
  {
    $data = $this->basic->get_data("ecommerce_coupon",array("where"=>array("store_id"=>$store_id,"coupon_code"=>$coupon_code,"status"=>"1","expiry_date >="=>date("Y-m-d H:i:s"))));
    if(isset($data[0])) 
    {
      if($data[0]['max_usage_limit']>0 && $data[0]['used']==$data[0]["max_usage_limit"]) return array();
      else return $data[0];
    }
    else return array();
  }


  private function get_ecommerce_config($store_id='0')
  {
    if($store_id=='0') $store_id = $this->session->userdata("ecommerce_selected_store");
    $data = $this->basic->get_data("ecommerce_config",array("where"=>array("store_id"=>$store_id)));
    if(isset($data[0])) return $data[0];
    else return array();
  }

  private function get_current_store_data()
  {
    $data = $this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$this->session->userdata("ecommerce_selected_store"),"status"=>"1")),"store_name,id,store_unique_id");
    if(isset($data[0])) return $data[0];
    else return array();
  }

  private function get_current_cart($subscriber_id="",$store_id=0)
  {
    $current_cart = array("cart_count"=>0,"cart_id"=>0,"cart_data"=>array());
    if($store_id!=0 && $subscriber_id!="")
    {          
        $join = array('ecommerce_cart_item'=>"ecommerce_cart.id=ecommerce_cart_item.cart_id,right");
        $where_simple = array("ecommerce_cart.store_id"=>$store_id,"action_type!="=>"checkout");
        if($subscriber_id!="") $where_simple["ecommerce_cart.subscriber_id"] = $subscriber_id;
        else $where_simple["ecommerce_cart.user_id"] = $this->user_id;
        $where = array('where'=>$where_simple);
        $select = array("ecommerce_cart.*","ecommerce_cart_item.id as ecommerce_cart_item_id","cart_id","product_id","unit_price","coupon_info","quantity","attribute_info");
        $cart_data = $this->basic->get_data("ecommerce_cart",$where,$select,$join);
        $cart_id = isset($cart_data[0]['cart_id']) ? $cart_data[0]['cart_id'] : 0;
        $cart_data_final = array();
        foreach ($cart_data as $key => $value) 
        {
          if($value["quantity"]<=0) 
          {
            $this->basic->delete_data("ecommerce_cart_item",array("id"=>$value["ecommerce_cart_item_id"]));
            unset($cart_data[$key]);
          }           
          else $cart_data_final[$value['product_id']] = $value;              
        }
        $cart_count = count($cart_data);
        $cart_url = base_url("ecommerce/cart/".$cart_id."?subscriber_id=".$subscriber_id);
        if($cart_count==0)
        {
          $this->basic->delete_data("ecommerce_cart",array("id"=>$cart_id));
          $cart_id = 0;
          $cart_url= "";
        }
        $current_cart = array("cart_count"=>$cart_count,"cart_id"=>$cart_id,"cart_url"=>$cart_url,"cart_data"=>$cart_data_final,"cart_data_raw"=>$cart_data);          
    }
    return $current_cart;        
  }

  private function get_store_list()
  {
    $store_list = $this->basic->get_data("ecommerce_store",array("where"=>array("user_id"=>$this->user_id,"status"=>"1")),$select='',$join='',$limit='',$start=NULL,$order_by='store_name ASC');
    $store_info=array();
    foreach($store_list as $value)
    {
      $store_info[$value['id']] = $value['store_name'];
    }
    return $store_info;
  }

  private function get_product_list_array($store_id=0,$default_where="",$order_by="")
  {
    $where_simple = array("store_id"=>$store_id,"status"=>"1");
    if(isset($default_where['product_name'])) {
      $product_name = $default_where['product_name'];
      $this->db->where(" product_name LIKE "."'%".$product_name."%'");
      unset($default_where['product_name']);
    }
    if(is_array($default_where) && !empty($default_where))
    {
      foreach($default_where as $key => $value) 
      {
        $where_simple[$key] = $value;
      }
    }      
    if($order_by=="") $order_by = "product_name ASC";     
    $product_list = $this->basic->get_data("ecommerce_product",array("where"=>$where_simple),$select='',$join='',$limit='',$start=NULL,$order_by);
    
    // echo $this->db->last_query();
    return $product_list;
  }

  private function get_category_list($store_id=0)
  {
    if($store_id==0) $store_id = $this->session->userdata("ecommerce_selected_store");
    $cat_list = $this->basic->get_data("ecommerce_category",array("where"=>array("store_id"=>$store_id,"status"=>"1")),$select='',$join='',$limit='',$start=NULL,$order_by='category_name ASC');
    $cat_info=array();
    foreach($cat_list as $value)
    {
      $cat_info[$value['id']] = $value['category_name'];
    }
    return $cat_info;
  }

  private function get_attribute_list($store_id=0,$raw_data=false)
  {
    if($store_id==0) $store_id = $this->session->userdata("ecommerce_selected_store");
    $at_list = $this->basic->get_data("ecommerce_attribute",array("where"=>array("store_id"=>$store_id,"status"=>"1")),$select='',$join='',$limit='',$start=NULL,$order_by='attribute_name ASC');
    if($raw_data) return $at_list;
    $at_info=array();
    foreach($at_list as $value)
    {
      $at_info[$value['id']] = $value['attribute_name'];
    }
    return $at_info;
  }

  public function get_product_list($store_id='0',$ajax='0',$multiselect='0')
  {
    if($ajax=='1') 
    {
        $this->ajax_check();
        if($store_id=='' || $store_id=='0')
        {
            echo form_dropdown('product_ids[]', array(),'','class="form-control select2" id="product_ids" multiple');
            echo "<script>$('.select2').select2();</script>";
            exit();
        }
    }

    $product_list = $this->basic->get_data("ecommerce_product",array("where"=>array("user_id"=>$this->user_id,"store_id"=>$store_id,"status"=>"1")),$select='',$join='',$limit='',$start=NULL,$order_by='product_name ASC');
    $product_info=array();
    foreach($product_list as $value)
    {
      $product_info[$value['id']] = $value['product_name'];
    }

    if($ajax=='0') return $product_info;
    else
    {
        if($multiselect=='0') echo form_dropdown('product_id', $product_info,'','class="form-control select2" id="product_id"');
        else echo form_dropdown('product_ids[]', $product_info,'0','class="form-control select2" id="product_ids" multiple');
        echo "<script>$('.select2').select2();</script>";
    }
  }

  public function check_coupon() 
  {
    $coupon_code = $this->input->post('coupon_code',true);
    $store_id = $this->input->post('store_id',true);
    $id = $this->input->post('hidden_id',true);
    $this->db->select('id');
    $this->db->from('ecommerce_coupon');
    $this->db->where('store_id', $store_id);
    $this->db->where('coupon_code', $coupon_code);
    // $this->db->where('user_id', $this->user_id);
    if($id!='') $this->db->where('id !=', $id);
    $query = $this->db->get();
    $num = $query->num_rows();
    if ($num > 0) 
    {
        $message = "<b>".$this->lang->line("Coupon code")." </b>".$this->lang->line("must be unique");
        $this->form_validation->set_message('check_coupon', $message);
        return FALSE;
    }
    else return TRUE;       
  }


  public function get_template_label_dropdown()
  {
      $this->ajax_check();
      if(!$_POST) exit();
      $page_id=$this->input->post('page_id');// database id

      $label_list=$this->get_page_label($page_id);

      $dropdown=array();
      $js='<script>
            $("document").ready(function()  {
              $("#label_ids").select2();
            });


          </script>';
      $str='';
      foreach ($label_list as  $key=>$value)
      {            
          $str.=  "<option value='{$key}'>".$value."</option>";
      }
      echo json_encode(array('label_option'=>$str,"script"=>$js));
  }

  public function get_template_label_dropdown_edit()
  {
      $this->ajax_check();
      if(!$_POST) exit();
      $page_id=$this->input->post('page_id');// database id
      $table_name="ecommerce_store";
      $id=$this->input->post('id');

      $xdata=$this->basic->get_data($table_name,array("where"=>array("id"=>$id)));
      $xlabel_ids=isset($xdata[0]["label_ids"])?$xdata[0]["label_ids"]:"";
      $xlabel_ids=explode(',', $xlabel_ids);
      $label_list=$this->get_page_label($page_id);

      $dropdown=array();
      $js='<script>
            $("document").ready(function()  {
              $("#label_ids").select2();
              $("#template_id").select2();
            });


          </script>';
      $str='';
      foreach ($label_list as  $key=>$value)
      {            
          if(in_array($key, $xlabel_ids)) $selected="selected";
          else $selected="";
          $str.=  "<option value='{$key}' {$selected}>".$value."</option>";
      }
     

      echo json_encode(array('label_option'=>$str,"script"=>$js));
  }

  private function get_page_label($page_id=0)
  {
      if($page_id==0) return array();  

      if(!$this->db->table_exists('messenger_bot_broadcast_contact_group')) return array();

      $label_data=$this->basic->get_data("messenger_bot_broadcast_contact_group",array("where"=>array("page_id"=>$page_id,"unsubscribe"=>"0","invisible"=>"0")),'','','',$start=NULL,$order_by="group_name ASC");
      $push_label=array();
      foreach ($label_data as $key => $value) 
      {    
          $push_label[$value['id']]=$value['group_name'].' ['.$value['label_id'].']';
      }
      return $push_label;
  }


  private function get_user_page()
  {
      $facebook_rx_fb_user_info = $this->session->userdata('facebook_rx_fb_user_info');

      $page_data=$this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("facebook_rx_fb_user_info_id"=>$facebook_rx_fb_user_info,"bot_enabled"=>"1")),'','','',$start=NULL,$order_by="page_name ASC");
      $push_page=array();
      foreach ($page_data as $key => $value) 
      {
          $push_page[$value['id']]=$value['page_name'];
      }
      return $push_page;
  }

  private function get_payment_status()
  {
    return array('pending'=>$this->lang->line('Pending'),'approved'=>$this->lang->line('Approved'),'rejected'=>$this->lang->line('Rejected'),'shipped'=>$this->lang->line('Shipped'),'delivered'=>$this->lang->line('Delivered'),'completed'=>$this->lang->line('Completed'));
  }


  private function get_page_template($page_id=0)
  {
      if($page_id==0) return array();  

      $postback_data=$this->basic->get_data("messenger_bot_postback",array("where"=>array("page_id"=>$page_id,"is_template"=>"1","template_for"=>"reply_message")),'','','',$start=NULL,$order_by="template_name ASC");
      $push_postback=array();
      foreach ($postback_data as $key => $value) 
      {
          $push_postback[$value['id']]=$value['template_name'].' ['.$value['postback_id'].']';
      }
      return $push_postback;
  }

  private function get_reminder_hour()
  {
    return array(
        "" => "--".$this->lang->line("Do not send")."--",
        "1"=>$this->lang->line("After 1 hour"),
        "2"=>$this->lang->line("After 2 hours"),
        "3"=>$this->lang->line("After 3 hours"),
        "4"=>$this->lang->line("After 4 hours"),
        "5"=>$this->lang->line("After 5 hours"),
        "6"=>$this->lang->line("After 6 hours"),
        "7"=>$this->lang->line("After 7 hours"),
        "8"=>$this->lang->line("After 8 hours"),
        "9"=>$this->lang->line("After 9 hours"),
        "10"=>$this->lang->line("After 10 hours"),
        "11"=>$this->lang->line("After 11 hours"),
        "12"=>$this->lang->line("After 12 hours"),
        "13"=>$this->lang->line("After 13 hours"),
        "14"=>$this->lang->line("After 14 hours"),
        "15"=>$this->lang->line("After 15 hours"),
        "16"=>$this->lang->line("After 16 hours"),
        "17"=>$this->lang->line("After 17 hours"),
        "18"=>$this->lang->line("After 18 hours"),
        "19"=>$this->lang->line("After 19 hours"),
        "20"=>$this->lang->line("After 20 hours"),
        "21"=>$this->lang->line("After 21 hours"),
        "22"=>$this->lang->line("After 22 hours"),
        "23"=>$this->lang->line("After 23 hours"),
      );
  }

  private function get_sms_api()
  {
      $where = array("where" => array('user_id'=>$this->user_id,'status'=>'1'));
      $sms_api_config=$this->basic->get_data('sms_api_config', $where, $select='', $join='', $limit='', $start='', $order_by='phone_number ASC', $group_by='', $num_rows=0);
      $sms_api_config_option=array(''=>$this->lang->line("Select Sender"));
      foreach ($sms_api_config as $info) 
      {
          $id=$info['id'];

          if($info['phone_number'] !="") $sms_api_config_option[$id]=$info['gateway_name'].": ".$info['phone_number'];
          else $sms_api_config_option[$id]=$info['gateway_name'].": ".$info['custom_name'];
      }
      return $sms_api_config_option;
  }

  private function get_email_api()
  {
    
    if(!$this->basic->is_exist("modules",array("id"=>263))) return array();

    /***get smtp  option***/
    $where=array("where"=>array('user_id'=>$this->user_id,'status'=>'1'));
    $smtp_info=$this->basic->get_data('email_smtp_config', $where, $select='', $join='', $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
    
    $smtp_option=array(''=>$this->lang->line("Select Sender"));
    foreach ($smtp_info as $info) {
        $id="email_smtp_config-".$info['id'];
        $smtp_option[$id]="SMTP: ".$info['email_address'];
    }
    
    /***get mandrill option***/
    $where=array("where"=>array('user_id'=>$this->user_id,'status'=>'1'));
    $smtp_info=$this->basic->get_data('email_mandrill_config', $where, $select='', $join='', $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
    
    foreach ($smtp_info as $info) {
        $id="email_mandrill_config-".$info['id'];
        $smtp_option[$id]="Mandrill: ".$info['email_address'];
    }

    /***get sendgrid option***/
    $where=array("where"=>array('user_id'=>$this->user_id,'status'=>'1'));
    $smtp_info=$this->basic->get_data('email_sendgrid_config', $where, $select='', $join='', $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
    
    foreach ($smtp_info as $info) {
        $id="email_sendgrid_config-".$info['id'];
        $smtp_option[$id]="SendGrid: ".$info['email_address'];
    }

    /***get mailgun option***/
    $where=array("where"=>array('user_id'=>$this->user_id,'status'=>'1'));
    $smtp_info=$this->basic->get_data('email_mailgun_config', $where, $select='', $join='', $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
    
    foreach ($smtp_info as $info) {
        $id="email_mailgun_config-".$info['id'];
        $smtp_option[$id]="Mailgun: ".$info['email_address'];
    }
    return $smtp_option;
  }

  private function handle_attachment($id, $file,$format=false) 
  {
      $info = pathinfo($file);
      if (isset($info['extension']) && ! empty($info['extension'])) {
          switch (strtolower($info['extension'])) {
              case 'jpg':
              case 'jpeg':
              case 'png':
              case 'gif':
                  return $this->manual_payment_display_attachment($file,$format);
              case 'zip':
              case 'pdf':
              case 'txt':
              if(!$format)return '<div data-id="' . $id . '" id="mp-download-file" class="btn btn-outline-info" data-toggle="tooltip" title="'.$this->lang->line("Attachment").'"><i class="fas fa-download"></i></div>';
              else return '<a data-id="' . $id . '" id="mp-download-file" href="#" class="dropdown-item has-icon"><i class="fas fa-download"></i> '.$this->lang->line("Download Attachment").'</a>';
          }
      }
  }

  public function manual_payment_download_file() 
  {
      // Prevents out-of-memory issue
      if (ob_get_level()) {
          ob_end_clean();
      }

      // If it is GET request let it download file
      $method = $this->input->method();
      if ('get' == $method) {
          $filename = $this->session->userdata('ecommerce_manual_payment_download_file');

          if (! $filename) {
              $message = $this->lang->line('No file to download.');
              echo json_encode(['msg' => $message]);
          } else {
              $file = FCPATH.'upload/ecommerce/' . $filename;
              header('Expires: 0');
              header('Pragma: public');
              header('Cache-Control: must-revalidate');
              header('Content-Length: ' . filesize($file));
              header('Content-Description: File Transfer');
              header('Content-Type: application/octet-stream');
              header('Content-Disposition: attachment; filename="' . $filename . '"');
              readfile($file);
              $this->session->unset_userdata('ecommerce_manual_payment_download_file');
              exit;
          }

      // If it is POST request, grabs the file
      } elseif ('post' === $method) {
          if (! $this->input->is_ajax_request()) {
              $message = $this->lang->line('Bad Request.');
              echo json_encode(['msg' => $message]);
              exit;
          }

          // Grabs transaction ID
          $id = (int) $this->input->post('file');

          // Checks file owner
          $select = ['id', 'user_id', 'manual_filename'];            
          $where = [
              'where' => [
                  'id' => $id,
                  'user_id' => $this->user_id,
              ],
          ];           

          $result = $this->basic->get_data('ecommerce_cart', $where, $select, [], 1);
          if (1 != count($result)) {
              $message = $this->lang->line('You do not have permission to download this file.');
              echo json_encode(['error' => $message]);
              exit;
          }

          $filename = $result[0]['manual_filename'];
          $this->session->set_userdata('ecommerce_manual_payment_download_file', $filename);

          echo json_encode(['status' => 'ok']);
      }
  }


  private function manual_payment_display_attachment($file,$format=false) 
  {
      $output = '<div class="mp-display-img d-inline">';
      if($format)$output .= '<a data-image="' . $file . '" href="' . $file . '" class="dropdown-item has-icon mp-img-item"><i class="fas fa-image"></i> '.$this->lang->line("View Attachment").'</a>';
      else
      {
        $output .= '<a class="mp-img-item btn btn-outline-info" data-image="' . $file . '" href="' . $file . '">';
        $output .= '<i class="fa fa-image"></i>';
        $output .= '</a>';
      }
      $output .= '</div>';
      $output .= '<script>$(".mp-display-img").Chocolat({className: "mp-display-img", imageSelector: ".mp-img-item"});</script>';

      return $output;
  }



  public function download_csv() // order or contact
  {        
      if($this->is_demo == '1')
      {
          if($this->session->userdata('user_type') == "Admin")
          {
              echo "<div class='alert alert-danger text-center'><i class='fa fa-ban'></i> This function is disabled from admin account in this demo!!</div>";
              exit();
          }
      }

      $latest_order_list_sql = $this->session->userdata("latest_order_list_sql");
      if(empty($latest_order_list_sql)) exit();

      $table="ecommerce_cart";
      $select = "ecommerce_cart.id as order_id,subscriber_id,buyer_first_name,buyer_last_name,buyer_email,buyer_mobile,buyer_country,buyer_city,buyer_state,buyer_address,buyer_zip,coupon_code,coupon_type,discount,payment_amount,currency,ordered_at,transaction_id,card_ending,payment_method,manual_additional_info,paid_at,ecommerce_cart.status as payment_status";
      // $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_cart.store_id,left");
      $join='';
      if(!empty($latest_order_list_sql)) $this->db->where($latest_order_list_sql);
      $info=$this->basic->get_data($table,$where='',$select,$join,$limit='',$start=NULL,$order_by='id asc');
      // echo $this->db->last_query(); exit();

      $head = isset($info[0]) ? array_keys($info[0]) : array();
      if(empty($head)) exit();

      $filename="exported_order_list_".time()."_".$this->user_id.".csv";
      $f = fopen('php://memory', 'w');
      fputs( $f, "\xEF\xBB\xBF" );
      fputcsv($f,$head, ",");

      foreach ($info as $value) 
      {
          $write_info=$value;        
          fputcsv($f, $write_info,',');  
      }

      fseek($f, 0);
      header('Content-Type: application/csv');
      header('Content-Disposition: attachment; filename="'.$filename.'";');
      fpassthru($f);         
  }

  public function get_attribute_values()
  {
    $this->ajax_check();
    if($this->addon_exist('ecommerce_product_price_variation'))
    {
      $response = '';
      if($this->session->userdata('user_type') == 'Admin' || in_array(281,$this->module_access))
      {
        $id = $this->input->post('id',true);
        $info = $this->basic->get_data('ecommerce_attribute',['where'=>['id'=>$id,'user_id'=>$this->user_id]]);
        $attribute_name = isset($info[0]['attribute_name']) ? $info[0]['attribute_name'] : '';
        $values = isset($info[0]['attribute_values']) ? json_decode($info[0]['attribute_values'],true) : [];
        $response = '
                    <div class="col-12" id="attribute_values_'.$id.'">
                      <div class="card">
                        <div class="card-header">
                          <h4>'.$this->lang->line("Set price variation for attribute's values of").' "'.$attribute_name.'"</h4>
                        </div>
                        <div class="card-body attribute_values_body">
                          <div class="table-responsive">
                            <table class="table table-bordered table-md">
                              <tbody>
                              <tr>
                                <th>'.$this->lang->line("Attribute Value").'</th>
                                <th>'.$this->lang->line("Increment/Decrement (with main price)").'</th>
                                <th>'.$this->lang->line("Amount (Keep it blank/Zero for no variation)").'</th>
                              </tr>';
          foreach ($values as $key=>$data) {
            $response .= '<tr>
                            <td>'.$data.'</td>
                            <td>
                              <select class="form-control select2" name="single_attribute_names_'.$id.'_'.$key.'" style="width:100%;">
                                <option value="+">'.$this->lang->line("+").'</option>
                                <option value="-">'.$this->lang->line("-").'</option>
                              </select>
                            </td>
                            <td><input class="form-control" type="text" name="single_attribute_values_'.$id.'_'.$key.'" id="single_attribute_values_'.$id.'_'.$key.'"></td>
                          </tr>';
          }
                              
          $response .= '      </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
      }
    }
    else $response = '';
    
    echo $response;
  }

  public function get_price_basedon_attribues()
  {
    $this->ajax_check();
    $product_id = $this->input->post('product_id',true);
    $store_id = $this->input->post('current_store_id',true);
    $attribute_info = $this->input->post('attribute_info',true);
    $currency_icon = $this->input->post('currency_icon',true);
    $currency_position = $this->input->post('currency_position',true);
    $decimal_point = $this->input->post('decimal_point',true);
    $thousand_comma = $this->input->post('thousand_comma',true);
    $response = [];
    if(!isset($attribute_info) || !is_array($attribute_info)) $attribute_info = array();
    $attribute_info = array_filter($attribute_info);
    // pre($attribute_info);
    $product_info = $this->basic->get_data('ecommerce_product',['where'=>['id'=>$product_id,'store_id'=>$store_id]]);
    $original_price = $product_info[0]['original_price'];
    $sell_price = $product_info[0]['sell_price'];
    $calculated_price_info = $this->calculate_price_basedon_attribute($product_id,$attribute_info,$original_price,$sell_price);
    $response['price_html'] = mec_display_price($calculated_price_info['calculated_original_price'],$calculated_price_info['calculated_sell_price'],$currency_icon,'1',$currency_position,$decimal_point,$thousand_comma);
    echo json_encode($response);
  }

  public function calculate_price_basedon_attribute($product_id=0,$attribute_info=[],$original_price=0,$sell_price=0)
  {
    if($sell_price == 0) $sell_price = $original_price;
    $response = [];

    if($this->addon_exist('ecommerce_product_price_variation'))
    {        
      foreach ($attribute_info as $key=>$value) {
        if(is_array($value))
        {
          foreach ($value as $value2) {
            $attribute_values = $this->basic->get_data('ecommerce_attribute_product_price',['where'=>['product_id'=>$product_id,'attribute_id'=>$key,'attribute_option_name'=>$value2]]);
            if(!empty($attribute_values))
            {
              if(isset($attribute_values[0]['price_indicator']) && $attribute_values[0]['price_indicator']=="+")
              {
                $original_price = $original_price+$attribute_values[0]['amount'];
                $sell_price = $sell_price+$attribute_values[0]['amount'];
              }
              else
              {
                $original_price = $original_price-$attribute_values[0]['amount'];
                $sell_price = $sell_price-$attribute_values[0]['amount'];
              }
            }
          }
        }
        else
        {
          $attribute_values = $this->basic->get_data('ecommerce_attribute_product_price',['where'=>['product_id'=>$product_id,'attribute_id'=>$key,'attribute_option_name'=>$value]]);
          if(!empty($attribute_values))
          {
            if(isset($attribute_values[0]['price_indicator']) && $attribute_values[0]['price_indicator']=="+")
            {
              $original_price = $original_price+$attribute_values[0]['amount'];
              $sell_price = $sell_price+$attribute_values[0]['amount'];
            }
            else
            {
              $original_price = $original_price-$attribute_values[0]['amount'];
              $sell_price = $sell_price-$attribute_values[0]['amount'];
            }
          }
        }

      }
      $response['calculated_original_price'] = $original_price;
      $response['calculated_sell_price'] = $sell_price;    
        
    }
    else
    {
      $response['calculated_original_price'] = $original_price;
      $response['calculated_sell_price'] = $sell_price;
    }
    
    return $response;
  }





}