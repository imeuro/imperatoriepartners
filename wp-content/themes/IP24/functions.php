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
    //wp_enqueue_script( 'ip24-scripts', get_template_directory_uri() . '/js/ip24.js', array('ip24-navigation'), _S_VERSION, true );
    //wp_enqueue_script( 'ip24-carousel', get_template_directory_uri() . '/js/ip24Carousel.js', array('ip24-scripts'), _S_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'ip24_scripts' );


add_theme_support( 'post-thumbnails' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
// require get_template_directory() . '/inc/custom-fields.php';


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
        wp_reset_postdata();
    endif;
}

add_shortcode('latest-offers', 'HP_latest_offers');
// USAGE:
// echo do_shortcode('[latest-offers]');
// [latest-offers]


add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});





/* converte post attachments in gallery-blocks */
function update_posts_galleries($content) {
    if (is_single()) {

        // echo 'giuseppe';
        $post = get_post();

        if ( has_blocks( $post->post_content ) ) {
            $blocks = parse_blocks( $post->post_content );

            //print_r($post);

            $gallerypresent = false;
            foreach ($blocks as $block) {
                // print_r($block['blockName']);
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

    // print_r($block_content);
    // echo 'eccomi';

    $post->post_content = $post->post_content.$block_content;
    wp_update_post( $post,true );


}





//Add Open Graph Meta Info from the actual article data, or customize as necessary
function facebook_open_graph() {
    global $post;
    if ( !is_singular()) //if it is not a post or a page
        return;
    if(get_the_excerpt()) {
        $excerpt = strip_tags(get_the_excerpt());
        $excerpt = str_replace("", "'", $excerpt);
    } else {
        $excerpt = get_bloginfo('description');
    }

    //You'll need to find you Facebook profile Id and add it as the admin
    echo '<meta property="og:title" content="' . wp_get_document_title() . '"/>';
    echo '<meta property="og:description" content="' . $excerpt . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    // Customize the below with the name of your site
    echo '<meta property="og:site_name" content="'.get_bloginfo( 'title' ).'"/>';

    if(!has_post_thumbnail( $post->ID ) || is_front_page()) { //the post does not have featured image, use a default image
        //Create a default image on your server or an image in your media library, and insert it's URL here
        $default_image="https://www.imperatoriepartners.it/wp-content/themes/IP24/images/android-chrome-512x512.png";
        echo '<meta property="og:image" content="' . $default_image . '"/>';
        echo '<meta property="og:image:width" content="512" />';
        echo '<meta property="og:image:height" content="512" />';
        echo '<meta property="og:image:type" content="image/png" />';
    } else{
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    }

    echo "
";
}
add_action( 'wp_head', 'facebook_open_graph', 5 );
