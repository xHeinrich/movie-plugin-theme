<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage movies
 * @since movies 1.0
 */
get_header(); ?>
<div class="jumbotron">
  <h1>Welcome to MovieDB!</h1>
  <p>All your movie information is just a key press away.</p>
  <p><a class="btn btn-orange btn-lg" href="<?php echo get_permalink(get_page_by_title('Movie List')->ID); ?>" role="button">Explore</a></p>
</div>
<div class="push"></div>
<?php get_footer(); ?>
