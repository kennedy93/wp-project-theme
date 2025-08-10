<?php
/**
 * Single Post template
 *
 * @package WP_Project_Theme
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area section">
            <section class="content-primary">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
                        
                        <!-- Featured Image Hero Section -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="entry-thumbnail-hero">
                                <div class="featured-image-container">
                                    <?php the_post_thumbnail('large', ['class' => 'featured-image']); ?>
                                    <div class="image-overlay"></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content-wrapper">
                            <header class="entry-header">
                                <!-- Categories Pills -->
                                <?php if (has_category()) : ?>
                                    <div class="post-categories">
                                        <?php 
                                        $categories = get_the_category();
                                        foreach ($categories as $category) {
                                            echo '<span class="category-pill">' . esc_html($category->name) . '</span>';
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                                
                                <!-- Enhanced Meta Information -->
                                <div class="entry-meta">
                                    <div class="meta-item author-meta">
                                        <div class="author-avatar">
                                            <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                                        </div>
                                        <div class="author-info">
                                            <span><?php _e('Posted by', 'wp-project-theme'); ?></span>
                                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-name">
                                                <?php the_author(); ?>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="meta-divider">•</div>
                                    
                                    <div class="meta-item date-meta">
                                        <svg class="meta-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8 2V5M16 2V5M3.5 9.09H20.5M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <time datetime="<?php echo get_the_date('c'); ?>" class="published-date">
                                            <?php echo get_the_date('F j, Y'); ?>
                                        </time>
                                    </div>
                                    
                                    <div class="meta-divider">•</div>
                                    
                                    <div class="meta-item reading-time">
                                        <svg class="meta-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>
                                            <?php 
                                            $word_count = str_word_count(strip_tags(get_the_content()));
                                            $reading_time = ceil($word_count / 200);
                                            echo $reading_time . ' ' . _n('min read', 'min read', $reading_time, 'wp-project-theme');
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </header>
                            
                            <div class="entry-content">
                                <?php 
                                the_content();
                                
                                wp_link_pages(array(
                                    'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'wp-project-theme') . '</span>',
                                    'after'  => '</div>',
                                    'link_before' => '<span class="page-number">',
                                    'link_after' => '</span>',
                                ));
                                ?>
                            </div>
                            
                            <!-- Tags Section -->
                            <?php if (has_tag()) : ?>
                                <div class="entry-footer">
                                    <div class="post-tags">
                                        <svg class="tags-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.9 2L20.5 9.6C21.1 10.2 21.1 11.2 20.5 11.8L11.8 20.5C11.2 21.1 10.2 21.1 9.6 20.5L2 12.9V2H12.9Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <circle cx="6.5" cy="6.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                        </svg>
                                        <?php 
                                        $tags = get_the_tags();
                                        if ($tags) {
                                            foreach ($tags as $tag) {
                                                echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-pill">#' . esc_html($tag->name) . '</a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Social Share Section -->
                        <div class="social-share-section">
                            <h3 class="share-title"><?php _e('Share this post', 'wp-project-theme'); ?></h3>
                            <div class="social-share-buttons">
                                <?php 
                                $post_url = get_permalink();
                                $post_title = get_the_title();
                                ?>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($post_url); ?>&text=<?php echo urlencode($post_title); ?>" 
                                   target="_blank" class="share-btn share-twitter" aria-label="Share on Twitter">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                    <span>Twitter</span>
                                </a>
                                
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($post_url); ?>" 
                                   target="_blank" class="share-btn share-facebook" aria-label="Share on Facebook">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    <span>Facebook</span>
                                </a>
                                
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($post_url); ?>" 
                                   target="_blank" class="share-btn share-linkedin" aria-label="Share on LinkedIn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    <span>LinkedIn</span>
                                </a>
                                
                                <button class="share-btn share-copy" onclick="copyToClipboard('<?php echo esc_js($post_url); ?>')" aria-label="Copy link">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.72"></path>
                                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.72-1.72"></path>
                                    </svg>
                                    <span>Copy Link</span>
                                </button>
                            </div>
                        </div>           
                    </article>


                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>
            </section>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer();
