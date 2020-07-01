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

	<div class="u-columns col2-set mc-woocommerce-login-wrapper" id="customer_login">

		<div class="u-column1 col-5">

		<?php endif; ?>

		<h2><?php esc_html_e('Login', 'woocommerce'); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action('woocommerce_login_form_start'); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
																																																															?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action('woocommerce_login_form'); ?>

			<p class="form-row">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
				</label>
				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
				<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
			</p>

			<?php do_action('woocommerce_login_form_end'); ?>

		</form>

		<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

		</div>

		<div class="u-column2 col-5">


			<div class="container-fluid my-2">
				<div class="card bg-light signup">
					<article class="card-body mx-auto" style="max-width: 400px;">
						<h4 class="card-title mt-3 text-center">
							<h2><?php esc_html_e('Create Account', 'mechanic'); ?></h2>
						</h4>
						<p class="text-center"><?php esc_html_e('Get started with your free account', 'mechanic'); ?></p>

						<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>
							<?php do_action('woocommerce_register_form_start'); ?>

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

							<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

								<div class="form-group input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
									</div>
									<input class="form-control" name="password" id="reg_password" placeholder="Repeat password" type="password" autocomplete="new-password">
								</div> <!-- form-group// -->

							<?php else : ?>

								<p><?php esc_html_e('A password will be sent to your email address.', 'woocommerce'); ?></p>

							<?php endif; ?>

							<div class="form-group input-group">
								<input class="" name="mc_reg_agree" type="checkbox"> By clicking register you are agree with our terms and conditions
							</div>

							<?php do_action('woocommerce_register_form'); ?>

							<div class="form-group">
								<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
								<button type="submit" class="btn btn-primary btn-block woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
							</div> <!-- form-group// -->
							<?php do_action('woocommerce_register_form_end'); ?>
						</form>
					</article>
				</div> <!-- card.// -->
			</div>
			<!--container end.//-->




		</div>

	</div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>