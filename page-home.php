<?php
/**
 * Template Name: Home Page
 *
 * @package WP_Project_Theme
 */

get_header(); ?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Transforming Ideas into Digital Excellence</h1>
                <p>We create sophisticated digital solutions that drive business growth and deliver exceptional user experiences.</p>
                <div class="d-flex flex-wrap gap-15">
                    <a href="<?php echo esc_url(home_url('/projects/')); ?>" class="btn btn-accent">Explore Projects <i class="fas fa-arrow-right"></i></a>
                    <a href="#" class="btn btn-contact-us">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('Latest Projects', 'wp-project-theme'); ?></h2>
                <p><?php _e("Discover our latest projects and see how we've helped clients achieve their business goals through innovative digital solutions.", 'wp-project-theme'); ?></p>
            </div>

            <!-- Projects Grid -->
            <div class="projects-grid">
                <?php
                // Get latest 3 projects
                $projects = new WP_Query(array(
                    'post_type' => 'project',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($projects->have_posts()) :
                    while ($projects->have_posts()) : $projects->the_post();  
                        // Get project dates (custom fields)
                        $start_date = get_post_meta(get_the_ID(), '_project_start_date', true);
                        $end_date = get_post_meta(get_the_ID(), '_project_end_date', true);
                        
                        // Format project duration
                        $project_duration = '';
                        if ($start_date && $end_date) {
                            $start_formatted = date('d, M Y', strtotime($start_date));
                            $end_formatted = date('d, M Y', strtotime($end_date));
                            $project_duration = $start_formatted . ' - ' . $end_formatted;
                        } elseif ($start_date) {
                            $project_duration = date('d, M Y', strtotime($start_date));
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
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <!-- Fallback content if no projects exist -->
                <div class="project-card">
                    <div class="project-image">
                        <i class="fas fa-plus-circle fa-3x"></i>
                    </div>
                    <div class="project-content">
                        <div class="project-meta">
                            <span><i class="far fa-calendar"></i> <?php echo date('M Y'); ?></span>
                            <span><i class="fas fa-tag"></i> <?php _e('Getting Started', 'wp-project-theme'); ?></span>
                        </div>
                        <h3><?php _e('Your First Project', 'wp-project-theme'); ?></h3>
                        <p><?php _e('Showcase your work by adding your first project. Highlight your skills, technologies used, and project outcomes.', 'wp-project-theme'); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>


    <!-- Blog Section -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('Industry Insights', 'wp-project-theme'); ?></h2>
                <p><?php _e('Expert perspectives on digital transformation, user experience, and technology trends shaping modern business.', 'wp-project-theme'); ?></p>
            </div>

            <div class="blog-grid">
                <?php
                // Get latest 3 blog posts
                $blog_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($blog_posts->have_posts()) :
                    while ($blog_posts->have_posts()) : $blog_posts->the_post();
                        $word_count = str_word_count(strip_tags(get_the_content()));
                        $reading_time = ceil($word_count / 200);
                ?>
                <div class="blog-card">
                    <div class="blog-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                            </a>
                        <?php else : ?>
                            <i class="fas fa-file-alt fa-3x"></i>
                        <?php endif; ?>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> <?php echo get_the_date('M j, Y'); ?></span>
                            <span><i class="far fa-clock"></i> <?php echo $reading_time; ?> min read</span>
                        </div>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-outline"><?php _e('Read Article', 'wp-project-theme'); ?> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <!-- Fallback content if no posts exist -->
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="fas fa-edit fa-3x"></i>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> <?php echo date('M j, Y'); ?></span>
                            <span><i class="far fa-clock"></i> 2 min read</span>
                        </div>
                        <h3><?php _e('Welcome to Our Blog', 'wp-project-theme'); ?></h3>
                        <p><?php _e('Start sharing your insights and expertise with the world. Create your first blog post to get started.', 'wp-project-theme'); ?></p>
                        <a href="<?php echo admin_url('post-new.php'); ?>" class="btn btn-outline"><?php _e('Create Post', 'wp-project-theme'); ?> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer();
