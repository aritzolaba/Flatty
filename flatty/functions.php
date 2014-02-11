<?php
/**
 * Flatty functions file.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

// Get Theme Options
global $flatty_theme_options;
$flatty_theme_options = get_option('flatty_theme_options');

/*********************************************************************
* THEME SETUP
*/
function flatty_setup() {

    // Translations support. Find language files in flatty/languages
    load_theme_textdomain('flatty', get_template_directory().'/languages');
    $locale = get_locale();
    $locale_file = get_template_directory()."/languages/{$locale}.php";
    if(is_readable($locale_file)) { require_once($locale_file); }

    // Set content width
    if (!isset($content_width)) $content_width = 720;

    // Editor style (editor-style.css)
    add_editor_style(array('assets/css/editor-style.css'));

    // Load up our theme options page and related code.
    require(get_template_directory() . '/inc/theme-options.php');

    // Widget areas
    if (function_exists('register_sidebar')) :
        // Sidebar right
        register_sidebar(array(
            'name' => "Sidebar right",
            'id' => "ft-widgets-aside-right",
            'description' => __('Widgets placed here will display in the right sidebar', 'flatty'),
            'before_widget' => '<div id="%1$s" class="well well-sm widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 1
        register_sidebar(array(
            'name' => "Footer Block 1",
            'id' => "ft-widgets-footer-block-1",
            'description' => __('Widgets placed here will display in the first footer block', 'flatty'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 2
        register_sidebar(array(
            'name' => "Footer Block 2",
            'id' => "ft-widgets-footer-block-2",
            'description' => __('Widgets placed here will display in the second footer block', 'flatty'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 3
        register_sidebar(array(
            'name' => "Footer Block 3",
            'id' => "ft-widgets-footer-block-3",
            'description' => __('Widgets placed here will display in the third footer block', 'flatty'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
    endif;

    // Nav Menu (Custom menu support)
    if (function_exists('register_nav_menu')) :
        register_nav_menu('primary', __('Flatty Primary Menu', 'flatty'));
    endif;

    // Theme Features: Automatic Feed Links
    add_theme_support('automatic-feed-links');

    // Theme Features: Post Thumbnails and custom image sizes for post-thumbnails
    add_theme_support('post-thumbnails', array('post', 'page'));

    // Theme Features: Post Formats
    add_theme_support('post-formats', array('aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio'));

    // Theme Features: Custom Background
    $custom_background_args = array(
        'default-color' => 'f5f5f5',
    );
    add_theme_support('custom-background', $custom_background_args);
}
add_action('after_setup_theme', 'flatty_setup');

// The excerpt "more" button
function flatty_excerpt($text) {
    return str_replace('[&hellip;]', '[&hellip;]<div class="clearfix"></div><br /><a class="btn btn-sm btn-info" title="'. sprintf (__('Read more on %s','flatty'), get_the_title()).'" href="'.get_permalink().'">' . __('Continue Reading','flatty') . '</a>', $text);
}
add_filter('the_excerpt', 'flatty_excerpt');

// wp_title filter
function flatty_title($output) {
    echo $output;
    // Add the blog name
    bloginfo('name');
    // Add the blog description for the home/front page
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) echo ' - '.$site_description;
    // Add a page number if necessary
    if (!empty($paged) && ($paged >= 2 || $page >= 2)) echo ' - ' . sprintf(__('Page %s', 'olabaworks'), max($paged, $page));
}
add_filter('wp_title', 'flatty_title');

/*********************************************************************
 * Function to load all theme assets (scripts and styles) in header
 */
function flatty_load_theme_assets() {

    global $flatty_theme_options;

    // HTML5shiv
    // Do not know any method to enqueue a script with conditional tags!
    echo '
    <!--[if lt IE 9]>
      <script src="'. get_template_directory_uri() .'/assets/libs/html5shiv.min.js"></script>
    <![endif]-->
    ';

    // Enqueue Font Awesome CSS
    wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/libs/font-awesome/css/font-awesome.min.css');
    wp_enqueue_style('font-awesome-ie7', get_template_directory_uri().'/assets/libs/font-awesome/css/font-awesome-ie7.min.css');
    wp_style_add_data('font-awesome-ie7', 'conditional', 'lt IE 9');

    // Enqueue Bootstrap
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/libs/bootstrap/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/assets/libs/bootstrap/js/bootstrap.min.js', array(), FALSE, TRUE);

    // Enqueue Main CSS (style.css)
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri().'/style.css');

    // Enqueue Flatty CSS and JS
    wp_enqueue_style('flatty-css', get_stylesheet_directory_uri().'/assets/css/flatty.css');
    wp_enqueue_script('flatty-js', get_template_directory_uri().'/assets/js/flatty.js', array(), FALSE, TRUE);

    // Enqueue CSS Style for colors
    if (!empty($flatty_theme_options['css_style']) && $flatty_theme_options['css_style'] != 'blue') :
        wp_enqueue_style('flatty-style-css', get_stylesheet_directory_uri().'/assets/css/styles/'.$flatty_theme_options['css_style'].'.css');
    endif;

    // Enqueue Wordpress Thickbox
    wp_enqueue_script('thickbox', FALSE, array(), FALSE, TRUE);
    wp_enqueue_style('thickbox');

    // Enqueue Retina.js
    wp_enqueue_script('retina-js', get_template_directory_uri() . '/assets/libs/retina.min.js', array(), FALSE, TRUE);
}
add_action('wp_enqueue_scripts', 'flatty_load_theme_assets');

/*********************************************************************
 * RETINA SUPPORT
 */
add_filter('wp_generate_attachment_metadata', 'flatty_retina_support_attachment_meta', 10, 2);
function flatty_retina_support_attachment_meta($metadata, $attachment_id) {

    // Create first image @2
    flatty_retina_support_create_images(get_attached_file($attachment_id), 0, 0, false);

    foreach ($metadata as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $image => $attr) {
                if (is_array($attr))
                    flatty_retina_support_create_images(get_attached_file($attachment_id), $attr['width'], $attr['height'], true);
            }
        }
    }

    return $metadata;
}

function flatty_retina_support_create_images($file, $width, $height, $crop = false) {

    $resized_file = wp_get_image_editor($file);
    if (!is_wp_error($resized_file)) {

        if ($width || $height) {
            $filename = $resized_file->generate_filename($width . 'x' . $height . '@2x');
            $resized_file->resize($width * 2, $height * 2, $crop);
        } else {
            $filename = str_replace('-@2x','@2x',$resized_file->generate_filename('@2x'));
        }
        $resized_file->save($filename);

        $info = $resized_file->get_size();

        return array(
            'file' => wp_basename($filename),
            'width' => $info['width'],
            'height' => $info['height'],
        );
    }

    return false;
}

add_filter('delete_attachment', 'flatty_delete_retina_support_images');
function flatty_delete_retina_support_images($attachment_id) {
    $meta = wp_get_attachment_metadata($attachment_id);
    $upload_dir = wp_upload_dir();
    $path = pathinfo($meta['file']);

    // First image (without width-height specified
    $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . wp_basename($meta['file']);
    $retina_filename = substr_replace($original_filename, '@2x.', strrpos($original_filename, '.'), strlen('.'));
    if (file_exists($retina_filename)) unlink($retina_filename);

    foreach ($meta as $key => $value) {
        if ('sizes' === $key) {
            foreach ($value as $sizes => $size) {
                $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
                $retina_filename = substr_replace($original_filename, '@2x.', strrpos($original_filename, '.'), strlen('.'));
                if (file_exists($retina_filename))
                    unlink($retina_filename);
            }
        }
    }
}

/* GALLERY SHORTCODE FILTER FOR CAROUSEL

Usage: [ft_carousel include="123,456,789"]content[/ft_carousel]
(*) 123,456,789 are the Media attachments IDs you want to be displayed

*/
add_shortcode('ft_carousel','ft_shortcode_carousel');
function ft_shortcode_carousel ($attr, $content) {

    global $post;

    // Little fix as the order of arguments is not the same when
    // in "gallery" post formats
    if (!empty($content) && is_array($content)) {
        $attr = $content;
        if (!empty($attr[0])) $content = $attr[0];
        else $content = '';
    }

    $output = $content;

    // OrderBy
    $orderby = 'menu_order';
    if (!empty($attr['orderby']))
        $orderby = sanitize_sql_orderby ($attr['orderby']);

    // If we got an include attr
    if (!empty($attr['include']))
        $images = get_posts(array('include' => $attr['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => $orderby));

    // If we do not have images yet...
    if (empty($images)) :
        // Get Post Images
        $images = get_children(array(
            'post_parent' => $post->ID,
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'numberposts' => 100,
            'orderby' => $orderby,
            'order' => 'DESC'
        ));
    endif;

    // If images are found, proceed
    if (!empty($images)) :

        $indicators = '';
        $items = '';

        $i=0; foreach ($images as $image) :

            $act = ($i==0) ? 'active' : '';

            $indicators .= '
                <li data-target="#slideshow-'.$post->ID.'" data-slide-to="'.$i.'" class="'.$act.'"></li>
            ';

            $items .= '
            <div class="item '.$act.'">
                <a rel="attached-to-slider-'.$post->ID.'" class="thickbox" href="'.$image->guid.'" title="'. get_the_title($image->ID).'">
                    <img src="'. $image->guid.'" alt="'.get_the_title($image->ID).'"/>
                </a>
                <div class="carousel-caption">
                    <h4>'. get_the_title($image->ID).'</h4>
                    <br />
                </div>
            </div>
            ';

        $i++; endforeach;

        // BEGIN OUTPUT

        // Clearfix
        $output .= '<div class="clearfix"></div>';

        $output .= '<div id="slideshow-'.$post->ID.'" class="carousel slide" data-ride="carousel">';

            // INDICATORS
            $output .= '<ol class="carousel-indicators">'. $indicators .'</ol>';

            // ITEMS
            $output .= '<div class="carousel-inner">' .$items. '</div>';

        $output .= '</div>';

        // Clearfix
        $output .= '<div class="clearfix"></div><br />';

        // END OUTPUT

        return $output;

    endif;

    // Return nothing
    return;
}

/* To automatically execute carousel shortcode when post type is "gallery" */
add_action('post_gallery', 'ft_shortcode_carousel', 10, 2);

// Flatty Pagination
// Code taken from: http://wp-snippets.com/pagination-for-twitter-bootstrap/
function flatty_pagination ($before = '', $after = '') {

    global $flatty_theme_options;

    echo $before;

    if ($flatty_theme_options['pagination_type'] == 'buttons') :

        $next_posts_link = str_replace('<a', '<a class="btn btn-lg btn-primary pull-left"',get_next_posts_link(__('<i class="icon-circle-arrow-left"></i> OLDER POSTS', 'flatty')));
        $prev_posts_link = str_replace('<a', '<a class="btn btn-lg btn-primary pull-right"',get_previous_posts_link(__('NEWER POSTS <i class="icon-circle-arrow-right"></i>', 'flatty')));

        echo '<div class="clearfix"></div><br />';
        echo $next_posts_link.$prev_posts_link;
        echo '<div class="clearfix"></div><br />';

    else :

        global $wpdb, $wp_query;

        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;

        if ($numposts <= $posts_per_page) return;
        if (empty($paged) || $paged == 0) $paged = 1;

        $pages_to_show = 7;
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1 / 2);
        $half_page_end = ceil($pages_to_show_minus_1 / 2);
        $start_page = $paged - $half_page_start;

        if ($start_page <= 0) $start_page = 1;
        $end_page = $paged + $half_page_end;
        if (($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if ($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if ($start_page <= 0) $start_page = 1;

        echo '<div class="clearfix"></div><br />';
        echo '<div class="btn-toolbar text-center" role="toolbar">';

        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $paged)
                echo '<button class="active btn btn-info" type="button">' . $i . '</button>';
            else
                echo '<a class="btn btn-default" href="' . get_pagenum_link($i) . '">' . $i . '</a>';
        }

        echo '</div>';

    endif;

    echo $after;

    return;
}
