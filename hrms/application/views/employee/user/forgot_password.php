<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $site_lang = $this->load->helper('language');?>
<?php $lang = $site_lang->session->userdata('site_lang');?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="">
<meta name="author" content="workable zone - ultimate hrm, hr, hrms">
<link rel="icon" href="<?php echo base_url()?>skin/img/wz-icon.png" type="image/png">

<!-- Title -->
<title><?php echo $title;?></title>

<!-- Vendor CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/bootstrap4/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/themify-icons/themify-icons.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/toastr/toastr.min.css">
<!-- Core CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/css/core.css">

<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="img-cover" style="background:#ece7e5;">
<nav class="navbar">
<div class="navbar-right navbar-toggleable-sm collapse" id="collapse-1">
  <ul class="nav navbar-nav float-md-right">
    <li class="nav-item dropdown"> 
    <a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false"> <img src="<?php echo base_url()?>skin/img/flags/<?php echo $this->Xin_model->get_selected_language_flag($lang);?>" alt="<?php echo $this->Xin_model->get_selected_language_name($lang);?>"> <?php echo $this->Xin_model->get_selected_language_name($lang);?></a>
    <div class="dropdown-menu dropdown-menu-right animated <?php echo $system[0]->animation_effect_topmenu;?>">
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/chineese')?>">
                <img src="<?php echo base_url()?>skin/img/flags/cn.gif" alt="Chinese"> Chinese
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/danish')?>">
                <img src="<?php echo base_url()?>skin/img/flags/dk.gif" alt="Danish"> Danish
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/english')?>">
                <img src="<?php echo base_url()?>skin/img/flags/en.gif" alt="English"> English
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/french')?>">
                <img src="<?php echo base_url()?>skin/img/flags/fr.gif" alt="French"> French
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/german')?>">
                <img src="<?php echo base_url()?>skin/img/flags/de.gif" alt="German"> German
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/greek')?>">
                <img src="<?php echo base_url()?>skin/img/flags/gr.gif" alt="Greek"> Greek
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/indonesian')?>">
                <img src="<?php echo base_url()?>skin/img/flags/id.gif" alt="Indonesian"> Indonesian
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/italian')?>">
                <img src="<?php echo base_url()?>skin/img/flags/ie.gif" alt="Italian"> Italian
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/japanese')?>">
                <img src="<?php echo base_url()?>skin/img/flags/jp.gif" alt="Japanese"> Japanese
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/polish')?>">
                <img src="<?php echo base_url()?>skin/img/flags/pl.gif" alt="Polish"> Polish
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/portuguese')?>">
                <img src="<?php echo base_url()?>skin/img/flags/pt.gif" alt="Portuguese"> Portuguese
            </a> 
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/romanian')?>">
                <img src="<?php echo base_url()?>skin/img/flags/ro.gif" alt="Romanian"> Romanian
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/russian')?>">
                <img src="<?php echo base_url()?>skin/img/flags/ru.gif" alt="Spanish"> Russian
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/spanish')?>">
                <img src="<?php echo base_url()?>skin/img/flags/es.gif" alt="Spanish"> Spanish
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/turkish')?>">
                <img src="<?php echo base_url()?>skin/img/flags/tr.gif" alt="Spanish"> Turkish
            </a>
            <a class="dropdown-item" href="<?php echo site_url('dashboard/set_language/vietnamese')?>">
                <img src="<?php echo base_url()?>skin/img/flags/vn.gif" alt="Vietnamese"> Vietnamese
            </a>         
        </div>
    </li>
  </ul>
</div>
</nav>
<div class="container-fluid">
  <div class="sign-form">
    <div class="row">
      <div class="col-md-4 offset-md-4 px-3">
        <div class="box b-a-0">
          <div class="p-2 text-xs-center">
            <h5><?php echo $this->lang->line('xin_find_your_account_fg');?></h5>
          </div>
          <form class="form-material" action="<?php echo site_url('forgot_password/send_mail');?>" method="post" name="xin-form" id="xin-form">
            <div class="form-group mb-0">
              <input type="text" class="form-control" name="iemail" id="iemail" placeholder="<?php echo $this->lang->line('xin_enter_your_email_fg');?>">
            </div>
            <div class="p-2 form-group mb-0">
              <button type="submit" class="btn btn-purple btn-block text-uppercase"><?php echo $this->lang->line('xin_reset');?></button>
            </div>
          <?php echo form_close(); ?>
           <p class="p-2 text-xs-center"><a href="<?php echo site_url();?>"><i class="fa fa-lock"></i> <?php echo $this->lang->line('xin_remember_password');?></a></p>
        </div>
      </div>
    </div>
  </div>
 
</div>

<!-- Vendor JS --> 
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/jquery/jquery-1.12.3.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/tether/js/tether.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/bootstrap/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/toastr/toastr.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = true;
	toastr.options.progressBar = true;
	toastr.options.timeOut = 3000;
	toastr.options.positionClass = "toast-bottom-right";
	
	/* Add data */ /*Form Submit*/
	$("#xin-form").submit(function(e){
	e.preventDefault();
		var obj = $(this), action = obj.attr('name');
		$('.save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: e.target.action,
			data: obj.serialize()+"&is_ajax=1&add_type=forgot_password&form="+action,
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} else {
					toastr.success(JSON.result);
					$('#iemail').val(''); // To reset form fields
					$('.save').prop('disabled', false);
				}
			}
		});
	});
});
</script>
</body>
</html>