<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<?php if (get_next_post_link('&laquo; %link', '%title', 1) OR get_previous_post_link('%link &raquo;', '%title', 1)) : ?>

    <div class="well article-related">
        <h3><?php _e('Related articles','flatty'); ?></h3><br />
        <div class="row">
            <div class="col-sm-6 text-center">
                <h3><?php next_post_link('%link', '<i class="icon-caret-left"></i> %title', 1); ?></h3>
            </div>
            <div class="col-sm-6 text-center">
                <h3><?php previous_post_link('%link', '%title <i class="icon-caret-right"></i>', 1); ?></h3>
            </div>
        </div>
    </div>

<?php endif; ?>