
    <!-- footer   -->
    <footer class="new_footer_area bg_color">
        <?php get_template_part('template-parts/social', 'menu'); ?>
        <div class="new_footer_top">
            <div class="container">
                <div class="row">

                    <?php if ( is_active_sidebar( 'footer-widget' ) ) { ?>
						<?php dynamic_sidebar( 'footer-widget' ); ?>
					<?php }; ?>

                    <div class="col-lg-3 col-md-6">
                        <div class="f_widget company_widget">
                            <h3 class="f-title f_600 t_color f_size_18">Get in Touch</h3>
                            <p>Don’t miss any offers of our upcoming services and events.!</p>
                            <?php
                                echo do_shortcode('[gravityform id="5"]');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bg">
                <div class="footer_bg_one"></div>
                <div class="footer_bg_two"></div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-7">
                        <p class="mb-0 f_400">© Mechanic Chai</p>
                    </div>
                    <div class="col-lg-6 col-sm-5 text-right">
                        <p> 2020 All rights reserved. <i class="icon_heart"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer   -->

    <!--All Contents here-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
        window.ga = function() {
            ga.q.push(arguments)
        };
        ga.q = [];
        ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto');
        ga('set', 'transport', 'beacon');
        ga('send', 'pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async></script>

    <?php wp_footer(); ?>
</body>

</html>
