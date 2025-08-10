<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title">
            <i class="fa-solid fa-ban"></i>
            <?php _e('Nothing here', 'wp-project-theme'); ?>
        </h1>
    </header>

    <div class="page-content">
        <?php if (is_home() && current_user_can('publish_posts')) : ?>
            <p>
                <?php
                printf(
                    wp_kses(
                        __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'wp-project-theme'),
                        array(
                            'a' => array(
                                'href' => array(),
                            ),
                        )
                    ),
                    esc_url(admin_url('post-new.php'))
                );
                ?>
            </p>
        <?php elseif (is_search()) : ?>
            <p class="text-center"><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wp-project-theme'); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p class="text-center"><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wp-project-theme'); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</section>
