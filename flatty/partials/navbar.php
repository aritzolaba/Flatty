<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only"><?php _e('Toggle Navigation', 'flatty'); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php global $flatty_theme_options; if ($flatty_theme_options['display_blog_title'] == 1) : ?>
            <a class="navbar-brand" href="<?php echo site_url(); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <?php echo esc_attr(get_bloginfo('name')); ?>
            </a>
        <?php endif; ?>
        <?php $site_description = esc_attr(get_bloginfo('description')); if (!empty($site_description)) : ?>
            <div class="navbar-text"><?php echo $site_description; ?></div>
        <?php endif; ?>
        <?php
        // Wordpress wp_nav_menu
        $args = array(
            'theme_location' => 'primary',
            'items_wrap' => '<div class="collapse navbar-collapse"><ul class="nav navbar-nav">%3$s</ul></div>'
        );
        wp_nav_menu($args);
        ?>
    </div>
</nav>