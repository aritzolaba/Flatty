<?php
/*
 * Template Name: Flatty - One column Empty
 *
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>

        <article class="well">
            <section>
                <?php the_content(); ?>
            </section>
        </article>

        <?php comments_template( '', true ); ?>

    <?php endwhile; ?>

<?php else : ?>

    <?php get_template_part('partials/nothing-found'); ?>

<?php endif; ?>

<?php get_footer(); ?>