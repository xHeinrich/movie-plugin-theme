<?php
/**
 * movies functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage movies
 * @since movies 1.0
 */
define( 'THEME_DIR', get_template_directory() );

require_once THEME_DIR . '/framework/init.php';
require_once dirname( __FILE__ ) . '/plugins/cmb2/init.php';
require_once dirname( __FILE__ ) . '/plugins/cmb2-post-search-field/lib/init.php';

function movie_setup() {
  //load plugin here
  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'movies' ),
  ) );

  add_theme_support( 'post-formats', array(
    'aside',
    'image',
    'video',
    'quote',
    'link',
    'gallery',
    'status',
    'audio',
    'chat',
  ) );

  $movie_list_title = 'Movie List';
  $movie_list_content = '';
  $movie_list_check = get_page_by_title($movie_list_title);
  $movie_list = array(
    'post_type' => 'page',
    'post_title' => $movie_list_title,
    'post_content' => $movie_list_content,
    'post_status' => 'publish',
    'post_author' => 1,
    'post_slug' => 'movie-list'
  );
  if(!isset($movie_list_check->ID)){
      $movie_list_id = wp_insert_post($movie_list);
  }
  $movie_list_check = get_page_by_title($movie_list_title);
  update_post_meta( $movie_list_check->ID, '_wp_page_template', 'movie-list.php' );


}

add_action( 'after_setup_theme', 'movie_setup' );

function compile_scss() {
  global $wp_filesystem;
  if (empty($wp_filesystem)) {
      require_once ABSPATH . '/wp-admin/includes/file.php';
      WP_Filesystem();
  }
  require_once THEME_DIR . "/framework/scssphp/scss.inc.php";
  require_once THEME_DIR . "/framework/scssphp/compass/compass.inc.php";
  $sass = new scssc();
  new scss_compass($sass);
  $format = 'scss_formatter_compressed';
  $sass->setFormatter($format);
  $sass->addImportPath('');
  $string_sass = $wp_filesystem->get_contents( THEME_DIR . '/scss/movies.scss');
  $string_css = $sass->compile($string_sass);

  $wp_filesystem->put_contents(
    THEME_DIR . '/assets/movies/movies.css',
    $string_css,
      FS_CHMOD_FILE
  );
}

function movies_scripts() {
  //Styles
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/framework/bootstrap/css/bootstrap.min.css', array(), '3.3.7' );
  wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), '1.0.0' );
  wp_enqueue_style( 'movies', get_template_directory_uri() . '/assets/movies/movies.css', array(), '1.0.0' );
  wp_enqueue_style( 'raleway', 'https://fonts.googleapis.com/css?family=Raleway:400,700', array(), '1.0.0');
  wp_enqueue_style( 'select2', get_template_directory_uri() . '/framework/select2/select2.min.css', array(), '4.0.3' );

  //Javascript
  wp_enqueue_script('jquery');
  wp_enqueue_script( 'html5shiv-ie9', 'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', array( 'html5shiv-ie9-style' ), '20170705' );
	wp_script_add_data( 'html5shiv-ie9', 'conditional', 'lt IE 9' );
  wp_enqueue_script( 'respond-ie9', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', array( 'respond-ie9-style' ), '20170705' );
	wp_script_add_data( 'respond-ie9', 'conditional', 'lt IE 9' );
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/framework/bootstrap/js/bootstrap.min.js', array(), '3.3.7' );
  wp_enqueue_script( 'jquery-bootpag', get_template_directory_uri() . '/framework/jquery-bootpag.min.js', array(), '3.3.7' );
  wp_enqueue_script( 'movies',  get_template_directory_uri() . '/assets/movies/movies.js', array(), '1.0.0' );
  wp_enqueue_script( 'select2',  get_template_directory_uri() . '/framework/select2/select2.full.min.js', array(), '4.0.3' );
}
add_action( 'wp_enqueue_scripts', 'compile_scss' );
add_action( 'wp_enqueue_scripts', 'movies_scripts' );

function load_plugin() {
    // load Social if not already loaded
    include_once( THEME_DIR . '/plugins/movies/movies.php');

}

add_action('after_setup_theme', 'load_plugin');
add_theme_support( 'movie-thumbnails' );
add_theme_support( 'movie-thumbnails' );
set_post_thumbnail_size( 230, 345, true );
