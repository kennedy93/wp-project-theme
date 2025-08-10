<?php get_header(); ?>

<main id="primary" class="site-main">
    <!-- Projects Archive Header -->
    <section class="section archive-header">
        <div class="container">
            <div class="section-header">
                <h1><?php _e('Our Projects', 'wp-project-theme'); ?></h1>
                <p><?php _e('Explore our portfolio of successful projects and see how we\'ve helped clients achieve their business goals through innovative digital solutions.', 'wp-project-theme'); ?></p>
            </div>

            <form id="projects-filter-form" class="filter-form" method="get" action="<?php echo esc_url(get_post_type_archive_link('project')); ?>">
                <div class="project-filter">
                    <div class="filter-group">
                        <label for="start_date_filter"><?php _e('Start Date:', 'wp-project-theme'); ?></label>
                        <input type="date" id="start_date_filter" name="start_date" value="<?php echo esc_attr($_GET['start_date'] ?? ''); ?>">
                    </div>
                    <div class="filter-group">
                        <label for="end_date_filter"><?php _e('End Date:', 'wp-project-theme'); ?></label>
                        <input type="date" id="end_date_filter" name="end_date" value="<?php echo esc_attr($_GET['end_date'] ?? ''); ?>">
                    </div>
                    <div class="filter-group align-self-end">
                        <button type="button" id="apply-filters" class="btn btn-accent"><?php _e('Apply Filters', 'wp-project-theme'); ?></button>
                        <button type="submit" class="btn btn-accent" style="display: none;" id="fallback-submit"><?php _e('Apply Filters', 'wp-project-theme'); ?></button>
                        <button type="button" id="clear-filters" class="btn btn-outline"><?php _e('Clear Filters', 'wp-project-theme'); ?></button>
                    </div>
                </div>
                <?php wp_nonce_field('wp_project_nonce', 'wp_project_nonce'); ?>
            </form>
        </div>
    </section>

    <!-- Projects Grid Section -->
    <section class="section">
        <div class="container">
            <div id="projects-container">
                <?php 
                // Handle filter parameters for non-AJAX requests
                $start_date_filter = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
                $end_date_filter = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';
                
                $query_args = array(
                    'post_type' => 'project',
                    'post_status' => 'publish',
                    'paged' => get_query_var('paged') ? get_query_var('paged') : 1
                );
                
                // Add meta query for date filtering if parameters are set
                if ($start_date_filter || $end_date_filter) {
                    $meta_query = array('relation' => 'AND');
                    
                    if ($start_date_filter) {
                        $meta_query[] = array(
                            'key' => '_project_start_date',
                            'value' => $start_date_filter,
                            'compare' => '>=',
                            'type' => 'DATE'
                        );
                    }
                    
                    if ($end_date_filter) {
                        $meta_query[] = array(
                            'key' => '_project_end_date',
                            'value' => $end_date_filter,
                            'compare' => '<=',
                            'type' => 'DATE'
                        );
                    }
                    
                    $query_args['meta_query'] = $meta_query;
                }
                
                $projects_query = new WP_Query($query_args);
                
                if ($projects_query->have_posts()) : ?>
                    <div class="projects-grid">
                        <?php while ($projects_query->have_posts()) : $projects_query->the_post(); 
                            // Get project dates (custom fields)
                            $start_date = get_post_meta(get_the_ID(), '_project_start_date', true);
                            $end_date = get_post_meta(get_the_ID(), '_project_end_date', true);
                            
                            // Format project duration
                            $project_duration = '';
                            if ($start_date && $end_date) {
                                $start_formatted = wp_project_format_date($start_date);
                                $end_formatted = wp_project_format_date($end_date);
                                $project_duration = $start_formatted . ' - ' . $end_formatted;
                            } elseif ($start_date) {
                                $project_duration = wp_project_format_date($start_date);
                            } else {
                                $project_duration = get_the_date('d, M Y');
                            }
                        ?>
                        <div class="project-card">
                            <div class="project-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                                    </a>
                                <?php else : ?>
                                    <i class="fas fa-briefcase fa-3x"></i>
                                <?php endif; ?>
                            </div>
                            <div class="project-content">
                                <div class="project-meta">
                                    <span><i class="far fa-calendar"></i> <?php echo esc_html($project_duration); ?></span>
                                </div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    // Preserve query parameters in pagination
                    $pagination_args = array(
                        'prev_text' => __('&larr; Older Projects', 'wp-project-theme'),
                        'next_text' => __('Newer Projects &rarr;', 'wp-project-theme'),
                        'total' => $projects_query->max_num_pages,
                        'current' => max(1, get_query_var('paged'))
                    );
                    
                    if ($start_date_filter || $end_date_filter) {
                        $pagination_args['add_args'] = array(
                            'start_date' => $start_date_filter,
                            'end_date' => $end_date_filter
                        );
                    }
                    
                    echo paginate_links($pagination_args);
                    wp_reset_postdata();
                    ?>
                <?php else : ?>
                    <div class="no-projects">
                        <h2><?php _e('No projects found', 'wp-project-theme'); ?></h2>
                        <p><?php _e('Sorry, no projects match your criteria. Please try adjusting your filters.', 'wp-project-theme'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer();