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

        <?php
        $word_count = str_word_count(strip_tags(get_the_content()));
        $reading_time = ceil($word_count / 200);
        ?>

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