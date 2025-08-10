<?php
    /**
     * Single Project template
     *
     * @package WP_Project_Theme
     */

get_header(); ?>

<main id="primary" class="site-main">
    <section class="section" id="single-project">
        <div class="container">
            <?php while (have_posts()): the_post();

            // Get custom field values
            $project_name        = wp_project_get_meta(get_the_ID(), 'project_name');
            $project_description = wp_project_get_meta(get_the_ID(), 'project_description');
            $project_url         = wp_project_get_meta(get_the_ID(), 'project_url');
            $project_start_date  = wp_project_get_meta(get_the_ID(), 'project_start_date');
            $project_end_date    = wp_project_get_meta(get_the_ID(), 'project_end_date');
            ?>

            <article id="project-<?php the_ID(); ?>"<?php post_class('project'); ?>>
                <div class="project-single">
                    <div class="project-header">
                        <h2><?php the_title(); ?></h2>
                        <div class="project-meta-large">
                            <div><i class="far fa-calendar"></i> <?php _e('Start Date:', 'wp-project-theme'); ?>: <?php echo wp_project_format_date($project_start_date); ?></div>
                            <div><i class="far fa-calendar-check"></i> <?php _e('End Date:', 'wp-project-theme'); ?>: <?php echo wp_project_format_date($project_end_date); ?></div>
                        </div>
                    </div>
                    <div class="project-body">
                        <div class="project-details">
                            <h3><?php echo esc_html($project_name); ?></h3>
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large', array('alt' => get_the_title(), 'class' => 'project-featured-image')); ?>
                                </a>
                            <?php endif; ?>
                            <p><?php echo wp_kses_post(wpautop($project_description)); ?></p>
 
                            <a href="<?php echo esc_url($project_url); ?>" target="_blank" class="project-url"><i class="fas fa-external-link-alt"></i> <?php _e('View Live Project', 'wp-project-theme') ?></a>
                            <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="back-to-projects"><i class="fas fa-arrow-left"></i> <?php _e('Back to Projects', 'wp-project-theme'); ?></a>
                        </div>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php get_footer();