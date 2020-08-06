<?php

/**
 * Template Name: Service
 * 
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>

<div class="service">
    <div class="service-cart">
        <div class="cd-cart cd-cart--empty js-cd-cart">
            <a href="#0" class="cd-cart__trigger text-replace">
                
                <ul class="cd-cart__count"> <!-- cart items count -->
                    <li>0</li>
                    <li>0</li>
                </ul> <!-- .cd-cart__count -->
            </a>

            <div class="cd-cart__content">
                <div class="cd-cart__layout">
                    

                    <div class="cd-cart__body">
                        <header class="cd-cart__header p-2 pt-3">
                            <h2>Selected Service</h2>
                            <span class="cd-cart__undo">Item removed. <a href="#0">Undo</a></span>
                        </header>
                        <ul class="p-4">
                            <!-- products added to the cart will be inserted here using JavaScript -->
                        </ul>
                    </div>

                    <footer class="cd-cart__footer">
                        <a href="#0" class="cd-cart__checkout">
                  <em>Submit Order - Tk<span>0</span>
                    <svg class="icon icon--sm" viewBox="0 0 24 24"><g fill="none" stroke="currentColor"><line stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x1="3" y1="12" x2="21" y2="12"/><polyline stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="15,6 21,12 15,18 "/></g>
                    </svg>
                  </em>
                </a>
                    </footer>
                </div>
            </div> <!-- .cd-cart__content -->
        </div> <!-- cd-cart -->
    </div>
    <div class="container">
        
        <form id="regForm" action="/action_page.php">
            <div class="step-group" style="text-align:center;">
                <span class="step service-category"><span class="count"><i class="fas fa-clone"></i></span><span class="name">Category & Specification</span></span>
                <span class="step service-select"><span class="count"><i class="fas fa-cog"></i></span><span class="name">Service</span></span>
                <span class="step service-info"><span class="count"><i class="fas fa-map-marker-alt"></i></span><span class="name">Address and Time/Date</span></span>
                <span class="step service-review"><span class="count"><i class="fas fa-eye"></i></span><span class="name">Review & Book</span></span>
            </div>
<!--            <h5>Answer a few simple questions to get a Service.</h5>-->
            <hr>
            <!-- One "tab" for each step in the form: -->
            <div class="tab">
                <div class="row">
                    <div class="col-md-8 select-service">
                        <h3>Select Service</h3>
                        <?php $categories = mc_get_all_parent_categories('service_category'); ?>
                        <div class="row se-services">
                            <?php
                            foreach ($categories as $category) {
                                $cat_id = $category->term_id;
                                $cat_name = $category->name;
                                
                                //category icon class
                                if( function_exists('get_field') ) {
                                    $category_icon_class =  get_field( 'category_field', 'category_' . $cat_id );
                                }else {
                                    $category_icon_class = '';
                                }

                            ?>
                                <div class="col-4 mt-2">
                                    <a class="mc-main-services btn <?php echo ($cat_name == 'Car') ? 'btn-primary service-cat-active' : 'btn-secondary'; ?>" data-cat_id="<?php echo !empty($cat_id) ? $cat_id : ''; ?>" data-category="<?php echo strtolower($category->name); ?>"><i class="<?php echo $category_icon_class; ?>"></i><br><?php echo !empty($cat_name) ? $cat_name : ''; ?></a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                    </div>
                    <div class="col-md-4 specify-service">
                        <h3>Specify Your <span class="mc-title-category">Car</span></h3>
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Brand</label>

                                <?php
                                foreach ($categories as $category) {
                                    $cat_id = $category->term_id;
                                    $brands_as_child_categories = get_categories(array(
                                        'parent' => $cat_id,
                                        'taxonomy' => 'service_category'
                                    ));

                                    if ($brands_as_child_categories) {
                                ?>

                                        <select name="" id="" class="form-control mc-service-brand <?php echo ($category->slug === 'car') ? 'mc-active' : ''; ?>" data-brand-category="<?php echo strtolower($category->name); ?>">
                                            <?php
                                            //default active brand id for getting model lists
                                            $default_active_brand_id = ($category->slug === 'car') ? $brands_as_child_categories[0]->term_id : '';

                                            if ($brands_as_child_categories) {
                                                foreach ($brands_as_child_categories as $brand) {
                                            ?>
                                                    <option data-brand="<?php echo !empty($brand) ? $brand->slug : ''; ?>" data-id="<?php echo !empty($brand) ? $brand->term_id : ''; ?>"><?php echo !empty($brand) ? $brand->name : ''; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Model</label>
                                <?php
                                foreach ($categories as $category) {
                                    $cat_id = $category->term_id;
                                    $brands_as_child_categories = get_categories(array(
                                        'parent' => $cat_id,
                                        'taxonomy' => 'service_category'
                                    ));

                                    if ($brands_as_child_categories) {
                                        $counter = 0;
                                        foreach ($brands_as_child_categories as $brand) {
                                            $models_as_child_categories = get_categories(array(
                                                'parent' => $brand->term_id,
                                                'taxonomy' => 'service_category'
                                            ));

                                            if ($models_as_child_categories) {
                                                ?>
                                                <select class="form-control mc-service-model <?php echo ($counter === 0 && $category->slug === 'car') ? 'mc-active' : ''; ?>" data-model-category="<?php echo strtolower($category->name); ?>" data-brand="<?php echo !empty($brand) ? $brand->slug : ''; ?>">
                                                    <?php
                                                    foreach ($models_as_child_categories as $model) {
                                                    ?>
                                                        <option data-id="<?php echo !empty($model) ? $model->term_id : ''; ?>" data-model="<?php echo !empty($model) ? $model->slug : ''; ?>"><?php echo !empty($model) ? $model->name : ''; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                            }

                                            $counter++;
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Year</label>
                                <input type="text" class="mc-service-year" placeholder="2010">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab">
                <div class="tabs">
                    <div class="tab-button-outer">
                        <ul id="tab-button">
                            <li><a href="#tab01">REPAIR & MAINTENANCE SERVICES</a></li>
                            <li><a href="#tab02">DIAGNOSTICS & INSPECTIONS</a></li>
                        </ul>
                    </div>
                    <div class="tab-select-outer">
                        <select id="tab-select" class="form-control">
                            <option value="#tab01">REPAIR & MAINTENANCE SERVICES</option>
                            <option value="#tab02">DIAGNOSTICS & INSPECTIONS</option>
                        </select>
                    </div>

                    <div id="tab01" class="tab-contents">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control mc-service-types">
                                    <option value="0">All</option>
                                    <?php
                                    //get random service post id
                                    $args = array( 
                                        'orderby' => 'desc',
                                        'posts_per_page' => '1', 
                                        'post_type' => 'service',
                                        'meta_query' => [
                                            'key'     => 'mc_service_type',
                                            'value'   => '1',
                                            'compare' => '=',
                                        ]
                                    );
                                    $posts = get_posts( $args );
                                    $post_id = $posts[0]->ID;
                                    if (get_post_status($post_id)) {
                                        $all_service_type_options = get_post_meta($post_id, 'mc_service_type_all_options', true);
                                        
                                        foreach ($all_service_type_options as $service_type_meta) { ?>
                                            <option value="<?php echo $service_type_meta['id']; ?>"><?php echo esc_html__( $service_type_meta['name'], 'mechanic' ); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                        <span class="input-group-text lighten-3" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12">
                                <table class="table table-hover mt-4 mc-repair-services">
                                    <tbody>
                                        <?php
                                        $args = array(
                                            'post_type' => 'service',
                                            'posts_per_page' => -1,
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'mc_service_type',
                                                    'value' => '1',
                                                    'compare' => '=',
                                                )
                                            )
                                        );
                                        $repair_service_posts = get_posts($args);

                                        echo '<pre>';
                                        print_r($repair_service_posts);
                                        echo '</pre>';
                                        
                                        

                                        if ($repair_service_posts) {
                                            foreach ($repair_service_posts as $repair_service_post) {
                                                setup_postdata($repair_service_posts);
                                                $id = $repair_service_post->ID;

                                                //get current service type meta
                                                $service_type = get_post_meta($id, 'mc_service_type', true);

                                                if (!empty($service_type) && $service_type == 1) {
                                                    $service_type_option = get_post_meta($id, 'mc_service_type_option', true);
                                                }

                                                if( function_exists('get_field') ) {
                                                    $cost = get_field('service_amount', $id);
                                                }

                                                //service category lists
                                                $service_cat_list = get_the_terms( $id, 'service_category' );
                                                $service_cat_list = ( $service_cat_list && is_array($service_cat_list) ) ? wp_list_pluck( $service_cat_list, 'slug' ) : array();
                                                $service_category =  implode( ',', $service_cat_list );
                                                

                                        ?>
                                                <tr data-category="<?php echo $service_category; ?>" data-service-type="<?php echo !empty($service_type) ? $service_type : ''; ?>" data-service-option="<?php echo !empty($service_type_option) ? $service_type_option : ''; ?>">
                                                    <td class="mc-service-title" data-id="<?php echo $id; ?>"><?php echo get_the_title($id); ?></td>
                                                    <td class="mc-service-cost" data-cost="<?php echo $cost ? $cost : ''; ?>"><?php echo $cost ? esc_html__( $cost, 'mechanic' ) : ''; ?>Tk</td>
                                                    <td class="text-right"><a href="#0" class="btn btn-primary btn-sm mc-add-service-cart-btn cd-add-to-cart js-cd-add-to-cart" data-price="300.00">Add</a></td>
                                                    
                                                </tr>
                                        <?php
                                            wp_reset_postdata();
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div id="tab02" class="tab-contents">
                        <table class="table table-hover mt-4">
                            <tbody>
                                <?php
                                $args = array(
                                    'post_type' => 'service',
                                    'posts_per_page' => 40,
                                    'meta_query' => array(
                                        array(
                                            'key' => 'mc_service_type',
                                            'value' => '0',
                                            'compare' => '=',
                                        )
                                    )
                                );
                                $diagnosis_service_posts = get_posts($args);

                                echo '<pre>';
                                print_r($diagnosis_service_posts);
                                echo '</pre>';

                                if ($diagnosis_service_posts) {
                                    foreach ($diagnosis_service_posts as $diagnosis_service_post) {
                                        setup_postdata($diagnosis_service_posts);
                                        $id = $diagnosis_service_post->ID;

                                        if( function_exists('get_field') ) {
                                            $cost = get_field('service_amount', $id);
                                        }

                                        //service category lists
                                        $service_cat_list = get_the_terms( $id, 'service_category' );
                                        $service_cat_list = ( $service_cat_list && is_array($service_cat_list) ) ? wp_list_pluck( $service_cat_list, 'slug' ) : array();
                                        $service_category =  implode( ',', $service_cat_list );
                                ?>
                                        <tr data-category="<?php echo $service_category; ?>">
                                            <td class="mc-service-title" data-id="<?php echo $id; ?>"><?php echo get_the_title($id); ?></td>
                                            <td class="mc-service-cost" data-cost="<?php echo $cost ? $cost : ''; ?>"><?php echo $cost ? esc_html__( $cost, 'mechanic' ) : ''; ?>Tk</td>
                                            <td class="text-right"><a href="#0" class="btn btn-primary btn-sm mc-add-service-cart-btn cd-add-to-cart js-cd-add-to-cart" data-price="300.00">Add</a></td>
                                        </tr>
                                <?php
                                    wp_reset_postdata();
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Name</label>
                                <input type="text" class="form-control service-info-name" placeholder="your name here">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Number</label>
                                <input type="text" class="form-control service-info-number" placeholder="your number here">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Location</label>
                                <select class="form-control service-info-location" id="exampleFormControlSelect1">
                                    <?php
                                        $locations = mc_get_service_locations();
                                        
                                        if( $locations ) {
                                            if( is_array( $locations ) ) {
                                                foreach( $locations as $location ) {
                                                    $location_name = $location['location_name'];

                                                    if( $location_name ) { ?>
                                                        <option><?php echo esc_html__( $location_name, 'mechanic' ); ?></option>
                                                        <?php 
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Address</label>
                                <textarea class="form-control service-info-address"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Date</label>
                                <input type="date" class="form-control service-info-date">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Time</label>
                                <input type="time" class="form-control service-info-time">
                            </div>
                        </div>
                        <?php
                            if( is_user_logged_in() ) {
                                $current_user = wp_get_current_user();
                                $user_obj = $current_user->data;
                            }
                        ?>
                        <input type="hidden" class="form-control service-info-user" value='<?php echo $user_obj ? json_encode($user_obj) : ""; ?>'>
                    </div>
                </form>
            </div>
            <div class="tab">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title text-center">Order Overview</div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mc-checkout-brand">Corolla G</h5>
                                <h6><span class="mc-checkout-model">Toyota</span> <span class="mc-checkout-year">- 2016</span></h6>
                            </div>
                            <div class="col-md-6">
                                <h5>Appointment Date/Time</h5>
                                <h6 class="mc-checkout-appoint-date">1st April 2020</h6>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5>Services</h5>
                                <table class="table table-hover mt-4 mc-checkout-services-list">
                                    <tbody>
                                        <tr>
                                            <td data-id="1">ABS Speed Sensor Replacement</td>
                                            <td data-cost="780">780Tk</td>
                                            <td class="text-right"><a class="btn btn-primary btn-sm">Cancel</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Address</h5>
                                <p>Location : <span class="service-checkout-location">Rampura</span></p>
                                <p>Address : <span class="service-checkout-address">House : 29, Road : 11, DIT Road, Rampura</span></p>
                            </div>
                            <div class="col-md-6">
                                <h5>Contact Info</h5>
                                <p>Name : <span class="service-checkout-name">Rafel Chy</span></p>
                                <p>Number : <span class="service-checkout-number">01992969618</span></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Payment Method</h5>
                                <p>Cash on Delivery</p>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mc-submit-form-wrapper" style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Order</button>
                    <div class="gravity-form service-form-submit">
                        <?php wp_nonce_field( 'mc_send_services', 'mc_send_services' ); ?>
                        <input type="submit" id="mc_service_submit" value="Submit">
                        <?php //echo do_shortcode('[gravityform id="1"]'); ?>
                    </div>
                </div>
                
            </div>

            <!-- Circles which indicates the steps of the form: -->

        </form>
    </div>
</div>

<?php get_footer(); ?>