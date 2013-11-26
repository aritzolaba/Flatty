<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<div class="row">

    <div class="col-md-9 <?php if ($flatty_theme_options['sidebar_position'] == 'left') echo 'pull-right'; ?>">

        <?php if ($flatty_theme_options['breadcrumb'] == 1) get_template_part('partials/breadcrumb'); ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('partials/article'); ?>

            <?php endwhile; ?>

            <?php // Display navigation to next/previous pages when applicable
            if ( $wp_query->max_num_pages > 1 ) :

                $next_posts_link = str_replace('<a', '<a class="btn btn-lg btn-primary pull-left"',get_next_posts_link(__('<i class="icon-circle-arrow-left"></i> OLDER POSTS', 'flatty')));
                $prev_posts_link = str_replace('<a', '<a class="btn btn-lg btn-primary pull-right"',get_previous_posts_link(__('NEWER POSTS <i class="icon-circle-arrow-right"></i>', 'flatty')));

                echo '<div class="clearfix"></div><br />';
                echo $next_posts_link.$prev_posts_link;
                echo '<div class="clearfix"></div><br />';

            endif; ?>

        <?php else : ?>

            <?php get_template_part('partials/nothing-found'); ?>

        <?php endif; ?>

    </div>

    <aside class="col-md-3 <?php if ($flatty_theme_options['sidebar_position'] == 'left') echo 'pull-left'; ?>">
        <?php if ($flatty_theme_options['sidebar_admin'] == 1) get_template_part('partials/sidebar-admin'); ?>
        <?php get_sidebar(); ?>
    </aside>

</div>

<?php get_footer(); ?>