<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <meta name="theme-color" content="#fafafa">
</head>

<?php wp_head(); ?>
<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

    <!-- Add your site or application content here -->
    <!--All Contents here-->

    <!--  top bar  -->
    <section class="top-bar py-2 px-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <a href="#" class="text-white" style="display: block; padding-top: 5px"><i class="fas fa-shopping-cart"></i></a>
                </div>
                <div class="col-6 text-right">
                    <?php echo get_template_part( 'template-parts/mc', 'login-button' ); ?>
                </div>
            </div>
        </div>
    </section>
    <!--  top bar  -->


    <!--  header nav  -->
    <header id="" style="z-index: 9!important">

        <div class="container-fluid">
            <?php
                // wp_nav_menu( array $args = array(
                //     'menu'              => "", // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
                //     'menu_class'        => "", // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
                //     'menu_id'           => "", // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
                //     'container'         => "", // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
                //     'container_class'   => "", // (string) Class that is applied to the container. Default 'menu-{menu slug}-container'.
                //     'container_id'      => "", // (string) The ID that is applied to the container.
                //     'fallback_cb'       => "", // (callable|bool) If the menu doesn't exists, a callback function will fire. Default is 'wp_page_menu'. Set to false for no fallback.
                //     'before'            => "", // (string) Text before the link markup.
                //     'after'             => "", // (string) Text after the link markup.
                //     'link_before'       => "", // (string) Text before the link text.
                //     'link_after'        => "", // (string) Text after the link text.
                //     'echo'              => "", // (bool) Whether to echo the menu or return it. Default true.
                //     'depth'             => "", // (int) How many levels of the hierarchy are to be included. 0 means all. Default 0.
                //     'walker'            => "", // (object) Instance of a custom walker class.
                //     'theme_location'    => "", // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
                //     'items_wrap'        => "", // (string) How the list items should be wrapped. Default is a ul with an id and class. Uses printf() format with numbered placeholders.
                //     'item_spacing'      => "", // (string) Whether to preserve whitespace within the menu's HTML. Accepts 'preserve' or 'discard'. Default 'preserve'.
                // ) ); 
            ?>
            <nav class="navbar navbar-expand-lg navbar-light">
                <?php
                    if( function_exists('get_field') ) {
                        $logo_img = get_field( 'logo_image', 'option' );
                        $logo_img_id = $logo_img['ID'];
                    }
                ?>

                <?php if( !empty($logo_img_id) ) { ?>
                    <a class="navbar-brand" href="<?php bloginfo('url'); ?>"><?php echo wp_get_attachment_image( $logo_img_id, 'logo-size' ); ?></a>
                <?php } ?>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Pages/about.html">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Pages/how-it-works.html">How it works</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Service
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                                <div class="container">
                                    <div class="row" style="width: 100%">
                                        <div class="col-md-3">
                                            <div class="service-thumbnail car">
                                                <span class="service-overlay">
                                                    <i class="fas fa-car"></i> Car<br>
                                                    <a href="#" class="btn btn-primary btn-sm quote-btn">Get a Quote</a>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- /.col-md-2  -->
                                        <div class="col-md-3">
                                            <div class="service-thumbnail motorbike">
                                                <span class="service-overlay">
                                                    <i class="fas fa-motorcycle"></i> Motorbike<br>
                                                    <a href="#" class="btn btn-primary btn-sm quote-btn">Get a Quote</a>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- /.col-md-2  -->

                                        <!-- /.col-md-2  -->
                                        <div class="col-md-3">
                                            <div class="service-thumbnail ac">
                                                <span class="service-overlay">
                                                    <i class="fas fa-fan"></i> Air Condition<br>
                                                    <a href="#" class="btn btn-primary btn-sm quote-btn">Get a Quote</a>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- /.col-md-2  -->
                                        <div class="col-md-3">
                                            <div class="service-thumbnail fridge">
                                                <span class="service-overlay">
                                                    <i class="fas fa-igloo"></i> Fridge<br>
                                                    <a href="#" class="btn btn-primary btn-sm quote-btn">Get a Quote</a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="service-thumbnail plumbing">
                                                <span class="service-overlay">
                                                    <i class="fas fa-wave-square"></i> Plumbing<br>
                                                    <a href="#" class="btn btn-primary btn-sm quote-btn">Get a Quote</a>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- /.col-md-2  -->
                                        <div class="col-md-3">
                                            <div class="service-thumbnail electronics">
                                                <span class="service-overlay">
                                                    <i class="fas fa-plug"></i> Electronics<br>
                                                    <a href="#" class="btn btn-primary btn-sm quote-btn">Get a Quote</a>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- /.col-md-2  -->
                                        <div class="col-md-3">
                                            <div class="service-thumbnail computer">
                                                <span class="service-overlay">
                                                    <i class="fas fa-laptop"></i> Leptop Computer<br>
                                                    <a href="#" class="btn btn-primary btn-sm quote-btn">Get a Quote</a>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- /.col-md-2  -->
                                        <div class="col-md-3">
                                            <div class="service-thumbnail mobile">
                                                <span class="service-overlay">
                                                    <i class="fas fa-mobile"></i> Mobile Device<br>
                                                    <a href="#" class="btn btn-primary btn-sm quote-btn">Get a Quote</a>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- /.col-md-2  -->
                                    </div>
                                </div>
                                <!--  /.container  -->


                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                More
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                                <div class="container">
                                    <div class="row more-menu-item py-3" style="width: 100%">
                                        <div class="col-4 col-md-2 col-sm-3 text-center">
                                            <a href="#" class="text-dark">
                                                <span class="menu-con">
                                                    <i class="fas fa-store"></i><br>
                                                    Shop
                                                </span>
                                            </a>
                                        </div>
                                        <!-- /.col-md-4  -->
                                        <div class="col-4 col-md-2 col-sm-3 text-center">
                                            <a href="#" class="text-dark">
                                                <span class="menu-con">
                                                    <i class="fas fa-user-tie"></i><br>
                                                    Career
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-4 col-md-2 col-sm-3 text-center">
                                            <a href="#" class="text-dark">
                                                <span class="menu-con">
                                                    <i class="fab fa-blogger-b"></i><br>
                                                    Blog
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-4 col-md-2 col-sm-3 text-center">
                                            <a href="#" class="text-dark">
                                                <span class="menu-con">
                                                    <i class="far fa-question-circle"></i><br>
                                                    FAQ
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-4 col-md-2 col-sm-3 text-center">
                                            <a href="#" class="text-dark">
                                                <span class="menu-con">
                                                    <i class="fas fa-user-tag"></i><br>
                                                    Vendors
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-4 col-md-2 col-sm-3 text-center">
                                            <a href="Pages/contact.html" class="text-dark">
                                                <span class="menu-con">
                                                    <i class="fas fa-tty"></i><br>
                                                    Contact
                                                </span>
                                            </a>
                                        </div>
                                        <!-- /.col-md-4  -->
                                        <div class="col-4 col-md-2 col-sm-3 text-center">
                                            <a href="#" class="text-dark">
                                                <span class="menu-con">
                                                    <i class="fab fa-android"></i><br>
                                                    App
                                                </span>
                                            </a>
                                        </div>
                                        <!-- /.col-md-4  -->
                                    </div>
                                </div>
                                <!--  /.container  -->


                            </div>
                        </li>

                    </ul>
                </div>


            </nav>
        </div>
    </header>

    <!--  header nav  -->