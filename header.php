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
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="index.html"><img src="img/logo.png"></a>
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