<?php require_once("Home.php"); // including home controller

class Stripe_action extends Home
{

    public function __construct()
    {
		parent::__construct();
		$this->load->library('Stripe_class');
		$this->load->model('basic');
        set_time_limit(0);
    }
	
	public function index()
    {
	
		$response= $this->stripe_class->stripe_payment_action();


		if($response['status']=='Error'){
			echo $response['message'];
			exit();
		}
		
		$currency = isset($response['charge_info']['currency'])?$response['charge_info']['currency']:"";
		$currency=strtoupper($currency);

		
		$receiver_email=$response['email'];

		if($currency=='JPY' || $currency=='VND')
			$payment_amount=$response['charge_info']['amount'];
		else
			$payment_amount=$response['charge_info']['amount']/100;


		$transaction_id=$response['charge_info']['balance_transaction'];
		$payment_date=date("Y-m-d H:i:s",$response['charge_info']['created']) ;
		$country=isset($response['charge_info']['source']['country'])?$response['charge_info']['source']['country']:"";

		

		
		$stripe_card_source=isset($response['charge_info']['source'])?$response['charge_info']['source']:"";
		$stripe_card_source=json_encode($stripe_card_source);
		
		
		
		$user_id=$this->session->userdata('user_id');
		$package_id=$this->session->userdata('stripe_payment_package_id');
		
		$simple_where['where'] = array('user_id'=>$user_id);
        $select = array('cycle_start_date','cycle_expired_date');
		
        $prev_payment_info = $this->basic->get_data('transaction_history',$simple_where,$select,$join='',$limit='1',$start=0,$order_by='ID DESC',$group_by='');
		
		$prev_cycle_expired_date="";


       $config_data=array();
       $price=0;
       $package_data=$this->basic->get_data("package",$where=array("where"=>array("package.id"=>$package_id)));
       if(is_array($package_data) && array_key_exists(0, $package_data))
       $price=$package_data[0]["price"];
       $validity=$package_data[0]["validity"];

        $validity_str='+'.$validity.' day';
		
		foreach($prev_payment_info as $info){
			$prev_cycle_expired_date=$info['cycle_expired_date'];
		}
		
		if($prev_cycle_expired_date==""){
			 $cycle_start_date=date('Y-m-d');
			 $cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}
		
		else if (strtotime($prev_cycle_expired_date) < strtotime(date('Y-m-d'))){
			$cycle_start_date=date('Y-m-d');
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}
		
		else if (strtotime($prev_cycle_expired_date) > strtotime(date('Y-m-d'))){
			$cycle_start_date=date("Y-m-d",strtotime('+1 day',strtotime($prev_cycle_expired_date)));
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}
		
		
		/** insert the transaction into database ***/
		
		$insert_data=array(
                "verify_status" 	=>"",
                "first_name"		=>"",
				"last_name"			=>"",
				"paypal_email"		=>"STRIPE",
				"receiver_email" 	=>$receiver_email,
				"country"			=>$country,
				"payment_date" 		=>$payment_date,
				"payment_type"		=>"STRIPE",
				"transaction_id"	=>$transaction_id,
                "user_id"           =>$user_id,
				"package_id"		=>$package_id,
				"cycle_start_date"	=>$cycle_start_date,
				"cycle_expired_date"=>$cycle_expired_date,
				"paid_amount"	    =>$payment_amount,
				"stripe_card_source"=>$stripe_card_source
            );
			
			
        $this->basic->insert_data('transaction_history', $insert_data);
        $this->session->set_userdata("payment_success",1);
		
		/** Update user table **/
		$table='users';
		$where=array('id'=>$user_id);
		$data=array('expired_date'=>$cycle_expired_date,"package_id"=>$package_id,"bot_status"=>"1");
		$this->basic->update_data($table,$where,$data);


		$product_short_name = $this->config->item('product_short_name');
        $from = $this->config->item('institute_email');
        $mask = $this->config->item('product_name');
        $subject = "Payment Confirmation";
        $where = array();
        $where['where'] = array('id'=>$user_id);
        $user_email = $this->basic->get_data('users',$where,$select='');

        $payment_confirmation_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'stripe_payment')),array('subject','message'));

        if(isset($payment_confirmation_email_template[0]) && $payment_confirmation_email_template[0]['subject'] != '' && $payment_confirmation_email_template[0]['message'] != '') {

            $to = $user_email[0]['email'];
            $url = base_url();
            $subject = $payment_confirmation_email_template[0]['subject'];
            $message = str_replace(array('#PRODUCT_SHORT_NAME#','#APP_SHORT_NAME#','#CYCLE_EXPIRED_DATE#','#SITE_URL#','#APP_NAME#'),array($product_short_name,$product_short_name,$cycle_expired_date,$url,$mask),$payment_confirmation_email_template[0]['message']);
            //send mail to user
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

        } else {

            $to = $user_email[0]['email'];
            $subject = "Payment Confirmation";
            $message = "Congratulation,<br/> we have received your payment successfully. Now you are able to use {$product_short_name} system till {$cycle_expired_date}.<br/><br/>Thank you,<br/><a href='".base_url()."'>{$mask}</a> team";
            //send mail to user
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

        }

        // new payment made email
        $paypal_new_payment_made_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'stripe_new_payment_made')),array('subject','message'));

        if(isset($paypal_new_payment_made_email_template[0]) && $paypal_new_payment_made_email_template[0]['subject'] !='' && $paypal_new_payment_made_email_template[0]['message'] != '') {

            $to = $from;
            $subject = $paypal_new_payment_made_email_template[0]['subject'];
            $message = str_replace('#PAID_USER_NAME#',$user_email[0]['name'],$paypal_new_payment_made_email_template[0]['message']);
            //send mail to admin
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

        } else {

            $to = $from;
            $subject = "New Payment Made";
            $message = "New payment has been made by {$user_email[0]['name']}";
            //send mail to admin
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);
        }
		
		$redirect_url=base_url()."payment/transaction_log?action=success";
		redirect($redirect_url, 'refresh');
		
		
	}

	public function razorpay_action($raz_order_id_session="")
	{
		$razorpay_key_id = '';
		$razorpay_key_secret = '';
		$where['where'] = array('deleted'=>'0');
		$payment_config = $this->basic->get_data('payment_config',$where,$select='');
		if(!empty($payment_config)) 
		{
		    $currency = $payment_config[0]["currency"];
		    $razorpay_key_id = isset($payment_config[0]['razorpay_key_id']) ? $payment_config[0]['razorpay_key_id'] : '';
		    $razorpay_key_secret = isset($payment_config[0]['razorpay_key_secret']) ? $payment_config[0]['razorpay_key_secret'] : '';
		} 
		else 
		    $currency = "USD";

		$this->load->library('razorpay_class_ecommerce'); 
		$this->razorpay_class_ecommerce->key_id=$razorpay_key_id;    
		$this->razorpay_class_ecommerce->key_secret=$razorpay_key_secret;    
		$response= $this->razorpay_class_ecommerce->razorpay_payment_action($raz_order_id_session);

		if(isset($response['status']) && $response['status']=='Error'){
		  echo $response['message'];
		  exit();
		} 

		$currency = isset($response['charge_info']['currency'])?$response['charge_info']['currency']:"INR";
		$currency = strtoupper($currency);
		$payment_amount = isset($response['charge_info']['amount_paid'])?($response['charge_info']['amount_paid']/100):"0";
		$transaction_id = isset($response['charge_info']['id'])?$response['charge_info']['id']:"";
		$payment_date= isset($response['charge_info']['created_at']) ? date("Y-m-d H:i:s",$response['charge_info']['created_at']) : '';


		$user_id=$this->session->userdata('user_id');
		$package_id=$this->session->userdata('razorpay_payment_package_id');
		
		$simple_where['where'] = array('user_id'=>$user_id);
        $select = array('cycle_start_date','cycle_expired_date');
		
        $prev_payment_info = $this->basic->get_data('transaction_history',$simple_where,$select,$join='',$limit='1',$start=0,$order_by='ID DESC',$group_by='');
		
		$prev_cycle_expired_date="";


       $config_data=array();
       $price=0;
       $package_data=$this->basic->get_data("package",$where=array("where"=>array("package.id"=>$package_id)));
       if(is_array($package_data) && array_key_exists(0, $package_data))
       $price=$package_data[0]["price"];
       $validity=$package_data[0]["validity"];

        $validity_str='+'.$validity.' day';
		
		foreach($prev_payment_info as $info){
			$prev_cycle_expired_date=$info['cycle_expired_date'];
		}
		
		if($prev_cycle_expired_date==""){
			 $cycle_start_date=date('Y-m-d');
			 $cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}
		
		else if (strtotime($prev_cycle_expired_date) < strtotime(date('Y-m-d'))){
			$cycle_start_date=date('Y-m-d');
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}
		
		else if (strtotime($prev_cycle_expired_date) > strtotime(date('Y-m-d'))){
			$cycle_start_date=date("Y-m-d",strtotime('+1 day',strtotime($prev_cycle_expired_date)));
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}

		/** insert the transaction into database ***/
		$receiver_email="";
		$country="";
	 	$insert_data=array(
            "verify_status" 	=>"",
            "first_name"		=>"",
			"last_name"			=>"",
			"paypal_email"		=>"Razorpay",
			"receiver_email" 	=>$receiver_email,
			"country"			=>$country,
			"payment_date" 		=>$payment_date,
			"payment_type"		=>"Razorpay",
			"transaction_id"	=>$transaction_id,
            "user_id"           =>$user_id,
			"package_id"		=>$package_id,
			"cycle_start_date"	=>$cycle_start_date,
			"cycle_expired_date"=>$cycle_expired_date,
			"paid_amount"	    =>$payment_amount
        );
			
			
        $this->basic->insert_data('transaction_history', $insert_data);
        $this->session->set_userdata("payment_success",1);

		/** Update user table **/
		$table='users';
		$where=array('id'=>$user_id);
		$data=array('expired_date'=>$cycle_expired_date,"package_id"=>$package_id,"bot_status"=>"1");
		$this->basic->update_data($table,$where,$data);

		$product_short_name = $this->config->item('product_short_name');
        $from = $this->config->item('institute_email');
        $mask = $this->config->item('product_name');
        $subject = "Payment Confirmation";
        $where = array();
        $where['where'] = array('id'=>$user_id);
        $user_email = $this->basic->get_data('users',$where,$select='');

        $payment_confirmation_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'stripe_payment')),array('subject','message'));

        if(isset($payment_confirmation_email_template[0]) && $payment_confirmation_email_template[0]['subject'] != '' && $payment_confirmation_email_template[0]['message'] != '') {

            $to = $user_email[0]['email'];
            $url = base_url();
            $subject = $payment_confirmation_email_template[0]['subject'];
            $message = str_replace(array('#PRODUCT_SHORT_NAME#','#APP_SHORT_NAME#','#CYCLE_EXPIRED_DATE#','#SITE_URL#','#APP_NAME#'),array($product_short_name,$product_short_name,$cycle_expired_date,$url,$mask),$payment_confirmation_email_template[0]['message']);
            //send mail to user
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

        } else {

            $to = $user_email[0]['email'];
            $subject = "Payment Confirmation";
            $message = "Congratulation,<br/> we have received your payment successfully. Now you are able to use {$product_short_name} system till {$cycle_expired_date}.<br/><br/>Thank you,<br/><a href='".base_url()."'>{$mask}</a> team";
            //send mail to user
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

        }

        // new payment made email
        $paypal_new_payment_made_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'stripe_new_payment_made')),array('subject','message'));

        if(isset($paypal_new_payment_made_email_template[0]) && $paypal_new_payment_made_email_template[0]['subject'] !='' && $paypal_new_payment_made_email_template[0]['message'] != '') {

            $to = $from;
            $subject = $paypal_new_payment_made_email_template[0]['subject'];
            $message = str_replace('#PAID_USER_NAME#',$user_email[0]['name'],$paypal_new_payment_made_email_template[0]['message']);
            //send mail to admin
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

        } else {

            $to = $from;
            $subject = "New Payment Made";
            $message = "New payment has been made by {$user_email[0]['name']}";
            //send mail to admin
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);
        }

		$redirect_url=base_url()."payment/transaction_log?action=success";
		redirect($redirect_url, 'refresh');

	}


	public function paystack_action($reference="")
	{
		$user_id=$this->session->userdata('user_id');
		$package_id=$this->session->userdata('paystack_payment_package_id');

		$paystack_secret_key = '';
		$where['where'] = array('deleted'=>'0');
		$payment_config = $this->basic->get_data('payment_config',$where,$select='');
		if(!empty($payment_config)) 
		{
		    $currency = $payment_config[0]["currency"];
		    $paystack_secret_key = isset($payment_config[0]['paystack_secret_key']) ? $payment_config[0]['paystack_secret_key'] : '';
		} 
		else 
		    $currency = "USD";

		$this->load->library('paystack_class_ecommerce'); 
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

		$simple_where['where'] = array('user_id'=>$user_id);
	    $select = array('cycle_start_date','cycle_expired_date');
		
	    $prev_payment_info = $this->basic->get_data('transaction_history',$simple_where,$select,$join='',$limit='1',$start=0,$order_by='ID DESC',$group_by='');
		
		$prev_cycle_expired_date="";

		$config_data=array();
		$price=0;
		$package_data=$this->basic->get_data("package",$where=array("where"=>array("package.id"=>$package_id)));
		if(is_array($package_data) && array_key_exists(0, $package_data))
		$price=$package_data[0]["price"];
		$validity=$package_data[0]["validity"];

		$validity_str='+'.$validity.' day';

		foreach($prev_payment_info as $info){
			$prev_cycle_expired_date=$info['cycle_expired_date'];
		}

		if($prev_cycle_expired_date==""){
			 $cycle_start_date=date('Y-m-d');
			 $cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}

		else if (strtotime($prev_cycle_expired_date) < strtotime(date('Y-m-d'))){
			$cycle_start_date=date('Y-m-d');
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}

		else if (strtotime($prev_cycle_expired_date) > strtotime(date('Y-m-d'))){
			$cycle_start_date=date("Y-m-d",strtotime('+1 day',strtotime($prev_cycle_expired_date)));
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}

		/** insert the transaction into database ***/
	 	$insert_data=array(
	        "verify_status" 	=>"",
	        "first_name"		=>"",
			"last_name"			=>"",
			"paypal_email"		=>"Paystack",
			"receiver_email" 	=>$receiver_email,
			"country"			=>$country,
			"payment_date" 		=>$payment_date,
			"payment_type"		=>"Paystack",
			"transaction_id"	=>$transaction_id,
	        "user_id"           =>$user_id,
			"package_id"		=>$package_id,
			"cycle_start_date"	=>$cycle_start_date,
			"cycle_expired_date"=>$cycle_expired_date,
			"paid_amount"	    =>$payment_amount
	    );

	    $this->basic->insert_data('transaction_history', $insert_data);
	    $this->session->set_userdata("payment_success",1);

		/** Update user table **/
		$table='users';
		$where=array('id'=>$user_id);
		$data=array('expired_date'=>$cycle_expired_date,"package_id"=>$package_id,"bot_status"=>"1");
		$this->basic->update_data($table,$where,$data);

		$product_short_name = $this->config->item('product_short_name');
	    $from = $this->config->item('institute_email');
	    $mask = $this->config->item('product_name');
	    $subject = "Payment Confirmation";
	    $where = array();
	    $where['where'] = array('id'=>$user_id);
	    $user_email = $this->basic->get_data('users',$where,$select='');

	    $payment_confirmation_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'stripe_payment')),array('subject','message'));

	    if(isset($payment_confirmation_email_template[0]) && $payment_confirmation_email_template[0]['subject'] != '' && $payment_confirmation_email_template[0]['message'] != '') {

	        $to = $user_email[0]['email'];
	        $url = base_url();
	        $subject = $payment_confirmation_email_template[0]['subject'];
	        $message = str_replace(array('#PRODUCT_SHORT_NAME#','#APP_SHORT_NAME#','#CYCLE_EXPIRED_DATE#','#SITE_URL#','#APP_NAME#'),array($product_short_name,$product_short_name,$cycle_expired_date,$url,$mask),$payment_confirmation_email_template[0]['message']);
	        //send mail to user
	        $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

	    } else {

	        $to = $user_email[0]['email'];
	        $subject = "Payment Confirmation";
	        $message = "Congratulation,<br/> we have received your payment successfully. Now you are able to use {$product_short_name} system till {$cycle_expired_date}.<br/><br/>Thank you,<br/><a href='".base_url()."'>{$mask}</a> team";
	        //send mail to user
	        $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

	    }

	    // new payment made email
	    $paypal_new_payment_made_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'stripe_new_payment_made')),array('subject','message'));

	    if(isset($paypal_new_payment_made_email_template[0]) && $paypal_new_payment_made_email_template[0]['subject'] !='' && $paypal_new_payment_made_email_template[0]['message'] != '') {

	        $to = $from;
	        $subject = $paypal_new_payment_made_email_template[0]['subject'];
	        $message = str_replace('#PAID_USER_NAME#',$user_email[0]['name'],$paypal_new_payment_made_email_template[0]['message']);
	        //send mail to admin
	        $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

	    } else {

	        $to = $from;
	        $subject = "New Payment Made";
	        $message = "New payment has been made by {$user_email[0]['name']}";
	        //send mail to admin
	        $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);
	    }

		$redirect_url=base_url()."payment/transaction_log?action=success";
		redirect($redirect_url, 'refresh');
 
	}


	public function mollie_action()
	{
		$user_id=$this->session->userdata('user_id');
		$package_id=$this->session->userdata('mollie_payment_package_id');

		$mollie_api_key = '';
		$where['where'] = array('deleted'=>'0');
		$payment_config = $this->basic->get_data('payment_config',$where,$select='');
		if(!empty($payment_config)) 
		{
		    $currency = $payment_config[0]["currency"];
		    $mollie_api_key = isset($payment_config[0]['mollie_api_key']) ? $payment_config[0]['mollie_api_key'] : '';
		} 
		else 
		    $currency = "USD";

		$this->load->library('mollie_class_ecommerce'); 
		$this->mollie_class_ecommerce->ec_order_id=$this->session->userdata('mollie_unique_id'); 
		$this->mollie_class_ecommerce->api_key=$mollie_api_key; 
		$response= $this->mollie_class_ecommerce->mollie_payment_action();

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

		$simple_where['where'] = array('user_id'=>$user_id);
		$select = array('cycle_start_date','cycle_expired_date');
		
		$prev_payment_info = $this->basic->get_data('transaction_history',$simple_where,$select,$join='',$limit='1',$start=0,$order_by='ID DESC',$group_by='');
		
		$prev_cycle_expired_date="";


		$config_data=array();
		$price=0;
		$package_data=$this->basic->get_data("package",$where=array("where"=>array("package.id"=>$package_id)));
		if(is_array($package_data) && array_key_exists(0, $package_data))
			$price=$package_data[0]["price"];
		$validity=$package_data[0]["validity"];

		$validity_str='+'.$validity.' day';
		
		foreach($prev_payment_info as $info){
			$prev_cycle_expired_date=$info['cycle_expired_date'];
		}
		
		if($prev_cycle_expired_date==""){
			$cycle_start_date=date('Y-m-d');
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}
		
		else if (strtotime($prev_cycle_expired_date) < strtotime(date('Y-m-d'))){
			$cycle_start_date=date('Y-m-d');
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}
		
		else if (strtotime($prev_cycle_expired_date) > strtotime(date('Y-m-d'))){
			$cycle_start_date=date("Y-m-d",strtotime('+1 day',strtotime($prev_cycle_expired_date)));
			$cycle_expired_date=date("Y-m-d",strtotime($validity_str,strtotime($cycle_start_date)));
		}

		/** insert the transaction into database ***/
		$receiver_email="";
		$country="";
		$insert_data=array(
			"verify_status" 	=>"",
			"first_name"		=>"",
			"last_name"			=>"",
			"paypal_email"		=>"Mollie",
			"receiver_email" 	=>$receiver_email,
			"country"			=>$country,
			"payment_date" 		=>$payment_date,
			"payment_type"		=>"Mollie",
			"transaction_id"	=>$transaction_id,
			"user_id"           =>$user_id,
			"package_id"		=>$package_id,
			"cycle_start_date"	=>$cycle_start_date,
			"cycle_expired_date"=>$cycle_expired_date,
			"paid_amount"	    =>$payment_amount
		);
		
		
		$this->basic->insert_data('transaction_history', $insert_data);
		$this->session->set_userdata("payment_success",1);

		/** Update user table **/
		$table='users';
		$where=array('id'=>$user_id);
		$data=array('expired_date'=>$cycle_expired_date,"package_id"=>$package_id,"bot_status"=>"1");
		$this->basic->update_data($table,$where,$data);

		$product_short_name = $this->config->item('product_short_name');
		$from = $this->config->item('institute_email');
		$mask = $this->config->item('product_name');
		$subject = "Payment Confirmation";
		$where = array();
		$where['where'] = array('id'=>$user_id);
		$user_email = $this->basic->get_data('users',$where,$select='');

		$payment_confirmation_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'stripe_payment')),array('subject','message'));

		if(isset($payment_confirmation_email_template[0]) && $payment_confirmation_email_template[0]['subject'] != '' && $payment_confirmation_email_template[0]['message'] != '') {

			$to = $user_email[0]['email'];
			$url = base_url();
			$subject = $payment_confirmation_email_template[0]['subject'];
			$message = str_replace(array('#PRODUCT_SHORT_NAME#','#APP_SHORT_NAME#','#CYCLE_EXPIRED_DATE#','#SITE_URL#','#APP_NAME#'),array($product_short_name,$product_short_name,$cycle_expired_date,$url,$mask),$payment_confirmation_email_template[0]['message']);
		        //send mail to user
			$this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

		} else {

			$to = $user_email[0]['email'];
			$subject = "Payment Confirmation";
			$message = "Congratulation,<br/> we have received your payment successfully. Now you are able to use {$product_short_name} system till {$cycle_expired_date}.<br/><br/>Thank you,<br/><a href='".base_url()."'>{$mask}</a> team";
		        //send mail to user
			$this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

		}

		    // new payment made email
		$paypal_new_payment_made_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'stripe_new_payment_made')),array('subject','message'));

		if(isset($paypal_new_payment_made_email_template[0]) && $paypal_new_payment_made_email_template[0]['subject'] !='' && $paypal_new_payment_made_email_template[0]['message'] != '') {

			$to = $from;
			$subject = $paypal_new_payment_made_email_template[0]['subject'];
			$message = str_replace('#PAID_USER_NAME#',$user_email[0]['name'],$paypal_new_payment_made_email_template[0]['message']);
		        //send mail to admin
			$this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);

		} else {

			$to = $from;
			$subject = "New Payment Made";
			$message = "New payment has been made by {$user_email[0]['name']}";
		        //send mail to admin
			$this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);
		}

		$redirect_url=base_url()."payment/transaction_log?action=success";
		redirect($redirect_url, 'refresh');
	}




}

