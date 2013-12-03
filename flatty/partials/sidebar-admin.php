<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<div class="sidebar-admin well">
    <div class="sidebar-admin-avatar pull-left">
        <?php echo str_replace('avatar-40', 'avatar-40 img-thumbnail img-circle', get_avatar(get_bloginfo('admin_email'), 40)); ?>
    </div>
    <p class="lead">
        <?php $user = get_user_by('email', get_bloginfo('admin_email')); echo $user->display_name; ?>
    </p>
    <?php echo get_user_meta($user->ID, 'description', TRUE); ?>

    <?php get_template_part('social-block'); ?>
    
</div>