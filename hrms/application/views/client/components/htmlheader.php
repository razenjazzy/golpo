<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$company[0]->favicon;?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php if($theme[0]->flipped_menu=='true'){
$ver_tem = 'rtl';
} else {
	$ver_tem = 'ltr';
}
?>
<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

<head>
  <title><?php echo $title;?></title>

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
  <script src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    
    <!-- Libs -->
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/datatables/datatables.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery-ui/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-select/bootstrap-select.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/select2/select2.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/kendo/kendo.common.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/kendo/kendo.default.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/Trumbowyg/dist/ui/trumbowyg.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/clockpicker/dist/bootstrap-clockpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/vendor/css/pages/projects.css">  
  </head>