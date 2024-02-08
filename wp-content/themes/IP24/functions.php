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



function update_posts_galleries($content) {
    if (is_single()) {

        // echo 'giuseppe';
        $post = get_post(); 

        if ( has_blocks( $post->post_content ) ) {
            $blocks = parse_blocks( $post->post_content );

            $gallerypresent = false;
            foreach ($blocks as $block) {
                //print_r($block['blockName']);
                if ( $block['blockName'] === 'core/gallery' ) {
                    //echo 'c\'è gia';
                    $gallerypresent = true;
                }
            }

            if (!$gallerypresent) {
                //echo '-> la creo..';
                gallery_from_attached_media($post);
            }
            
        } else {
            //echo 'non c\'è un gazz';
            gallery_from_attached_media($post);
        }
    }
    return $content;
}
add_filter( 'loop_start', 'update_posts_galleries' );

function gallery_from_attached_media($post) {
    $media = get_attached_media('image', $post->ID); // Get image attachment(s) to the current Post
    //print_r($media);

    $fake_block = "<!-- wp:paragraph --><p>fgreg nkerngkesnenrgjkl nelkbrsgvklwbgwan vlka ewnkwenjfklw bfkvqcbq klfgw evbwefb lewq</p><!-- /wp:paragraph -->";


    $block_content = '
        <!-- wp:gallery {"linkTo":"none"} -->
        <figure class="wp-block-gallery has-nested-images columns-default is-cropped">';
    
    foreach ($media as $pic) {
        //print_r($pic);
        //echo '<br>'.$pic->ID.'-------- <br>';
        $img_atts = wp_get_attachment_image_src( $pic->ID, 'large' );
        $block_content .= '<!-- wp:image {"id":'.$pic->ID.',"sizeSlug":"large","linkDestination":"none"} -->
            <figure class="wp-block-image size-large"><img src="'.$img_atts[0].'" alt="" class="wp-image-'.$pic->ID.'"/></figure>
        <!-- /wp:image -->';
    }
    
    $block_content .= '
        </figure>
        <!-- /wp:gallery -->';     
    
    // echo do_blocks($fake_block);
    // echo do_blocks($block_content);
    // print_r($fake_block);

    // print_r($block_content);
    // echo 'eccomi';

    $post->post_content = $post->post_content.$block_content;
    wp_update_post( $post,true );
    // if (is_wp_error($post->ID)) {
    //     $errors = $post->ID->get_error_messages();
    //     foreach ($errors as $error) {
    //         echo $error;
    //     }
    // } else {
    //     echo 'T\'appó.';
    // }
}

