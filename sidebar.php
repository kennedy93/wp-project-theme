<?php
/**
 * Sidebar template
 *
 * @package WP_Project_Theme
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area content-secondary">
    <!-- Search Widget -->
    <div class="widget widget_search">
        <div class="widget-content">
            <h3 class="widget-title"><?php _e('Search', 'wp-project-theme'); ?></h3>
            <div class="widget-body">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
    
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>
