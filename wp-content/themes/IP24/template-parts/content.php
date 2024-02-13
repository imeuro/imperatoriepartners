<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package IP24
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<header class="entry-header">


		<?php
		if ( is_singular() ) :

			ip24_post_thumbnail('thumbnail');

			echo '<div class="entry-text">';
				ip24_entry_categories();
				the_title( '<h1 class="entry-title">', '</h1>' );
			echo '</div>';

		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		 ?>
		<div class="entry-toolbar">
			<a href="#" title="vedi immagini" id="entry-img"></a>
			<span id="entry-share"></span>
			
		</div>

	</header><!-- .entry-header -->


	<div class="entry-content">
		<div class="entry-sunto">
			<span id="entry-info">
				<?php
				if(get_field('locali')) : echo get_field('locali');
					if(get_field('locali')==1) : echo " locale"; else : echo " locali"; endif;
					
				endif;
				?>
				<?php if(get_field('locali')&&get_field('metriquadri')) : echo " - ";  endif; ?> 
				<?php if(get_field('metriquadri')) : echo get_field('metriquadri')." mq"; endif; ?>
				<?php if(get_field('prezzo')) : ?><br/>&euro; <?php the_field('prezzo'); ?><?php endif; ?>
			</span>
		</div>

		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ip24' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ip24' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
