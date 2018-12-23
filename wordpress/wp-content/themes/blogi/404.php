<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Blogi
 */

get_header(); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div id="primary" class="content-area col-md-8">
				<main id="main" class="site-main" role="main">
			
					<section class="error-404 not-found">
						<header class="page-header">
							<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'blogi' ); ?></h1>
						</header><!-- .page-header -->
			
						<div class="page-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'blogi' ); ?></p>
							
							<div class="error-404-searchbox clearfix"><?php get_search_form(); ?></div>

							<div class="row">
								<div class="col-md-6">
									<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
								</div>
								<div class="col-md-6">
									<?php if ( blogi_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
									<div class="widget widget_categories">
										<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'blogi' ); ?></h2>
										<ul>
										<?php
											wp_list_categories( array(
												'orderby'    => 'count',
												'order'      => 'DESC',
												'show_count' => 1,
												'title_li'   => '',
												'number'     => 5,
											) );
										?>
										</ul>
									</div><!-- .widget -->
									<?php endif; ?>
								</div>
							</div>
			
							
			
							
			
						</div><!-- .page-content -->
					</section><!-- .error-404 -->
			
				</main><!-- #main -->
			</div><!-- #primary -->
			<div class="col-md-2"></div>
		</div>
	</div>

<?php get_footer(); ?>
