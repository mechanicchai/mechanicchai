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
    $repair_service_types = mc_get_service_types();
    if( $repair_service_types ) {
        if( is_array( $repair_service_types ) ) {
            update_post_meta( $post_id, 'mc_service_type_all_options', $repair_service_types ? $repair_service_types : [] );
        }
    }
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
            <?php
                $repair_service_types = mc_get_service_types();
                if( $repair_service_types ) {
                    if( is_array( $repair_service_types ) ) {
                        foreach( $repair_service_types as $repair_service_type ) {
                            $service_repair_id = $repair_service_type['id'];
                            $service_repair_type = $repair_service_type['name'];

                            if( $service_repair_type ) { ?>
                                <p>
                                    <input type="radio" name="mc_service_type_option" class="post-format" value="<?php echo $service_repair_id; ?>" <?php checked( get_post_meta( $post->ID, 'mc_service_type_option', true ), $service_repair_id ); ?>>
                                    <label for="mc_service_type_option" class="post-format-icon"><b><?php echo esc_html__( $service_repair_type, 'mechanic' ) ?></b></label>
                                </p>
                                <?php 
                            }
                        }
                    }
                }
            ?>
        </div>
	</div>
	<?php
}
