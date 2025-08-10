<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area section">
            <section class="content-primary">
                <?php if (have_posts()) : ?>
                
                    <div class="blog-grid">
                    <?php while (have_posts()) : the_post(); ?>     
                        <?php get_template_part('template-parts/content', get_post_type()); ?>
                    <?php endwhile; ?>
                    </div>

                    <?php
                    the_posts_navigation(array(
                        'prev_text' => __('&larr; Older posts', 'wp-project-theme'),
                        'next_text' => __('Newer posts &rarr;', 'wp-project-theme'),
                    ));
                    ?>

                <?php else : ?>
                    <?php get_template_part('template-parts/content', 'none'); ?>
                <?php endif; ?>
            </section>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php get_footer();