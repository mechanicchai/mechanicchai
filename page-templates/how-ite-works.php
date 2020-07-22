<?php

/**
 * Template Name: How it works
 * 
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>

<section class="content">
    <div class="head-section text-center">
        <div class="head-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>How it Works</h2>
                        <?php
                            mc_get_quote_button(
                                home_url('service'), 'Get a Quote'
                            );
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="timeline-con">
        <div class="container">
            <h2 class="text-center py-5">How to Get a Service</h2>
            <ul class="timeline">
                <li>
                    <div class="timeline-badge">1st</div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Tell us about your Problem</h4>
                        </div>
                        <div class="timeline-body">
                            <p>Just make a call and tell us about your problem. If you know what to fix then you can select it
                                from our service packs and enter your location and detail of your problem so that we know
                                what to fix. Then you'll need to select the work that needs doing and select it to cart and place
                                an order according to it.
                                If you're not sure what's wrong with your machine, don't worry! You can either take the help
                                from our executive or book a diagnostic inspection and the mechanic will let you know.</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-badge warning">2nd</div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">You get an instant quote</h4>
                        </div>
                        <div class="timeline-body">
                            <p>Then we'll put this information into our quote engine and you'll get an industry standard
                                approved quote within seconds. Want to know how the price is an industry standard approved one? Take a look at our honest
                                pricing page to find out how we use millions of data points to get your quote.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-badge danger">3rd</div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">Confirm your booking</h4>
                        </div>
                        <div class="timeline-body">
                            <p>Let us know your preferred date, time, and location for the work to be done. To finalize your
                                booking, you don’t need to enter your bank card details. We won't take a penny from you until
                                the mechanic has completed any work.</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-badge danger">4th</div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title">On the day</h4>
                        </div>
                        <div class="timeline-body">
                            <p>Your mechanic will collect any parts they need and arrive at your chosen location within your
                                requested arrival window. They'll introduce themselves and either take your machine to the
                                workshop/garage or get on with the work that you have selected.
                                Once all work has been agreed and finished (and your machine returned if it was taken to a
                                workshop or garage), your mechanic will explain the work they carried out. Once you're happy,
                                your securely stored bankcard will be charged through the Click Mechanic app that all of the
                                mechanics carry on their smart phone. The invoice from your mechanic will be sent directly to
                                your email. After paying bill to the mechanic you have to confirm the bill through mail or from
                                app.
                                After the visit, you'll receive an email asking you to rate your mechanic. This helps us ensure
                                our standards remain high and improve the service for the next time you use us.</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>



    <div class="mobile-app-workflow">
        <div class="mobile-app-workflow-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section-title text-center mb-60 py-5">
                            <h3>Our Mobile App</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="single_service service_right text-center">
                            <i class="fas fa-globe-africa"></i>
                            <h4>Online Appointment</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                        <div class="single_service service_right text-center">
                            <i class="fas fa-gifts"></i>
                            <h4>Popular Services</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                        <div class="single_service service_right text-center">
                            <i class="fas fa-shopping-cart"></i>
                            <h4>Imported Products</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center text-center">
                        <div class="single_mid">
                            <?php
                                // echo $image = mc_display_mobile_app_img();
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="single_service text-center">
                            <i class="fas fa-clock"></i>
                            <h4>24/7 Service</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                        <div class="single_service text-center">
                            <i class="fas fa-car"></i>
                            <h4>Car Status Tracking</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                        <div class="single_service text-center">
                            <i class="fas fa-users-cog"></i>
                            <h4>Expert Tecnicians</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <section class="FAQ-con">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center wow zoomIn">
                        <h1>FAQ</h1>
                        <span></span>
                        <p>Our Frequently Asked Questions here.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php
                    $faqs = mc_get_faqs();
                    
                    if( $faqs ) {
                        if( is_array( $faqs ) ) {
                            $counter_id = 0;
                            foreach( $faqs as $faq ) {
                                $faq_question = $faq['faq_question'];
                                $faq_answer = $faq['faq_answer'];

                                if( $faq_question && $faq_answer ) { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading<?php echo $counter_id; ?>">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $counter_id; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                <?php echo esc_html__( $faq_question, 'mechanic' ); ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo $counter_id; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <?php echo sprintf( '<p>%s</p>', esc_html($faq_answer) ); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                }

                                $counter_id++;
                            }
                        }
                    }
                    ?>
                        
                    </div>
                </div>
                <!--- END COL -->
            </div>
            <!--- END ROW -->
        </div>
    </section>

</section>
<?php get_footer(); ?>