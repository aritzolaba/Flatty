<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<div class="row">

    <div class="col-md-9">

        <?php get_template_part('partials/breadcrumb'); ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('partials/article'); ?>

                <?php get_template_part('partials/article-author'); ?>

                <?php get_template_part('partials/article-related'); ?>

                <?php comments_template( '', true ); ?>

            <?php endwhile; ?>

        <?php else : ?>

            <?php get_template_part('partials/nothing-found'); ?>

        <?php endif; ?>

    </div>

    <aside class="col-md-3 pull-left">
        <?php get_sidebar(); ?>
    </aside>

</div><!-- .row -->

<?php get_footer(); ?>