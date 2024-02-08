<?php
/**
 * IP24 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package IP24
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Enqueue scripts and styles.
 */
function ip24_scripts() {
	wp_enqueue_style( 'base-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'ip24-style', get_template_directory_uri() . '/ip24.css', array('base-style'), _S_VERSION );
	wp_style_add_data( 'base-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ip24-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'ip24_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


// DEBLOAT
add_filter('show_admin_bar', '__return_false');
// function dm_remove_wp_block_library_css(){
// 	wp_dequeue_style( 'wp-block-library' );
// }
//add_action( 'wp_enqueue_scripts', 'dm_remove_wp_block_library_css' );
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


// IMPERATORI 
function HP_latest_offers() {
    $args = array(
        'posts_per_page' => 3, /* how many post you need to display */
        'offset' => 0,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'post_type' => 'post', /* your post type name */
        'post_status' => 'publish',
        'ignore_sticky_posts' => true
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) :
    	echo '<section class="container-offers">';
    	echo '<h2 class="wp-block-heading">IN EVIDENZA</h2>';
        while ($query->have_posts()) : $query->the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="offer-card">
            	<figure class="offer-card-pic"><?php echo get_the_post_thumbnail( $query->post->ID, 'large' );?></figure>
            	<div class="offer-card-text">
            		<h3 class="offer-card-tit"><?php the_title(); ?></h3>
            		<?php the_excerpt(); ?>
            	</div>
            </a>
            <?php
        endwhile;
        echo '</section>';
    endif;
}

add_shortcode('latest-offers', 'HP_latest_offers');
// USAGE:
// echo do_shortcode('[latest-offers]');
// [latest-offers]
