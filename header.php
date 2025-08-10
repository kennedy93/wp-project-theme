<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <!-- Header with Navigation -->
    <header>
        <div class="container header-container">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" rel="home">
                    <i class="fas fa-cube"></i> <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
            
            
            <div class="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>
            
            <nav>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => 'wp_project_fallback_menu',
                    ));
                ?>
            </nav>
        </div>
    </header>

<?php
/**
 * Fallback menu if no menu is assigned
 */
function wp_project_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'wp-project-theme') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/projects/')) . '">' . __('Projects', 'wp-project-theme') . '</a></li>';
    echo '</ul>';
}
