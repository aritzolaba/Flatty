<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<p class="sidebar-admin-social">
    <?php global $flatty_theme_options; ?>

    <?php if (!empty($flatty_theme_options['social_facebook'])) : ?>
        <a href="<?php echo $flatty_theme_options['social_facebook']; ?>" target="_blank" class="social-icon"><i class="icon-facebook-sign"></i></a>
    <?php endif; ?>

    <?php if (!empty($flatty_theme_options['social_googleplus'])) : ?>
        <a href="<?php echo $flatty_theme_options['social_googleplus']; ?>" target="_blank" class="social-icon"><i class="icon-google-plus-sign"></i></a>
    <?php endif; ?>

    <?php if (!empty($flatty_theme_options['social_github'])) : ?>
        <a href="<?php echo $flatty_theme_options['social_github']; ?>" target="_blank" class="social-icon"><i class="icon-github-sign"></i></a>
    <?php endif; ?>

    <?php if (!empty($flatty_theme_options['social_linkedin'])) : ?>
        <a href="<?php echo $flatty_theme_options['social_linkedin']; ?>" target="_blank" class="social-icon"><i class="icon-linkedin-sign"></i></a>
    <?php endif; ?>

    <?php if (!empty($flatty_theme_options['social_twitter'])) : ?>
        <a href="<?php echo $flatty_theme_options['social_twitter']; ?>" target="_blank" class="social-icon"><i class="icon-twitter-sign"></i></a>
    <?php endif; ?>
</p>