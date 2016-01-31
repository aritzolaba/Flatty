<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<?php if (comments_open()) : ?>

    <section id="comments" class="well well-sm">

        <?php if ( post_password_required() ) : ?>
            <p class="nopassword">
                <?php _e( 'This post is password protected. Enter the password to view any comments.', 'flatty' ); ?>
            </p>
        <?php return; endif; ?>

        <?php
        $ncom = get_comments_number();
        if ($ncom>0) :

            echo '<h3 class="widgettitle"><i class="icon-comments"></i>&nbsp;';
            _e('Comments','flatty');
            echo '&nbsp;<em class="text-muted">';
            if ($ncom==1) _e('1 comment', 'flatty'); else echo sprintf (__('%s comments','flatty'), $ncom);
            echo '</em></h3>';

            if ($ncom >= get_option('comments_per_page') && get_option('page_comments')) : ?>
                <nav id="comment-nav-above">
                    <?php paginate_comments_links(); ?>
                </nav>
            <?php endif; ?>

            <div class="commentlist">
                <?php
                // Comment List
                $args = array (
                    'paged' => true,
                );
                wp_list_comments();
                ?>
            </div>

            <?php if ($ncom >= get_option('comments_per_page') && get_option( 'page_comments' ) ) : ?>
                <nav id="comment-nav-below">
                    <?php paginate_comments_links(); ?>
                </nav>
            <?php endif; ?>

        <?php endif; ?>

        <div class="clearfix"></div><br />

        <?php
        // Comment Form
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields =  array(
            'author' => '<p class="comment-form-author">' . '<label for="author">' . ( $req ? '<span class="required">*</span> ' : '' ) . __( 'Name', 'flatty' ) . '</label> ',
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . ( $req ? '<span class="required">*</span> ' : '' ) . __( 'Email', 'flatty' ) . '</label> ',
                        '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>'
        );
        $args = array (
            'id_submit' => 'comment-submit',
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),
            'logged_in_as' => '<p class="alert alert-warning logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','flatty'), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink($post->ID) ) ) ) . '</p>',
            'comment_notes_before' => '<p class="alert alert-info comment-notes">' . __( 'Your email address will not be published. Fields with * are mandatory.','flatty') . '</p>',
        );
        comment_form($args);
        ?>

    </section>

<?php endif; ?>