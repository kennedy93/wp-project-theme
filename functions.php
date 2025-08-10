<?php
/**
 * WP Project Theme Functions
 *
 * @package WP_Project_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function wp_project_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'wp-project-theme'),
    ));

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('style.css');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for automatic feed links
    add_theme_support('automatic-feed-links');
}
add_action('after_setup_theme', 'wp_project_theme_setup');

/**
 * Register Widget Areas
 */
function wp_project_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'wp-project-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'wp-project-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'wp_project_widgets_init');

/**
 * Enqueue Scripts and Styles
 */
function wp_project_theme_scripts() {
    // Main stylesheet
    wp_enqueue_style('wp-project-theme-style', get_stylesheet_uri(), array(), '1.0.1');

    wp_enqueue_style( 
        'font-awesome', 
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', 
        array(), 
        '6.4.0'
    );
    
    // Main JavaScript
    wp_enqueue_script('wp-project-theme-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    // Localize script for AJAX
    wp_localize_script('wp-project-theme-main', 'wpProjectAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wp_project_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'wp_project_theme_scripts');

/**
 * Register Custom Post Type: Projects
 */
function wp_project_register_projects_cpt() {
    $labels = array(
        'name'                  => _x('Projects', 'Post type general name', 'wp-project-theme'),
        'singular_name'         => _x('Project', 'Post type singular name', 'wp-project-theme'),
        'menu_name'             => _x('Projects', 'Admin Menu text', 'wp-project-theme'),
        'name_admin_bar'        => _x('Project', 'Add New on Toolbar', 'wp-project-theme'),
        'add_new'               => __('Add New', 'wp-project-theme'),
        'add_new_item'          => __('Add New Project', 'wp-project-theme'),
        'new_item'              => __('New Project', 'wp-project-theme'),
        'edit_item'             => __('Edit Project', 'wp-project-theme'),
        'view_item'             => __('View Project', 'wp-project-theme'),
        'all_items'             => __('All Projects', 'wp-project-theme'),
        'search_items'          => __('Search Projects', 'wp-project-theme'),
        'parent_item_colon'     => __('Parent Projects:', 'wp-project-theme'),
        'not_found'             => __('No projects found.', 'wp-project-theme'),
        'not_found_in_trash'    => __('No projects found in Trash.', 'wp-project-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'projects'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-portfolio',
        'show_in_rest'       => true,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('project', $args);
}
add_action('init', 'wp_project_register_projects_cpt');

/**
 * Add Custom Meta Boxes for Projects
 */
function wp_project_add_meta_boxes() {
    add_meta_box(
        'project_details',
        __('Project Details', 'wp-project-theme'),
        'wp_project_meta_box_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'wp_project_add_meta_boxes');

/**
 * Meta Box Callback Function
 */
function wp_project_meta_box_callback($post) {
    wp_nonce_field('wp_project_save_meta_box_data', 'wp_project_meta_box_nonce');

    $project_name = get_post_meta($post->ID, '_project_name', true);
    $project_description = get_post_meta($post->ID, '_project_description', true);
    $project_start_date = get_post_meta($post->ID, '_project_start_date', true);
    $project_end_date = get_post_meta($post->ID, '_project_end_date', true);
    $project_url = get_post_meta($post->ID, '_project_url', true);

    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="project_name">' . __('Project Name', 'wp-project-theme') . '</label></th>';
    echo '<td><input type="text" id="project_name" name="project_name" value="' . esc_attr($project_name) . '" class="regular-text" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="project_description">' . __('Project Description', 'wp-project-theme') . '</label></th>';
    echo '<td><textarea id="project_description" name="project_description" rows="4" class="large-text">' . esc_textarea($project_description) . '</textarea></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="project_start_date">' . __('Project Start Date', 'wp-project-theme') . '</label></th>';
    echo '<td><input type="date" id="project_start_date" name="project_start_date" value="' . esc_attr($project_start_date) . '" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="project_end_date">' . __('Project End Date', 'wp-project-theme') . '</label></th>';
    echo '<td><input type="date" id="project_end_date" name="project_end_date" value="' . esc_attr($project_end_date) . '" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="project_url">' . __('Project URL', 'wp-project-theme') . '</label></th>';
    echo '<td><input type="url" id="project_url" name="project_url" value="' . esc_attr($project_url) . '" class="regular-text" /></td>';
    echo '</tr>';
    echo '</table>';
}

/**
 * Save Meta Box Data
 */
function wp_project_save_meta_box_data($post_id) {
    if (!isset($_POST['wp_project_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['wp_project_meta_box_nonce'], 'wp_project_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'project' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    $fields = array('project_name', 'project_description', 'project_start_date', 'project_end_date', 'project_url');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);
            if ($field === 'project_description') {
                $value = sanitize_textarea_field($_POST[$field]);
            } elseif ($field === 'project_url') {
                $value = esc_url_raw($_POST[$field]);
            }
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post', 'wp_project_save_meta_box_data');

/**
 * Add Projects archive link to primary menu if it exists.
 */
function wp_project_add_projects_link( $items, $args ) {
    // Only modify the primary menu
    if ( $args->theme_location === 'primary' ) {
        
        // Replace 'project' with your custom post type slug
        $projects_link = get_post_type_archive_link( 'project' );

        if ( $projects_link ) {
            $items .= '<li><a href="' . esc_url( $projects_link ) . '">' 
                      . esc_html__( 'Projects', 'wp-project-theme' ) 
                      . '</a></li>';
        }
    }

    return $items;
}
add_filter( 'wp_nav_menu_items', 'wp_project_add_projects_link', 10, 2 );

/**
 * Custom REST API Endpoint for Projects
 */
function wp_project_register_api_endpoints() {
    register_rest_route('wp-project/v1', '/projects', array(
        'methods' => 'GET',
        'callback' => 'wp_project_get_projects_api',
        'permission_callback' => '__return_true',
        'args' => array(
            'per_page' => array(
                'default' => 10,
                'sanitize_callback' => 'absint',
            ),
            'page' => array(
                'default' => 1,
                'sanitize_callback' => 'absint',
            ),
            'start_date' => array(
                'sanitize_callback' => 'sanitize_text_field',
            ),
            'end_date' => array(
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ));
}
add_action('rest_api_init', 'wp_project_register_api_endpoints');

/**
 * API Callback Function
 */
function wp_project_get_projects_api($request) {
    $per_page = $request->get_param('per_page');
    $page = $request->get_param('page');
    $start_date = $request->get_param('start_date');
    $end_date = $request->get_param('end_date');

    $args = array(
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'meta_query' => array(),
    );

    if ($start_date || $end_date) {
        $date_query = array('relation' => 'AND');
        
        if ($start_date) {
            $date_query[] = array(
                'key' => '_project_start_date',
                'value' => $start_date,
                'compare' => '>=',
                'type' => 'DATE'
            );
        }
        
        if ($end_date) {
            $date_query[] = array(
                'key' => '_project_end_date',
                'value' => $end_date,
                'compare' => '<=',
                'type' => 'DATE'
            );
        }
        
        $args['meta_query'] = $date_query;
    }

    $query = new WP_Query($args);
    $projects = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $project_id = get_the_ID();
            
            $projects[] = array(
                'id' => $project_id,
                'title' => get_the_title(),
                'project_name' => get_post_meta($project_id, '_project_name', true),
                'project_description' => get_post_meta($project_id, '_project_description', true),
                'project_url' => get_post_meta($project_id, '_project_url', true),
                'project_start_date' => get_post_meta($project_id, '_project_start_date', true),
                'project_end_date' => get_post_meta($project_id, '_project_end_date', true),
                'permalink' => get_permalink(),
                'excerpt' => get_the_excerpt(),
            );
        }
    }

    wp_reset_postdata();

    return new WP_REST_Response(array(
        'projects' => $projects,
        'total' => $query->found_posts,
        'pages' => $query->max_num_pages,
        'current_page' => $page,
    ), 200);
}

/**
 * AJAX Handler for Project Filtering
 */
function wp_project_filter_projects() {
    check_ajax_referer('wp_project_nonce', 'nonce');

    $start_date = sanitize_text_field($_POST['start_date']);
    $end_date = sanitize_text_field($_POST['end_date']);

    $args = array(
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(),
    );

    if ($start_date || $end_date) {
        $date_query = array('relation' => 'AND');
        
        if ($start_date) {
            $date_query[] = array(
                'key' => '_project_start_date',
                'value' => $start_date,
                'compare' => '>=',
                'type' => 'DATE'
            );
        }
        
        if ($end_date) {
            $date_query[] = array(
                'key' => '_project_end_date',
                'value' => $end_date,
                'compare' => '<=',
                'type' => 'DATE'
            );
        }
        
        $args['meta_query'] = $date_query;
    }

    $query = new WP_Query($args);
    
    ob_start();
    if ($query->have_posts()) : ?>
        <div class="projects-grid">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="project-card">
                    <?php get_template_part('template-parts/content', 'project-card'); ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <div class="no-projects">
            <h2><?php _e('No projects found', 'wp-project-theme'); ?></h2>
            <p><?php _e('Sorry, no projects match your criteria. Please try adjusting your filters.', 'wp-project-theme'); ?></p>
        </div>
    <?php endif;
    
    wp_reset_postdata();
    $output = ob_get_clean();
    
    wp_send_json_success($output);
}
add_action('wp_ajax_filter_projects', 'wp_project_filter_projects');
add_action('wp_ajax_nopriv_filter_projects', 'wp_project_filter_projects');

/**
 * Security: Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Security: Disable file editing from admin
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * Helper function to get project meta safely
 */
function wp_project_get_meta($post_id, $key, $single = true) {
    $value = get_post_meta($post_id, '_' . $key, $single);
    return $value ? $value : '';
}

/**
 * Helper function to format dates
 */
function wp_project_format_date($date) {
    if (empty($date)) {
        return '';
    }
    return date_i18n(get_option('date_format'), strtotime($date));
}

/**
 * Add body classes for better styling
 */
function wp_project_body_classes($classes) {
    if (is_post_type_archive('project')) {
        $classes[] = 'projects-archive';
    }
    if (is_singular('project')) {
        $classes[] = 'single-project';
    }
    return $classes;
}
add_filter('body_class', 'wp_project_body_classes');

/**
 * Flush rewrite rules on theme activation
 */
function wp_project_flush_rewrite_rules() {
    wp_project_register_projects_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'wp_project_flush_rewrite_rules');

