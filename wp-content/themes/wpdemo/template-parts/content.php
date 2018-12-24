<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpdemo
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">			
		<div class="blog-wrapper">		
			<?php if ( has_post_thumbnail() ){?>
				<a href="<?php echo esc_url( get_permalink() );?>" class="blog-image">				
					<?php the_post_thumbnail( 'medium'); ?>
				</a>
			<?php }?>
		    <div class="blog-content">
				<div class="wd-postdate"><?php wpdemo_posted_on();?></div>
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );?>
				<?php the_excerpt();?>
		    </div> 
			<span class="clear"></span>
			<hr>
	    </div>
	</div><!-- .entry-content -->
	<span class="clear"></span>
</article><!-- #post-<?php the_ID(); ?> -->
