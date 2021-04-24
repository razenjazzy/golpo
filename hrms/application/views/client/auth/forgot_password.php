<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$company[0]->favicon;?>
<?php
if(empty($wz_lang)):
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';
elseif($wz_lang == 'english'):
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
else:
	$lang_code = $this->Xin_model->get_language_info($wz_lang);
	$flg_icn = $lang_code[0]->language_flag;
	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
endif;
if($system[0]->enable_auth_background=='yes'):
	$auth_bg = 'bg-full-screen-image-admin-fpass';
else:
	$auth_bg = '';	
endif;
?>
<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">
  <head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
  <link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

  <!-- Icon fonts -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/fonts/fontawesome.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/fonts/ionicons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/fonts/linearicons.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/fonts/open-iconic.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/fonts/pe-icon-7-stroke.css">

  <!-- Core stylesheets -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/css/rtl/bootstrap-material.css" class="theme-settings-bootstrap-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/css/rtl/hrsale_h-material.css" class="theme-settings-hrsale-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/css/rtl/theme-corporate-material.css" class="theme-settings-theme-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/css/rtl/colors-material.css" class="theme-settings-colors-css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/css/rtl/uikit.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/demo.css">
  <script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/material-ripple.js"></script>
  <script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/layout-helpers.js"></script>

  <!-- Theme settings -->
  <!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
  <script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/theme-settings.js"></script>
  <script>
    window.themeSettings = new ThemeSettings({
      cssPath: '<?php echo base_url();?>skin/hrsale_assets/vendor/css/rtl/',
      themesPath: '<?php echo base_url();?>skin/hrsale_assets/vendor/css/rtl/'
    });
  </script>

  <!-- Core scripts -->
  <script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/pace.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Libs -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
  <!-- Page -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/css/pages/authentication.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.css">
  <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/animate.css">
  </head>
  
  <body>
<div class="page-loader">
    <div class="bg-primary"></div>
  </div>

<!-- Content -->

<div class="authentication-wrapper authentication-2 ui-bg-cover ui-bg-overlay-container px-4" style="background-image: url('<?php echo base_url();?>skin/hrsale_assets/img/bg/bg-2.jpg');">
    <div class="authentication-inner py-5 animated fadeInDownBig"> 
    
    <!-- Form -->
    <?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'class' => 'form-horizontal', 'autocomplete' => 'off');?>
    <?php $hidden = array('_method' => 'forgott_pass');?>
    <?php echo form_open('client/auth/send_mail/', $attributes, $hidden);?>
    <div class="card">
        <div class="p-4 p-sm-5"> 
        <!-- Logo -->
        <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
            <div class="position-relative"> <img src="<?php echo base_url();?>uploads/logo/signin/<?php echo $company[0]->sign_in_logo;?>" alt="hrsale logo"> </div>
          </div>
        <!-- / Logo -->
        <h5 class="text-center text-muted font-weight-normal mb-4"><?php echo $this->lang->line('xin_reset_password_hr');?></h5>
        <hr class="mt-0 mb-4">
        <p> <?php echo $this->lang->line('xin_find_your_account_fg');?> </p>
        <div class="form-group">
            <input type="text" name="iemail" id="iemail" class="form-control" placeholder="<?php echo $this->lang->line('xin_enter_your_email_fg');?>"><a href="<?php echo site_url('client/');?>" class="d-block small"><?php echo $this->lang->line('xin_remember_password');?></a>
          </div>
        <button type="submit" class="btn btn-outline-primary btn-block"><i class="ft-unlock"></i> <?php echo $this->lang->line('xin_hr_recover_password');?></button>
      </div>
        <?php echo form_close();?> 
        <!-- / Form -->
        <div class="card-footer py-3 px-4 px-sm-5">
        <div class="text-center text-muted">
            <?php if($system[0]->enable_current_year=='yes'):?>
            <?php echo date('Y');?>
            <?php endif;?>
            © <?php echo $system[0]->footer_text;?>
            <?php if($system[0]->enable_page_rendered=='yes'):?>
            - <?php echo $this->lang->line('xin_page_rendered_text');?> <strong>{elapsed_time}</strong> seconds.
            <?php endif; ?>
          </div>
      </div>
      </div>
  </div>
  </div>
<!-- / Content --> 
<!-- Core scripts --> 
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/popper/popper.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/bootstrap.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/js/sidenav.js"></script> 

<!-- Libs --> 
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script> 

<!-- Demo --> 
<script src="<?php echo base_url();?>skin/hrsale_assets/js/demo.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
});
</script> 
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>';</script> 
<script type="text/javascript">
    $(document).ready(function(){
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        toastr.options.timeOut = 3000;
        toastr.options.positionClass = "toast-top-center";
        
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
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                        $('.save').prop('disabled', false);
                    } else {
                        toastr.success(JSON.result);
						$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                        $('.save').prop('disabled', false);
                    }
                }
            });
        });
    });
    </script>
</body>
</html>