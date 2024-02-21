<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package IP24
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Pagina non trovata.', 'ip24' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'Sembra che la pagina che cerchi non sia disponibile.', 'ip24' ); ?></p>
				<p>puoi Tornare alla <a href="/">Homepage</a>, oppure cercare altre offerte nelle categorie del sito.</p>

					<?php /*
					get_search_form();

					the_widget( 'WP_Widget_Recent_Posts' );
					*/ ?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Elenco categorie', 'ip24' ); ?></h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div><!-- .widget -->

					<?php
					/* translators: %1$s: smiley */
					/*
					$ip24_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'ip24' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$ip24_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
					*/
					?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
