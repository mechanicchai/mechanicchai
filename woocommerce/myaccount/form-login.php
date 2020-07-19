<?php

/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>
<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
		<?php
		$parsed_url = mc_parse_current_url();

		if (isset($parsed_url['path']) && !empty($parsed_url['path'])) {
			$path = $parsed_url['path'];

			if ($path == '/registration') {
				if( isset($_GET['otp']) && $_GET['otp'] == 'yes'  ) {?>
					<!-- OTP Form content  -->
					<div class="container-fluid my-2">
						<div class="card bg-light signup">
							<article class="card-body mx-auto" style="max-width: 400px;">
								<h4 class="card-title mt-3 text-center"> <?php esc_html_e('OTP Submit', 'mechanic'); ?></h4>

								<form method="post" class="mc-register-otp-form" >
									<div class="form-group input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"> <i class="fa fa-paper-plane-o"></i> </span>
										</div>
										<input name="mc_reg_otp_code" class="form-control" placeholder="Type OTP code" type="text">
									</div> <!-- form-group// -->

									<div class="form-group">
										<?php wp_nonce_field('woocommerce-otp', 'woocommerce-otp-nonce'); ?>
										<button type="submit" class="btn btn-primary btn-block" name="otp" value="<?php esc_attr_e('Send', 'mechanic'); ?>"><?php esc_html_e('Send', 'mechanic'); ?></button>
									</div> 
								</form>
							</article>
						</div> <!-- card.// -->
					</div>
					<?php
				}else { ?>
					<!-- Register content  -->
					<div class="container-fluid my-2">
						<div class="card bg-light signup">
							<article class="card-body mx-auto" style="max-width: 400px;">
								<h4 class="card-title mt-3 text-center"> <?php esc_html_e('Create Account', 'mechanic'); ?></h4>
								<p class="text-center"><?php esc_html_e('Get started with your free account', 'mechanic'); ?></p>

								<form method="post" class="mc-wc-register-form">
									<?php do_action('woocommerce_register_form_start'); ?>

									<div class="form-group input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"> <i class="fa fa-user"></i> </span>
										</div>
										<input name="mc_reg_full_name" class="form-control" placeholder="Full name" type="text">
									</div> <!-- form-group// -->

									<div class="form-group input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"> <i class="fa fa-building"></i> </span>
										</div>
										
										<select class="form-control" name="mc_reg_location">
											<option value="0" selected=""> Select Location</option>
											<?php
												$locations = mc_get_service_locations();
												if( $locations ) {
													foreach( $locations as $location ) {
														$location_name = $location['location_name'];
														?>
														<option value="<?php esc_html_e( $location_name, 'mechanic' ); ?>"><?php esc_html_e( $location_name, 'mechanic' ); ?></option>
														<?php
													}
												}
												
											?>
										</select>
									</div> 

									<div class="form-group input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"> <i class="fa fa-phone"></i> </span>
										</div>
										<select class="custom-select" name="mc_reg_mobile_first" style="max-width: 120px;">
											<option value="013">+88013</option>
											<option value="014">+88014</option>
											<option value="015">+88015</option>
											<option value="016">+88016</option>
											<option value="017">+88017</option>
											<option value="018">+88018</option>
											<option value="019">+88019</option>
										</select>
										<input name="mc_reg_mobile_last" maxlength="8" class="form-control" placeholder="Phone number" type="text">
									</div>

									<div class="form-group input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
										</div>
										<input class="form-control" name="mc_reg_password" placeholder="Create password" type="password">
									</div> <!-- form-group// -->

									<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

										<div class="form-group input-group">
											<div class="input-group-prepend">
												<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
											</div>
											<input class="form-control" name="mc_reg_re_password" id="reg_password" placeholder="Repeat password" type="password" autocomplete="new-password">
										</div> <!-- form-group// -->

									<?php else : ?>

										<p><?php esc_html_e('A password will be sent to your email address.', 'woocommerce'); ?></p>

									<?php endif; ?>

									<div class="form-group input-group">
										<input class="" name="mc_reg_agree" type="checkbox"> By clicking register you are agree with our terms and conditions
									</div>

									<?php do_action('woocommerce_register_form'); ?>

									<div class="form-group">
										<?php wp_nonce_field('woocommerce-register-nonce'); ?>
										<button type="submit" class="btn btn-primary btn-block woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
									</div> <!-- form-group// -->
									<?php do_action('woocommerce_register_form_end'); ?>
								</form>
							</article>
						</div> <!-- card.// -->
					</div>
					<?php
				}
			} else { ?>
				<!-- Login content  -->
				<div class="container-fluid my-2">
					<div class="card bg-light signup">
						<article class="card-body mx-auto" style="max-width: 400px;">
							<h4 class="card-title mt-3 text-center">Login</h4>
							<p class="text-center">Get started</p>
							<form class="woocommerce-form woocommerce-form-login login" method="post">
								<?php do_action('woocommerce_login_form_start'); ?>
								
								<div class="form-group input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"> <i class="fa fa-phone"></i> </span>
									</div>
									<input name="mc_login_phone_number" class="form-control" placeholder="phone number" type="text">
								</div> 

								<div class="form-group input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
									</div>
									<input class="woocommerce-Input woocommerce-Input--text input-text form-control" placeholder="password" type="password" name="mc_login_password" id="password" autocomplete="current-password" />
								</div> 

								<?php do_action('woocommerce_login_form'); ?>

								<div class="form-group">
									<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
									<button type="submit" class="btn btn-primary btn-block" name="login" value="<?php esc_attr_e('Login', 'woocommerce'); ?>"><?php esc_html_e('Login', 'woocommerce'); ?></button>
								</div> 

								<p class="text-center">Have an account? <a href="<?php echo home_url('/registration'); ?>">Signup</a> </p>
								<?php do_action('woocommerce_login_form_end'); ?>
							</form>
							
						</article>
					</div> <!-- card.// -->
			<?php
			}
		}
		?>
<?php endif; ?>
<?php do_action('woocommerce_after_customer_login_form'); ?>
<?php do_action( 'mc_login_form_submission' ); ?>