<?php
/**
 * The theme options page in wp-admin
 */
class flatty_theme_options_page {

    function init() {

        // Add menu
        add_action('admin_menu', array('flatty_theme_options_page', 'add_flatty_options_page'));

        // Initialize default options
        $def_theme_options = array();
        $def_theme_options['google_analytics_account'] = '';
        $def_theme_options['sidebar_position'] = 'right';
        $def_theme_options['sidebar_admin'] = 1;
        $def_theme_options['article_author'] = 1;
        $def_theme_options['article_related'] = 1;
        $def_theme_options['breadcrumb'] = 1;

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

    function add_flatty_options_page() {
        add_theme_page(__('Theme Options', 'flatty'), __('Theme Options', 'flatty'), 'edit_theme_options', 'theme-options-page', array('flatty_theme_options_page', 'page'));
    }

    function page() {

        // Get options
        global $flatty_theme_options;

        // SAVE OPTIONS
        if (isset($_POST['submit'])) :
            // Check referer
            check_admin_referer('flatty_theme_options_page');

            // Obtain all $_POST values and make sure unchecked options are
            // saved with a 0 value.
            foreach ($flatty_theme_options as $k => $v) {
                if (isset($_POST[$k])) {
                    $flatty_theme_options[$k] = wp_kses($_POST[$k], array());
                } else {
                    $flatty_theme_options[$k] = 0;
                }
            }

            // Update
            $ret=update_option('flatty_theme_options', $flatty_theme_options);
            if ($ret) $updated=1;
            ?>

        <?php endif; ?>

        <div class="wrap">

            <?php screen_icon(); ?>

            <h2>
                <?php printf(__('%s Theme Options', 'flatty'), wp_get_theme()); ?>
            </h2>

            <?php settings_errors(); ?>

            <br />

            <form method="post" action="">

                <h3 class="title"><?php _e('Article options', 'flatty'); ?></h3>

                <table class="form-table">
                    <tbody>
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

                <h3 class="title"><?php _e('General options', 'flatty'); ?></h3>

                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="breadcrumb"><?php _e('Display breadcrumb?','flatty'); ?></label></th>
                            <td><input name="breadcrumb" type="checkbox" id="breadcrumb" value="1" <?php if ($flatty_theme_options['breadcrumb'] == 1) echo 'checked="checked"'; ?>></td>
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

                <h3 class="title"><?php _e('Google Analytics', 'flatty'); ?></h3>

                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="google_analytics_account"><?php _e('Google Analytics account','flatty'); ?></label></th>
                            <td>
                                <input name="google_analytics_account" type="text" placeholder="UA-" id="google_analytics_account" value="<?php echo $flatty_theme_options['google_analytics_account']; ?>" class="regular-text" style="width: 100px;" size="15" maxlength="10">
                                <p class="description"><?php _e('Type your "UA-12345" account or leave it blank', 'flatty'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="submit">
                    <button type="submit" class="button button-primary menu-save" id="submit" name="submit"><i class="icon-save"></i> <?php _e('Save Changes','flatty'); ?></button>
                </p>

                <?php wp_nonce_field( 'flatty_theme_options_page' ) ?>

            </form>

        </div><!-- .wrap -->

    <?php }
}
add_action('init', array('flatty_theme_options_page', 'init'));