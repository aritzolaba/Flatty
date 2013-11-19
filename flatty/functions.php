<?php
/**
 * Flatty functions file.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

/*********************************************************************
* THEME SETUP
*/
function ft_setup() {

    // Translations support. Find language files in flatty/languages
    load_theme_textdomain('flatty', get_template_directory().'/languages');
    $locale = get_locale();
    $locale_file = get_template_directory()."/languages/{$locale}.php";
    if(is_readable($locale_file)) { require_once($locale_file); }

    // Set content width
    if (!isset($content_width)) $content_width = 720;

    // Editor style (editor-style.css)
    add_editor_style(array('assets/css/editor-style.css'));

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

    // Theme Features: Custom Background
    $custom_background_args = array(
        'default-color' => 'f5f5f5',
    );
    add_theme_support('custom-background', $custom_background_args);

    // Theme Features: Post Thumbnails and custom image sizes for post-thumbnails
    add_theme_support('post-thumbnails', array('post', 'page'));
    if (function_exists('add_image_size')) {
        add_image_size('post-thumbnail', 720, 400, true);
        add_image_size('loop-thumbnail', 120, 120, true);
    }

    // Theme Features: Post Formats
    add_theme_support('post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio'));
}
add_action('after_setup_theme', 'ft_setup');

// The excerpt "more" button
function custom_excerpt($text) {
    return str_replace('[&hellip;]', '[&hellip;]<div class="clearfix"></div><br /><a class="btn btn-sm btn-info" title="'. sprintf (__('Read more on %s','flatty'), get_the_title()).'" href="'.get_permalink().'">' . __('Continue Reading','flatty') . '</a>', $text);
}
add_filter('the_excerpt', 'custom_excerpt');

/*********************************************************************
 * Function to load all theme assets (scripts and styles) in header
 */
function load_theme_assets() {

    // HTML5shiv
    // Do not know any method to enqueue a script with conditional tags!
    echo '
    <!--[if lt IE 9]>
      <script src="'. get_template_directory_uri() .'/assets/libs/html5shiv.js"></script>
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
    wp_enqueue_style('theme-style', get_template_directory_uri().'/style.css');

    // Enqueue Flatty CSS and JS
    wp_enqueue_style('flatty-css', get_template_directory_uri().'/assets/css/flatty.css');
    wp_enqueue_script('flatty-js', get_template_directory_uri().'/assets/js/flatty.js', array(), FALSE, TRUE);

    // Enqueue Wordpress Thickbox
    wp_enqueue_script('thickbox', FALSE, array(), FALSE, TRUE);
    wp_enqueue_style('thickbox');

    // Enqueue Retina.js
    wp_enqueue_script('retina-js', get_template_directory_uri() . '/assets/libs/retina.js', array(), FALSE, TRUE);
}
add_action( 'wp_enqueue_scripts', 'load_theme_assets' );

/*********************************************************************
 * RETINA SUPPORT
 */
add_filter( 'wp_generate_attachment_metadata', 'retina_support_attachment_meta', 10, 2 );
function retina_support_attachment_meta($metadata, $attachment_id) {
    foreach ($metadata as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $image => $attr) {
                if (is_array($attr))
                    retina_support_create_images(get_attached_file($attachment_id), $attr['width'], $attr['height'], true);
            }
        }
    }

    return $metadata;
}

function retina_support_create_images($file, $width, $height, $crop = false) {
    if ($width || $height) {
        $resized_file = wp_get_image_editor($file);
        if (!is_wp_error($resized_file)) {
            $filename = $resized_file->generate_filename($width . 'x' . $height . '@2x');

            $resized_file->resize($width * 2, $height * 2, $crop);
            $resized_file->save($filename);

            $info = $resized_file->get_size();

            return array(
                'file' => wp_basename($filename),
                'width' => $info['width'],
                'height' => $info['height'],
            );
        }
    }
    return false;
}

add_filter( 'delete_attachment', 'delete_retina_support_images' );
function delete_retina_support_images($attachment_id) {
    $meta = wp_get_attachment_metadata($attachment_id);
    $upload_dir = wp_upload_dir();
    $path = pathinfo($meta['file']);
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

// GALLERY SHORTCODE FILTER FOR CAROUSEL
/* To automatically execute carousel shortcode when post type is "gallery" */
add_shortcode('ol_carousel','ol_shortcode_carousel');
add_action('post_gallery', 'ol_shortcode_carousel', 10, 2);
function ol_shortcode_carousel ($output, $attr) {
    global $post;

    // OrderBy
    $orderby = 'menu_order';
    if (isset($attr['orderby']) && !empty($attr['orderby']))
        $orderby = sanitize_sql_orderby ($attr['orderby']);

    // If we got an include attr
    if (isset($attr['include']))
        $images = get_posts( array('include' => $attr['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => $orderby) );

    // If we do not have images yet...
    if (!isset($images) OR empty($images)) :
        // Get Post Images
        $images = get_children( array(
            'post_parent' => $post->ID,
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'numberposts' => 100,
            'orderby' => $orderby,
            'order' => 'DESC'
        ));
    endif;

    // If images are found, proceed
    if ( $images ) :

        $output = '<div class="clearfix"></div>';

        $output .= '
            <div id="slideshow" class="carousel slide">
                <div class="carousel-inner">';

                $i=0;
                foreach ($images as $image) :
                    $i++;
                    $act = '';
                    if ($i==1) $act = 'active';

                    $output .= '<div class="item '.$act.'" style="text-align: center;">
                        <a rel="attached-to-'.$image->post_parent.'" class="thickbox" href="'.$image->guid.'" title="'. get_the_title($image->ID).'">
                            <img style="width: 100%; margin: auto;" src="'. $image->guid.'" alt="'.get_the_title($image->ID).'"/>
                        </a>
                        <div class="carousel-caption">
                            <h4>'. get_the_title($image->ID).'</h4>
                            <br />
                        </div>
                    </div>';

                endforeach;

                $output .= '</div>';
                $output .= '
                <a class="left carousel-control" href="#slideshow" data-slide="prev">
                <span class="icon-prev"></span>
                </a>
                <a class="right carousel-control" href="#slideshow" data-slide="next">
                <span class="icon-next"></span>
                </a>
                ';
        $output .= '</div>';

        $output .= '<div class="clearfix"></div>';

        return $output;

    endif;

    // Return nothing
    return;
}