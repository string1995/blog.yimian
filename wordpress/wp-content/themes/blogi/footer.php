<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blogi
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="site-info">
						<?php echo wp_kses_post(get_theme_mod( 'footer_text', sprintf('<a href="%1$s">%2$s</a>', esc_url(__('https://wordpress.org/', 'blogi')), __('Proudly powered by WordPress', 'blogi')) )); ?>
						<?php if(get_theme_mod( 'footer_love', 1)): ?>
							<span class="sep"> | </span>
							<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'blogi' ), 'Blogi', '<a href="https://www.cantothemes.com/" rel="designer">CantoThemes</a>' ); ?>
						<?php endif; ?>
					</div><!-- .site-info -->
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->


<?php wp_footer(); ?>

</body>
</html>
