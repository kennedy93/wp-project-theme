<?php
/**
 * Search form template
 *
 * @package WP_Project_Theme
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php _e('Search for:', 'wp-project-theme'); ?></span>
        <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search...', 'wp-project-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s">
    </label>
    <button type="submit" class="search-submit">
        <span class="screen-reader-text"><?php _e('Search', 'wp-project-theme'); ?></span>
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</form>
