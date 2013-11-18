<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>

    <h3><?php _e('Related articles','flatty'); ?></h3>

    <div class="well well-sm article-related">
        <div class="row">
            <div class="col-sm-6">
                <h4><?php next_post_link('&laquo; %link', '%title', 1); ?></h4>
            </div>
            <div class="col-sm-6 text-right">
                <h4><?php previous_post_link('%link &raquo;', '%title', 1); ?></h4>
            </div>
        </div>
    </div>

<?php endif; ?>