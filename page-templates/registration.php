<?php
/**
 * Template Name: Registration
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<!--  content  -->
<div class="container-fluid my-2">
    <div class="card bg-light signup">
        <article class="card-body mx-auto" style="max-width: 400px;">
            <h4 class="card-title mt-3 text-center">Create Account</h4>
            <p class="text-center">Get started with your free account</p>
            <form method="post" action="">
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
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input class="form-control" name="mc_reg_rep_password" placeholder="Repeat password" type="password">
                </div> <!-- form-group// -->
                <div class="form-group input-group">
                    <input class="" name="mc_reg_agree" type="checkbox"> By clicking register you are agree with our terms and conditions
                </div>
                <div class="form-group">
                    <button type="submit" name="mc_register" class="btn btn-primary btn-block"> Register </button>
                </div> <!-- form-group// -->
                <p class="text-center">Have an account? <a href="../signin.html">Log In</a> </p>
            </form>
        </article>
    </div> <!-- card.// -->
</div> <!--container end.//-->
<!--  content  -->

<?php get_footer(); ?>