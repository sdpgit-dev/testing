<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpdemo
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<span><?php echo __('&copy; 2018 ','wpdemo'); ?><a href="https://www.onlinebrothers.nl"><?php echo __('onlinebrothers.nl','wpdemo'); ?></a><?php echo __(' | All rights reserved.','wpdemo');?></span>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
