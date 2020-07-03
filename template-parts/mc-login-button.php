<?php
    // Exit if accessed directly.
    defined( 'ABSPATH' ) || exit;
?>

<?php 
    if( !is_user_logged_in() ) {
    ?>
    <a href="<?php echo get_home_url(); ?>/log-in/" class="btn btn-primary btn-sm px-4"><i class="fas fa-user"></i> <span class="hide-con"><?php esc_html_e( 'Sign In', 'mechanic' ); ?></span></a>
    
    <?php
        $parsed_url = mc_parse_current_url();
        if (isset($parsed_url['path']) && !empty($parsed_url['path'])) {
            $path = $parsed_url['path'];
            if ($path !== '/registration') { ?>
                <a href="<?php echo get_home_url(); ?>/registration/" class="btn btn-outline-primary btn-sm px-4"><i class="fas fa-user-plus"></i> <span class="hide-con"><?php esc_html_e( 'Sign Up', 'mechanic' ); ?></span></a>
            <?php
            }
        }
    }
?>
