<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<div class="article-author alert alert-info">
    <div class="article-author-avatar pull-left">
        <?php echo str_replace('avatar-60', 'avatar-60 img-thumbnail img-circle', get_avatar(get_the_author_meta('email'), 60)); ?>
    </div>
    <p class="lead">
        <?php the_author(); ?>
    </p>
    <p>
        <?php the_author_meta('description'); ?>
    </p>
</div>