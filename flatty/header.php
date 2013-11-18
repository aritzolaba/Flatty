<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="description" content="<?php bloginfo('description'); ?>">
<meta name="author" content="<?php bloginfo('name'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php global $page, $paged;
// Print title
wp_title('-', true, 'right');
// Add the blog name.
bloginfo('name');
// Add the blog description for the home/front page.
$site_description = get_bloginfo('description', 'display');
if ($site_description && (is_home() || is_front_page())) echo ' - '.$site_description;
// Add a page number if necessary:
if ($paged >= 2 || $page >= 2) echo ' - ' . sprintf(__('Page %s', 'flatty'), max($paged, $page));
?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
// Enqueue comment-reply script if comments_open and singular
if (is_singular() && comments_open()) wp_enqueue_script('comment-reply');

// WordPress Head
wp_head();

// Load respond.min.js if browser version is < IE9
echo '
<!--[if lt IE 9]>
<script src="'. get_stylesheet_directory_uri() .'/assets/libs/respond.min.js"></script>
<![endif]-->
';
?>
</head>

<body id="flatty" <?php body_class(); ?>>
<?php // Navbar
get_template_part('partials/navbar');
?>

<div class="container">