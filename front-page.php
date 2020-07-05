<?php get_header(); ?>

    <section class="content">
        <div class="head-section">
            <div class="head-wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Welcome to<br><strong>Mechanic Chai</strong></h2>
                            <p>Mechanic Chai is Mechanical Service Providing Company...</p>
                            <?php
                                mc_get_quote_button(
                                    home_url('service'), 'Get a Service'
                                );
                            ?>
                        </div>
                        <div class="col-md-6 text-center">
                            <?php echo get_template_part( 'template-parts/mc', 'call-now' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--   slider     -->

        <!--slide end-->



        <!--   service     -->
        <div class="service">
            <div class="container">
                <h2>Why Choose Us?</h2>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xsx-6">
                        <div class="serviceBox">
                            <div class="service-icon">
                                <span><i class="fab fa-angellist"></i></span>
                            </div>
                            <div class="service-content">
                                <h3 class="title">Quality Service and Work</h3>
                                <p class="description">Mechai chai will ensure the quality of service/product by doing 24/7 observation by Quality Control Team</p>
                                <a href="WebDesigning.html" class="read-more fas fa-eye" data-toggle="tooltip" title="Read More"></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xsx-6">
                        <div class="serviceBox green">
                            <div class="service-icon">
                                <span><i class="fas fa-award"></i></span>
                            </div>
                            <div class="service-content">
                                <h3 class="title">Well mannered and licenced tecnistian</h3>
                                <p class="description">We will provide Professional and Licensed technicians who have experience in this field for a decade. Not only that they will be polite and well-mannered as well.</p>
                                <a href="WebDevelopment.html" class="read-more fas fa-eye" data-toggle="tooltip" title="Read More"></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xsx-6">
                        <div class="serviceBox orange">
                            <div class="service-icon">
                                <span><i class="fas fa-tags"></i></span>
                            </div>
                            <div class="service-content">
                                <h3 class="title">Resonable<br>Price</h3>
                                <p class="description">We care about your expenses, we are here to reduce the time and money for you as your assistant. We will provide you the best deal on Servicing and Spare Part Products at a very reasonable price. </p>
                                <a href="MobileAppDevelopment.html" class="read-more fas fa-eye" data-toggle="tooltip" title="Read More"></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xsx-6">
                        <div class="serviceBox blue">
                            <div class="service-icon">
                                <span><i class="fas fa-user-clock"></i></span>
                            </div>
                            <div class="service-content">
                                <h3 class="title">Anywhere anytime 24/7 Service</h3>
                                <p class="description">Any kinds of mechanical/technical problems anytime anywhere. We are a call ahead of you. Just make a call and tell us your problem, a professional will be sent on location</p>
                                <a href="ECommarce.html" class="read-more fas fa-eye" data-toggle="tooltip" title="Read More"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--    about sec    -->
        <section class="about-sec">
            <div class="row">
                <div class="col-md-6">
                    <div class="about-bg">
                        <div class="abt-bg-wrap"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-con">
                        <h2>A Little About Us</h2>
                        <p>Mechanic Chai is Mechanical Service Providing Company...
                            In this modern time Repairing shouldn’t be a hassle, and that’s why we started Mechanic Chai!
                            When you need fixing or maintenance, Mechanic Chai will send a professional technician to
                            repair your machine ON LOCATION, providing a superior level of customer service, parts, and
                            repair for an affordable price without sacrificing quality. Our intent is to honor all of our
                            commitments and to strive for 100% customer satisfaction.</p>
                        <br>
                        <h3>Our Mission</h3>
                        <p>Our local facilities are owned and operated by independent business owners, which means
                            that in most cases, it's the actual owner themselves providing personalized service to their
                            customers. This dedication separates us from our competitors as we continually strive to
                            deliver an outstanding experience to each one of our customers.</p>
                        <a href="#" class="btn btn-primary btn-lg px-5">Read More</a>

                    </div>
                </div>
            </div>
        </section>
        <!--    about sec    -->

        <!--     service sec   -->
        <section class="service-sec">
            <div class="container">
                <h2 class="py-4">Our Services</h2>
                <p>Mechanic Chai will provide various mechanical/technical services which is given below:</p>
                <div class="row">
                    <div class="col-md-3">
                        <div class="square-service-block s-car">
                            <a href="#">
                                <div class="ssb-icon"><i class="fas fa-car"></i></div>
                                <h2 class="ssb-title">Car</h2>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="square-service-block s-motorbike">
                            <a href="#">
                                <div class="ssb-icon"><i class="fas fa-motorcycle"></i> </div>
                                <h2 class="ssb-title">Motorbike</h2>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="square-service-block s-ac">
                            <a href="#">
                                <div class="ssb-icon"> <i class="fas fa-fan"></i></div>
                                <h2 class="ssb-title">Air Condition</h2>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="square-service-block s-fridge">
                            <a href="#">
                                <div class="ssb-icon"> <i class="fas fa-igloo"></i></div>
                                <h2 class="ssb-title">Fridge</h2>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="square-service-block s-plumbing">
                            <a href="#">
                                <div class="ssb-icon"> <i class="fas fa-wave-square"></i></div>
                                <h2 class="ssb-title">Plumbing</h2>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="square-service-block s-elec">
                            <a href="#">
                                <div class="ssb-icon"> <i class="fas fa-plug"></i></div>
                                <h2 class="ssb-title">Electronics</h2>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="square-service-block s-com">
                            <a href="#">
                                <div class="ssb-icon"> <i class="fas fa-laptop"></i> </div>
                                <h2 class="ssb-title">Leptop/Computer</h2>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="square-service-block s-mobile">
                            <a href="#">
                                <div class="ssb-icon"> <i class="fas fa-mobile"></i></div>
                                <h2 class="ssb-title">Mobile Device</h2>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-lg px-5 my-5">Read More</a>
            </div>
        </section>
        <!--     service sec   -->

        <div class="register-as text-center">
            <div class="reg-as-wrap">
                <div class="container">
                    <a href="#" class="btn btn-primary btn-lg px-5">Register as User</a>
                    <a href="#" class="btn btn-outline-primary btn-lg px-5">Register as Agent</a>
                </div>
            </div>
        </div>
        <!--     service sec   -->

        <div class="pricing">
            <div class="container mb-5 mt-5">
                <h3 class="text-center py-5">Our Package Plans</h3>
                <div class="pricing card-deck flex-column flex-md-row mb-3">
                    <div class="card card-pricing text-center px-3 mb-4">
                        <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white shadow-sm">0</span>
                        <div class="bg-transparent card-header pt-4 border-0">
                            <h1 class="h1 font-weight-normal text-dark text-center mb-0" data-pricing-value="15">Tk<span class="price">0</span><span class="h6 text-muted ml-2">/ One Time</span></h1>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-4">
                                <li>1 free check up</li>
                                <li>Safety Training & Advising Session</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary mb-3">Order now</button>
                        </div>
                    </div>
                    <div class="card card-pricing popular shadow text-center px-3 mb-4">
                        <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white shadow-sm">Basic</span>
                        <div class="bg-transparent card-header pt-4 border-0">
                            <h1 class="h1 font-weight-normal text-dark text-center mb-0" data-pricing-value="30">Tk<span class="price">3500</span><span class="h6 text-muted ml-2">/ per month</span></h1>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-4">
                                <li>3 check up</li>
                                <li>Safety Training & Advising Session</li>
                                <li>On credit Service</li>
                                <li>Discount</li>
                            </ul>
                            <a href="https://www.totoprayogo.com" target="_blank" class="btn btn-primary mb-3">Order Now</a>
                        </div>
                    </div>
                    <div class="card card-pricing text-center px-3 mb-4">
                        <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white shadow-sm">Gold</span>
                        <div class="bg-transparent card-header pt-4 border-0">
                            <h1 class="h1 font-weight-normal text-dark text-center mb-0" data-pricing-value="45">Tk<span class="price">5000</span><span class="h6 text-muted ml-2">/ per month</span></h1>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-4">
                                <li>4 free check up</li>
                                <li>Safety Training & Advising Session</li>
                                <li>On credit Service</li>
                                <li>Discount</li>
                                <li>Free Home Delivery</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary mb-3">Order now</button>
                        </div>
                    </div>
                    <div class="card card-pricing text-center px-3 mb-4">
                        <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white shadow-sm">Platinum</span>
                        <div class="bg-transparent card-header pt-4 border-0">
                            <h1 class="h1 font-weight-normal text-dark text-center mb-0" data-pricing-value="60">Tk<span class="price">10,000</span><span class="h6 text-muted ml-2">/ per month</span></h1>
                        </div>
                        <div class="card-body pt-0">
                            <ul class="list-unstyled mb-4">
                                <li>4 free check up</li>
                                <li>Safety Training & Advising Session</li>
                                <li>On credit Service</li>
                                <li>Discount</li>
                                <li>Free Home Delivery</li>
                                <li>Free Cancelation</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary mb-3">Order now</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--    subscribe    -->
        <div class="subscriber text-center">
            <div class="sub-wrap">
                <div class="container">
                    <h3>Subscribe</h3>
                    <p>Subcribe to our Newslatter to get update <br>about ourNew and Upcoming services, events & Products.</p>
                    <form action="" method="post">
                        <input type="text" class="form-control" placeholder="yourmail@email.com">
                        <input type="submit" value="subscribe" class="btn btn-primary px-5 mt-4">
                    </form>
                </div>
            </div>
        </div>
        <!--    subscribe    -->

        <!--    rating    -->
        <div class="rating-sec">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>See What <b>Our Customers</b> Say About Us</h2>
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Carousel indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                            </ol>
                            <!-- Wrapper for carousel items -->
                            <div class="carousel-inner">
                                <div class="item carousel-item active">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="testimonial-wrapper">
                                                <div class="testimonial">My family has had two occasions to use this service. Both times the mechanics were on time, efficient, and knowledgeable. Great way to get many car repairs done!</div>
                                                <div class="media">
                                                    <div class="media-left d-flex mr-3">
                                                        <img src="img/user-1.jpg" alt="">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="overview">
                                                            <div class="name"><b>Abdur Razzak</b></div>
                                                            <div class="details">Businessman</div>
                                                            <div class="star-rating">
                                                                <ul class="list-inline">
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star-half-o"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="testimonial-wrapper">
                                                <div class="testimonial">They do a great job. Very professional and on time and convenient, they come to you and work on your car. Very good price.</div>
                                                <div class="media">
                                                    <div class="media-left d-flex mr-3">
                                                        <img src="img/user-2.jpg" alt="">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="overview">
                                                            <div class="name"><b>Asharful Khondokar Mehedy</b></div>
                                                            <div class="details">Transporter</div>
                                                            <div class="star-rating">
                                                                <ul class="list-inline">
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item carousel-item">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="testimonial-wrapper">
                                                <div class="testimonial">I had my Rear Differential Gasket and Gear oil fluid replaced on My Allion G 2016 by Alim Mahmud today! He showed up early and was very professional and friendly. I hope this company realizes the dedication and service this man gives!! Thanks again Alim!!</div>
                                                <div class="media">
                                                    <div class="media-left d-flex mr-3">
                                                        <img src="img/user-3.jpg" alt="">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="overview">
                                                            <div class="name"><b>Shah Faridul Azam</b></div>
                                                            <div class="details">Rent a Car</div>
                                                            <div class="star-rating">
                                                                <ul class="list-inline">
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="testimonial-wrapper">
                                                <div class="testimonial">I googled a search to see comparable prices to the quote I got for replacing the spark plugs on my Toyota Axio. I found this amazing website! The mechanic comes to me at no extra charge! Unbelievable! They have an A rating on the Better Business Bureau. I'm definitely going to check this out and report back. Stay tune ...</div>
                                                <div class="media">
                                                    <div class="media-left d-flex mr-3">
                                                        <img src="img/user-1.jpg" alt="">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="overview">
                                                            <div class="name"><b>Reegan Ahmed</b></div>
                                                            <div class="details">Businessman</div>
                                                            <div class="star-rating">
                                                                <ul class="list-inline">
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                                    <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    rating    -->

    </section>
    
<?php get_footer(); ?>