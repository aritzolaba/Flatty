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

    </body>
</html>