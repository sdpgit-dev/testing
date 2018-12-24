<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpdemo
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php $hidetitle = get_field('wdhide_title');
		if($hidetitle == "no"){ ?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
		<?php 
	}?>

	<?php wpdemo_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
