<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
/**
 * Displays the site header.
 *
 * @package WordPress
 */

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
?>
<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>">

<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<div class="site-name">
			<?php if ( has_custom_logo() ) : ?>
				<div class="site-logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<?php if ( get_bloginfo( 'name' ) && get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
					<?php if ( is_front_page() && ! is_paged() ) : ?>
						<?php bloginfo( 'name' ); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
	</div><!-- .site-name -->
	<nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'twentytwentyone' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'menu_class'      => 'menu-wrapper',
				'container_class' => 'primary-menu-container',
				'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
				'fallback_cb'     => false,
			)
		);
		?>
		<button id="modal__burger" class="btn-modal" aria-label="Menu pour la version portable">
			<span class="line"></span>
			<span class="line"></span>
			<span class="line"></span>
		</button>
		
		<div id="modal__content" class="modal__content">           
			<?php 				
			wp_nav_menu(array(	'theme_location' => 'primary',
								'container_class' => 'primary-menu-container',
		)); 
			?>
		</div>
	</nav><!-- #site-navigation -->
	<?php
endif;
?>
</header><!-- #masthead -->
