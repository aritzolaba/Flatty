<?php
/**
 * The theme options page in wp-admin
 */
class flatty_theme_options_page {

    public static function init() {

        // Add menu
        add_action('admin_menu', array('flatty_theme_options_page', 'add_flatty_options_page'));

        // Initialize default options
        $def_theme_options = array();
        $def_theme_options['css_style'] = 'blue';
        $def_theme_options['sidebar_position'] = 'right';
        $def_theme_options['footer_social'] = 1;
        $def_theme_options['sidebar_admin'] = 1;
        $def_theme_options['article_author'] = 1;
        $def_theme_options['article_related'] = 1;
        $def_theme_options['article_featured_images'] = 'left';
        $def_theme_options['breadcrumb'] = 1;
        $def_theme_options['pagination_type'] = 'buttons';
        $def_theme_options['display_blog_title'] = 1;

        // Social buttons
        $def_theme_options['social_facebook'] = '';
        $def_theme_options['social_github'] = '';
        $def_theme_options['social_googleplus'] = '';
        $def_theme_options['social_twitter'] = '';
        $def_theme_options['social_linkedin'] = '';

        global $flatty_theme_options;

        // This part is for theme updates, to ensure options are stored
        // properly in wp-config.

        // If there are options already, check if there are new options or
        // if any option has been deleted in a theme update, updating
        // the options array without loosing the current configuration
        if (!empty($flatty_theme_options) && is_array($flatty_theme_options) && count($flatty_theme_options)>1) {

            $cur_size = count($flatty_theme_options);
            $def_size = count($def_theme_options);
            if ($def_size!=$cur_size) {
                // Check for new options
                foreach ($def_theme_options as $def_key => $def_value) :
                    if (!isset($flatty_theme_options[$def_key])) {
                        $flatty_theme_options[$def_key] = $def_value;
                    }
                endforeach;

                // Check for deleted options
                foreach ($flatty_theme_options as $cur_key => $cur_value) :
                    if (!isset($def_theme_options[$cur_key])) {
                        unset ($flatty_theme_options[$cur_key]);
                    }
                endforeach;

                delete_option('flatty_theme_options');
                add_option('flatty_theme_options', $flatty_theme_options);
            }
        } else {
            // Update options with defaults
            $flatty_theme_options = $def_theme_options;
            // Add default options to db
            add_option('flatty_theme_options', $def_theme_options);
        }
    }

    public static function add_flatty_options_page() {
        add_theme_page(__('Theme Options', 'flatty'), __('Theme Options', 'flatty'), 'edit_theme_options', 'theme-options-page', array('flatty_theme_options_page', 'page'));
    }

    public static function page() {

        // Get options
        global $flatty_theme_options;

        // SAVE OPTIONS
        if (isset($_POST['submit'])) :
            // Check referer
            check_admin_referer('flatty_theme_options_page');

            // Obtain all $_POST values and make sure unchecked options are
            // saved with a 0 value.
            foreach ($flatty_theme_options as $k => $v) :
                if (!empty($_POST[$k])) :
                    $flatty_theme_options[$k] = wp_kses($_POST[$k], array());
                else :
                    $flatty_theme_options[$k] = 0;
                endif;
            endforeach;

            // Update
            $ret=update_option('flatty_theme_options', $flatty_theme_options);
            if ($ret) $updated=1;

        endif; ?>

        <div class="wrap">

            <?php screen_icon(); ?>

            <h2>
                <?php printf(__('%s Theme Options', 'flatty'), wp_get_theme()); ?>
            </h2>

            <?php settings_errors(); ?>

            <br />

            <form method="post" action="">

                <h3 class="title"><?php _e('General options', 'flatty'); ?></h3>

                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="css_style"><?php _e('CSS Style','flatty'); ?></label></th>
                            <td>
                                <select name="css_style" id="css_style">
                                    <option value="black_white" <?php if ($flatty_theme_options['css_style'] == 'black_white') echo 'selected="selected"'; ?>><?php _e('Black and White','flatty'); ?></option>
                                    <option value="blue" <?php if ($flatty_theme_options['css_style'] == 'blue') echo 'selected="selected"'; ?>><?php _e('Blue','flatty'); ?> (default)</option>
                                    <option value="green" <?php if ($flatty_theme_options['css_style'] == 'green') echo 'selected="selected"'; ?>><?php _e('Green','flatty'); ?></option>
                                    <option value="red" <?php if ($flatty_theme_options['css_style'] == 'red') echo 'selected="selected"'; ?>><?php _e('Red','flatty'); ?></option>
                                    <option value="salmon" <?php if ($flatty_theme_options['css_style'] == 'salmon') echo 'selected="selected"'; ?>><?php _e('Salmon','flatty'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="pagination_type"><?php _e('Pagination type','flatty'); ?></label></th>
                            <td>
                                <select name="pagination_type" id="sidebar_position">
                                    <option value="buttons" <?php if ($flatty_theme_options['pagination_type'] == 'buttons') echo 'selected="selected"'; ?>><?php _e('Buttons','flatty'); ?></option>
                                    <option value="numbers" <?php if ($flatty_theme_options['pagination_type'] == 'numbers') echo 'selected="selected"'; ?>><?php _e('Numbers','flatty'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="breadcrumb"><?php _e('Display breadcrumb?','flatty'); ?></label></th>
                            <td><input name="breadcrumb" type="checkbox" id="breadcrumb" value="1" <?php if ($flatty_theme_options['breadcrumb'] == 1) echo 'checked="checked"'; ?>></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="display_blog_title"><?php _e('Display Blog Title?','flatty'); ?></label></th>
                            <td><input name="display_blog_title" type="checkbox" id="display_blog_title" value="1" <?php if ($flatty_theme_options['display_blog_title'] == 1) echo 'checked="checked"'; ?>></td>
                        </tr>
                    </tbody>
                </table>

                <br />

                <h3 class="title"><?php _e('Article options', 'flatty'); ?></h3>

                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="article_featured_images"><?php _e('Display post featured images?','flatty'); ?></label></th>
                            <td>
                                <select name="article_featured_images" id="article_featured_images">
                                    <option value="left" <?php if ($flatty_theme_options['article_featured_images'] == 'left') echo 'selected="selected"'; ?>><?php _e('Left','flatty'); ?></option>
                                    <option value="right" <?php if ($flatty_theme_options['article_featured_images'] == 'right') echo 'selected="selected"'; ?>><?php _e('Right','flatty'); ?></option>
                                    <option value="none" <?php if ($flatty_theme_options['article_featured_images'] == 'none') echo 'selected="selected"'; ?>><?php _e('Do not display','flatty'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="article_author"><?php _e('Display author info?','flatty'); ?></label></th>
                            <td><input name="article_author" type="checkbox" id="article_author" value="1" <?php if ($flatty_theme_options['article_author'] == 1) echo 'checked="checked"'; ?>></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="article_related"><?php _e('Display related articles?','flatty'); ?></label></th>
                            <td><input name="article_related" type="checkbox" id="article_related" value="1" <?php if ($flatty_theme_options['article_related'] == 1) echo 'checked="checked"'; ?>></td>
                        </tr>
                    </tbody>
                </table>

                <br />

                <h3 class="title"><?php _e('Sidebar options', 'flatty'); ?></h3>

                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="sidebar_position"><?php _e('Sidebar position','flatty'); ?></label></th>
                            <td>
                                <select name="sidebar_position" id="sidebar_position">
                                    <option value="left" <?php if ($flatty_theme_options['sidebar_position'] == 'left') echo 'selected="selected"'; ?>><?php _e('Left','flatty'); ?></option>
                                    <option value="right" <?php if ($flatty_theme_options['sidebar_position'] == 'right') echo 'selected="selected"'; ?>><?php _e('Right','flatty'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="sidebar_admin"><?php _e('Display admin info in sidebar?','flatty'); ?></label></th>
                            <td><input name="sidebar_admin" type="checkbox" id="sidebar_admin" value="1" <?php if ($flatty_theme_options['sidebar_admin'] == 1) echo 'checked="checked"'; ?>></td>
                        </tr>
                    </tbody>
                </table>

                <br />

                <h3 class="title"><?php _e('Social URLs', 'flatty'); ?></h3>

                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="footer_social"><?php _e('Display social links in footer?','flatty'); ?></label></th>
                            <td><input name="footer_social" type="checkbox" id="footer_social" value="1" <?php if ($flatty_theme_options['footer_social'] == 1) echo 'checked="checked"'; ?>></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="social_facebook">Facebook</label></th>
                            <td><input name="social_facebook" type="text" id="social_facebook" value="<?php if (!empty($flatty_theme_options['social_facebook'])) echo $flatty_theme_options['social_facebook']; ?>" class="regular-text" placeholder="http://"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="social_github">GitHub</label></th>
                            <td><input name="social_github" type="text" id="social_github" value="<?php if (!empty($flatty_theme_options['social_github'])) echo $flatty_theme_options['social_github']; ?>" class="regular-text" placeholder="http://"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="social_googleplus">Google+</label></th>
                            <td><input name="social_googleplus" type="text" id="social_googleplus" value="<?php if (!empty($flatty_theme_options['social_googleplus'])) echo $flatty_theme_options['social_googleplus']; ?>" class="regular-text" placeholder="http://"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="social_twitter">Twitter</label></th>
                            <td><input name="social_twitter" type="text" id="social_twitter" value="<?php if (!empty($flatty_theme_options['social_twitter'])) echo $flatty_theme_options['social_twitter']; ?>" class="regular-text" placeholder="http://"></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="social_linkedin">LinkedIn</label></th>
                            <td><input name="social_linkedin" type="text" id="social_linkedin" value="<?php if (!empty($flatty_theme_options['social_linkedin'])) echo $flatty_theme_options['social_linkedin']; ?>" class="regular-text" placeholder="http://"></td>
                        </tr>
                    </tbody>
                </table>

                <br />

                <p class="submit">
                    <button type="submit" class="button button-primary menu-save" id="submit" name="submit"><i class="icon-save"></i> <?php _e('Save Changes','flatty'); ?></button>
                </p>

                <?php wp_nonce_field( 'flatty_theme_options_page' ) ?>

            </form>

        </div><!-- .wrap -->

    <?php }
}
add_action('init', array('flatty_theme_options_page', 'init'));