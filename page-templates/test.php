<?php
/**
 * Template Name: Test  
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php
    // $user = reset(
    //     get_users(
    //         array(
    //             'meta_key' => 'user_phone',
    //             'meta_value' => '01685773283',
    //             'number' => 1,
    //             'count_total' => false
    //         )
    //     )
    // );
    
    // $user = get_users(
    //         array(
    //             'meta_key' => 'phone',
    //             'meta_value' => '01756589954',
    //             'number' => 1,
    //             'count_total' => false
    //         )
    //     );

    // echo '<pre>';
    // print_r( $user );
    // echo '</pre>';
    
    // Add phone number field in the woocommerce registration form
    function wooc_add_phone_number_field() {
        return apply_filters( 'woocommerce_forms_field', array(
            'wooc_user_phone' => array(
                'type'        => 'text',
                'label'       => __( 'Phone Number', ' woocommerce' ),
                'placeholder' => __( 'Your phone number', 'woocommerce' ),
                'required'    => true,
            ),
        ) );
    }
    //add_action( 'woocommerce_register_form', 'wooc_add_field_to_registeration_form', 15 );

    function wooc_add_field_to_registeration_form() {
        $fields = wooc_add_phone_number_field();
        foreach ( $fields as $key => $field_args ) {
            woocommerce_form_field( $key, $field_args );
        }
    }

    // Finally we need to edit the login label to tell the user that he can login with his phone number
    add_filter( 'gettext', 'wooc_change_login_label', 10, 3 );
    function wooc_change_login_label( $translated, $original, $domain ) {
        if ( $translated == "Username or email address" && $domain === 'woocommerce' ) {
            $translated = "phone";
        }
        return $translated;
    } 
?>

<div class="container">
    <div class="row">
        <?php
            if( have_posts() ):

                while( have_posts() ):
                    the_post();

                    the_content();
                endwhile;
            endif; 
        ?>
    </div>
</div>

<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			<?php else : ?>

				<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocommerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>
        




        <div class="container-fluid my-2">
			<div class="card bg-light signup">
				<article class="card-body mx-auto" style="max-width: 400px;">
					<h4 class="card-title mt-3 text-center"><h2><?php esc_html_e( 'Create Account', 'mechanic' ); ?></h2></h4>
					<p class="text-center"><?php esc_html_e( 'Get started with your free account', 'mechanic' ); ?></p>
					
					<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
						<?php do_action( 'woocommerce_register_form_start' ); ?>

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-user"></i> </span>
							</div>
							<input name="mc_reg_full_name" class="form-control" placeholder="Full name" type="text">
						</div> <!-- form-group// -->

						<!-- form-group// -->
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-user"></i> </span>
							</div>
							<input name="" class="form-control" placeholder="User Name" type="text">
						</div> <!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-building"></i> </span>
							</div>
							<select class="form-control" name="mc_reg_location">
								<option selected=""> Select Location</option>
								<option>Abdullah Pur</option>
								<option>Uttara</option>
								<option>Airport</option>
								<option>Khilkhet</option>
								<option>Kuril</option>
								<option>Bashundhara R/A</option>
								<option>Kalachandpur</option>
								<option>Baridhara</option>
								<option>Gulshan 2</option>
								<option>Gulshan 1</option>
								<option>Badda</option>
								<option>Rampura</option>
							</select>
						</div> <!-- form-group end.// -->
						
						<!-- <div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
							</div>
							<input name="mc_reg_email" class="form-control" placeholder="Email address" type="email">
						</div>  -->
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-phone"></i> </span>
							</div>
							<select class="custom-select" name="mc_reg_mobile_first" style="max-width: 120px;">
								<option selected="">+88015</option>
								<option selected="">+88016</option>
								<option selected="">+88017</option>
								<option value="1">+88018</option>
								<option value="2">+88019</option>
							</select>
							<input name="mc_reg_mobile_last" class="form-control" placeholder="Phone number" type="text">
						</div>

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input class="form-control" name="mc_reg_password" placeholder="Create password" type="password">
						</div> <!-- form-group// -->

						<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

							<div class="form-group input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
								</div>
								<input class="form-control" name="password" id="reg_password" placeholder="Repeat password" type="password" autocomplete="new-password">
							</div> <!-- form-group// -->

						<?php else : ?>

						<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

						<?php endif; ?>

						<div class="form-group input-group">
							<input class="" name="mc_reg_agree" type="checkbox"> By clicking register you are agree with our terms and conditions
						</div>

						<?php do_action( 'woocommerce_register_form' ); ?>

						<div class="form-group">
							<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
							<button type="submit" class="btn btn-primary btn-block woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
						</div> <!-- form-group// -->
						<?php do_action( 'woocommerce_register_form_end' ); ?>
					</form>
				</article>
			</div> <!-- card.// -->
		</div> <!--container end.//-->

<?php
get_footer();
?>