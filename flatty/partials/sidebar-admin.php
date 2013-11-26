<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<div class="sidebar-admin well well-sm">
    <div class="sidebar-admin-avatar pull-left">
        <?php echo str_replace('avatar-50', 'avatar-50 img-thumbnail img-circle', get_avatar(get_bloginfo('admin_email'), 50)); ?>
    </div>
    <p class="lead">
        <?php $user = get_user_by('email', get_bloginfo('admin_email')); echo $user->display_name; ?>
    </p>
    <?php echo get_user_meta($user->ID, 'description', TRUE); ?>    
</div>
