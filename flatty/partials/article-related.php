<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>

    <div class="well well-sm article-related">
        <h3 class="widgettitle"><i class="icon-link"></i> <?php _e('Related articles','flatty'); ?></h3>
        <div class="row">
            <div class="col-xs-6 text-center">
                <h3><?php next_post_link('%link', '%title', 1); ?></h3>
            </div>
            <div class="col-xs-6 text-center">
                <h3><?php previous_post_link('%link', '%title', 1); ?></h3>
            </div>
        </div>
    </div>

<?php endif; ?>