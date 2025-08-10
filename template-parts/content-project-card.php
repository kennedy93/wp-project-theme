<?php
/**
 * Template part for displaying project cards
 *
 * @package WP_Project_Theme
 */

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

<article id="project-<?php the_ID(); ?>" <?php post_class('project-card-content'); ?>>
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
</article>
