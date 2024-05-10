<?php

// Action qui permet de charger des scripts dans notre thème
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles(){
    // Chargement du style.css du thème parent Twenty Twenty
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	// Chargement du css/theme.css pour nos personnalisations
	wp_enqueue_style('mota-theme-main-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/theme.css'));
	wp_enqueue_style('mota-theme-contact-modal-style', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/contact.css'));

}


add_action('wp_enqueue_scripts', 'motatheme_scripts');
function motatheme_scripts() {
    wp_enqueue_script('motatheme', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
	if (is_front_page()) {
        wp_enqueue_script( 'motatheme-scripts-filtres', get_theme_file_uri( '/assets/js/filtres.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/filtres.js'), true );   
  	
	};  
  
}

if ( ! function_exists( 'mota_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since mota-theme 1.0
	 *
	 * @return void
	 */
	function mota_theme_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add post-formats support.
		 */
		add_theme_support(
			'post-formats',
			array(
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			)
		);

		// Ajouter la prise en charge des images mises en avant
		add_theme_support( 'post-thumbnails' );

		// permet de définir la taille des images mises en avant 
		// set_post_thumbnail_size(largeur, hauteur max, true = on adapte l'image aux dimensions)
		set_post_thumbnail_size( 600, 0, false );

		// Définir d'autres tailles d'images : 
		// les options de base WP : 
		//      'thumbnail': 150 x 150 hard cropped 
		//      'medium' : 300 x 300 max height 300px
		//      'medium_large' : resolution (768 x 0 infinite height)
		//      'large' : 1024 x 1024 max height 1024px
		//      'full' : original size uploaded
		add_image_size( 'hero', 1450, 960, true );
		add_image_size( 'desktop-home', 600, 520, true );
		add_image_size( 'lightbox', 1300, 900, true );

		// créer un lien pour la gestion des menus dans l'administration
		// et activation d'un menu pour le header et d'un menu pour le footer
		// Visibles ensuite dans Apparence / Menus (after_setup_theme)
		register_nav_menus(
			array(
				'primary' => esc_html__( 'header menu', 'mota-theme' ),
				'footer'  => esc_html__( 'footer menu', 'mota-theme' ),
			)
		);


		// créer un pour la gestion des widgets dans l'administration

		/*
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		$logo_width  = 300;
		$logo_height = 100;

		add_theme_support(
			'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );


	}
}


add_action( 'after_setup_theme', 'mota_theme_setup' );

// Partie pour gerer le padding de l'affichage des photos  
include get_template_directory() . '/includes/ajax.php';

// Récupération de la valeur d'un champs personnalisé CPF
// $variable = nom de la variable dont on veut récupérer la valeur
// $field = nom du champs personnalisés
function my_cpf_load_value( $variable,  $fields ) {
    // Initialisation de la valeur à retourner
    $return = "";
    // Recherche de la clé
    foreach ( $fields as $field) { $return= $field->$variable; }
    return $return;
}