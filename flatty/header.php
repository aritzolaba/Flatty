<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="author" content="<?php bloginfo('name'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title('-', true, 'right'); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
// Enqueue comment-reply script if comments_open and singular
if (is_singular() && comments_open()) wp_enqueue_script('comment-reply');
// WordPress Head
wp_head();
?>
</head>

<body id="flatty" <?php body_class(); ?>>

<?php // Navbar
get_template_part('partials/navbar');
?>

<div class="container">