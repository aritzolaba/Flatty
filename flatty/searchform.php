<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<form class="form-search" method="post" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <input type="search" class="form-control " name="s" id="s" placeholder="<?php _e('Search', 'flatty'); ?>" />
        <span class="input-group-btn">
            <button id="searchsubmit" type="submit" class="btn btn-primary"><i class="icon-search"></i></button>
        </span>
    </div>
</form>