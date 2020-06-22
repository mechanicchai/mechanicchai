<?php

/**
 * Saving Metabox Data
 * Post Type: Service
 *
 * @param $post_id
 */
function mc_save_postmeta( $post_id, $post, $is_update ) {

	if ( ! $is_update ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	if ( 'service' !== get_post_type( $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, 'mc_service_type', empty( $_POST['mc_service_type'] ) ? '0' : '1' );
    update_post_meta( $post_id, 'mc_service_type_option', empty( $_POST['mc_service_type_option'] ) ? '1' : $_POST['mc_service_type_option'] );
    

    //default array for services types
    $mc_service_types = [
        '1' => 'Brake', 
        '2' => 'Engine', 
        '3' => 'Body/Chasis', 
        '4' => 'Fuel/Gas', 
        '5' => 'Tire/Rim', 
    ];

    $mc_service_types = apply_filters( 'mc_get_service_type_options', $mc_service_types );
    update_post_meta( $post_id, 'mc_service_type_all_options', is_array($mc_service_types) ? $mc_service_types : [] );
}

add_action( 'save_post', 'mc_save_postmeta', 10, 3 );


/**
 * Register Metabox
 * Post Type: Service
 */
function mc_register_metabox() {
	add_meta_box( 'post-controls', 'Post Controls', 'mc_post_controls_metabox', 'service', 'side', 'high' );
}

add_action( 'admin_init', 'mc_register_metabox' );


/*
 * Post Controls Metabox
 * Post Type: Service
 */
function mc_post_controls_metabox( $post ) {
	?>
	<div class="service-section">
		<div class="service-type">
            <p>
                <input type="radio" name="mc_service_type" class="post-format mc_service_type" value="1" <?php checked( get_post_meta( $post->ID, 'mc_service_type', true ), '1' ); ?>>
                <label for="mc_service_type" class="post-format-icon"><b><?php echo esc_html__( 'REPAIR & MAINTENANCE', 'mechanic' ) ?></b></label>
            </p>
            <p>
                <input type="radio" name="mc_service_type" class="post-format mc_service_type" value="0" <?php checked( get_post_meta( $post->ID, 'mc_service_type', true ), '0' ); ?>>
                <label for="mc_service_type" class="post-format-icon"><b><?php echo esc_html__( 'DIAGNOSTICS & INSPECTIONS', 'mechanic' ) ?></b></label>
            </p>
        </div>

        <div class="service-type-child" style="padding-left: 30px;">
            <p>
                <input type="radio" name="mc_service_type_option" class="post-format" value="1" <?php checked( get_post_meta( $post->ID, 'mc_service_type_option', true ), '1' ); ?>>
                <label for="mc_service_type_option" class="post-format-icon"><b><?php echo esc_html__( 'Brake', 'mechanic' ) ?></b></label>
            </p>
            <p>
                <input type="radio" name="mc_service_type_option" class="post-format" value="2" <?php checked( get_post_meta( $post->ID, 'mc_service_type_option', true ), '2' ); ?>>
                <label for="mc_service_type_option" class="post-format-icon"><b><?php echo esc_html__( 'Engine', 'mechanic' ) ?></b></label>
            </p>
            <p>
                <input type="radio" name="mc_service_type_option" class="post-format" value="3" <?php checked( get_post_meta( $post->ID, 'mc_service_type_option', true ), '3' ); ?>>
                <label for="mc_service_type_option" class="post-format-icon"><b><?php echo esc_html__( 'Body/Chasis', 'mechanic' ) ?></b></label>
            </p>
            <p>
                <input type="radio" name="mc_service_type_option" class="post-format" value="4" <?php checked( get_post_meta( $post->ID, 'mc_service_type_option', true ), '4' ); ?>>
                <label for="mc_service_type_option" class="post-format-icon"><b><?php echo esc_html__( 'Fuel/Gas', 'mechanic' ) ?></b></label>
            </p>
            <p>
                <input type="radio" name="mc_service_type_option" class="post-format" value="5" <?php checked( get_post_meta( $post->ID, 'mc_service_type_option', true ), '5' ); ?>>
                <label for="mc_service_type_option" class="post-format-icon"><b><?php echo esc_html__( 'Tire/Rim', 'mechanic' ) ?></b></label>
            </p>
        </div>
	</div>
	<?php
}
