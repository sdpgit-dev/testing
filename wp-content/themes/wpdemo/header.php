<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpdemo
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
	<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
	
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wpdemo' ); ?></a>
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<img src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="online brothers"/>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'wpdemo' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<?php
			add_filter( 'lazyblock/section/frontend_callback', 'my_block_output', 10, 2 );
			if ( ! function_exists( 'section' ) ) :
				/**
				 * Test Render Callback
				 *
				 * @param string $output - block output.
				 * @param array  $attributes - block attributes.
				 */
				function my_block_output( $output, $attributes ) {
					ob_start();
					?>
					<div>
						<?php 
						$repeater = $attributes[ 'wdsection' ];
						foreach ( $repeater as $r ) {?>
							<div class="<?php echo $r['wdcontent_type']; ?>">
								<h2><?php echo $r['wdtitle']; ?></h2>
								<p><?php echo $r['wdcontent']; ?></p>
							</div>
						<?php	}?>
					</div>

					<?php
					return ob_get_clean();
				}
			endif;
			?>
