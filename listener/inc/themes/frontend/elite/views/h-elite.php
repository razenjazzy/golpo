<!DOCTYPE html>
<html>
<head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php _e( get_option('website_title', 'Stackposts - Social Marketing Tool') )?></title>
        <meta name="description" content="<?php _e( get_option('website_desc', '#1 Marketing Platform for Social Network') )?>">
        <meta name="keywords" content="<?php _e( get_option('website_keywords', 'social network, marketing, brands, businesses, agencies, individuals') )?>">
        <link rel="icon" type="image/png" href="<?php _e( get_option('website_favicon', get_url("inc/themes/backend/default/assets/img/favicon.png")) )?>" />
        <!-- CSS -->
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/bootstrap.min.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/animate.min.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/owl.carousel.min.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/pe-icon-7-stroke.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/magnific-popup.min.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/icofont.min.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/meanmenu.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/odometer.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/style.css'))?>" id="stylesheet">
        <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/plus/css/responsive.css'))?>" id="stylesheet">
        <script type="text/javascript">
            var token = '<?php _e( $this->security->get_csrf_hash() )?>',
                PATH  = '<?php _e(PATH)?>',
                BASE  = '<?php _e(BASE)?>';

            document.onreadystatechange = function () {
                var state = document.readyState
                if (state == 'complete') {
                    setTimeout(function(){
                        document.getElementById('interactive');
                        document.getElementById('loading-overplay').style.opacity ="0";
                    },500);

                    setTimeout(function(){
                        document.getElementById('loading-overplay').style.display ="none";
                        document.getElementById('loading-overplay').style.opacity ="1";
                    },1000);
                }
            }
        </script>
        <?php _e( htmlspecialchars_decode(get_option('embed_code', ''), ENT_QUOTES) , false)?>
    </head>

    <body>

        <!-- Start Preloader Area -->
        <div class="preloader">
            <div class="spinner"></div>
        </div>
        <!-- End Preloader Area -->

        <!-- Start Navbar Area -->
		<header class="header-area">
			<div class="uxhaven-mobile-nav">
				<div class="logo img-logo">
					<a href="<?php _e( get_url() )?>">
                <img alt="Logo" class="h-40" src="<?php _e( get_option('website_white', get_url("inc/themes/backend/default/assets/img/logo-white.png")) )?>" id="navbar-logo">
                    </a>
				</div>
			</div>

			<div class="uxhaven-nav">
				<div class="container">
					<nav class="navbar navbar-expand-md navbar-light">
						<a href="<?php _e( get_url() )?>">
                            <img alt="Logo" class="h-40" src="<?php _e( get_option('website_white', get_url("inc/themes/backend/default/assets/img/logo-white.png")) )?>" id="navbar-logo">
                        </a>

						<div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
							<ul class="navbar-nav nav">
								<li class="nav-item">
                                    <a class="nav-link" href="<?php _e( get_url() )?>"><?php _e("Home")?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php _e( get_url("#features") )?>"><?php _e("Features")?></a>
                                </li>
                                <li class="nav-item">
                                	<a class="nav-link" href="<?php _e( get_url("#pricing") )?>"><?php _e("Pricing")?></a>
                                </li>
								<li class="nav-item">
									<a class="nav-link" href="<?php _e( get_url("#faq") )?>"><?php _e("F.A.Q")?></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="<?php _e( get_url("#contact") )?>"><?php _e("Contact")?></a>
							</ul>
						</div>

						<div class="others-options">
							<?php if(!_s("uid")){?>
                            <?php if( get_option("signup_status", 1) ){?>
                                <a href="<?php _e( get_url("login") )?>" class="btn btn-secondary"><?php _e("Login")?></a>
                                <a href="<?php _e( get_url("signup") )?>" class="btn btn-secondary"><?php _e("Sign Up")?></a>
                            <?php }else{?>
                                <a href="<?php _e( get_url("login") )?>" class="btn btn-secondary"><?php _e("Login")?></a>
                            <?php }?>
                            <?php }else{?>
                              <a href="<?php _e( get_url("dashboard") )?>" class="btn btn-primary btn-sm btn--has-shadow mt-3 mt-lg-0"><?php _e( sprintf( __("Hello, %s"), _u("fullname") ) )?></a>
                            <?php }?>
						</div>
					</nav>
				</div> 
			</div>
		</header>
