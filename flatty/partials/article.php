<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('media well'); ?>>

    <div class="header-container">

        <?php // Article Featured Image
        global $flatty_theme_options;
        if (has_post_thumbnail() && !is_single() && !is_page() && $flatty_theme_options['article_featured_images'] != 'none') : ?>
            <a class="media-object pull-<?php echo $flatty_theme_options['article_featured_images']; ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php echo get_the_post_thumbnail(get_the_ID(), 'thumb', array('class' => 'img-thumbnail')); ?>
            </a>
        <?php endif; ?>

        <header class="media-body">

            <h1 class="media-heading">
                <?php if (is_single() OR is_page()) : ?>
                    <?php the_title(); ?>
                <?php else : ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                <?php endif; ?>
            </h1>

            <?php if (!is_page()) : ?>
                <div class="media-heading text-muted">
                    <?php
                    // Date
                    $output = '<strong><i class="icon-calendar"></i></strong>&nbsp;'.get_the_date('M, d - Y');

                    // Comment number
                    if (comments_open()) :
                        $output .= '&nbsp;&nbsp;<strong><i class="icon-comments"></i></strong>&nbsp;<a href="'.get_permalink().'#comments" title="'.__('Comments','flatty').'">';
                        $ncom=get_comments_number(); if ($ncom==0) $output .= __('no comments', 'flatty'); elseif ($ncom==1) $output .= __('1 comment', 'flatty'); else $output .= sprintf (__('%s comments','flatty'), $ncom);
                        $output .= '</a>';
                    endif;

                    // Categories
                    if (get_the_category()) :
                        $output .= '&nbsp;&nbsp;<strong><i class="icon-folder-open"></i></strong>&nbsp;'.get_the_category_list(',&nbsp;');
                    endif;

                    // Output all
                    echo $output;

                    // Admin only edit link
                    edit_post_link( __('Edit', 'flatty'), '&nbsp;&nbsp;<i class="icon-pencil"></i>&nbsp;<span class="edit-link">', '</span>');
                    ?>
                </div>
            <?php endif; ?>
        </header>

    </div>

    <?php if (has_post_thumbnail() && (is_single() || is_page())) :
        // Get attached file guid
        $att = get_post_meta(get_the_ID(),'_thumbnail_id',true);
        $thumb = get_post($att);
        if (is_object($thumb)) { $att_ID = $thumb->ID; $att_url = $thumb->guid; }
        else { $att_ID = $post->ID; $att_url = $post->guid; }
        $att_title = (!empty(get_post($att_ID)->post_excerpt)) ? get_post($att_ID)->post_excerpt : get_the_title($att_ID);
        ?>
        <div class="clearfix"><br /></div>
        <div class="clearfix text-center">
            <a class="thickbox" href="<?php echo $att_url; ?>" title="<?php echo $att_title; ?>">
                <?php echo get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'img-thumbnail')); ?>
            </a>
        </div><br />
    <?php endif; ?>

    <section>
        <?php // If displaying a single post or a page
        if (is_single() OR is_page()) :

            the_content();

            wp_link_pages(array(
                'next_or_number' => 'number',
                'nextpagelink' => __('Next page', 'flatty'),
                'previouspagelink' => __('Previous page', 'flatty'),
                'pagelink' => '%',
                'link_before' => '<span class="ft-btn">',
                'link_after' => '</span>',
                'before' => '<div class="clearfix"></div><br />' . __('Pages:', 'flatty') . ' <div class="ft-article-pages">',
                'after' => '</div>'
            ));

        else :

            if (has_post_format('audio') OR has_post_format('gallery') OR has_post_format('video'))
                the_content();
            else
                the_excerpt ();

        endif;
        ?>
    </section>

    <div class="clearfix"></div><br />

    <?php if (!is_page() && is_single()) : ?>

        <footer>

            <?php
            // Tags
            if (get_the_tags()) : ?>
                <hr />
                <i class="icon-tags"></i>&nbsp;<?php the_tags('',',&nbsp;'); ?>
            <?php endif; ?>

        </footer>

    <?php endif; ?>

</article>