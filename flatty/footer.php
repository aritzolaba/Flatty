<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

        </div><!-- .container (initiated at header -->

        <footer>
            <div class="container">
                <div class="row">

                    <div class="col-sm-4">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-footer-block-1')) : ?>

                            <?php //_e ('add widgets here', 'flatty'); ?>

                        <?php endif; ?>

                        <?php global $flatty_theme_options;  if ($flatty_theme_options['footer_social'] == 1) get_template_part('partials/social-block'); ?>
                    </div>

                    <div class="col-sm-4">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-footer-block-2')) : ?>

                            <?php //_e ('add widgets here', 'flatty'); ?>

                        <?php endif; ?>
                    </div>

                    <div class="col-sm-4">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-footer-block-3')) : ?>

                            <?php //_e ('add widgets here', 'flatty'); ?>

                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </footer>

        <?php wp_footer(); ?>

        <!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/libs/respond.min.js"></script>
	<![endif]-->

    </body>
</html>