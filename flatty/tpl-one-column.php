<?php
/*
 * Template Name: Flatty - One column
 *
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<?php if ($flatty_theme_options['breadcrumb'] == 1) get_template_part('partials/breadcrumb'); ?>

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

<?php get_footer(); ?>