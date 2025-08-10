<?php
/**
 * Template Name: Blog Page
 *
 * @package WP_Project_Theme
 */

get_header(); ?>

<main id="primary" class="site-main">
     <section class="section blog-hero">
        <div class="container">
            <div class="section-header">
                <h1><?php _e('Blog', 'wp-project-theme'); ?></h1>
                <p><?php _e('Latest news, updates, and insights', 'wp-project-theme'); ?></p>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="content-area section">
            <section class="content-primary">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $blog_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => get_option('posts_per_page'),
                    'paged' => $paged,
                    'post_status' => 'publish'
                ));

                if ($blog_posts->have_posts()) : ?>   
                    <div class="blog-grid">
                        <?php while ($blog_posts->have_posts()) : $blog_posts->the_post();
                            $word_count = str_word_count(strip_tags(get_the_content()));
                            $reading_time = ceil($word_count / 200);
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
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
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    // Custom pagination
                    $pagination_args = array(
                        'total' => $blog_posts->max_num_pages,
                        'current' => $paged,
                        'prev_text' => __('&larr; Previous', 'wp-project-theme'),
                        'next_text' => __('Next &rarr;', 'wp-project-theme'),
                        'type' => 'list',
                        'end_size' => 3,
                        'mid_size' => 3,
                    );
                    
                    $pagination_links = paginate_links($pagination_args);
                    
                    if ($pagination_links) : ?>
                        <nav class="navigation pagination">
                            <h2 class="screen-reader-text"><?php _e('Posts navigation', 'wp-project-theme'); ?></h2>
                            <?php echo $pagination_links; ?>
                        </nav>
                    <?php endif; ?>

                <?php else : ?>
                    <div class="no-posts">
                        <h2><?php _e('No posts found', 'wp-project-theme'); ?></h2>
                        <p><?php _e('Sorry, no blog posts were found. Please check back later.', 'wp-project-theme'); ?></p>
                    </div>
                <?php endif; 
                
                wp_reset_postdata(); ?>   
            </section>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer();