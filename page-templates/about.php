<?php
/**
 * Template Name: About
 * 
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="content">
        <?php mc_page_head_section( 'About Us', 'Mechanic Chai is Mechanical Service Providing Company...' ); ?>

        <div class="what-is-mc">
            <div class="container">
                <div class="abt-top">
                    <?php
                        $args = array(
                            'post_type' => 'about',
                            'posts_per_page' => 3,
                        );
                        $posts = get_posts( $args );
                        
                        if( !empty( $posts ) ) {
                            $counter = 0;
                            foreach( $posts as $post ) {
                                setup_postdata( $post );
                                $id = $post->ID;
                                $image = get_the_post_thumbnail( $post, 'about-post-thumbnail' );
                                
                                ?>
                                <div class="row">
                                    <?php if($counter % 2 == 0) { ?>
                                        <div class="col-md-8 py-5">
                                            <?php echo sprintf( '<h2>%s</h2><br>', get_the_title( $id ) ) ?>
                                            <?php the_content(); ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?php echo !empty( $image ) ? $image : ''; ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-md-4">
                                            <?php echo !empty( $image ) ? $image : ''; ?>
                                        </div>
                                        <div class="col-md-8 py-5">
                                            <?php echo sprintf( '<h2>%s</h2><br>', get_the_title( $id ) ) ?>
                                            <?php the_content(); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr class="py-2">
                            <?php
                                $counter++;
                                wp_reset_postdata();
                            }
                        }
                        ?>

                    <?php get_template_part( 'template-parts/about', 'points' ); ?>

                    <div class="abt-some-more"></div>
                </div>
            </div>
        </div>


        <?php get_template_part( 'template-parts/about', 'local-info' ); ?>
        <?php get_template_part( 'template-parts/about', 'remember-care' ); ?>

    </section>

<?php
get_footer();
?>