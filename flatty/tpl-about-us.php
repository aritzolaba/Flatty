<?php
/*
 * Template Name: Flatty - About us
 *
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-top-jumbotron-narrow')) : ?>
	<?php //_e ('add widgets here', 'flatty'); ?>
<?php endif; ?>

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-about-row-above-content')) : ?>
	<?php //_e ('add widgets here', 'flatty'); ?>
<?php endif; ?>

<div class="row">

    <div class="main col-sm-8 col-md-9 <?php if ($flatty_theme_options['sidebar_position'] == 'left') echo 'pull-right'; ?>">

        <?php if ($flatty_theme_options['breadcrumb'] == 1) get_template_part('partials/breadcrumb'); ?>

        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-about-above-content')) : ?>
            <?php //_e ('add widgets here', 'flatty'); ?>
        <?php endif; ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('partials/article'); ?>

                <?php if ($flatty_theme_options['article_author'] == 1) get_template_part('partials/article-author'); ?>

                <?php if ($flatty_theme_options['article_related'] == 1) get_template_part('partials/article-related'); ?>

                <?php comments_template( '', true ); ?>

            <?php endwhile; ?>

        <?php else : ?>

            <?php get_template_part('partials/nothing-found'); ?>

        <?php endif; ?>


        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-about-below-content')) : ?>
            <?php //_e ('add widgets here', 'flatty'); ?>
        <?php endif; ?>
    </div>

    <aside class="col-sm-4 col-md-3 <?php if ($flatty_theme_options['sidebar_position'] == 'left') echo 'pull-left'; ?>">
        <?php if ($flatty_theme_options['sidebar_admin'] == 1) get_template_part('partials/sidebar-admin'); ?>
        <?php
        // Dynamic Sidebar
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-about-aside')) :
            _e ('add widgets here', 'flatty');
        endif;
        ?>
    </aside>

</div><!-- /row -->

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-about-row-below-content')) : ?>
	<?php //_e ('add widgets here', 'flatty'); ?>
<?php endif; ?>

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-mid-jumbotron-narrow')) : ?>
	<?php //_e ('add widgets here', 'flatty'); ?>
<?php endif; ?>

<?php get_footer(); ?>