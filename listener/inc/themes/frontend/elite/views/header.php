<header class="header header-transparent" id="header-main">
    <!-- Main navbar -->
    <nav class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-dark bg-dark" id="navbar-main">
        <div class="container px-lg-0">
            <!-- Logo -->
            <a class="navbar-brand mr-lg-5" href="<?php _e( get_url() )?>">
                <img alt="Logo" class="h-40" src="<?php _e( get_option('website_white', get_url("inc/themes/backend/default/assets/img/logo-white.png")) )?>" id="navbar-logo">
            </a>
            <!-- Navbar collapse trigger -->
            <button class="navbar-toggler pr-0" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar nav -->
            <div class="collapse navbar-collapse" id="navbar-main-collapse">
                <ul class="navbar-nav align-items-lg-center">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php _e( get_url("#home") )?>"><?php _e("Home")?></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" class="scroll-me" href="<?php _e( get_url("#features") )?>"><?php _e("Features")?></a>
                    </li>
                    <?php if(find_modules("payment")){ ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php _e( get_url("pricing") )?>"><?php _e("Pricing")?></a>
                    </li>
                    <?php }?>
                </ul>
                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <?php if(!_s("uid")){?>
                        <?php if( get_option("signup_status", 1) ){?>
                        <li class="nav-item d-lg-none d-xl-block">
                            <a class="nav-link" href="<?php _e( get_url("login") )?>"><?php _e("Login")?></a>
                        </li>
                        <li class="nav-item mr-0">
                            <a href="<?php _e( get_url("signup") )?>" class="nav-link d-lg-none"><?php _e("Sign Up")?></a>
                            <a href="<?php _e( get_url("signup") )?>" class="btn btn-sm btn-white rounded-pill btn-icon rounded-pill d-none d-lg-inline-flex">
                                <span class="btn-inner--icon"><i class="fas fa-sign-in-alt"></i></span>
                                <span class="btn-inner--text"><?php _e("Sign Up")?></span>
                            </a>
                        </li>
                        <?php }else{?>
                        <li class="nav-item mr-0">
                            <a href="<?php _e( get_url("login") )?>" class="nav-link d-lg-none"><?php _e("Login")?></a>
                            <a href="<?php _e( get_url("login") )?>" class="btn btn-sm btn-white rounded-pill btn-icon rounded-pill d-none d-lg-inline-flex">
                                <span class="btn-inner--icon"><i class="fas fa-sign-in-alt"></i></span>
                                <span class="btn-inner--text"><?php _e("Login")?></span>
                            </a>
                        </li>
                        <?php }?>
                    <?php }else{?>
                        <li class="nav-item mr-0">
                            <a href="<?php _e( get_url("dashboard") )?>" class="nav-link d-lg-none"><?php _e("Dashboard")?></a>
                            <a href="<?php _e( get_url("dashboard") )?>" class="btn btn-sm btn-white rounded-pill btn-icon rounded-pill d-none d-lg-inline-flex">
                                <span class="btn-inner--icon"><i class="fas fa-desktop"></i></span>
                                <span class="btn-inner--text"><?php _e("Dashboard")?></span>
                            </a>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>
</header>