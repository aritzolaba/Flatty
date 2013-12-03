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

        <?php global $flatty_theme_options; if (!empty($flatty_theme_options['google_analytics_account'])) : ?>
            <!-- Google Analytics -->
            <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
            </script>
            <script type="text/javascript">
            try{
            var pageTracker = _gat._getTracker("<?php echo $flatty_theme_options['google_analytics_account']; ?>");
            pageTracker._trackPageview();
            } catch(err) {console.log('%o', err);}
            </script>
            <!-- END Google Analytics -->
        <?php endif; ?>
    </body>
</html>