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
<body <?php echo body_class(); ?>>
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



                <!-- The WordPress Menu goes here -->
                <?php 
                wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => 'collapse navbar-collapse hidden-xs',
						'container_id'    => 'navbarSupportedContent',
						'menu_class'      => 'navbar-nav mr-auto',
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu',
						'depth'           => 2,
						'walker'          => new MC_WP_Bootstrap_Navwalker(),
					)
                ); 
                ?>


            </nav>
        </div>
    </header>

    <!--  header nav  -->