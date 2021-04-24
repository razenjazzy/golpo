        <?php include 'h-elite.php'?>
		<!-- End Navbar Area -->

        <!-- Start Main Banner -->
        <div class="main-banner item-bg1">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="main-banner-content">
                                    <span>Social Automation</span>
                                    <h1>Make your social media work for you!</h1>
                                    <p>With Stackposts you can manage all your social media in a single panel easily and with maximum security!</p>

                                    <?php if(!_s("uid")){?>
                                    <?php if( get_option("signup_status", 1) ){?>
                                        <a href="<?php _e( get_url("signup") )?>" class="btn btn-primary"><?php _e("Try it 30 days for free!")?></a>
                                        <a href="<?php _e( get_url("login") )?>" class="btn btn-secondary"><?php _e("Login")?></a>
                                    <?php }else{?>
                                        <a href="<?php _e( get_url("login") )?>" class="btn btn-secondary"><?php _e("Login")?></a>
                                    <?php }?>
                                    <?php }else{?>
                                      <a href="<?php _e( get_url("dashboard") )?>" class="btn btn-primary btn-sm btn--has-shadow mt-3 mt-lg-0"><?php _e( sprintf( __("Hello, %s"), _u("fullname") ) )?></a>
                                    <?php }?>
                                        </div>
                                    </div>

                            <div class="col-lg-6">
                                <div class="banner-image">
                                    <img src="inc/themes/frontend/elite/assets/plus/img/banner-img.png" alt="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Banner -->

        <!-- Start Featured Services Area -->
        <section id="features" class="featured-services-area">
            <div class="container">
                <div class="row">
                    <div class="featured-services-slides owl-carousel owl-theme">
                        <div class="col-lg-12 col-md-12">
                            <div class="featured-services-box">
                                <div class="icon">
                                    <i class="icofont-instagram"></i>
                                </div>
                                <h3>Instagram Automation</h3>
                                <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                                
                                <div class="back-text">Ia</div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="featured-services-box">
                                <div class="icon">
                                    <i class="icofont-facebook"></i>
                                </div>
                                <h3>Facebook Automation</h3>
                                <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                                
                                <div class="back-text">Fa</div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="featured-services-box">
                                <div class="icon">
                                    <i class="icofont-twitter"></i>
                                </div>
                                <h3>Twitter Automation</h3>
                                <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                                
                                <div class="back-text">Ta</div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="featured-services-box">
                                <div class="icon">
                                    <i class="icofont-brand-youtube"></i>
                                </div>
                                <h3>Youtube Automation</h3>
                                <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                                
                                <div class="back-text">Ya</div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="featured-services-box">
                                <div class="icon">
                                    <i class="icofont-pinterest"></i>
                                </div>
                                <h3>Pinterest Automation</h3>
                                <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                                
                                <div class="back-text">Pa</div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="featured-services-box">
                                <div class="icon">
                                    <i class="icofont-vk"></i>
                                </div>
                                <h3>Vk Automation</h3>
                                <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                                
                                <div class="back-text">Va</div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="featured-services-box">
                                <div class="icon">
                                    <i class="icofont-life-bouy"></i>
                                </div>
                                <h3>Support Premium</h3>
                                <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                                
                                <div class="back-text">Sp</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Featured Services Area -->

        <section class="quotes-area">
        </section>

        <!-- Start Feedback Area -->
        <section class="feedback-area ptb-110">
            <div class="container">
                <div class="feedback-list">
                    <div class="quotes-icon">
                        <img src="inc/themes/frontend/elite/assets/plus/img/left-quote-white.png" alt="icon">
                    </div>

                    <div class="feedback-slides owl-carousel owl-theme">
                        <div class="single-feedback">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                            <div class="bar"></div>
                            <h3>John Smith</h3>
                            <span>CEO & Founder, Envato</span>
                        </div>

                        <div class="single-feedback">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
                            <div class="bar"></div>
                            <h3>John Smith</h3>
                            <span>CEO & Founder, Envato</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="client-image-box">
                <img src="inc/themes/frontend/elite/assets/plus/img/client1.png" class="client1" alt="client">
                <img src="inc/themes/frontend/elite/assets/plus/img/client2.png" class="client2" alt="client">
                <img src="inc/themes/frontend/elite/assets/plus/img/client3.png" class="client3" alt="client">
                <img src="inc/themes/frontend/elite/assets/plus/img/client4.png" class="client4" alt="client">
                <img src="inc/themes/frontend/elite/assets/plus/img/client5.png" class="client5" alt="client">
                <img src="inc/themes/frontend/elite/assets/plus/img/client6.png" class="client6" alt="client">
                <img src="inc/themes/frontend/elite/assets/plus/img/client7.png" class="client7" alt="client">
                <img src="inc/themes/frontend/elite/assets/plus/img/client8.png" class="client8" alt="client">
            </div>
        </section>
        <!-- End Feedback Area -->

        <!-- Start Portfolio Area -->
        <section class="portfolio-area ptb-110 pb-0">
            <div class="container">
                <div class="section-title">
                    <h2>Our Portfolio on Instagram</h2>
                    <p>Follow our instagram profile and learn about our updates and promotions first hand!</p>
                </div>
            </div>

            <div class="row m-0">
                <!-- LightWidget WIDGET -->
                <!-- Change this url: //lightwidget.com/widgets/a91c35be3f6057878f48303a9276cf8b.html to your url generated in LightWidget and save -->
                <iframe src="//lightwidget.com/widgets/a91c35be3f6057878f48303a9276cf8b.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="
                width:100%;
                border:0;
                overflow:hidden;">
                </iframe>
                <!-- LightWidget WIDGET finish -->
            </div>
        </section>
        <!-- End Portfolio Area -->

        <!-- Start Team Area -->
        <section class="team-area ptb-110">
            <div class="container">
                <div class="section-title">
                    <h2>Our Creative Team</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-md-6">
                        <div class="single-team">
                            <div class="team-img">
                                <img src="inc/themes/frontend/elite/assets/plus/img/team1.jpg" alt="image">

                                <div class="overlay">
                                    <p>Email: <span>hello@procodebr.xyz</span></p>

                                    <ul>
                                        <li><a href="#" target="_blank"><i class="icofont-facebook"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="icofont-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="icofont-dribbble"></i></a> </li>
                                        <li><a href="#" target="_blank"><i class="icofont-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="team-content">
                                <h3>Jos Buttler</h3>
                                <span>UX Designer</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-6">
                        <div class="single-team">
                            <div class="team-img">
                                <img src="inc/themes/frontend/elite/assets/plus/img/team2.jpg" alt="image">

                                <div class="overlay">
                                    <p>Email: <span>hello@procodebr.xyz</span></p>

                                    <ul>
                                        <li><a href="#" target="_blank"><i class="icofont-facebook"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="icofont-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="icofont-dribbble"></i></a> </li>
                                        <li><a href="#" target="_blank"><i class="icofont-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="team-content">
                                <h3>Smith John</h3>
                                <span>UI Designer</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-6">
                        <div class="single-team">
                            <div class="team-img">
                                <img src="inc/themes/frontend/elite/assets/plus/img/team3.jpg" alt="image">

                                <div class="overlay">
                                    <p>Email: <span>hello@procodebr.xyz</span></p>

                                    <ul>
                                        <li><a href="#" target="_blank"><i class="icofont-facebook"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="icofont-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="icofont-dribbble"></i></a> </li>
                                        <li><a href="#" target="_blank"><i class="icofont-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="team-content">
                                <h3>Nick Leaver</h3>
                                <span>Product Designer</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-6">
                        <div class="single-team">
                            <div class="team-img">
                                <img src="inc/themes/frontend/elite/assets/plus/img/team4.jpg" alt="image">

                                <div class="overlay">
                                    <p>Email: <span>hello@uxhaven.com</span></p>

                                    <ul>
                                        <li><a href="#" target="_blank"><i class="icofont-facebook"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="icofont-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="icofont-dribbble"></i></a> </li>
                                        <li><a href="#" target="_blank"><i class="icofont-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="team-content">
                                <h3>Olivia Jacob</h3>
                                <span>Interior Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Team Area -->

        <!-- Start Fun Facts Area -->
		<section class="funfacts-area ptb-110 bg-fcfbfb">
			<div class="container">
                <div class="section-title">
					<h2>Stackposts in Numbers!</h2>
                    <p>Check out our numbers and make sure Stackposts is the best for you!</p>
                </div>

				<div class="row">
					<div class="col-lg-3 col-md-3 col-6">
						<div class="funfact">
							<h3><span class="odometer" data-count="5">00</span>B+</h3>
							<p>Automation</p>
						</div>
					</div>

					<div class="col-lg-3 col-md-3 col-6">
						<div class="funfact">
							<h3><span class="odometer" data-count="1">00</span>M+</h3>
							<p>Customers</p>
						</div>
					</div>

					<div class="col-lg-3 col-md-3 col-6">
						<div class="funfact">
							<h3><span class="odometer" data-count="500">00</span>+</h3>
							<p>Support</p>
						</div>
					</div>

					<div class="col-lg-3 col-md-3 col-6">
						<div class="funfact">
							<h3><span class="odometer" data-count="70">00</span>+</h3>
							<p>Contrubutors</p>
						</div>
					</div>
				</div>

				<div id="contact" class="contact-cta-box">
					<h3>Have any question about us?</h3>
					<p>Don't hesitate to contact us</p>
					<a href="#" class="btn btn-primary">Contact Us</a>
				</div>

				<div class="map-bg">
					<img src="inc/themes/frontend/elite/assets/plus/img/map.png" alt="map">
				</div>
			</div>
		</section>
        <!-- End Fun Facts Area -->
        
        <!-- Start Pricing Area -->
        <?php include 'p-elite.php'?>
        <!-- Start CTA Area -->
        <section class="cta-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-md-12 offset-md-0">
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-md-8">
                                <div class="cta-content">
                                    <h3>Need much more resources?</h3>
                                    <p>Contact our team and set up a personalized plan!</p>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-4">
                                <div class="cta-btn-box">
                                    <a href="#" class="btn btn-primary">Contact our team</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End CTA Area -->

        <!-- Start FAQ Area --> 
        <section id="faq" class="faq-area ptb-110">
            <div class="container">
                <div class="faq-accordion">
                    <div class="section-title">
                    <h3>Ask Your Question</h3>
                </div>
                    <ul class="accordion">
                        <li class="accordion-item">
                            <a class="accordion-title active" href="javascript:void(0)">Edit 01 <i class="icofont-plus"></i></a>
                            <p class="accordion-content show">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua.</p>
                        </li>
                        
                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">Edit 02 <i class="icofont-plus"></i></a>
                            <p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua.</p>
                        </li>
                        
                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">Edit 03 <i class="icofont-plus"></i></a>
                            <p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua.</p>
                        </li>
                        
                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">Edit 04 <i class="icofont-plus"></i></a>
                            <p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua.</p>
                        </li>
                        
                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">Edit 05 <i class="icofont-plus"></i></a>
                            <p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua.</p>
                        </li>
                        
                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">Edit 06 <i class="icofont-plus"></i></a>
                            <p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. incididunt ut labore et dolore magna aliqua.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- End FAQ Area -->

        <!-- Start Partner Area -->
        <section class="partner-area ptb-110">
            <div class="container">
                <div class="section-title">
                    <h2>Our clients</h2>
                    <p>Here are some of our customers.</p>
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner1.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner2.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner3.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner4.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner5.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner6.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner7.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner8.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner9.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner10.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner11.png" alt="image">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-6 col-sm-4">
                        <div class="single-partner">
                            <a href="#">
                                <img src="inc/themes/frontend/elite/assets/plus/img/partner12.png" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Partner Area -->

        <!-- Start Footer Area -->
        <?php include 'f-elite.php'?>
