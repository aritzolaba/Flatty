<?php
/*
 * Template Name: Flatty - Frontpage
 *
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<?php // Blog Posts Query
$args = array('paged'=>get_query_var('paged'),'posts_per_page'=>get_query_var('posts_per_page'),'post_type'=> 'post');
query_posts($args);
?>

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-top-jumbotron-narrow')) : ?>
	<?php //_e ('add widgets here', 'flatty'); ?>
<?php endif; ?>

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-row-above-content')) : ?>
	<?php //_e ('add widgets here', 'flatty'); ?>
<?php endif; ?>

<div class="row">

    <div class="main col-sm-8 col-md-9 <?php if ($flatty_theme_options['sidebar_position'] == 'left') echo 'pull-right'; ?>">

        <?php if ($flatty_theme_options['breadcrumb'] == 1) get_template_part('partials/breadcrumb'); ?>

        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-frontpage-above-content')) : ?>
            <?php //_e ('add widgets here', 'flatty'); ?>
        <?php endif; ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('partials/article'); ?>

            <?php endwhile; ?>

            <?php if ($wp_query->max_num_pages>1) : ?>

                <?php flatty_pagination(); ?>

            <?php endif; ?>

        <?php else : ?>

            <?php get_template_part('partials/nothing-found'); ?>

        <?php endif; ?>


        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-frontpage-below-content')) : ?>
            <?php //_e ('add widgets here', 'flatty'); ?>
        <?php endif; ?>
    </div>

    <aside class="col-sm-4 col-md-3 <?php if ($flatty_theme_options['sidebar_position'] == 'left') echo 'pull-left'; ?>">
        <?php if ($flatty_theme_options['sidebar_admin'] == 1) get_template_part('partials/sidebar-admin'); ?>
        <?php
        // Dynamic Sidebar
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-frontpage-aside')) :
            _e ('add widgets here', 'flatty');
        endif;
        ?>
    </aside>

</div><!-- /row -->

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-frontpage-row-below-content')) : ?>
	<?php //_e ('add widgets here', 'flatty'); ?>
<?php endif; ?>

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('ft-widgets-mid-jumbotron-narrow')) : ?>
	<?php //_e ('add widgets here', 'flatty'); ?>
<?php endif; ?>

<?php get_footer(); ?>