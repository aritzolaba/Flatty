<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

// Get Admin User
$user = get_user_by('email', get_bloginfo('admin_email'));
if (is_object($user)) : ?>

    <div class="sidebar-admin well">
        <div class="sidebar-admin-avatar pull-left">
            <?php echo str_replace('avatar-40', 'avatar-40 img-thumbnail img-circle', get_avatar($user->user_email, 40)); ?>
        </div>
        <p class="lead">
            <?php echo $user->display_name; ?>
        </p>
        <?php echo get_user_meta($user->ID, 'description', TRUE); ?>

        <?php get_template_part('partials/social-block'); ?>
    </div>

<?php endif; ?>