<?php
/**
 * Template Name: Contact
 * 
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="content">
    <div class="head-section text-center">
        <div class="head-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo get_template_part( 'template-parts/mc', 'call-now' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="contact-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Contact us</h3><br />

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <?php
                                if( have_posts() ):
                                    while( have_posts() ):
                                        the_post();

                                        the_content();
                                    endwhile;
                                endif;  
                            ?>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-content">
                                <?php
                                    if( function_exists( 'get_field' ) ) {
                                        echo get_field( 'contact_content', get_the_ID() );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="map">
        <?php
            if( function_exists( 'get_field' ) ) {
                echo get_field( 'contact_map', get_the_ID() );
            }
        ?>
    </div>
</section>

<?php get_footer(); ?>
