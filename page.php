<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area section">
            <section class="content-primary">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article class="page" id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="page-content-wrapper">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="entry-thumbnail">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="entry-header">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            </div>
                            
                            <div class="entry-content">
                                <?php 
                                the_content();
                                
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'wp-project-theme'),
                                    'after'  => '</div>',
                                ));
                                ?>
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
